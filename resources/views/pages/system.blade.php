@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="mb-0 font-size-18">
            <i class="bx bx-cog mr-2"></i> Quản lý hệ thống
        </h4>
    </div>

    <div class="row mt-3">

        <!-- Quản lý Domain -->
        <div class="col-xl-4 col-sm-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar-lg mx-auto mb-3">
                        <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-28">
                            <i class="bx bx-world"></i>
                        </span>
                    </div>
                    <h5 class="font-size-18">Quản lý Domain</h5>
                    <p class="text-muted mb-3">Theo dõi và quản lý toàn bộ domain thuộc hệ thống.</p>
                    <a href="/domain_list" class="btn btn-primary">
                        <i class="bx bx-chevron-right"></i> Xem chi tiết
                    </a>
                </div>
            </div>
        </div>

        <!-- Quản lý Phần mềm -->
        <div class="col-xl-4 col-sm-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar-lg mx-auto mb-3">
                        <span class="avatar-title rounded-circle bg-soft-success text-success font-size-28">
                            <i class="bx bx-grid-alt"></i>
                        </span>
                    </div>
                    <h5 class="font-size-18">Quản lý Phần mềm</h5>
                    <p class="text-muted mb-3">Quản lý thông tin, mô tả và file liên quan đến phần mềm.</p>
                    <a href="/software_list" class="btn btn-success">
                        <i class="bx bx-chevron-right"></i> Xem chi tiết
                    </a>
                </div>
            </div>
        </div>

        <!-- Quản lý Phần cứng -->
        <div class="col-xl-4 col-sm-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar-lg mx-auto mb-3">
                        <span class="avatar-title rounded-circle bg-soft-warning text-warning font-size-28">
                            <i class="bx bx-chip"></i>
                        </span>
                    </div>
                    <h5 class="font-size-18">Quản lý Phần cứng</h5>
                    <p class="text-muted mb-3">Theo dõi chi tiết máy chủ, thiết bị và phần cứng hệ thống.</p>
                    <a href="/hardware_list" class="btn btn-warning">
                        <i class="bx bx-chevron-right"></i> Xem chi tiết
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
