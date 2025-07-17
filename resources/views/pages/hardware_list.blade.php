@extends('layouts.app')
@hasPermission('hardware.list')
@section('content')
<link rel="stylesheet" href="{{ asset('css/modal/hardware_create.css') }}">

<div>
    <div class="row">
        <div class="page-title-box col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 font-size-18">Quản lý phần cứng</h4>
            @hasPermission('hardware.create')
            <a href="#" class="btn btn-primary" onclick="loadModal('hardware_create','','xl')">Thêm phần cứng</a>
            @endhasPermission
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mb-3">Bộ lọc tìm kiếm</h5>

            <div class="row">
                <div class="col-md-3 mb-2">
                    <label class="fw-semibold ">Địa chỉ IP</label>
                    <input type="text" id="filter-ip" class="form-control" placeholder="Tìm theo IP">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="fw-semibold">Database</label>
                    <select id="filter-dbname" class="form-control select2">
                        <option></option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="fw-semibold">Phiên bản DB</label>
                    <select id="filter-dbversion" class="form-control select2" disabled>
                        <option></option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="fw-semibold">Loại máy</label>
                    <select id="filter-virtual" class="form-control">
                        <option value="">-- Tất cả --</option>
                        <option value="true">Máy ảo</option>
                        <option value="false">Máy vật lý</option>
                    </select>
                </div>
            </div>

            <div id="advanced-filters" style="display: none;">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="fw-semibold">Hệ điều hành</label>
                        <select id="filter-os" class="form-control select2">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="fw-semibold">Phiên bản HĐH</label>
                        <select id="filter-osver" class="form-control select2" disabled>
                            <option></option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="fw-semibold">Ổ cứng (HDD)</label>
                        <input type="text" id="filter-hdd" class="form-control" placeholder="VD: 500GB">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="fw-semibold">RAM</label>
                        <input type="text" id="filter-ram" class="form-control" placeholder="VD: 8GB">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="fw-semibold">Trạng thái xóa</label>
                        <select id="filter-delete" class="form-control">
                            <option value="false">Chưa xóa</option>
                            <option value="true">Đã xóa</option>

                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="fw-semibold">Dịch vụ</label>
                        <input type="text" id="filter-services" class="form-control" placeholder="VD: Apache, MySQL...">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="fw-semibold">Người tạo</label>
                        <input type="text" id="filter-createdby" class="form-control" placeholder="Tên người tạo">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="fw-semibold">Ngày tạo</label>
                        <input type="date" id="filter-createdat" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="fw-semibold">Ngày cập nhật</label>
                        <input type="date" id="filter-updatedat" class="form-control">
                    </div>
                </div>
            </div>

            <div class="mt-2 d-flex w-full justify-content-between ">
                <button class="btn btn-link text-primary p-0" type="button" onclick="toggleAdvancedFilters()">
                    <span id="toggle-text">Hiện thêm bộ lọc nâng cao</span>
                </button>
                <button class="btn btn-primary" onclick="applyFilter()">Tìm</button>
            </div>

        </div>
    </div>

    <div class="row" id="hardware-container">
        <!-- Danh sách phần cứng sẽ được JS đẩy vào đây -->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="text-center my-3">
                <a href="javascript:void(0);" class="text-success" onclick="loadHardware()">
                    <i class="bx bx-hourglass bx-spin mr-2"></i> Tải lại
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@vite('resources/js/pages/hardware_list.js')
<script>
    window.permissions = {
        list: @json($userPermissionCodes)
    };
</script>

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
@endhasPermission