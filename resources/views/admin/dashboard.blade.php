@extends('admin.layouts.master')

@section('title','Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Tổng quan -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stats-card">
            <div class="stats-content">
                <h6>Tổng Đơn Hàng</h6>
                <h3>{{ $totalOrders }}</h3>
            </div>
            <div class="stats-icon bg-icon-primary">
                <i class='bx bx-cart-alt'></i>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stats-card">
            <div class="stats-content">
                <h6>Doanh Thu</h6>
                <h3>{{ number_format($totalRevenue,0,',','.') }} ₫</h3>
            </div>
            <div class="stats-icon bg-icon-success">
                <i class='bx bx-dollar'></i>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stats-card">
            <div class="stats-content">
                <h6>Khách Hàng</h6>
                <h3>{{ $totalCustomers }}</h3>
            </div>
            <div class="stats-icon bg-icon-warning">
                <i class='bx bx-user'></i>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stats-card">
            <div class="stats-content">
                <h6>Đơn Chờ Xử Lý</h6>
                <h3 class="text-danger">{{ $pendingOrders }}</h3>
            </div>
            <div class="stats-icon bg-icon-danger">
                <i class='bx bx-time-five'></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="recent-sales h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0">Biểu đồ doanh thu</h5>
                <select class="form-select form-select-sm w-auto" id="periodSelect">
                    <option value="week">Tuần này</option>
                    <option value="month">Tháng này</option>
                    <option value="year">Năm nay</option>
                </select>

            </div>
            <canvas id="revenueChart" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="recent-sales h-100">
            <h5 class="fw-bold mb-4">Đơn hàng gần đây</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold">#{{ $order->order_number }}</div>
                                </div>
                                <small class="text-muted">{{ $order->notes }}</small>
                            </td>
                            <td class="text-end">
                                @php
                                    $statusClass = match($order->status) {
                                        'pending' => 'status-pending',
                                        'delivered' => 'status-delivered',
                                        'completed' => 'status-completed',
                                        'cancelled' => 'status-cancel'
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('admin.orders.index') }}" class="text-decoration-none fw-bold" style="color: var(--primary-color);">
                    Xem tất cả <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const weeklyRevenue  = @json($weeklyRevenue);
const monthlyRevenue = @json($monthlyRevenue);
const yearlyRevenue  = @json($yearlyRevenue);


const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['T2','T3','T4','T5','T6','T7','CN'],
        datasets: [{
            label: 'Doanh thu (₫)',
            data: weeklyRevenue,
            borderColor: '#ff6b35',
            backgroundColor: 'rgba(255,107,53,0.1)',
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: { beginAtZero: true, grid: { borderDash: [5,5] } },
            x: { grid: { display: false } }
        }
    }
});

// Thay đổi tuần/tháng
document.getElementById('periodSelect').addEventListener('change', function(){
    if(this.value === 'week'){
        revenueChart.data.labels = ['T2','T3','T4','T5','T6','T7','CN'];
        revenueChart.data.datasets[0].data = weeklyRevenue;
    } else {
        const days = Array.from({length: monthlyRevenue.length}, (_,i)=>i+1);
        revenueChart.data.labels = days;
        revenueChart.data.datasets[0].data = monthlyRevenue;
    }
    revenueChart.update();
});

document.getElementById('periodSelect').addEventListener('change', function () {

    if (this.value === 'week') {
        revenueChart.data.labels = ['T2','T3','T4','T5','T6','T7','CN'];
        revenueChart.data.datasets[0].data = weeklyRevenue;
    }

    else if (this.value === 'month') {
        const days = Array.from({ length: monthlyRevenue.length }, (_, i) => i + 1);
        revenueChart.data.labels = days;
        revenueChart.data.datasets[0].data = monthlyRevenue;
    }

    else if (this.value === 'year') {
        revenueChart.data.labels = [
            'T1','T2','T3','T4','T5','T6',
            'T7','T8','T9','T10','T11','T12'
        ];
        revenueChart.data.datasets[0].data = yearlyRevenue;
    }

    revenueChart.update();
});

</script>
@endpush
