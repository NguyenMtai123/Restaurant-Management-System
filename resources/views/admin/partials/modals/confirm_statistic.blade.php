<!-- Modal xác nhận xuất báo cáo -->
<div class="modal fade" id="exportConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class='bx bxs-file-pdf text-danger'></i>
                    Xác nhận xuất báo cáo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2">
                    Bạn có chắc chắn muốn <strong>xuất báo cáo PDF</strong> với dữ liệu:
                </p>

                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Từ ngày</span>
                        <strong id="confirmFrom"></strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Đến ngày</span>
                        <strong id="confirmTo"></strong>
                    </li>
                </ul>

                <div class="alert alert-warning small mb-0">
                    <i class='bx bx-info-circle'></i>
                    Báo cáo chỉ bao gồm <strong>đơn hàng đã hoàn thành</strong>.
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Hủy
                </button>
                <button class="btn btn-danger" onclick="confirmExportPdf()">
                    <i class='bx bxs-file-pdf'></i> Xác nhận xuất
                </button>
            </div>
        </div>
    </div>
</div>
