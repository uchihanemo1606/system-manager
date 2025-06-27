<div class="m-4">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="mb-0 font-size-18 text-success">
            <i class="bx bx-world"></i> Chi tiết Tên Miền
        </h4>
    </div>

    <div class="row"> 
        <!-- Thông tin Domain -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between align-items-center mb-4">
                        <span class="text-primary">Thông tin Tên miền</span>
                    </h5>
                    <p>
                        <i class="bx bx-link-external"></i>
                        <a href="#" id="domain-link" target="_blank" class="text-primary" title="Truy cập">

                        </a>
                    </p>
                    <p><i class="bx bx-globe"></i> <strong>Tên miền:</strong> <span id="domain-name">...</span></p>
                    <p><i class="bx bx-user"></i> <strong>Người tạo:</strong> <span id="domain-createdby">...</span></p>
                    <p><i class="bx bx-calendar"></i> <strong>Ngày tạo:</strong> <span id="domain-createdat">...</span>
                    </p>
                    {{-- software --}}
                     <h5 class="card-title d-flex justify-content-between align-items-center mt-4 mb-3">
                        <span class="text-primary">Phần mềm liên kết</span>
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
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bx bx-server"></i> Phần cứng sử dụng
                    </h5>
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
