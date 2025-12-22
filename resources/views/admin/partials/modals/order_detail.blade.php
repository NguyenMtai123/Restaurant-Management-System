<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Chi tiết đơn hàng <span id="modalOrderId" class="text-primary">#ORD-000</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="fw-bold">Thông tin khách hàng:</h6>
                            <p class="mb-1" id="modalCustomerName">Nguyễn Văn A</p>
                            <p class="mb-1 small text-muted" id="modalCustomerPhone">0909 123 456</p>
                            <p class="mb-0 small text-muted" id="modalCustomerAddress">123 Đường ABC, Quận 1, TP.HCM</p>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <h6 class="fw-bold">Trạng thái:</h6>
                            <span id="modalOrderStatus" class="badge bg-warning">Chờ xử lý</span>
                            <p class="mt-2 mb-0 small text-muted" id="modalOrderDate">10:30 - 12/12/2023</p>
                        </div>
                    </div>

                    <div class="table-responsive bg-light p-3 rounded mb-3">
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr class="text-muted small border-bottom">
                                    <th>Món ăn</th>
                                    <th class="text-center">SL</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody id="modalOrderItems">
                                </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold pt-3">Tổng cộng:</td>
                                    <td class="text-end fw-bold pt-3 text-primary fs-5" id="modalOrderTotal">0 ₫</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ghi chú của khách:</label>
                        <p class="text-muted bg-light p-2 rounded small" id="modalOrderNote">Không có ghi chú.</p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary text-white" onclick="printOrder()"><i class='bx bx-printer'></i> In hóa đơn</button>
                </div>
            </div>
        </div>
    </div>
