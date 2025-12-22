// Dữ liệu mẫu Khách hàng
const customersData = [
    {
        id: "KH001",
        name: "Nguyễn Văn An",
        email: "an.nguyen@example.com",
        phone: "0909 111 222",
        address: "123 Lê Lợi, Quận 1, TP.HCM",
        joinDate: "2023-01-15",
        ordersCount: 12,
        totalSpent: 5400000,
        rank: "VIP",
        avatar: "https://ui-avatars.com/api/?name=Nguyen+Van+An&background=ff6b35&color=fff"
    },
    {
        id: "KH002",
        name: "Trần Thị Bích",
        email: "bich.tran@example.com",
        phone: "0988 777 666",
        address: "45 Nguyễn Huệ, Quận 1, TP.HCM",
        joinDate: "2023-05-20",
        ordersCount: 3,
        totalSpent: 450000,
        rank: "Member",
        avatar: "https://ui-avatars.com/api/?name=Tran+Thi+Bich&background=2ecc71&color=fff"
    },
    {
        id: "KH003",
        name: "Lê Hoàng Nam",
        email: "nam.le@example.com",
        phone: "0912 345 678",
        address: "Chung cư Sunrise, Quận 7, TP.HCM",
        joinDate: "2023-08-10",
        ordersCount: 5,
        totalSpent: 1200000,
        rank: "Member",
        avatar: "https://ui-avatars.com/api/?name=Le+Hoang+Nam&background=3498db&color=fff"
    },
    {
        id: "KH004",
        name: "Phạm Minh Tâm",
        email: "tam.pham@example.com",
        phone: "0905 555 888",
        address: "12 Đường 3/2, Quận 10, TP.HCM",
        joinDate: "2022-11-01",
        ordersCount: 25,
        totalSpent: 15600000,
        rank: "VIP",
        avatar: "https://ui-avatars.com/api/?name=Pham+Minh+Tam&background=9b59b6&color=fff"
    }
];

// Helper: Format tiền tệ
const formatCurrency = (amount) => {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
};

// Helper: Lấy class badge theo hạng
const getRankBadge = (rank) => {
    return rank === 'VIP' ? 'badge-vip' : 'badge-member';
};

// Helper: Lấy icon theo hạng
const getRankIcon = (rank) => {
    return rank === 'VIP' ? "<i class='bx bxs-crown'></i>" : "";
};

// Render Bảng Khách hàng
const renderCustomerTable = (data) => {
    const tbody = document.getElementById("customerTableBody");
    tbody.innerHTML = "";

    data.forEach(customer => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td class="ps-4">
                <div class="customer-info-group">
                    <img src="${customer.avatar}" class="customer-avatar-small">
                    <div>
                        <h6 class="mb-0 fw-semibold">${customer.name}</h6>
                        <small class="text-muted">ID: ${customer.id}</small>
                    </div>
                </div>
            </td>
            <td>
                <div class="d-flex flex-column">
                    <small><i class='bx bx-phone'></i> ${customer.phone}</small>
                    <small class="text-muted"><i class='bx bx-envelope'></i> ${customer.email}</small>
                </div>
            </td>
            <td>${customer.joinDate}</td>
            <td class="text-center"><span class="badge bg-light text-dark border">${customer.ordersCount} đơn</span></td>
            <td class="fw-bold text-primary">${formatCurrency(customer.totalSpent)}</td>
            <td>
                <span class="badge rounded-pill ${getRankBadge(customer.rank)}">
                    ${getRankIcon(customer.rank)} ${customer.rank}
                </span>
            </td>
            <td class="text-end pe-4">
                <button class="action-btn" title="Xem chi tiết" onclick="viewCustomer('${customer.id}')">
                    <i class='bx bx-show'></i>
                </button>
                <button class="action-btn delete" title="Xóa" onclick="deleteCustomer('${customer.id}')">
                    <i class='bx bx-trash'></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
};

// Xem chi tiết (Modal)
window.viewCustomer = (id) => {
    const customer = customersData.find(c => c.id === id);
    if(!customer) return;

    // Fill thông tin
    document.getElementById('modalAvatar').src = customer.avatar;
    document.getElementById('modalName').innerText = customer.name;
    document.getElementById('modalEmail').innerText = customer.email;
    document.getElementById('modalPhone').innerText = customer.phone;
    document.getElementById('modalAddress').innerText = customer.address;
    
    // Fill Rank
    const rankEl = document.getElementById('modalRank');
    rankEl.className = `badge rounded-pill mb-3 ${getRankBadge(customer.rank)}`;
    rankEl.innerHTML = `${getRankIcon(customer.rank)} ${customer.rank}`;

    // Fake lịch sử đơn hàng (Random dữ liệu để demo)
    const historyBody = document.getElementById('modalHistoryBody');
    historyBody.innerHTML = `
        <tr>
            <td class="text-primary fw-bold">#ORD-${Math.floor(Math.random()*1000)}</td>
            <td>2023-12-10</td>
            <td>${formatCurrency(150000)}</td>
            <td><span class="badge bg-success-subtle text-success">Hoàn thành</span></td>
        </tr>
        <tr>
            <td class="text-primary fw-bold">#ORD-${Math.floor(Math.random()*1000)}</td>
            <td>2023-11-25</td>
            <td>${formatCurrency(85000)}</td>
            <td><span class="badge bg-success-subtle text-success">Hoàn thành</span></td>
        </tr>
    `;

    // Show Modal
    const modal = new bootstrap.Modal(document.getElementById('customerDetailModal'));
    modal.show();
};

// Xóa khách hàng
window.deleteCustomer = (id) => {
    if(confirm(`Bạn có chắc muốn xóa khách hàng ${id} không?`)) {
        const index = customersData.findIndex(c => c.id === id);
        if(index > -1) {
            customersData.splice(index, 1);
            renderCustomerTable(customersData);
        }
    }
};

// Tìm kiếm
document.getElementById('searchCustomer').addEventListener('keyup', (e) => {
    const term = e.target.value.toLowerCase();
    const filtered = customersData.filter(c => 
        c.name.toLowerCase().includes(term) || 
        c.phone.includes(term) || 
        c.email.toLowerCase().includes(term)
    );
    renderCustomerTable(filtered);
});

// Lọc theo Rank
document.getElementById('rankFilter').addEventListener('change', (e) => {
    const rank = e.target.value;
    if(rank === 'all') {
        renderCustomerTable(customersData);
    } else {
        const filtered = customersData.filter(c => c.rank === rank);
        renderCustomerTable(filtered);
    }
});

// Init
document.addEventListener("DOMContentLoaded", () => {
    renderCustomerTable(customersData);
});