// Dữ liệu mẫu Đơn hàng (Giả lập Database)
const ordersData = [
    {
        id: "ORD-001",
        customer: { name: "Nguyễn Văn An", phone: "0909 111 222", address: "123 Lê Lợi, Q1" },
        date: "2023-12-14",
        time: "10:30",
        total: 150000,
        payment: "Momo",
        status: "completed", // pending, completed, cancelled
        note: "Ít cay, nhiều tương ớt",
        items: [
            { name: "Cơm Gà Xối Mỡ", qty: 2, price: 45000 },
            { name: "Trà Đào Cam Sả", qty: 2, price: 30000 }
        ]
    },
    {
        id: "ORD-002",
        customer: { name: "Trần Thị Bích", phone: "0988 777 666", address: "45 Nguyễn Huệ, Q1" },
        date: "2023-12-14",
        time: "11:15",
        total: 85000,
        payment: "Tiền mặt",
        status: "pending",
        note: "",
        items: [
            { name: "Bánh Mì Đặc Biệt", qty: 1, price: 25000 },
            { name: "Cà Phê Sữa Đá", qty: 1, price: 18000 },
            { name: "Khoai Tây Chiên", qty: 2, price: 21000 }
        ]
    },
    {
        id: "ORD-003",
        customer: { name: "Lê Hoàng Nam", phone: "0912 345 678", address: "Chung cư ABC, Q7" },
        date: "2023-12-13",
        time: "18:45",
        total: 210000,
        payment: "Banking",
        status: "cancelled",
        note: "Giao trước 7h tối",
        items: [
            { name: "Pizza Hải Sản", qty: 1, price: 180000 },
            { name: "Coca Cola", qty: 3, price: 10000 }
        ]
    }
];

// Helper: Format tiền tệ
const formatCurrency = (amount) => {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
};

// Helper: Lấy Badge trạng thái
const getStatusBadge = (status) => {
    switch(status) {
        case 'completed': return '<span class="badge badge-completed rounded-pill">Hoàn thành</span>';
        case 'pending': return '<span class="badge badge-pending rounded-pill">Chờ xử lý</span>';
        case 'cancelled': return '<span class="badge badge-cancelled rounded-pill">Đã hủy</span>';
        default: return '<span class="badge bg-secondary">Không rõ</span>';
    }
};

// Helper: Dịch tên trạng thái
const getStatusText = (status) => {
    switch(status) {
        case 'completed': return 'Hoàn thành';
        case 'pending': return 'Chờ xử lý';
        case 'cancelled': return 'Đã hủy';
        default: return 'Không rõ';
    }
};

// Render Bảng Đơn Hàng
const renderOrderTable = (data) => {
    const tableBody = document.getElementById("orderTableBody");
    tableBody.innerHTML = "";

    data.forEach(order => {
        const row = document.createElement("tr");
        
        // Tạo avatar chữ cái đầu tên khách
        const initial = order.customer.name.charAt(0).toUpperCase();

        row.innerHTML = `
            <td class="ps-4 fw-bold text-primary">${order.id}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="customer-avatar me-2">${initial}</div>
                    <div>
                        <div class="fw-bold fs-6">${order.customer.name}</div>
                        <small class="text-muted">${order.customer.phone}</small>
                    </div>
                </div>
            </td>
            <td>
                <div>${order.date}</div>
                <small class="text-muted">${order.time}</small>
            </td>
            <td class="fw-bold text-danger">${formatCurrency(order.total)}</td>
            <td>${order.payment}</td>
            <td>${getStatusBadge(order.status)}</td>
            <td class="text-end pe-4">
                <button class="action-btn" title="Xem chi tiết" onclick="viewOrderDetails('${order.id}')">
                    <i class='bx bx-show'></i>
                </button>
                <button class="action-btn delete" title="Xóa" onclick="deleteOrder('${order.id}')">
                    <i class='bx bx-trash'></i>
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
};

// Chức năng: Xem chi tiết đơn hàng (Mở Modal)
window.viewOrderDetails = (id) => {
    const order = ordersData.find(o => o.id === id);
    if (!order) return;

    // Điền thông tin vào Modal
    document.getElementById('modalOrderId').innerText = `#${order.id}`;
    document.getElementById('modalCustomerName').innerText = order.customer.name;
    document.getElementById('modalCustomerPhone').innerText = order.customer.phone;
    document.getElementById('modalCustomerAddress').innerText = order.customer.address;
    document.getElementById('modalOrderDate').innerText = `${order.time} - ${order.date}`;
    document.getElementById('modalOrderTotal').innerText = formatCurrency(order.total);
    document.getElementById('modalOrderNote').innerText = order.note || "Không có ghi chú";

    // Cập nhật Badge trạng thái trong Modal
    const statusEl = document.getElementById('modalOrderStatus');
    statusEl.className = `badge rounded-pill ${order.status === 'completed' ? 'badge-completed' : order.status === 'pending' ? 'badge-pending' : 'badge-cancelled'}`;
    statusEl.innerText = getStatusText(order.status);

    // Render danh sách món ăn trong Modal
    const itemsBody = document.getElementById('modalOrderItems');
    itemsBody.innerHTML = "";
    order.items.forEach(item => {
        itemsBody.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td class="text-center">${item.qty}</td>
                <td class="text-end">${formatCurrency(item.price)}</td>
                <td class="text-end fw-bold">${formatCurrency(item.price * item.qty)}</td>
            </tr>
        `;
    });

    // Mở Modal bằng Bootstrap API
    const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
    modal.show();
};

// Chức năng: Xóa đơn hàng (Demo)
window.deleteOrder = (id) => {
    if(confirm(`Bạn có chắc muốn xóa đơn hàng ${id} không?`)) {
        const index = ordersData.findIndex(o => o.id === id);
        if (index > -1) {
            ordersData.splice(index, 1);
            renderOrderTable(ordersData);
        }
    }
};

// Chức năng: In hóa đơn (Demo)
window.printOrder = () => {
    alert("Đang kết nối máy in...");
};

// Chức năng: Tìm kiếm
document.getElementById('searchOrderInput').addEventListener('keyup', function(e) {
    const term = e.target.value.toLowerCase();
    const filtered = ordersData.filter(order => 
        order.id.toLowerCase().includes(term) || 
        order.customer.name.toLowerCase().includes(term) ||
        order.customer.phone.includes(term)
    );
    renderOrderTable(filtered);
});

// Chức năng: Lọc theo trạng thái
document.getElementById('statusFilter').addEventListener('change', function(e) {
    const status = e.target.value;
    if (status === 'all') {
        renderOrderTable(ordersData);
    } else {
        const filtered = ordersData.filter(order => order.status === status);
        renderOrderTable(filtered);
    }
});

// Khởi chạy lần đầu
document.addEventListener("DOMContentLoaded", () => {
    renderOrderTable(ordersData);
});