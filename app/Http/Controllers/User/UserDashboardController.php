<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalOrders = $user->orders()->where('status', 'paid')->count();
        $totalSpent = $user->orders()->where('status', 'paid')->sum('amount');
        $recentOrders = $user->orders()->with('kost.city')->where('status', 'paid')->latest()->take(5)->get();

        return view('user.dashboard', compact('user', 'totalOrders', 'totalSpent', 'recentOrders'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with('kost.city')->where('status', 'paid')->latest()->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = auth()->user()->orders()->with('kost.city', 'kost.images', 'kost.facilities')->where('status', 'paid')->findOrFail($id);
        return view('user.orders.show', compact('order'));
    }
}
