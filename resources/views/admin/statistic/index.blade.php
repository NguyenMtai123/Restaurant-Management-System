@extends('admin.layouts.master')

@section('title','Thống kê')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/statistics.css') }}">
@endpush

@section('content')
<!-- Lọc theo ngày -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <div class="row align-items-center g-3">
            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Từ ngày</label>
                <input type="date" class="form-control" id="dateFrom" value="{{ $from->toDateString() }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Đến ngày</label>
                <input type="date" class="form-control" id="dateTo" value="{{ $to->toDateString() }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100 mt-4" onclick="filterStats()">
                    <i class='bx bx-filter-alt'></i> Lọc dữ liệu
                </button>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-outline-danger w-100 mt-4" onclick="openExportConfirm()">
                    <i class='bx bxs-file-pdf'></i> Xuất báo cáo PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê chính -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stats-card">
            <div class="stats-content">
                <h6>Doanh Thu</h6>
                <h3>{{ number_format($totalRevenue,0,',','.') }} ₫</h3>
            </div>
            <div class="stats-icon bg-icon-primary"><i class='bx bx-money'></i></div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stats-card">
            <div class="stats-content">
                <h6>Tổng Đơn</h6>
                <h3>{{ $totalOrders }}</h3>
            </div>
            <div class="stats-icon bg-icon-warning"><i class='bx bx-shopping-bag'></i></div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stats-card">
            <div class="stats-content">
                <h6>Đã Bán</h6>
                <h3>{{ $totalItems }}</h3>
                <small class="text-muted">sản phẩm</small>
            </div>
            <div class="stats-icon bg-icon-success"><i class='bx bx-dish'></i></div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stats-card">
            <div class="stats-content">
                <h6>Tỉ lệ hủy</h6>
                <h3 class="text-danger">{{ $cancelRate }}%</h3>
            </div>
            <div class="stats-icon bg-icon-danger"><i class='bx bx-x-circle'></i></div>
        </div>
    </div>
</div>

<!-- Biểu đồ doanh thu và danh mục -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Biểu đồ doanh thu</h5>
            </div>
            <div class="card-body px-4">
                <canvas id="revenueAnalyticsChart" style="max-height: 350px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Tỷ lệ bán theo Danh mục</h5>
            </div>
            <div class="card-body px-4 d-flex align-items-center justify-content-center">
                <div style="width: 100%; max-width: 300px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top 5 sản phẩm bán chạy -->
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between">
        <h5 class="fw-bold mb-0">Top 5 Sản phẩm bán chạy nhất</h5>
        <a href="{{ route('admin.menu-items.index') }}" class="text-primary text-decoration-none">Xem kho hàng <i class='bx bx-right-arrow-alt'></i></a>
    </div>
    <div class="card-body px-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Sản phẩm</th>
                        <th>Danh mục</th>
                        <th class="text-end">Đã bán</th>
                        <th class="text-end">Doanh thu</th>
                        <th class="text-end pe-4">VAT (10%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $product)
                    <tr>
                        <td class="d-flex align-items-center ps-4">
                            <img src="{{ $product->img
                                ? asset($product->img)
                                : asset('images/menu/default.png') }}"
                                class="top-product-img me-2"
                                style="width:40px;height:40px;object-fit:cover;">
                            {{ $product->name }}
                        </td>
                        <td>{{ $product->category }}</td>
                        <td class="text-end">{{ $product->sold }}</td>
                        <td class="text-end">{{ number_format($product->revenue,0,',','.') }} ₫</td>
                        <td class="text-end pe-4">{{ number_format($product->vat,0,',','.') }} ₫</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
 @include('admin.partials.modals.confirm_statistic')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlyRevenue = @json($monthlyRevenue);
    const categoryLabels = @json($categoryShare->pluck('category'));
    const categoryData = @json($categoryShare->pluck('total_sold'));

    // Biểu đồ doanh thu
    const ctxRev = document.getElementById("revenueAnalyticsChart").getContext("2d");
    new Chart(ctxRev, {
        type: 'line',
        data: {
            labels: ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
            datasets: [{
                label: 'Doanh thu (₫)',
                data: monthlyRevenue,
                borderColor: '#ff6b35',
                backgroundColor: 'rgba(255,107,53,0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive:true,
            plugins:{ legend:{ display:false } },
            scales:{ y:{ beginAtZero:true } }
        }
    });

    // Biểu đồ danh mục
    const ctxCat = document.getElementById("categoryChart").getContext("2d");
    new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets:[{
                data: categoryData,
                backgroundColor:['#ff6b35','#2ecc71','#f1c40f','#3498db','#9b59b6'],
                borderWidth:0
            }]
        },
        options:{ responsive:true, cutout:'70%' }
    });

    function filterStats() {
        const from = document.getElementById('dateFrom').value;
        const to = document.getElementById('dateTo').value;
        const url = new URL(window.location.href);
        if(from) url.searchParams.set('from', from);
        if(to) url.searchParams.set('to', to);
        window.location.href = url.toString();
    }

    function openExportConfirm() {
    const from = document.getElementById('dateFrom').value || '---';
    const to   = document.getElementById('dateTo').value || '---';

    document.getElementById('confirmFrom').innerText = from;
    document.getElementById('confirmTo').innerText   = to;

    const modal = new bootstrap.Modal(
        document.getElementById('exportConfirmModal')
    );
    modal.show();
}

function confirmExportPdf() {
    const from = document.getElementById('dateFrom').value;
    const to   = document.getElementById('dateTo').value;

    let url = "{{ route('admin.statistics.export.pdf') }}";
    const params = new URLSearchParams();

    if (from) params.append('from', from);
    if (to) params.append('to', to);

    window.open(url + '?' + params.toString(), '_blank');

    // đóng modal
    bootstrap.Modal.getInstance(
        document.getElementById('exportConfirmModal')
    ).hide();
}


</script>


@endpush
