@extends('admin.layouts.master')

@section('title','Thống kê')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/statistics.css') }}">
<style>
/* nhỏ gọn: style cho dashboard */
.stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap:1rem; }
@media (max-width:992px){ .stats-grid{grid-template-columns:repeat(2,1fr);} }
.stats-card {
    background: linear-gradient(180deg,#fff,#fbfbfd);
    border-radius:12px;
    padding:1rem;
    display:flex;
    align-items:center;
    justify-content:space-between;
    box-shadow:0 6px 18px rgba(15,23,42,0.06);
}
.stats-content h6{ margin:0; color:#6b7280; font-weight:600; font-size:0.9rem;}
.stats-content h3{ margin:0; font-size:1.4rem; }
.stats-icon{ width:54px; height:54px; display:grid; place-items:center; border-radius:10px; color:#fff; }
.bg-icon-primary{ background: linear-gradient(135deg,#ff7a3d,#ff6b35); }
.bg-icon-warning{ background: linear-gradient(135deg,#f6c343,#f59e0b); }
.bg-icon-success{ background: linear-gradient(135deg,#34d399,#10b981); }
.bg-icon-danger{ background: linear-gradient(135deg,#fb7185,#ef4444); }

.card-compare { border-radius:12px; box-shadow:0 6px 18px rgba(15,23,42,0.04); padding:1rem; background:#fff; }
.delta { font-size:1.05rem; font-weight:700; }
.delta.up { color:#10b981; }
.delta.down { color:#ef4444; }
.small-muted { color:#6b7280; font-size:0.85rem; }

.chart-toolbar { display:flex; gap:0.5rem; align-items:center; }
.toggle-group .btn { border-radius:999px; padding:0.45rem 0.8rem; }
.sparkline { height:34px; width:120px; display:inline-block; vertical-align:middle; }

/* table image */
.top-product-img { width:48px; height:48px; object-fit:cover; border-radius:6px; }

/* responsive tweaks */
@media (max-width:768px){
    .chart-toolbar{ flex-direction:column; align-items:flex-start; gap:0.75rem; }
}
</style>
@endpush

@section('content')
<!-- Filter -->
<div class="card mb-4" style="border-radius:12px;">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Từ ngày</label>
                <input type="date" id="dateFrom" class="form-control" value="{{ $from->toDateString() }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Đến ngày</label>
                <input type="date" id="dateTo" class="form-control" value="{{ $to->toDateString() }}">
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary mt-3" onclick="filterStats()"><i class='bx bx-filter-alt'></i> Lọc</button>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-outline-danger mt-3" onclick="openExportConfirm()"><i class='bx bxs-file-pdf'></i> Xuất PDF</button>
            </div>
            <div class="col-md-2 text-end">
                <a class="btn btn-outline-secondary mt-3" href="{{ route('admin.menu-items.index') }}"><i class='bx bx-box'></i> Kho hàng</a>
            </div>
        </div>
    </div>
</div>

<!-- KPI cards -->
<div class="stats-grid mb-4">
    <div class="stats-card">
        <div class="stats-content">
            <h6>Doanh thu</h6>
            <h3>{{ number_format($totalRevenue,0,',','.') }} ₫</h3>
            <div class="small-muted">Khoảng {{ $from->toDateString() }} → {{ $to->toDateString() }}</div>
        </div>
        <div class="stats-icon bg-icon-primary"><i class='bx bx-money'></i></div>
    </div>

    <div class="stats-card">
        <div class="stats-content">
            <h6>Tổng đơn</h6>
            <h3>{{ $totalOrders }}</h3>
            <div class="small-muted">Đơn hoàn thành</div>
        </div>
        <div class="stats-icon bg-icon-warning"><i class='bx bx-shopping-bag'></i></div>
    </div>

    <div class="stats-card">
        <div class="stats-content">
            <h6>Đã bán</h6>
            <h3>{{ $totalItems }}</h3>
            <div class="small-muted">Sản phẩm</div>
        </div>
        <div class="stats-icon bg-icon-success"><i class='bx bx-dish'></i></div>
    </div>

    <div class="stats-card">
        <div class="stats-content">
            <h6>Tỉ lệ hủy</h6>
            <h3 class="text-danger">{{ $cancelRate }}%</h3>
            <div class="small-muted">Tỉ lệ trên tổng</div>
        </div>
        <div class="stats-icon bg-icon-danger"><i class='bx bx-x-circle'></i></div>
    </div>
</div>

<!-- Comparison + Chart area -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card" style="border-radius:12px; box-shadow:0 6px 18px rgba(15,23,42,0.04);">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0 fw-bold">So sánh doanh thu</h5>

                    <div class="chart-toolbar">
                        <div class="btn-group toggle-group" role="group" aria-label="Timeframe">
                            <button class="btn btn-sm btn-outline-secondary active" data-range="7">Ngày</button>
                            <button class="btn btn-sm btn-outline-secondary" data-range="8w">Tuần</button>
                            <button class="btn btn-sm btn-outline-secondary" data-range="12m">Tháng</button>
                        </div>

                        <div class="ms-3 small-muted text-end">
                            <div>Chu kỳ hiện tại vs Chu kỳ trước</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-3">
                    <div class="card-compare" style="flex:1">
                        <div>
                            <div class="small-muted">Hôm nay</div>
                            <div class="delta {{ $revenueToday >= $revenueYesterday ? 'up' : 'down' }}">
                                {{ number_format($revenueToday,0,',','.') }} ₫
                            </div>
                            <div class="small-muted">So với hôm qua:
                                @php
                                    $delta = $revenueYesterday > 0 ? round((($revenueToday - $revenueYesterday) / $revenueYesterday) * 100,2) : ($revenueToday>0?100:0);
                                @endphp
                                <span class="ms-1 {{ $delta>=0 ? 'delta up' : 'delta down' }}">{{ $delta }}%</span>
                            </div>
                        </div>
                        <div class="sparkline" id="sparkToday"></div>
                    </div>

                    <div class="card-compare" style="flex:1">
                        <div>
                            <div class="small-muted">Tuần này</div>
                            <div class="delta {{ $weekThis >= $weekLast ? 'up' : 'down' }}">{{ number_format($weekThis,0,',','.') }} ₫</div>
                            <div class="small-muted">So với tuần trước:
                                @php
                                    $deltaW = $weekLast > 0 ? round((($weekThis - $weekLast)/$weekLast)*100,2) : ($weekThis>0?100:0);
                                @endphp
                                <span class="ms-1 {{ $deltaW>=0 ? 'delta up' : 'delta down' }}">{{ $deltaW }}%</span>
                            </div>
                        </div>
                        <div class="sparkline" id="sparkWeek"></div>
                    </div>

                    <div class="card-compare" style="flex:1">
                        <div>
                            <div class="small-muted">Tháng này</div>
                            <div class="delta {{ $monthThis >= $monthLast ? 'up' : 'down' }}">{{ number_format($monthThis,0,',','.') }} ₫</div>
                            <div class="small-muted">So với tháng trước:
                                @php
                                    $deltaM = $monthLast > 0 ? round((($monthThis - $monthLast)/$monthLast)*100,2) : ($monthThis>0?100:0);
                                @endphp
                                <span class="ms-1 {{ $deltaM>=0 ? 'delta up' : 'delta down' }}">{{ $deltaM }}%</span>
                            </div>
                        </div>
                        <div class="sparkline" id="sparkMonth"></div>
                    </div>
                </div>
                <div style="height:360px;">
                    <canvas id="compareChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <!-- Category share -->
        <div class="card mb-3" style="border-radius:12px;">
            <div class="card-body">
                <h6 class="fw-bold">Tỷ lệ bán theo danh mục</h6>
                <canvas id="categoryChartCompact" style="height:220px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card" style="border-radius:12px;">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Top 5 sản phẩm bán chạy nhất</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Danh mục</th>
                                <th class="text-end">Đã bán</th>
                                <th class="text-end">Doanh thu</th>
                                <th class="text-end">VAT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $p)
                            <tr>
                                <td class="d-flex align-items-center">
                                    <img src="{{ $p->img ? asset($p->img) : asset('images/menu/default.png') }}" class="top-product-img me-2">
                                    <div>{{ $p->name }}</div>
                                </td>
                                <td>{{ $p->category }}</td>
                                <td class="text-end">{{ $p->sold }}</td>
                                <td class="text-end">{{ number_format($p->revenue,0,',','.') }} ₫</td>
                                <td class="text-end">{{ number_format($p->vat,0,',','.') }} ₫</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
</div>
<div class="row g-4 mb-4 mt-2">
    <div class="col-lg-7">
        <div class="card" style="border-radius:12px;">
            <div class="card-body">
                <h6 class="fw-bold mb-3">🏆 Top khách hàng chi tiêu</h6>

                @php
                    $maxSpent = $topCustomers->max('total_spent') ?: 1;
                @endphp

                @foreach($topCustomers as $index => $c)
                @php
                    $percent = round(($c->total_spent / $maxSpent) * 100);
                    $rankColor = match($index){
                        0 => 'bg-warning',
                        1 => 'bg-secondary',
                        2 => 'bg-info',
                        3 => 'bg-primary',
                        4 => 'bg-success',
                        default => 'bg-light'
                    };
                @endphp

                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <div class="rounded-circle {{ $rankColor }} text-white fw-bold d-flex align-items-center justify-content-center"
                            style="width:42px;height:42px;">
                            #{{ $index+1 }}
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-fill">
                        <div class="fw-semibold">{{ $c->name }}</div>
                        <div class="small text-muted">{{ $c->orders_count }} đơn</div>

                        <div class="progress mt-1" style="height:6px;">
                            <div class="progress-bar bg-success" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>

                    <div class="fw-bold text-end ms-3">
                        {{ number_format($c->total_spent,0,',','.') }} ₫
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card" style="border-radius:12px;">
            <div class="card-body">
                <h6 class="fw-bold mb-3">🔥 Top sản phẩm theo doanh thu</h6>

                @php
                    $maxRevenue = $topProductsRevenue->max('revenue') ?: 1;
                @endphp

                @foreach($topProductsRevenue as $i => $p)
                @php
                    $percent = round(($p->revenue / $maxRevenue) * 100);
                @endphp

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-semibold">
                            {{ $i+1 }}. {{ $p->name }}
                        </div>
                        <div class="fw-bold">
                            {{ number_format($p->revenue,0,',','.') }} ₫
                        </div>
                    </div>

                    <div class="progress mt-1" style="height:6px;">
                        <div class="progress-bar bg-primary" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



@include('admin.partials.modals.confirm_statistic')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/**
 * Data passed from controller
 * - 7 days: labels7, data7, prev7
 * - 8 weeks: labels8w, data8w, prev8w
 * - 12 months: labels12, data12, prev12
 * categoryShare, topProducts, topCustomers available in blade too
 */
const labels7 = @json($labels7 ?? []);
const data7 = @json($data7 ?? []);
const prev7 = @json($prev7 ?? []);

const labels8w = @json($labels8w ?? []);
const data8w = @json($data8w ?? []);
const prev8w = @json($prev8w ?? []);

const labels12 = @json($labels12 ?? []);
const data12 = @json($data12 ?? []);
const prev12 = @json($prev12 ?? []);

const categoryLabels = @json($categoryShare->pluck('category'));
const categoryData = @json($categoryShare->pluck('total_sold'));

// small sparkline generator (mini chart)
function renderSparkline(ctxId, arr) {
    const ctx = document.getElementById(ctxId);
    if (!ctx) return;
    new Chart(ctx, {
        type: 'bar',
        data: { labels: Array.from({length: arr.length}, (_,i)=>i+1), datasets:[{ data: arr }]},
        options: { responsive:true, maintainAspectRatio:true, plugins:{legend:{display:false}}, scales:{ x:{ display:false }, y:{ display:false } } }
    });
}

// main compare chart (line)
let compareChart;
const ctx = document.getElementById('compareChart').getContext('2d');

function buildChart(labels, currentData, previousData, labelCurrent='Hiện tại', labelPrev='Trước đó') {
    if (compareChart) compareChart.destroy();

    compareChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: labelPrev,
                    data: previousData,
                    borderColor: 'rgba(99,102,241,0.65)',
                    backgroundColor: 'rgba(99,102,241,0.08)',
                    borderDash: [6,4],
                    tension: 0.35,
                    pointRadius: 3,
                    fill: true
                },
                {
                    label: labelCurrent,
                    data: currentData,
                    borderColor: 'rgba(255,111,66,0.95)',
                    backgroundColor: 'rgba(255,111,66,0.12)',
                    tension: 0.35,
                    pointRadius: 4,
                    fill: true
                }
            ]
        },
        options: {
            responsive:true,
            interaction: { mode:'index', intersect:false },
            plugins: {
                legend: { position:'top' }
            },
            scales: {
                y: { beginAtZero:true, ticks:{ callback: function(v){ return v>=1000 ? new Intl.NumberFormat().format(v) : v; } } }
            }
        }
    });
}

// initial render: day (7)
document.addEventListener('DOMContentLoaded', function() {
    // initial chart
    buildChart(labels7, data7, prev7, '7 ngày gần nhất', '7 ngày trước');

    // render sparklines
    renderSparkline('sparkToday', data7.slice(-7));
    renderSparkline('sparkWeek', data8w.slice(-8) || []);
    renderSparkline('sparkMonth', data12.slice(-6) || []);

    // category doughnut
    const ctxCat = document.getElementById('categoryChartCompact').getContext('2d');
    new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                borderWidth:0
            }]
        },
        options: { responsive:true, cutout:'60%', plugins:{ legend:{ position:'bottom' } } }
    });

    // toggle buttons
    document.querySelectorAll('.toggle-group .btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.toggle-group .btn').forEach(b=>b.classList.remove('active'));
            this.classList.add('active');

            const range = this.dataset.range;
            if (range === '7') {
                buildChart(labels7, data7, prev7, '7 ngày gần nhất', '7 ngày trước');
            } else if (range === '8w') {
                buildChart(labels8w, data8w, prev8w, '8 tuần gần nhất', '8 tuần trước');
            } else {
                buildChart(labels12, data12, prev12, '12 tháng gần nhất', '12 tháng trước');
            }
        });
    });

});
/* Filter & PDF */
function filterStats(){
    const from = document.getElementById('dateFrom').value;
    const to = document.getElementById('dateTo').value;
    const url = new URL(window.location.href);
    if (from) url.searchParams.set('from', from);
    else url.searchParams.delete('from');
    if (to) url.searchParams.set('to', to);
    else url.searchParams.delete('to');
    window.location.href = url.toString();
}

function openExportConfirm(){
    const from = document.getElementById('dateFrom').value || '---';
    const to = document.getElementById('dateTo').value || '---';
    document.getElementById('confirmFrom').innerText = from;
    document.getElementById('confirmTo').innerText = to;
    const modal = new bootstrap.Modal(document.getElementById('exportConfirmModal'));
    modal.show();
}

function confirmExportPdf(){
    const from = document.getElementById('dateFrom').value;
    const to = document.getElementById('dateTo').value;
    let url = "{{ route('admin.statistics.export.pdf') }}";
    const params = new URLSearchParams();
    if (from) params.append('from', from);
    if (to) params.append('to', to);
    window.open(url + '?' + params.toString(), '_blank');
    bootstrap.Modal.getInstance(document.getElementById('exportConfirmModal')).hide();
}
</script>
@endpush
