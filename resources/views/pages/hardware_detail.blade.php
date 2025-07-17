@extends('layouts.app')
@section('content')
@hasPermission('hardware.detail')
<div id="hardware-detail" style="display: none;">
    <div class="row" style=" position: absolute;">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Chi tiết phần cứng</h4>
            </div>
        </div>
    </div>

    @hasPermission('hardware.delete')
    <div class="w-full d-flex justify-content-end">
        <button id="delete-hardware-btn" class="btn btn-danger">
            <i class="mdi mdi-delete"></i> Xóa
        </button>
    </div>
    @endhasPermission
    <div class="row">
        <div class="col-xl-7">
            <div class="card overflow-hidden shadow-sm border">
                <div class="bg-soft-primary p-3">
                    <div class="row">

                        <div class="col-4">
                            <div class="text-primary">
                                <h6 class="mb-1 ">Máy ảo</h6>
                                <p class="fw-bold mb-0" id="hardware-ip-view">192.168.1.140</p>
                                <input type="text" id="hardware-ip-input" class="form-control form-control-sm d-none">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-primary">
                                <h6 class="mb-1">Hệ điều hành</h6>
                                <p class="fw-bold mb-0" id="hardware-os-view">Ubuntu 22.04</p>
                                <input type="text" id="hardware-os-input" class="form-control form-control-sm d-none">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-primary">
                                <h6 class="mb-1">Phiên bản</h6>
                                <p class="fw-bold mb-0" id="hardware-osver-view">v1.0.5</p>
                                <input type="text" id="hardware-osver-input"
                                    class="form-control form-control-sm d-none">
                            </div>
                        </div>

                    </div>
                    @hasPermission('hardware.update')
                    <div class="d-flex justify-content-end mb-3" style="position: absolute; right: 0px; top: 0px;">
                        <a id="toggle-edit-btn" class="btn btn-sm text-primary" style="font-size: 16px;">
                            <i class="mdi mdi-pencil"></i> Sửa
                        </a>
                    </div>
                    @endhasPermission
                </div>

                <div class="p-3">
                    <div class="row align-items-center">
                        <div class="col-sm-4 text-center">
                            <div class="profile-user-wid mx-auto">
                                <img src="/images/img-1.jpg" alt="Avatar" class="img-thumbnail rounded-circle"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="p-2">
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <h6 class="text-muted mb-1">Lần cập nhật gần nhất</h6>
                                        <p class="fw-bold mb-0 text-dark" id="hardware-updated">03/06/2025</p>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <h6 class="text-muted mb-1">Tạo bởi</h6>
                                        <p class="fw-bold mb-0 text-dark" id="hardware-createdby">ONO</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <h6 class="text-primary mb-0 d-flex align-items-center">
                                        <span class="fw-bold mr-2">Domain:</span>
                                        <!-- <button class="btn btn-outline-primary btn-sm mr-3" id="add-hardware-domain-btn"
                                            type="button">
                                            <i class="mdi mdi-plus-circle-outline mr-1"></i> Liên kết tên miền
                                        </button> -->
                                        <button class="btn btn-outline-primary btn-sm" id="view-domain-btn"
                                            type="button">
                                            Xem tên miền đã liên kết <i class="mdi mdi-arrow-right ml-1"></i>
                                        </button>
                                    </h6>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Thông tin kỹ thuật</h4>

                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">HDD :</th>
                                    <td>
                                        <span id="hardware-hdd-view">1 TG</span>
                                        <div class="input-group d-none" id="hardware-hdd-input-group">
                                            <input type="number" id="hardware-hdd-input"
                                                class="form-control form-control-sm" min="1" placeholder="Dung lượng">
                                            <select id="hardware-hdd-unit" class="form-select form-select-sm">
                                                <option value="MB">MB</option>
                                                <option value="GB" selected>GB</option>
                                                <option value="TB">TB</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Ram :</th>
                                    <td>
                                        <span id="hardware-ram-view">524 MB</span>
                                        <div class="input-group d-none" id="hardware-ram-input-group">
                                            <input type="number" id="hardware-ram-input"
                                                class="form-control form-control-sm" min="1" placeholder="Dung lượng">
                                            <select id="hardware-ram-unit" class="form-select form-select-sm">
                                                <option value="MB">MB</option>
                                                <option value="GB" selected>GB</option>
                                                <option value="TB">TB</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row" class="text-primary">Database :</th>
                                    <td>
                                        <span id="hardware-db-view">Mysql</span>
                                        <input type="text" id="hardware-db-input"
                                            class="form-control form-control-sm d-none">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-primary"> Database Version:</th>
                                    <td>
                                        <span id="hardware-dbver-view">1.0.0</span>
                                        <input type="text" id="hardware-dbver-input"
                                            class="form-control form-control-sm d-none">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Thành viên quản lý phần cứng</h4>
                    @include('components.user_member_list', ['type' => 'hardware'])
                    @vite('resources/js/component/user_member_list/user_member_hardware.js')
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            {{-- thông tin phần cứng --}}

            <!-- end card -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">
                                        Phát hành
                                    </p>
                                    <h5 class="mb-0" id="hardware-created">2/4/2025</h5>
                                </div>

                                <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-check-circle font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">
                                        Trạng thái phần cứng
                                    </p>
                                    <h5 class="mb-0 text-success" id="hardware-is-active">hoạt động</h5>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-hourglass font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">dịch vụ</h4>
                    <div id="revenue-chart" class="apex-charts">
                        <p class="text-muted mb-4" id="hardware-services-view">
                            cung cấp máy ảo VPS, server hosting,.. sẵn sàng hỗ trợ các bạn tận tâm. chúng tôi vui lòng
                            tiếp nhận
                        </p>
                        <textarea id="hardware-services-input" class="form-control d-none"></textarea>
                    </div>
                </div>
            </div>
            <!-- @include('components.rule_by_type', ['type' => 'hardware'])
            @vite('resources/js/component/rule/hardware_rule.js') -->
            @include('components.log_by_type', ['type' => 'hardware'])
            @vite('resources/js/component/log/hardware_log.js')
        </div>
    </div>
</div>
@vite('resources/js/pages/hardware_detail.js')
@endhasPermission
@endsection