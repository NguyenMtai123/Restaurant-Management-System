document.addEventListener("DOMContentLoaded", function() {

    /* ============================================================
     * 1. LOGIC SIDEBAR (THANH MENU TRÁI)
     * ============================================================ */
    const sidebar = document.querySelector(".sidebar");
    const sidebarBtn = document.querySelector(".sidebarBtn");

    // Chỉ chạy khi nút menu tồn tại
    if (sidebarBtn && sidebar) {
        sidebarBtn.onclick = function() {
            sidebar.classList.toggle("close");

            // Thay đổi icon menu (từ 3 gạch sang mũi tên và ngược lại)
            if(sidebar.classList.contains("close")){
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else {
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
        }
    }

    /* ============================================================
     * 2. LOGIC DROPDOWN THÔNG BÁO (HÌNH QUẢ CHUÔNG)
     * ============================================================ */
    const notifBtn = document.getElementById('notifDropdownBtn');
    const notifMenu = document.getElementById('notifDropdown');

    if (notifBtn && notifMenu) {
        // Toggle bật/tắt khi click vào chuông
        notifBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Ngăn sự kiện click lan ra ngoài
            notifMenu.classList.toggle('show');
        });

        // Đóng dropdown khi click bất kỳ đâu bên ngoài
        document.addEventListener('click', (e) => {
            if (!notifMenu.contains(e.target) && !notifBtn.contains(e.target)) {
                notifMenu.classList.remove('show');
            }
        });
    }

    /* ============================================================
     * 3. LOGIC BIỂU ĐỒ (CHART.JS)
     * ============================================================ */
    // Lấy thẻ canvas vẽ biểu đồ
    const chartCanvas = document.getElementById('revenueChart');

    // QUAN TRỌNG: Kiểm tra xem trang hiện tại có biểu đồ không
    // (Trang Dashboard có, trang Sản phẩm không có)
    if (chartCanvas) {
        const ctx = chartCanvas.getContext('2d');

        // Khởi tạo Chart
        const revenueChart = new Chart(ctx, {
            type: 'line', // Loại biểu đồ đường
            data: {
                labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'], // Trục hoành
                datasets: [{
                    label: 'Doanh thu (Triệu VNĐ)',
                    data: [12, 19, 15, 25, 22, 30, 45], // Dữ liệu
                    borderColor: '#ff6b35', // Màu cam chủ đạo (lấy từ biến CSS)
                    backgroundColor: 'rgba(255, 107, 53, 0.1)', // Màu nền mờ dưới đường
                    tension: 0.4, // Độ cong mềm mại của đường (0 là đường thẳng)
                    fill: true, // Tô màu vùng dưới
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#ff6b35',
                    pointRadius: 4, // Kích thước chấm tròn
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // Ẩn chú thích (để giao diện gọn hơn)
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5] // Nét đứt cho lưới ngang
                        }
                    },
                    x: {
                        grid: {
                            display: false // Ẩn lưới dọc
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    }
});

// Xem trước ảnh trong Modal Hồ sơ
function previewModalAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('modalAvatarPreview').src = e.target.result;
            // Cập nhật luôn avatar nhỏ trên navbar nếu muốn
            var navAvatar = document.querySelector('.user-avatar');
            if(navAvatar) navAvatar.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

/* ============================================================
 * 4. HIỂN THỊ NGÀY THÁNG NĂM (HEADER)
 * ============================================================ */
function updateCurrentDate() {
    const dateElement = document.getElementById('currentDateDisplay');

    // Kiểm tra xem trang hiện tại có thẻ hiển thị ngày không
    if (dateElement) {
        const now = new Date();

        // Mảng tên các thứ trong tuần
        const daysOfWeek = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];

        const dayName = daysOfWeek[now.getDay()];
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
        const year = now.getFullYear();

        // Định dạng: Thứ Hai, 14/12/2025
        dateElement.innerText = `${dayName}, ${day}/${month}/${year}`;
    }
}

// Gọi hàm khi trang tải xong
document.addEventListener("DOMContentLoaded", () => {
    // ... các code cũ ...
    updateCurrentDate();
});


setTimeout(() => {
        document.querySelectorAll('.home-alert').forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
}, 4000);

function previewModalAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('modalAvatarPreview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
