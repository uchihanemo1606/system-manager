@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">
                <i class="bx bx-history"></i> Nhật ký hoạt động hệ thống
            </h4>
        </div>

        <!-- Bộ lọc -->
        <div class="card mt-3">
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label>Người thực hiện</label>
                        <input type="text" id="filter-username" class="form-control" placeholder="Nhập username...">
                    </div>

                    <div class="col-md-3">
                        <label>IP Phần cứng</label>
                        <input type="text" id="filter-hardware-ip" class="form-control" placeholder="Nhập IP...">
                    </div>

                    <div class="col-md-3">
                        <label>Phần mềm</label>
                        <input type="text" id="filter-software-id" class="form-control" placeholder="ID phần mềm...">
                    </div>

                    <div class="col-md-3">
                        <label>Quyền</label>
                        <input type="text" id="filter-permission-name" class="form-control" placeholder="Tên quyền...">
                    </div>

                    <div class="col-md-3">
                        <label>Log</label>
                        <input type="text" id="filter-message" class="form-control" placeholder="Nội dung Log...">
                    </div>

                    <div class="col-md-3">
                        <label>Domain</label>
                        <input type="text" id="filter-domain" class="form-control" placeholder="Link domain...">
                    </div>

                    <div class="col-md-3">
                        <label>Phòng ban</label>
                        <input type="text" id="filter-department" class="form-control" placeholder="Tên phòng ban...">
                    </div>

                    <div class="col-md-3">
                        <label>Quyền phần mềm</label>
                        <input type="text" id="filter-sw-permission" class="form-control" placeholder="Quyền phần mềm...">
                    </div>

                    <div class="col-md-3">
                        <label>Quyền phần cứng</label>
                        <input type="text" id="filter-hw-permission" class="form-control" placeholder="Quyền phần cứng...">
                    </div>

                    <div class="col-md-3">
                        <label>Từ ngày</label>
                        <input type="date" id="filter-from-date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Đến ngày</label>
                        <input type="date" id="filter-to-date" class="form-control">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100" id="btn-filter">
                            <i class="bx bx-search"></i> Lọc dữ liệu
                        </button>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-secondary w-100" id="btn-reset">
                            <i class="bx bx-refresh"></i> Đặt lại
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Bảng log -->
        <div class="card mt-4">
            <div class="card-body table-responsive">
                <h4 class="card-title mb-4">Danh sách nhật ký hệ thống</h4>

                <div id="log-loading" class="text-center text-muted mb-3 d-none">
                    <i class="mdi mdi-loading mdi-spin"></i> Đang tải dữ liệu...
                </div>

                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Người thực hiện</th>
                            <th>IP Phần cứng</th>
                            <th>ID Phần mềm</th>
                            <th>Tên quyền</th>
                            <th>Log</th>
                            <th>Thời gian</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="log-table-body">
                        <tr>
                            <td colspan="8" class="text-center">Vui lòng nhập điều kiện lọc hoặc tải dữ liệu để xem</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div id="pagination-info" class="text-muted"></div>
                    <nav>
                        <ul id="pagination" class="pagination mb-0"></ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Modal chi tiết -->
        <div class="modal fade" id="logDetailModal" tabindex="-1" aria-labelledby="logDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chi tiết nhật ký</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td id="detail-id"></td>
                                </tr>
                                <tr>
                                    <th>Người thực hiện</th>
                                    <td id="detail-username"></td>
                                </tr>
                                <tr>
                                    <th>IP Phần cứng</th>
                                    <td id="detail-hardware"></td>
                                </tr>
                                <tr>
                                    <th>ID Phần mềm</th>
                                    <td id="detail-software"></td>
                                </tr>
                                <tr>
                                    <th>Tên quyền</th>
                                    <td id="detail-permission"></td>
                                </tr>
                                <tr>
                                    <th>Log</th>
                                    <td id="detail-message"></td>
                                </tr>
                                <tr>
                                    <th>Domain</th>
                                    <td id="detail-domain"></td>
                                </tr>
                                <tr>
                                    <th>Thời gian tạo</th>
                                    <td id="detail-created"></td>
                                </tr>
                                <tr>
                                    <th>Thời gian cập nhật</th>
                                    <td id="detail-updated"></td>
                                </tr>
                            </tbody>
                        </table>a

                    </div>
                </div>
            </div>
        </div>

    </div>
    @vite('resources/js/pages/log_list.js')
@endsection