<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('kost')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order = Order::with('kost')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}
