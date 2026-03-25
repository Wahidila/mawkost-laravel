<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeUserMail;
use App\Models\Kost;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show($kostSlug)
    {
        $kost = Kost::where('slug', $kostSlug)->firstOrFail();
        return view('checkout.show', compact('kost'));
    }

    public function process(Request $request, $kostSlug)
    {
        $rules = [
            'payment' => 'required|in:qris,gopay,va',
        ];

        if (!auth()->check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['whatsapp'] = 'required|string|max:20';
            $rules['email'] = 'required|email|max:255';
        }

        $request->validate($rules);

        $kost = Kost::where('slug', $kostSlug)->firstOrFail();

        // Handle user (auth or guest)
        $isNewUser = false;
        $plainPassword = null;

        if (auth()->check()) {
            $user = auth()->user();
            // Data order menggunakan data auth user
            $customerName = $user->name;
            $customerWhatsapp = $user->whatsapp;
            $customerEmail = $user->email;
        }
        else {
            $user = User::where('email', $request->email)->first();
            $customerName = $request->name;
            $customerWhatsapp = $request->whatsapp;
            $customerEmail = $request->email;

            if (!$user) {
                // Generate a strong random password
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

        $order = Order::create([
            'invoice_no' => Order::generateInvoiceNo(),
            'kost_id' => $kost->id,
            'user_id' => $user->id,
            'customer_name' => $customerName,
            'customer_whatsapp' => $customerWhatsapp,
            'customer_email' => $customerEmail,
            'amount' => $kost->unlock_price,
            'payment_method' => $request->payment,
            'status' => 'paid', // Simulasi langsung lunas
            'paid_at' => now(),
        ]);

        // Send emails
        $emailError = null;
        try {
            if ($isNewUser && $plainPassword) {
                // Send welcome email with credentials
                Mail::to($user->email)->send(new WelcomeUserMail($user, $plainPassword, $order));
            }
            else {
                // Send standard unlocked notification for existing users
                Mail::to($user->email)->send(new \App\Mail\KostUnlockedMail($user, $order));
            }
        }
        catch (\Exception $e) {
            // Log error but don't block the checkout flow
            $emailError = $e->getMessage();
            \Illuminate\Support\Facades\Log::error('Failed to send emails: ' . $emailError);
        }

        return redirect()->route('checkout.success', ['invoiceNo' => $order->invoice_no])
            ->with([
            'is_new_user' => $isNewUser,
            'email_error' => $emailError
        ]);
    }

    public function callback(Request $request)
    {
        // Placeholder webhook untuk integrasi payment gateway nanti
        return response()->json(['status' => 'ok']);
    }

    public function success($invoiceNo)
    {
        $order = Order::with('kost')->where('invoice_no', $invoiceNo)->firstOrFail();
        return view('checkout.success', compact('order'));
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

        // Ensure at least one of each type
        $password = $upper[random_int(0, strlen($upper) - 1)]
            . $lower[random_int(0, strlen($lower) - 1)]
            . $numbers[random_int(0, strlen($numbers) - 1)]
            . $symbols[random_int(0, strlen($symbols) - 1)];

        // Fill the rest randomly
        $all = $upper . $lower . $numbers . $symbols;
        for ($i = 4; $i < $length; $i++) {
            $password .= $all[random_int(0, strlen($all) - 1)];
        }

        // Shuffle the password characters
        return str_shuffle($password);
    }
}
