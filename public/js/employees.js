// Dữ liệu mẫu Nhân viên
const employeesData = [
    {
        id: "NV-001",
        name: "Phạm Văn Minh",
        role: "Quản lý",
        phone: "0909 888 777",
        email: "minh.pham@takeaway.com",
        shift: "Full",
        joinDate: "2022-01-10",
        status: "Đang làm việc",
        avatar: "https://ui-avatars.com/api/?name=Pham+Van+Minh&background=34495e&color=fff"
    },
    {
        id: "NV-002",
        name: "Nguyễn Thị Hoa",
        role: "Thu ngân",
        phone: "0912 333 444",
        email: "hoa.nguyen@takeaway.com",
        shift: "Sáng",
        joinDate: "2023-03-15",
        status: "Đang làm việc",
        avatar: "https://ui-avatars.com/api/?name=Nguyen+Thi+Hoa&background=3498db&color=fff"
    },
    {
        id: "NV-003",
        name: "Lê Tuấn Anh",
        role: "Đầu bếp",
        phone: "0987 654 321",
        email: "tuan.le@takeaway.com",
        shift: "Chiều",
        joinDate: "2023-05-20",
        status: "Đang làm việc",
        avatar: "https://ui-avatars.com/api/?name=Le+Tuan+Anh&background=e67e22&color=fff"
    },
    {
        id: "NV-004",
        name: "Trần Hùng",
        role: "Giao hàng",
        phone: "0905 123 123",
        email: "hung.tran@takeaway.com",
        shift: "Chiều",
        joinDate: "2023-08-01",
        status: "Nghỉ phép",
        avatar: "https://ui-avatars.com/api/?name=Tran+Hung&background=27ae60&color=fff"
    },
    {
        id: "NV-005",
        name: "Hoàng Yến",
        role: "Thu ngân",
        phone: "0933 456 789",
        email: "yen.hoang@takeaway.com",
        shift: "Chiều",
        joinDate: "2023-11-12",
        status: "Đang làm việc",
        avatar: "https://ui-avatars.com/api/?name=Hoang+Yen&background=3498db&color=fff"
    }
];

// Helper: Lấy class CSS theo chức vụ
const getRoleClass = (role) => {
    switch(role) {
        case 'Quản lý': return 'role-manager';
        case 'Thu ngân': return 'role-cashier';
        case 'Đầu bếp': return 'role-chef';
        case 'Giao hàng': return 'role-shipper';
        default: return 'bg-light text-dark border';
    }
};

// Helper: Lấy dot trạng thái
const getStatusDot = (status) => {
    return status === 'Đang làm việc' ? 'dot-active' : 'dot-leave';
};

// Render Bảng Nhân viên
const renderEmployeeTable = (data) => {
    const tbody = document.getElementById("employeeTableBody");
    tbody.innerHTML = "";

    data.forEach(emp => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td class="ps-4">
                <div class="d-flex align-items-center gap-3">
                    <img src="${emp.avatar}" class="employee-avatar shadow-sm">
                    <div>
                        <h6 class="mb-0 fw-semibold">${emp.name}</h6>
                        <small class="text-muted fw-bold">${emp.id}</small>
                    </div>
                </div>
            </td>
            <td>
                <span class="badge rounded-pill badge-role ${getRoleClass(emp.role)}">${emp.role}</span>
            </td>
            <td>
                <div class="d-flex flex-column">
                    <small><i class='bx bx-phone'></i> ${emp.phone}</small>
                    <small class="text-muted"><i class='bx bx-envelope'></i> ${emp.email}</small>
                </div>
            </td>
            <td>
                <span class="fw-medium">${emp.shift}</span>
            </td>
            <td>${emp.joinDate}</td>
            <td>
                <div class="d-flex align-items-center">
                    <span class="status-dot ${getStatusDot(emp.status)}"></span>
                    <span class="small ${emp.status === 'Nghỉ phép' ? 'text-danger' : 'text-success'}">${emp.status}</span>
                </div>
            </td>
            <td class="text-end pe-4">
                <button class="action-btn" title="Chỉnh sửa"><i class='bx bx-edit'></i></button>
                <button class="action-btn delete" title="Xóa" onclick="deleteEmployee('${emp.id}')"><i class='bx bx-trash'></i></button>
            </td>
        `;
        tbody.appendChild(row);
    });
};

// Xóa nhân viên
window.deleteEmployee = (id) => {
    if(confirm(`Bạn có chắc muốn xóa nhân viên ${id} khỏi hệ thống?`)) {
        const index = employeesData.findIndex(e => e.id === id);
        if(index > -1) {
            employeesData.splice(index, 1);
            renderEmployeeTable(employeesData);
            alert("Đã xóa nhân viên thành công!");
        }
    }
};

// Tìm kiếm
document.getElementById('searchEmployee').addEventListener('keyup', (e) => {
    const term = e.target.value.toLowerCase();
    const filtered = employeesData.filter(emp => 
        emp.name.toLowerCase().includes(term) || 
        emp.id.toLowerCase().includes(term) ||
        emp.phone.includes(term)
    );
    renderEmployeeTable(filtered);
});

// Lọc theo Chức vụ
document.getElementById('roleFilter').addEventListener('change', (e) => {
    const role = e.target.value;
    if(role === 'all') {
        renderEmployeeTable(employeesData);
    } else {
        const filtered = employeesData.filter(emp => emp.role === role);
        renderEmployeeTable(filtered);
    }
});

// Init
document.addEventListener("DOMContentLoaded", () => {
    renderEmployeeTable(employeesData);
});