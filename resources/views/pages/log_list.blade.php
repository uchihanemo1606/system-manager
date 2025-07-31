@extends('layouts.app')

@section('content')
@hasPermission('system.get')
<div>
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="mb-0 font-size-18">
            <i class="bx bx-history"></i> Nhật ký hoạt động hệ thống
        </h4>
    </div>

    <!-- ====== CARD: BỘ LỌC ====== -->
    <div class="card px-4 py-3 mt-3">
        <h5 class="mb-3 d-flex justify-content-between align-items-center">
            Bộ lọc tìm kiếm
            <button class="btn btn-outline-secondary btn-sm d-md-none" type="button" data-toggle="collapse"
                data-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                <i class="mdi mdi-filter-outline"></i> Bộ lọc
            </button>
        </h5>

        <div class="collapse d-md-block" id="filterCollapse">
            <!-- BỘ LỌC CƠ BẢN -->
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label>Người thực hiện</label>
                    <input type="text" id="filter-username" class="form-control" placeholder="Nhập username...">
                </div>
                <div class="col-md-3 mb-2">
                    <label>Log</label>
                    <input type="text" id="filter-message" class="form-control" placeholder="Nội dung Log...">
                </div>
                <div class="col-md-3 mb-2">
                    <label>IP Phần cứng</label>
                    <input type="text" id="filter-hardware-ip" class="form-control" placeholder="Nhập IP...">
                </div>
                <div class="col-md-3 mb-2">
                    <label>ID/Tên phần mềm</label>
                    <input type="text" id="filter-software-id" class="form-control" placeholder="Nhập ID hoặc tên...">
                </div>
            </div>

            <!-- BỘ LỌC NÂNG CAO -->
            <div id="advanced-filters" style="display: none;">
                <hr class="my-2">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label>Tên quyền</label>
                        <input type="text" id="filter-permission-name" class="form-control" placeholder="Tên quyền...">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Domain</label>
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
                    <div class="col-md-3 mb-2">
                        <label>Từ giờ</label>
                        <input type="time" id="filter-from-time" class="form-control">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Đến giờ</label>
                        <input type="time" id="filter-to-time" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Nút -->
            <div class="d-flex justify-content-between mt-3">
                <button class="btn btn-link text-primary p-0" type="button" onclick="toggleAdvancedFilters()">
                    <span id="toggle-text">Hiện thêm bộ lọc nâng cao</span>
                </button>
                <div class="d-flex gap-2">
                   <button class="btn btn-primary w-100 mr-2" id="btn-filter">

                        <i class="bx bx-search"></i> Tìm kiếm
                    </button>
                    <button class="btn btn-secondary text-nowrap" id="btn-reset">
                        <i class="bx bx-refresh"></i> Đặt lại
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== CARD: DANH SÁCH LOG ====== -->
    <div class="card mt-3">
        <div class="card-body table-responsive">
            <h5 class="card-title mb-3">Danh sách nhật ký hệ thống</h5>

            <div id="log-loading" class="text-center text-muted mb-3 d-none">
                <i class="mdi mdi-loading mdi-spin"></i> Đang tải dữ liệu...
            </div>

            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
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

            <div class="d-flex justify-content-between align-items-center mt-2">
                <div id="pagination-info" class="text-muted"></div>
                <nav>
                    <ul id="pagination" class="pagination mb-0"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAdvancedFilters() {
        const advanced = document.getElementById('advanced-filters');
        const toggleText = document.getElementById('toggle-text');

        if (advanced.style.display === 'none') {
            advanced.style.display = 'block';
            toggleText.innerText = 'Ẩn bộ lọc nâng cao';
        } else {
            advanced.style.display = 'none';
            toggleText.innerText = 'Hiện thêm bộ lọc nâng cao';
        }
    }
</script>
@vite('resources/js/pages/log_list.js')
@endhasPermission
@endsection
