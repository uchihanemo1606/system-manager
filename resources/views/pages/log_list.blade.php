@extends('layouts.app')

@section('content')
@hasPermission('system.get')
<div>
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="mb-0 font-size-18">
            <i class="bx bx-history"></i> Nhật ký hoạt động hệ thống
        </h4>
    </div>

    <!-- Nút Ẩn/Hiện bộ lọc -->

    <div class="card px-4 py-2">
        <!-- Bộ lọc -->
        <div class="text-center">
            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#filter-box"
                aria-expanded="false" aria-controls="filter-box">
                <i class="bx bx-filter"></i> Ẩn/Hiện bộ lọc
            </button>
        </div>
        <div class="collapse" id="filter-box">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label>Người thực hiện</label>
                    <input type="text" id="filter-username" class="form-control" placeholder="Nhập username...">
                </div>

                <div class="col-md-3 mb-2">
                    <label>IP Phần cứng</label>
                    <input type="text" id="filter-hardware-ip" class="form-control" placeholder="Nhập IP...">
                </div>

                <div class="col-md-3 mb-2">
                    <label>Id Phần mềm/ tên phần mềm</label>
                    <input type="text" id="filter-software-id" class="form-control"
                        placeholder="ID hoặc tên phần mềm...">
                </div>

                <div class="col-md-3 mb-2">
                    <label>Tên role</label>
                    <input type="text" id="filter-permission-name" class="form-control" placeholder="Tên quyền...">
                </div>

                <div class="col-md-3 mb-2">
                    <label>Log</label>
                    <input type="text" id="filter-message" class="form-control" placeholder="Nội dung Log...">
                </div>

                <div class="col-md-3 mb-2">
                    <label>Đường dẫn domain</label>
                    <input type="text" id="filter-domain" class="form-control" placeholder="Link domain...">
                </div>

                <div class="col-md-3 mb-2">
                    <label>Từ ngày</label>
                    <input type="date" id="filter-from-date" class="form-control">
                </div>

                <div class="col-md-3 mb-2">
                    <label>Đến ngày</label>
                    <input type="date" id="filter-to-date" class="form-control">
                </div>

                <div class="col-md-3 mb-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 mr-2" id="btn-filter">
                        <i class="bx bx-search"></i> Lọc dữ liệu
                    </button>
                    <button class="btn btn-secondary w-100" id="btn-reset">
                        <i class="bx bx-refresh"></i> Đặt lại
                    </button>
                </div>

                <div class="col-md-3 mb-3 d-flex align-items-end">

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bảng log -->
<div class="card mt-2">

    <div class="card-body table-responsive">
        <h4 class="card-title mb-4">Danh sách nhật ký hệ thống</h4>
        <div id="log-loading" class="text-center text-muted mb-3 d-none">
            <i class="mdi mdi-loading mdi-spin"></i> Đang tải dữ liệu...
        </div>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Người thực hiện</th>
                    <th>Log</th>
                    <th>Thời gian thực thi</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="log-table-body">
                <tr>
                    <td colspan="8" class="text-center">Vui lòng nhập điều kiện lọc hoặc tải dữ liệu để xem</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center p-2">
        <div id="pagination-info" class="text-muted"></div>
        <nav>
            <ul id="pagination" class="pagination mb-0"></ul>
        </nav>
    </div>
</div>
</div>
@vite('resources/js/pages/log_list.js')
@endhasPermission
@endsection