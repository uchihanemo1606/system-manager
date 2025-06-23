@extends('layouts.app')
@section('content')
<div>
    @hasPermission("user.list")
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 font-size-18">Danh sách người dùng</h4>
            @hasPermission("user.create")
            <a href="#" class="btn btn-primary" onclick="loadModal('user_create')">Thêm người dùng</a>
            @endhasPermission
        </div>
    </div>
    <form id="filter-form" class="mb-3 row g-3">
        <div class="col-md-3">
            <input type="text" name="username" class="form-control" placeholder="Tìm theo họ và tên">
        </div>
        <div class="col-md-3">
            <input type="text" name="email" class="form-control" placeholder="Tìm theo email">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-control" id="filter-role">
                <option value="">Tất cả quyền</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-secondary">Lọc</button>
        </div>
    </form>
    <div class="row" aria-hidden="true">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 70px;">#</th>
                                    <th scope="col">Họ và tên</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Quyền hạng</th>
                                    <th scope="col">Projects</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="user-table-body">
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="text-center my-3">
                            <a href="javascript:void(0);" class="text-success"><i class="bx bx-loader bx-spin font-size-18 align-middle mr-2"></i> Load more </a>
                        </div>
                    </div> <!-- end col-->
                </div>
            </div>
        </div>
    </div>
</div>
@vite('resources/js/pages/user_list.js')
@endhasPermission
@endsection