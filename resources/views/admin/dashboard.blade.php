@extends('layouts.admin')

@section('title', 'Dashboard Analytics')
@section('header', 'Dashboard Analytics')

@section('content')
{{-- Row 1: Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6 mt-2">
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-primary-lighter/80 text-primary-dark">
                <i class="fas fa-building text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Kost</p>
                <p class="text-2xl font-bold font-display text-primary-dark">{{ number_format($totalKost) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-[rgba(232,115,74,0.15)] text-cta">
                <i class="fas fa-receipt text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Order (Paid)</p>
                <p class="text-2xl font-bold font-display text-primary-dark">{{ number_format($paidOrders) }}</p>
                <p class="text-[10px] text-gray-400">dari {{ $totalOrders }} total</p>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-green-100/60 text-green-700">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Revenue Total</p>
                <p class="text-xl font-bold font-display text-primary-dark">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-blue-100/60 text-blue-700">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Conversion Rate</p>
                <p class="text-2xl font-bold font-display text-primary-dark">{{ $conversionRate }}%</p>
                <p class="text-[10px] text-gray-400">paid / total order</p>
            </div>
        </div>
    </div>
</div>

{{-- Row 2: Mini Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white/60 backdrop-blur rounded-xl border border-primary-lighter/30 p-4 flex items-center gap-3">
        <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-primary-lighter/50 text-primary">
            <i class="fas fa-calendar-check text-sm"></i>
        </div>
        <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Bulan Ini</p>
            <p class="text-sm font-bold text-primary-dark">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</p>
            <p class="text-[10px] text-gray-400">{{ $ordersThisMonth }} order</p>
        </div>
    </div>
    <div class="bg-white/60 backdrop-blur rounded-xl border border-primary-lighter/30 p-4 flex items-center gap-3">
        <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-primary-lighter/50 text-primary">
            <i class="fas fa-city text-sm"></i>
        </div>
        <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Kota</p>
            <p class="text-sm font-bold text-primary-dark">{{ $totalCities }} kota</p>
        </div>
    </div>
    <div class="bg-white/60 backdrop-blur rounded-xl border border-primary-lighter/30 p-4 flex items-center gap-3">
        <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-primary-lighter/50 text-primary">
            <i class="fas fa-users text-sm"></i>
        </div>
        <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Users</p>
            <p class="text-sm font-bold text-primary-dark">{{ number_format($totalUsers) }} user</p>
        </div>
    </div>
    <div class="bg-white/60 backdrop-blur rounded-xl border border-primary-lighter/30 p-4 flex items-center gap-3">
        <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-purple-100/60 text-purple-600">
            <i class="fas fa-robot text-sm"></i>
        </div>
        <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">AI Chat</p>
            <p class="text-sm font-bold text-primary-dark">{{ $chatSessions }} sesi</p>
            <p class="text-[10px] text-gray-400">{{ $chatMessages }} pesan</p>
        </div>
    </div>
</div>

{{-- Row 3: Chart --}}
<div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden mb-6">
    <div class="p-5 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between flex-wrap gap-3">
        <h3 class="text-base font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
            <i class="fas fa-chart-bar text-cta"></i> Order & Revenue
        </h3>
        <div class="flex gap-1.5">
            <button onclick="loadChart('daily')" id="btn-daily" class="chart-period-btn active">Harian</button>
            <button onclick="loadChart('weekly')" id="btn-weekly" class="chart-period-btn">Mingguan</button>
            <button onclick="loadChart('monthly')" id="btn-monthly" class="chart-period-btn">Bulanan</button>
        </div>
    </div>
    <div class="p-5" style="height: 320px;">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

{{-- Row 4: Top Kost + Chat Stats --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Top Kost Unlocked --}}
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
        <div class="p-5 border-b border-primary-lighter/40 bg-white/50">
            <h3 class="text-base font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-trophy text-amber-500"></i> Kost Paling Banyak Di-unlock
            </h3>
        </div>
        <div class="p-5">
            @forelse($topKosts as $i => $kost)
            <div class="flex items-center gap-3 {{ !$loop->last ? 'mb-4 pb-4 border-b border-primary-lighter/20' : '' }}">
                <div class="w-8 h-8 flex items-center justify-center rounded-full font-bold font-display text-sm
                    {{ $i === 0 ? 'bg-amber-100 text-amber-700' : ($i === 1 ? 'bg-gray-100 text-gray-600' : 'bg-orange-50 text-orange-600') }}">
                    {{ $i + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-primary-dark truncate">{{ $kost->title }}</p>
                    <p class="text-xs text-gray-400">{{ $kost->kode }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-primary-dark">{{ $kost->unlock_count }}x</p>
                    <p class="text-[10px] text-gray-400">Rp {{ number_format($kost->total_revenue, 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <i class="fas fa-chart-pie text-3xl text-primary-lighter mb-2"></i>
                <p class="text-sm text-gray-400">Belum ada data unlock.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Revenue per Bulan (Bar mini) --}}
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
        <div class="p-5 border-b border-primary-lighter/40 bg-white/50">
            <h3 class="text-base font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-calendar-alt text-primary"></i> Revenue per Bulan ({{ now()->year }})
            </h3>
        </div>
        <div class="p-5" style="height: 260px;">
            <canvas id="monthlyRevenueChart"></canvas>
        </div>
    </div>
</div>

{{-- Row 5: Recent Orders --}}
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="p-5 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <h3 class="text-base font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
            <i class="fas fa-clock-rotate-left text-primary"></i> Pesanan Terbaru
        </h3>
        <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-primary hover:text-cta transition-colors">Lihat Semua <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i></a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-primary-lighter/50">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Invoice</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Pembeli</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Kost</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-lighter/30">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-primary-lighter/10 transition-colors duration-150">
                    <td class="px-5 py-4 whitespace-nowrap text-sm font-semibold text-primary-dark">{{ $order->invoice_no }}</td>
                    <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->customer_name }}</td>
                    <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->kost->title ?? '-' }}</td>
                    <td class="px-5 py-4 whitespace-nowrap text-sm">
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full
                        {{ $order->status == 'paid' ? 'bg-green-100 text-green-800 border border-green-200' : ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 'bg-red-100 text-red-800 border border-red-200') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-sm text-center text-gray-400">
                        <i class="fa-solid fa-inbox text-2xl mb-2 text-primary-lighter block"></i>
                        Belum ada pesanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.chart-period-btn {
    padding: 5px 14px;
    border-radius: 9999px;
    font-size: .75rem;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    border: 1px solid #E8DDD5;
    background: #FFF9F5;
    color: #8C7A6E;
    cursor: pointer;
    transition: all 200ms ease;
}
.chart-period-btn:hover {
    border-color: #DEB8A0;
    color: #5C3D2E;
}
.chart-period-btn.active {
    background: #8B5E3C;
    color: #fff;
    border-color: #8B5E3C;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
const chartUrl = '{{ route("admin.dashboard.chartData") }}';
let revenueChart = null;

const chartColors = {
    primary: '#8B5E3C',
    primaryLight: 'rgba(139, 94, 60, 0.15)',
    cta: '#E8734A',
    ctaLight: 'rgba(232, 115, 74, 0.15)',
};

function loadChart(period) {
    document.querySelectorAll('.chart-period-btn').forEach(function(b) { b.classList.remove('active'); });
    document.getElementById('btn-' + period).classList.add('active');

    fetch(chartUrl + '?period=' + period)
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (revenueChart) revenueChart.destroy();

            var ctx = document.getElementById('revenueChart').getContext('2d');
            revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Revenue (Rp)',
                            data: data.revenue,
                            backgroundColor: chartColors.primaryLight,
                            borderColor: chartColors.primary,
                            borderWidth: 2,
                            borderRadius: 6,
                            yAxisID: 'y',
                            order: 2,
                        },
                        {
                            label: 'Orders',
                            data: data.orders,
                            type: 'line',
                            borderColor: chartColors.cta,
                            backgroundColor: chartColors.ctaLight,
                            borderWidth: 2.5,
                            pointRadius: 3,
                            pointBackgroundColor: chartColors.cta,
                            tension: 0.3,
                            fill: true,
                            yAxisID: 'y1',
                            order: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { font: { family: 'Poppins', size: 11, weight: '600' }, usePointStyle: true, pointStyle: 'circle', padding: 16 }
                        },
                        tooltip: {
                            backgroundColor: '#5C3D2E',
                            titleFont: { family: 'Poppins', weight: '600' },
                            bodyFont: { family: 'Open Sans' },
                            cornerRadius: 8,
                            padding: 10,
                            callbacks: {
                                label: function(ctx) {
                                    if (ctx.dataset.yAxisID === 'y') return 'Revenue: Rp ' + ctx.raw.toLocaleString('id-ID');
                                    return 'Orders: ' + ctx.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Poppins', size: 10 }, maxRotation: 45 } },
                        y: {
                            position: 'left',
                            grid: { color: 'rgba(232,221,213,0.3)' },
                            ticks: {
                                font: { family: 'Poppins', size: 10 },
                                callback: function(v) { return v >= 1000000 ? (v/1000000) + 'jt' : v >= 1000 ? (v/1000) + 'rb' : v; }
                            }
                        },
                        y1: {
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { font: { family: 'Poppins', size: 10 }, stepSize: 1 }
                        }
                    }
                }
            });
        });
}

var monthlyData = @json($monthlyData);
var mCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
new Chart(mCtx, {
    type: 'bar',
    data: {
        labels: monthlyData.map(function(d) { return d.month; }),
        datasets: [{
            label: 'Revenue',
            data: monthlyData.map(function(d) { return d.revenue; }),
            backgroundColor: monthlyData.map(function(d, i) {
                return i === (new Date().getMonth()) ? '#E8734A' : 'rgba(139, 94, 60, 0.2)';
            }),
            borderColor: monthlyData.map(function(d, i) {
                return i === (new Date().getMonth()) ? '#D4622E' : '#8B5E3C';
            }),
            borderWidth: 1.5,
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#5C3D2E',
                titleFont: { family: 'Poppins', weight: '600' },
                bodyFont: { family: 'Open Sans' },
                cornerRadius: 8,
                callbacks: {
                    label: function(ctx) { return 'Rp ' + ctx.raw.toLocaleString('id-ID'); }
                }
            }
        },
        scales: {
            x: { grid: { display: false }, ticks: { font: { family: 'Poppins', size: 10 } } },
            y: {
                grid: { color: 'rgba(232,221,213,0.3)' },
                ticks: {
                    font: { family: 'Poppins', size: 10 },
                    callback: function(v) { return v >= 1000000 ? (v/1000000) + 'jt' : v >= 1000 ? (v/1000) + 'rb' : v; }
                }
            }
        }
    }
});

loadChart('daily');
</script>
@endsection
