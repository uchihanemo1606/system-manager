<div class="mt-4">
    <div class=" w-full ml-4">
        <h4 class="mb-0 font-size-18 text-success w-full">
            <i class="bx bx-world "></i> Chi tiết Tên Miền
        </h4>
    </div>

    <div class="row">
        <!-- Thông tin Domain -->
        <div class="col-lg-4">
            <div class=" p-4 shadow-sm h-100">
                <div class=" ">
                    <h5 class="card-title d-flex justify-content-between align-items-center mb-4">
                        <span class="text-primary">Tên miền</span>
                        <div>
                            <button id="edit-domain-btn" class="btn btn-outline-primary btn-sm mr-2"
                                title="Cập nhật tên miền">
                                <i class="bx bx-pencil"></i>
                            </button>
                            <button id="delete-domain-btn" class="btn btn-outline-danger btn-sm" title="Xóa tên miền">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </h5>
                    <p>
                        <i class="bx bx-globe"></i> <strong>Tên:</strong>
                        <span id="domain-name">...</span>
                        <input type="text" id="domain-name-input" class="form-control form-control-sm d-none mt-2" />
                    </p>
                    <p>
                        <i class="bx bx-globe"></i> <strong>Link:</strong>
                        <a href="#" id="domain-link" target="_blank" class="text-primary" title="Truy cập">

                        </a>
                        <input type="text" id="domain-link-input" class="form-control form-control-sm d-none mt-2" />
                    </p> 
                    <p><i class="bx bx-user"></i> <strong>Người tạo:</strong> <span id="domain-createdby">...</span></p>
                    <p><i class="bx bx-calendar"></i> <strong>Ngày tạo:</strong> <span id="domain-createdat">...</span>
                    </p>
                    {{-- software --}}
                    <h5 class="card-title d-flex justify-content-between align-items-center mt-4 mb-3">
                        <span class="text-primary">Thông tin phần mềm</span>
                        <a href="#" id="software-detail-link" class="text-success" title="Xem chi tiết phần mềm">
                            <i class="bx bx-cog"></i>
                        </a>
                    </h5>
                    <p><i class="bx bx-chip"></i> <strong>Tên phần mềm:</strong> <span id="software-name">...</span></p>
                    <p><i class="bx bx-code-alt"></i> <strong>Ngôn ngữ:</strong> <span id="software-language">...</span>
                    </p>
                    <p><i class="bx bx-git-branch"></i> <strong>Phiên bản:</strong> <span
                            id="software-version">...</span></p>
                </div>
            </div>
        </div>

        <!-- Danh sách Phần cứng -->
        <div class="col-lg-8">
            <div class="p-4  shadow-sm h-100">
                <div class=" ">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-server"></i> Phần cứng liên kết
                    </h5>
                    <p class="text-muted mt-1">Danh sách phần cứng đã liên kết với tên miền này</p>
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-centered mb-0" id="hardware-list">
                            <tbody>
                                <tr>
                                    <td class="text-center text-muted">Đang tải...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>