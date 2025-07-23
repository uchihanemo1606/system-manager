@hasPermission('software.list')
@extends('layouts.app')
@section('content')
<div>
    <div class="row">
        <div class="page-title-box col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 font-size-18">Quản lý phần mềm</h4>
            @hasPermission('software.create')
            <a href="#" class="btn btn-primary" onclick="loadModal('software_create')">Thêm phần mềm</a>
            @endhasPermission
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mb-3">Bộ lọc tìm kiếm</h5>

            <div class="row">
                <div class="col-md-3 mb-2">
                    <input type="text" id="filter-name" class="form-control" placeholder="Tên phần mềm">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="text" id="filter-language" class="form-control" placeholder="Ngôn ngữ">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="text" id="filter-version" class="form-control" placeholder="Phiên bản">
                </div>
                <div class="col-md-3 mb-2">
                    <select id="filter-delete" class="form-control">
                        <option value="">-- Trạng thái xóa --</option>
                        <option value="false">Chưa xóa</option>
                        <option value="true">Đã xóa</option>
                    </select>
                </div>
            </div>

            <div id="advanced-filters" style="display: none;">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="text" id="filter-createdby" class="form-control" placeholder="Người tạo">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" id="filter-createdat" class="form-control" placeholder="Ngày tạo">
                    </div>
                </div>
            </div>

            <div class="mt-2 d-flex justify-content-between">
                <button class="btn btn-link text-primary p-0" type="button" onclick="toggleAdvancedFilters()">
                    <span id="toggle-text">Hiện thêm bộ lọc nâng cao</span>
                </button>
                <button class="btn btn-primary" onclick="loadSoftware()">Tìm kiếm</button>

            </div>
        </div>
    </div>

    <div class="row" id="software-list-container">
        <!-- Danh sách phần mềm sẽ được render bằng JS vào đây -->
    </div>
    <ul class="pagination pagination-sm justify-content-center">
        <li class="page-item disabled">
            <a class="page-link" href="#" data-page="0">Trang trước</a>
        </li>
        <li class="page-item active">
            <a class="page-link" href="#" data-page="1">1</a>
        </li>
        <li class="page-item ">
            <a class="page-link" href="#" data-page="2">Trang sau</a>
        </li>
    </ul>
    <!-- <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <a href="javascript:void(0);" class="text-success" onclick="loadSoftware()">
                            <i class="bx bx-hourglass bx-spin mr-2"></i> Tải lại
                        </a>
                    </div>
                </div>
            </div> -->
</div>
@endsection
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
@vite('resources/js/pages/software_list.js')
@endhasPermission