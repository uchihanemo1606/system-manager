@extends('layouts.app')
@hasPermission('hardware.list')
@section('content')
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
                    <input type="text" id="filter-ip" class="form-control" placeholder="Tìm theo IP">
                </div>
                <div class="col-md-3 mb-2">
                    <select id="filter-dbname" class="form-control select2">
                        <option></option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select id="filter-dbversion" class="form-control select2" disabled>
                        <option></option>
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <select id="filter-virtual" class="form-control">
                        <option value="">-- Loại máy --</option>
                        <option value="true">Máy ảo</option>
                        <option value="false">Máy vật lý</option>
                    </select>
                </div>
            </div>

            <div id="advanced-filters" style="display: none;">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <select id="filter-os" class="form-control select2">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select id="filter-osver" class="form-control select2" disabled>
                            <option></option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <input type="text" id="filter-hdd" class="form-control" placeholder="Ổ cứng (HDD)">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" id="filter-ram" class="form-control" placeholder="RAM">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <select id="filter-delete" class="form-control">
                            <option value="">-- Trạng thái xóa --</option>
                            <option value="true">Đã xóa</option>
                            <option value="false">Chưa xóa</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" id="filter-services" class="form-control" placeholder="Dịch vụ">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" id="filter-createdby" class="form-control" placeholder="Người tạo">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" id="filter-createdat" class="form-control" placeholder="Ngày tạo">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="date" id="filter-updatedat" class="form-control" placeholder="Ngày cập nhật">
                    </div>
                    <!-- <div class="col-md-3 mb-2">
                        <select id="sort-option" class="form-control">
                            <option value="">-- Sắp xếp --</option>
                            <option value="ip">IP tăng dần</option>
                            <option value="-ip">IP giảm dần</option>
                            <option value="ram">RAM tăng dần</option>
                            <option value="-ram">RAM giảm dần</option>
                        </select>
                    </div>  -->
                </div>

            </div>

            <div class="mt-2">
                <button class="btn btn-link text-primary p-0" type="button" onclick="toggleAdvancedFilters()">
                    <span id="toggle-text">Hiện thêm bộ lọc nâng cao</span>
                </button>
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