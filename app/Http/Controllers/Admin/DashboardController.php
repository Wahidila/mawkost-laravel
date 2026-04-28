<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\City;
use App\Models\Kost;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKost = Kost::count();
        $totalOrders = Order::count();
        $paidOrders = Order::where('status', 'paid')->count();
        $totalRevenue = Order::where('status', 'paid')->sum('amount');
        $totalCities = City::count();
        $totalUsers = User::where('role', 'user')->count();

        $revenueThisMonth = Order::where('status', 'paid')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        $ordersThisMonth = Order::where('status', 'paid')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->count();

        $conversionRate = $totalOrders > 0
            ? round(($paidOrders / $totalOrders) * 100, 1)
            : 0;

        $topKosts = Kost::select('kosts.id', 'kosts.title', 'kosts.kode')
            ->join('orders', 'orders.kost_id', '=', 'kosts.id')
            ->where('orders.status', 'paid')
            ->groupBy('kosts.id', 'kosts.title', 'kosts.kode')
            ->selectRaw('COUNT(orders.id) as unlock_count')
            ->selectRaw('SUM(orders.amount) as total_revenue')
            ->orderByDesc('unlock_count')
            ->limit(5)
            ->get();

        $chatSessions = ChatMessage::distinct('session_id')->count('session_id');
        $chatMessages = ChatMessage::count();
        $chatUserMessages = ChatMessage::where('role', 'user')->count();

        $recentOrders = Order::with('kost')->latest()->take(5)->get();

        $revenueByMonth = Order::where('status', 'paid')
            ->whereYear('paid_at', now()->year)
            ->selectRaw("MONTH(paid_at) as month, SUM(amount) as revenue, COUNT(*) as orders")
            ->groupByRaw("MONTH(paid_at)")
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $monthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $row = $revenueByMonth->get($m);
            $monthlyData[] = [
                'month' => Carbon::create(null, $m)->translatedFormat('M'),
                'revenue' => $row->revenue ?? 0,
                'orders' => $row->orders ?? 0,
            ];
        }

        return view('admin.dashboard', compact(
            'totalKost', 'totalOrders', 'paidOrders', 'totalRevenue',
            'totalCities', 'totalUsers', 'revenueThisMonth', 'ordersThisMonth',
            'conversionRate', 'topKosts', 'chatSessions', 'chatMessages',
            'chatUserMessages', 'recentOrders', 'monthlyData'
        ));
    }

    public function chartData(Request $request)
    {
        $period = $request->input('period', 'daily');
        $now = Carbon::now();

        if ($period === 'daily') {
            $start = $now->copy()->subDays(29);
            $data = Order::where('status', 'paid')
                ->where('paid_at', '>=', $start)
                ->selectRaw("DATE(paid_at) as label, COUNT(*) as orders, SUM(amount) as revenue")
                ->groupByRaw("DATE(paid_at)")
                ->orderBy('label')
                ->get()
                ->keyBy('label');

            $labels = [];
            $orders = [];
            $revenue = [];
            for ($d = $start->copy(); $d->lte($now); $d->addDay()) {
                $key = $d->format('Y-m-d');
                $labels[] = $d->format('d M');
                $row = $data->get($key);
                $orders[] = $row->orders ?? 0;
                $revenue[] = $row->revenue ?? 0;
            }
        } elseif ($period === 'weekly') {
            $start = $now->copy()->subWeeks(11)->startOfWeek();
            $data = Order::where('status', 'paid')
                ->where('paid_at', '>=', $start)
                ->selectRaw("YEARWEEK(paid_at, 1) as yw, MIN(DATE(paid_at)) as first_day, COUNT(*) as orders, SUM(amount) as revenue")
                ->groupByRaw("YEARWEEK(paid_at, 1)")
                ->orderBy('yw')
                ->get()
                ->keyBy('yw');

            $labels = [];
            $orders = [];
            $revenue = [];
            for ($w = $start->copy(); $w->lte($now); $w->addWeek()) {
                $yw = $w->format('oW');
                $labels[] = 'W' . $w->weekOfYear . ' ' . $w->format('M');
                $row = $data->get($yw);
                $orders[] = $row->orders ?? 0;
                $revenue[] = $row->revenue ?? 0;
            }
        } else {
            $labels = [];
            $orders = [];
            $revenue = [];
            for ($m = 1; $m <= 12; $m++) {
                $labels[] = Carbon::create(null, $m)->translatedFormat('M');
                $row = Order::where('status', 'paid')
                    ->whereMonth('paid_at', $m)
                    ->whereYear('paid_at', $now->year)
                    ->selectRaw("COUNT(*) as orders, SUM(amount) as revenue")
                    ->first();
                $orders[] = $row->orders ?? 0;
                $revenue[] = $row->revenue ?? 0;
            }
        }

        return response()->json(compact('labels', 'orders', 'revenue'));
    }
}
