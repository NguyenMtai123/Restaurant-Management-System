@foreach($users as $user)
    <div class="modal fade" id="deleteCustomerModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bx bx-trash"></i> Xác nhận xóa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="bx bx-error-circle text-danger fs-1 mb-3"></i>

                    <p class="mb-1">
                        Bạn có chắc chắn muốn xóa khách hàng:
                    </p>

                    <h6 class="fw-bold text-danger">
                        {{ $user->name }}
                    </h6>

                    <p class="text-muted mt-2 mb-0">
                        Hành động này <strong>không thể hoàn tác</strong>.
                    </p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button"
                            class="btn btn-light px-4"
                            data-bs-dismiss="modal">
                        Hủy
                    </button>

                    <form action="{{ route('admin.users.destroy', $user) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger px-4">
                            <i class="bx bx-trash"></i> Xóa
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @endforeach
