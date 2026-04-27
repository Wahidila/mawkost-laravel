<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('kost')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by invoice, customer name, or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $orders = $query->paginate(10)->withQueryString();
        $currentStatus = $request->status;

        // Stats for filter pills
        $stats = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'expired' => Order::where('status', 'expired')->count(),
            'refunded' => Order::where('status', 'refunded')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'currentStatus', 'stats'));
    }

    public function show(string $id)
    {
        $order = Order::with('kost.city')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:paid,expired,refunded',
        ]);

        $newStatus = $request->status;
        $oldStatus = $order->status;

        // Prevent invalid transitions
        if ($oldStatus === 'paid' && $newStatus === 'expired') {
            return back()->with('error', 'Tidak bisa mengubah status dari Paid ke Expired.');
        }

        $updateData = ['status' => $newStatus];

        // If marking as paid, set paid_at
        if ($newStatus === 'paid' && !$order->paid_at) {
            $updateData['paid_at'] = now();
        }

        $order->update($updateData);

        // Send notifications if marked as paid manually
        if ($newStatus === 'paid' && $oldStatus !== 'paid') {
            try {
                $user = $order->user;
                if ($user) {
                    \Illuminate\Support\Facades\Mail::to($order->customer_email)
                        ->send(new \App\Mail\KostUnlockedMail($user, $order));
                }

                $xsender = new \App\Services\XSenderService();
                if ($xsender->isEnabled()) {
                    $xsender->sendKostNotification($order);
                }
            } catch (\Exception $e) {
                Log::error('Failed to send notification on manual status update: ' . $e->getMessage());
            }
        }

        $statusLabels = ['paid' => 'Lunas', 'expired' => 'Kedaluwarsa', 'refunded' => 'Dikembalikan'];
        return back()->with('success', "Status pesanan {$order->invoice_no} berhasil diubah ke {$statusLabels[$newStatus]}.");
    }

    public function export(Request $request): StreamedResponse
    {
        $query = Order::with('kost.city')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $orders = $query->get();
        $filename = 'pesanan-mawkost-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            // Header
            fputcsv($handle, ['Invoice', 'Nama Customer', 'WhatsApp', 'Email', 'Nama Kost', 'Kota', 'Nominal', 'Status', 'Metode Bayar', 'Tanggal Order', 'Tanggal Bayar']);
            // Data
            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->invoice_no,
                    $order->customer_name,
                    $order->customer_whatsapp,
                    $order->customer_email,
                    $order->kost->title ?? '-',
                    $order->kost->city->name ?? '-',
                    $order->amount,
                    strtoupper($order->status),
                    strtoupper($order->payment_method ?? '-'),
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->paid_at ? $order->paid_at->format('Y-m-d H:i:s') : '-',
                ]);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
