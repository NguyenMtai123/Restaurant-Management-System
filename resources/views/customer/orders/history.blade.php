@extends('customer.layouts.app')

@section('title', 'Lịch sử đơn hàng')

@section('content')
<div class="orders-container">
    <h2>Lịch sử đơn hàng</h2>

    @if($orders->count() > 0)
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="status {{ $order->status }}">{{ ucfirst($order->status) }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                        <td>
                            <button class="btn-view" onclick="showOrderDetail({{ $order->id }})">Xem</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $orders->links('pagination::simple-tailwind') }}
        </div>
    @else
        <p class="no-orders">Bạn chưa có đơn hàng nào.</p>
    @endif
</div>

<!-- Modal chi tiết đơn hàng thuần -->
<div id="orderDetailModal" class="custom-modal">
  <div class="custom-modal-content">
    <span class="custom-modal-close" onclick="closeModal()">&times;</span>
    <div id="orderDetailContent">
        <p>Đang tải...</p>
    </div>
  </div>
</div>

<style>
.orders-container {
    max-width: 900px;
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    font-family: 'Poppins', sans-serif;
}

.orders-container h2 {
    text-align: center;
    color: #FF6B35;
    margin-bottom: 25px;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.orders-table th, .orders-table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

.orders-table th {
    background: #f8f8f8;
}

.status.paid {
    color: #198754;
    font-weight: bold;
}
.status.pending {
    color: #ffc107;
    font-weight: bold;
}
.status.cancelled {
    color: #dc3545;
    font-weight: bold;
}

.btn-view {
    padding: 5px 10px;
    background: #FF6B35;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.3s;
}
.btn-view:hover {
    background: #ff824c;
}

.no-orders {
    text-align: center;
    font-size: 16px;
    color: #555;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
}

/* Modal thuần CSS */
.custom-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.custom-modal-content {
    background-color: #fff;
    margin: 8% auto;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 700px;
    position: relative;
}

.custom-modal-close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.order-detail table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
}

.order-detail th, .order-detail td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.order-detail th {
    background-color: #f8f8f8;
}

.order-detail p {
    margin: 4px 0;
}
</style>

<script>
function showOrderDetail(orderId) {
    const modal = document.getElementById('orderDetailModal');
    const content = document.getElementById('orderDetailContent');
    content.innerHTML = '<p>Đang tải...</p>';

    fetch('/orders/history/' + orderId)
        .then(res => res.text())
        .then(html => {
            content.innerHTML = html;
            modal.style.display = 'block';
        })
        .catch(err => {
            content.innerHTML = '<p>Không thể tải chi tiết đơn hàng.</p>';
            console.error(err);
        });
}

function closeModal() {
    document.getElementById('orderDetailModal').style.display = 'none';
}

// Đóng modal khi click ngoài nội dung
window.onclick = function(event) {
    const modal = document.getElementById('orderDetailModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
@endsection
