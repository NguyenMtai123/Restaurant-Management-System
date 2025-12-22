// Dữ liệu giả lập cho Thống kê (Mock Data)
const statsData = {
  revenue: 125000000, // 125 triệu
  orders: 1250,
  itemsSold: 3400,
  cancelRate: 2.4, // %

  // Dữ liệu biểu đồ doanh thu (12 tháng)
  monthlyRevenue: [45, 52, 48, 60, 55, 68, 72, 85, 90, 88, 110, 125], // Đơn vị: Triệu

  // Dữ liệu biểu đồ danh mục
  categoryShare: [45, 35, 20], // Đồ ăn, Đồ uống, Ăn vặt (%)

  // Top sản phẩm
  topProducts: [
    {
      name: "Cơm Gà Xối Mỡ",
      category: "Đồ ăn",
      sold: 450,
      revenue: 20250000,
      img: "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=100",
    },
    {
      name: "Trà Đào Cam Sả",
      category: "Đồ uống",
      sold: 380,
      revenue: 13300000,
      img: "https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=100",
    },
    {
      name: "Bánh Mì Đặc Biệt",
      category: "Đồ ăn",
      sold: 310,
      revenue: 7750000,
      img: "https://images.unsplash.com/photo-1550547660-d9450f859349?w=100",
    },
    {
      name: "Cà Phê Sữa Đá",
      category: "Đồ uống",
      sold: 290,
      revenue: 5220000,
      img: "https://i.pinimg.com/736x/1f/b1/64/1fb16469948fe4d6b43067bd6bd87572.jpg",
    },
    {
      name: "Khoai Tây Chiên",
      category: "Ăn vặt",
      sold: 150,
      revenue: 3000000,
      img: "https://images.unsplash.com/photo-1518013431117-eb1465fa5752?w=100",
    },
  ],
};

// Format tiền tệ
const formatCurrency = (amount) => {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(amount);
};

// Hàm khởi tạo số liệu tổng quan
const initStatsCards = () => {
  document.getElementById("totalRevenue").innerText = formatCurrency(
    statsData.revenue
  );
  document.getElementById("totalOrders").innerText = statsData.orders;
  document.getElementById("totalItems").innerText = statsData.itemsSold;
  document.getElementById("cancelRate").innerText = statsData.cancelRate + "%";

  // Set ngày mặc định (Đầu tháng đến nay)
  const today = new Date();
  document.getElementById("dateTo").valueAsDate = today;
  document.getElementById("dateFrom").valueAsDate = new Date(
    today.getFullYear(),
    today.getMonth(),
    1
  );
};

// Vẽ biểu đồ Doanh thu (Line Chart)
const initRevenueChart = () => {
  const ctx = document.getElementById("revenueAnalyticsChart").getContext("2d");

  new Chart(ctx, {
    type: "line",
    data: {
      labels: [
        "T1",
        "T2",
        "T3",
        "T4",
        "T5",
        "T6",
        "T7",
        "T8",
        "T9",
        "T10",
        "T11",
        "T12",
      ],
      datasets: [
        {
          label: "Doanh thu (Triệu VNĐ)",
          data: statsData.monthlyRevenue,
          borderColor: "#ff6b35", // Primary Color
          backgroundColor: "rgba(255, 107, 53, 0.1)",
          tension: 0.4,
          fill: true,
          pointBackgroundColor: "#fff",
          pointBorderColor: "#ff6b35",
          pointRadius: 5,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          mode: "index",
          intersect: false,
          callbacks: {
            label: function (context) {
              return context.parsed.y + " Triệu VNĐ";
            },
          },
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { borderDash: [5, 5] },
        },
        x: {
          grid: { display: false },
        },
      },
    },
  });
};

// Vẽ biểu đồ Danh mục (Doughnut Chart)
const initCategoryChart = () => {
  const ctx = document.getElementById("categoryChart").getContext("2d");

  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: ["Đồ ăn", "Đồ uống", "Ăn vặt"],
      datasets: [
        {
          data: statsData.categoryShare,
          backgroundColor: [
            "#ff6b35", // Cam (Primary)
            "#2ecc71", // Xanh lá
            "#f1c40f", // Vàng
          ],
          borderWidth: 0,
          hoverOffset: 4,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: "bottom",
          labels: { usePointStyle: true, padding: 20 },
        },
      },
      cutout: "70%", // Độ mỏng của vòng tròn
    },
  });
};

// Render Bảng Top Sản Phẩm
const renderTopProducts = () => {
  const tbody = document.getElementById("topProductsTable");
  tbody.innerHTML = "";

  statsData.topProducts.forEach((product, index) => {
    const rankClass =
      index === 0
        ? "rank-1"
        : index === 1
        ? "rank-2"
        : index === 2
        ? "rank-3"
        : "bg-light";
    const row = `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <span class="rank-badge ${rankClass}">${
      index + 1
    }</span>
                        <img src="${product.img}" class="top-product-img">
                        <span class="fw-semibold">${product.name}</span>
                    </div>
                </td>
                <td><span class="badge bg-light text-dark border">${
                  product.category
                }</span></td>
                <td class="text-end fw-bold">${product.sold}</td>
                <td class="text-end pe-4 text-primary">${formatCurrency(
                  product.revenue
                )}</td>
            </tr>
        `;
    tbody.innerHTML += row;
  });
};

// Chức năng lọc (Demo alert)
window.filterStats = () => {
  const from = document.getElementById("dateFrom").value;
  const to = document.getElementById("dateTo").value;
  alert(
    `Đang lọc dữ liệu từ ${from} đến ${to}...\n(Chức năng này cần kết nối Backend thực tế)`
  );
};

// Khởi chạy
document.addEventListener("DOMContentLoaded", () => {
  initStatsCards();
  initRevenueChart();
  initCategoryChart();
  renderTopProducts();
});
