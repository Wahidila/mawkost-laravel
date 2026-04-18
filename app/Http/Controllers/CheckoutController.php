<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeUserMail;
use App\Models\Kost;
use App\Models\Order;
use App\Models\User;
use App\Services\XenditService;
use App\Services\XSenderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show($kostSlug)
    {
        $kost = Kost::where('slug', $kostSlug)->firstOrFail();

        // Prevent duplicate unlock — redirect if user already has a paid order for this kost
        if (auth()->check()) {
            $existingOrder = auth()->user()->orders()
                ->where('kost_id', $kost->id)
                ->where('status', 'paid')
                ->first();

            if ($existingOrder) {
                return redirect()->route('user.orders.show', $existingOrder->id)
                    ->with('success', 'Kamu sudah membuka info kontak kost ini sebelumnya.');
            }
        }

        return view('checkout.show', compact('kost'));
    }

    public function process(Request $request, $kostSlug)
    {
        $rules = [
            'payment' => 'required|in:qris,gopay,va',
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ];

        $request->validate($rules);

        $kost = Kost::where('slug', $kostSlug)->firstOrFail();

        // Handle user (auth or guest)
        $isNewUser = false;
        $plainPassword = null;

        if (auth()->check()) {
            $user = auth()->user();
            $customerName = $request->name;
            $customerWhatsapp = $request->whatsapp;
            $customerEmail = $request->email;
        }
        else {
            $user = User::where('email', $request->email)->first();
            $customerName = $request->name;
            $customerWhatsapp = $request->whatsapp;
            $customerEmail = $request->email;

            if (!$user) {
                $plainPassword = $this->generateStrongPassword();

                $user = User::create([
                    'name' => $customerName,
                    'email' => $customerEmail,
                    'whatsapp' => $customerWhatsapp,
                    'password' => Hash::make($plainPassword),
                    'role' => 'user',
                ]);
                $isNewUser = true;
            }
        }

        // Create order (initially pending)
        $order = Order::create([
            'invoice_no' => Order::generateInvoiceNo(),
            'kost_id' => $kost->id,
            'user_id' => $user->id,
            'customer_name' => $customerName,
            'customer_whatsapp' => $customerWhatsapp,
            'customer_email' => $customerEmail,
            'amount' => $kost->unlock_price,
            'payment_method' => $request->payment,
            'status' => 'pending',
        ]);

        // Check if Xendit is enabled
        $xendit = new XenditService();

        Log::info('Checkout process', [
            'order' => $order->invoice_no,
            'xendit_enabled' => $xendit->isEnabled(),
        ]);

        if ($xendit->isEnabled()) {
            // — XENDIT MODE: Create invoice & redirect to Xendit payment page —
            $result = $xendit->createInvoice($order);

            Log::info('Xendit createInvoice result', [
                'order' => $order->invoice_no,
                'result' => $result,
            ]);

            if ($result['ok']) {
                $order->update([
                    'xendit_invoice_id' => $result['invoice_id'],
                    'xendit_invoice_url' => $result['invoice_url'],
                ]);

                // Store new user info in session (for webhook to pick up later)
                if ($isNewUser && $plainPassword) {
                    session([
                        'checkout_new_user_' . $order->invoice_no => true,
                        'checkout_password_' . $order->invoice_no => $plainPassword,
                    ]);
                }

                // Redirect to Xendit payment page
                return redirect()->away($result['invoice_url']);
            }

            // Xendit failed — show error to user, NOT silent fallback
            Log::error('Xendit invoice creation failed', [
                'order' => $order->invoice_no,
                'error' => $result['error'] ?? 'unknown',
            ]);

            // Delete the pending order since payment failed to initialize
            $order->delete();

            return redirect()->route('checkout.show', $kostSlug)
                ->with('error', 'Gagal membuat invoice pembayaran: ' . ($result['error'] ?? 'Unknown error'))
                ->withInput();
        }

        // — SIMULATION MODE: Mark as paid immediately (Xendit NOT enabled) —
        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // Send notifications in simulation mode
        $this->sendNotifications($order, $user, $isNewUser, $plainPassword);

        return redirect()->route('checkout.success', ['invoiceNo' => $order->invoice_no])
            ->with([
            'is_new_user' => $isNewUser,
        ]);
    }

    /**
     * Xendit webhook callback handler.
     */
    public function callback(Request $request)
    {
        $xendit = new XenditService();

        // Verify webhook token
        if (!$xendit->verifyWebhookToken($request)) {
            Log::warning('Xendit webhook: invalid callback token', [
                'ip' => $request->ip(),
            ]);
            return response()->json(['error' => 'Invalid token'], 403);
        }

        $externalId = $request->input('external_id');
        $status = $request->input('status');

        $order = Order::where('invoice_no', $externalId)->first();

        if (!$order) {
            Log::warning('Xendit webhook: order not found', ['external_id' => $externalId]);
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Prevent duplicate processing
        if ($order->status === 'paid') {
            return response()->json(['status' => 'already_processed']);
        }

        if ($status === 'PAID') {
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
                'xendit_payment_method' => $request->input('payment_method'),
                'xendit_payment_channel' => $request->input('payment_channel'),
            ]);

            // Determine if this was a new user registration
            $isNewUser = session('checkout_new_user_' . $order->invoice_no, false);
            $plainPassword = session('checkout_password_' . $order->invoice_no);

            // Send notifications
            $this->sendNotifications($order, $order->user, $isNewUser, $plainPassword);

            // Clear session data
            session()->forget([
                'checkout_new_user_' . $order->invoice_no,
                'checkout_password_' . $order->invoice_no,
            ]);

            Log::info('Xendit payment confirmed', [
                'invoice' => $order->invoice_no,
                'method' => $request->input('payment_method'),
            ]);
        }
        elseif ($status === 'EXPIRED') {
            $order->update(['status' => 'expired']);
            Log::info('Xendit invoice expired', ['invoice' => $order->invoice_no]);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Success page — handles both paid and pending states.
     */
    public function success($invoiceNo)
    {
        $order = Order::with('kost.city')->where('invoice_no', $invoiceNo)->firstOrFail();

        if ($order->status === 'pending' && $order->xendit_invoice_url) {
            // Show pending page with link to pay
            return view('checkout.pending', compact('order'));
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * AJAX endpoint to check order payment status.
     */
    public function checkStatus($invoiceNo)
    {
        $order = Order::where('invoice_no', $invoiceNo)->firstOrFail();
        return response()->json([
            'status' => $order->status,
            'paid' => $order->status === 'paid',
        ]);
    }

    /**
     * Send email and WhatsApp notifications after payment.
     */
    private function sendNotifications(Order $order, $user, bool $isNewUser, ?string $plainPassword): void
    {
        // Send email
        try {
            if ($isNewUser && $plainPassword) {
                Mail::to($user->email)->send(new WelcomeUserMail($user, $plainPassword, $order));
            }
            else {
                Mail::to($order->customer_email)->send(new \App\Mail\KostUnlockedMail($user, $order));
            }
        }
        catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
        }

        // Send WhatsApp
        try {
            $xsender = new XSenderService();
            if ($xsender->isEnabled()) {
                $waResult = $xsender->sendKostNotification($order);
                if (!$waResult['ok']) {
                    Log::warning('WhatsApp notification failed: ' . ($waResult['body'] ?? 'Unknown'));
                }
            }
        }
        catch (\Exception $e) {
            Log::error('WhatsApp send error: ' . $e->getMessage());
        }
    }

    /**
     * Generate a strong password with uppercase, lowercase, numbers, and symbols.
     */
    private function generateStrongPassword(int $length = 12): string
    {
        $upper = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $lower = 'abcdefghjkmnpqrstuvwxyz';
        $numbers = '23456789';
        $symbols = '!@#$%&*';

        $password = $upper[random_int(0, strlen($upper) - 1)]
            . $lower[random_int(0, strlen($lower) - 1)]
            . $numbers[random_int(0, strlen($numbers) - 1)]
            . $symbols[random_int(0, strlen($symbols) - 1)];

        $all = $upper . $lower . $numbers . $symbols;
        for ($i = 4; $i < $length; $i++) {
            $password .= $all[random_int(0, strlen($all) - 1)];
        }

        return str_shuffle($password);
    }
}
