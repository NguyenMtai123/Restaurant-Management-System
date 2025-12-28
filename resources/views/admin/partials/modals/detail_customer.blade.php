<div class="modal fade" id="customerDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Hồ sơ khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center border-end">
                            <img id="modalAvatar" src="" class="rounded-circle mb-3" width="100" height="100">
                            <h5 class="fw-bold mb-1" id="modalName"></h5>
                            <span class="badge rounded-pill mb-3" id="modalRank"></span>
                            <div class="d-grid gap-2 px-3 mt-4">
                                <button class="btn btn-outline-primary btn-sm"><i class='bx bx-envelope'></i> Gửi Email</button>
                                <button class="btn btn-outline-success btn-sm"><i class='bx bx-phone'></i> Gọi điện</button>
                            </div>
                        </div>
                        <div class="col-md-8 ps-md-4">
                            <h6 class="fw-bold border-bottom pb-2">Thông tin cá nhân</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Email</small>
                                    <span class="fw-medium" id="modalEmail"></span>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Số điện thoại</small>
                                    <span class="fw-medium" id="modalPhone"></span>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">Địa chỉ</small>
                                    <span class="fw-medium" id="modalAddress"></span>
                                </div>
                            </div>

                            <h6 class="fw-bold border-bottom pb-2">Lịch sử đơn hàng gần đây</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless">
                                    <thead class="text-muted small">
                                        <tr>
                                            <th>Mã đơn</th>
                                            <th>Ngày</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modalHistoryBody">
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
