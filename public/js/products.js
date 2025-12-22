// Dữ liệu mẫu (Giả lập database)
// const productsData = [
//     {
//         id: "SP001",
//         name: "Bánh Mì Đặc Biệt",
//         category: "food",
//         categoryName: "Đồ ăn",
//         price: 25000,
//         image: "https://images.unsplash.com/photo-1550547660-d9450f859349?w=100", // Ảnh demo
//         status: "Còn hàng"
//     },
//     {
//         id: "SP002",
//         name: "Cà Phê Sữa Đá",
//         category: "drink",
//         categoryName: "Đồ uống",
//         price: 18000,
//         image: "https://i.pinimg.com/736x/1f/b1/64/1fb16469948fe4d6b43067bd6bd87572.jpg",
//         status: "Còn hàng"
//     },
//     {
//         id: "SP003",
//         name: "Trà Đào Cam Sả",
//         category: "drink",
//         categoryName: "Đồ uống",
//         price: 35000,
//         image: "https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=100",
//         status: "Sắp hết"
//     },
//     {
//         id: "SP004",
//         name: "Khoai Tây Chiên",
//         category: "snack",
//         categoryName: "Ăn vặt",
//         price: 20000,
//         image: "https://images.unsplash.com/photo-1518013431117-eb1465fa5752?w=100",
//         status: "Hết hàng"
//     },
//     {
//         id: "SP005",
//         name: "Cơm Gà Xối Mỡ",
//         category: "food",
//         categoryName: "Đồ ăn",
//         price: 45000,
//         image: "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=100",
//         status: "Còn hàng"
//     }
// ];

// Function format tiền tệ VNĐ
const formatCurrency = (amount) => {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
};

// Function lấy class màu dựa trên trạng thái
const getStatusBadge = (status) => {
    if (status === true) return "badge-stock";
    // if (status === "Sắp hết") return "badge-low";
    return "badge-out";
};

// Function Render Bảng
const renderTable = (data) => {
    const tableBody = document.getElementById("productTableBody");
    tableBody.innerHTML = ""; // Xóa dữ liệu cũ

    data.forEach(product => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td class="ps-4 fw-bold text-muted">#${product.id}</td>
            <td>
                <div class="product-img-group">
                    <img src="${product.image}" alt="" class="product-thumb">
                    <div class="product-info">
                        <h6>${product.name}</h6>
                        <small>ID: ${product.id}</small>
                    </div>
                </div>
            </td>
            <td><span class="badge bg-light text-dark border">${product.categoryName}</span></td>
            <td class="fw-bold">${formatCurrency(product.price)}</td>
            <td><span class="badge rounded-pill ${getStatusBadge(product.status)}">${product.status}</span></td>
            <td class="text-end pe-4">
                <button class="action-btn" title="Chỉnh sửa"><i class='bx bx-edit'></i></button>
                <button class="action-btn delete" title="Xóa" onclick="deleteProduct('${product.id}')"><i class='bx bx-trash'></i></button>
            </td>
        `;
        tableBody.appendChild(row);
    });
};

// Chức năng Xóa (Demo)
window.deleteProduct = (id) => {
    if(confirm(`Bạn có chắc muốn xóa sản phẩm ${id} không?`)) {
        // Trong thực tế sẽ gọi API xóa, ở đây ta lọc mảng
        const index = productsData.findIndex(p => p.id === id);
        if (index > -1) {
            productsData.splice(index, 1);
            renderTable(productsData); // Render lại bảng
            alert("Đã xóa thành công!");
        }
    }
};

// Chức năng Tìm kiếm
document.getElementById('searchInput').addEventListener('keyup', function(e) {
    const term = e.target.value.toLowerCase();
    const filtered = productsData.filter(item =>
        item.name.toLowerCase().includes(term) ||
        item.id.toLowerCase().includes(term)
    );
    renderTable(filtered);
});

// Chức năng Lọc Danh mục
document.getElementById('categoryFilter').addEventListener('change', function(e) {
    const cat = e.target.value;
    if(cat === 'all') {
        renderTable(productsData);
    } else {
        const filtered = productsData.filter(item => item.category === cat);
        renderTable(filtered);
    }
});

// Khởi chạy lần đầu
document.addEventListener("DOMContentLoaded", () => {
    renderTable(productsData);
});
