@extends('layouts.app')
@section('content')
<div>
    @hasPermission('user.list')
    <div class="row">
        <div class="page-title-box  col-12 d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 font-size-18">Danh sách người dùng</h4>
            @hasPermission('user.create')
            <a href="#" class="btn btn-primary" onclick="loadModal('user_create')">Thêm người dùng</a>
            @endhasPermission
        </div>
    </div>
    <h5 class="mb-3 d-flex justify-content-between align-items-center">
        Bộ lọc tìm kiếm
        <button class="btn btn-outline-secondary btn-sm d-md-none" type="button" data-toggle="collapse"
            data-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
            <i class="mdi mdi-filter-outline"></i> Bộ lọc
        </button>
    </h5>
    <div class="collapse d-md-block" id="filterCollapse">
        <div class="row px-3">
            <form id="filter-form" class="row g-3 align-items-end mb-4">
                <!-- Tên đăng nhập -->
                <div class="col-md-3">
                    <label class="form-label">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" placeholder="Tìm theo tên đăng nhập">
                </div>

                <!-- Email -->
                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Tìm theo email">
                </div>

                <!-- Họ và tên -->
                <div class="col-md-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="fullName" class="form-control" placeholder="Tìm theo họ và tên">
                </div>

                <!-- Trạng thái xóa -->
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="deletedStatus" class="form-control">
                        <option value="">Chưa bị xóa</option>
                        <option value="deleted">Đã bị xóa</option>
                        <option value="all">Tất cả</option>
                    </select>
                </div>

                <!-- Quyền (ẩn, nhưng có thể bật lại nếu muốn) -->
                <div class="col-md-3 d-none">
                    <label class="form-label">Quyền</label>
                    <select name="role" class="form-control" id="filter-role">
                        <option value="">Tất cả quyền</option>
                    </select>
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                </div>
            </form>

        </div>
    </div>
    <div class="row" aria-hidden="true">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 70px;">#</th>
                                    <th scope="col">Tên đăng nhập</th>
                                    <th scope="col" class="text-center">Họ và tên</th>
                                    <!-- <th scope="col" class="text-center">Quyền hạng</th> -->
                                    <th scope="col" class="text-center">Email</th>
                                    <th scope="col" class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="user-table-body">
                            </tbody>
                        </table>
                        <div id="pagination" class="mt-3"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@vite('resources/js/pages/user_list.js')
@endhasPermission
@endsection