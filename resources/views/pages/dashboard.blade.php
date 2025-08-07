@extends('layouts.app')

@section('content')
@hasPermission('system.get')

<div class="container-fluid">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="mb-0 font-size-18">
            <i class="bx bx-bar-chart-alt-2"></i> Thống kê hệ thống
        </h4>
    </div>

    <!-- Bộ lọc thời gian -->
    <div class="card mt-3">
        <div class="card-body">
            <div id="filter-form">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label mb-1">Từ ngày</label>
                        <input type="date" id="filter-start-date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label mb-1">Đến ngày</label>
                        <input type="date" id="filter-end-date" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" id="loadAnalytics" class="btn btn-sm btn-primary me-2">
                        <i class="bx bx-filter-alt"></i> Thống kê
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" id="btn-reset-time">
                        <i class="bx bx-reset"></i> Đặt lại
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- PHẦN MỀM -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="mb-3">
                <i class="bx bx-code-alt text-primary"></i> Phần mềm
                <small class="text-info mx-2" id="software-range">(Tất cả thời gian)</small>
            </h5>

            <div class="row text-center">
                <div class="col-md-6 border-end">
                    <p class="text-muted mb-1">Tổng số phần mềm được tạo
                        <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Tổng số phần mềm được tạo và chưa bị xóa trong hệ thống,tính theo khoản thời gian được chọn.">
                        </i>
                    </p>
                    <h4 id="software-active">--</h4>
                </div>
                <div class="col-md-6">
                    <p class="text-muted mb-1">Đã xóa
                        <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Tổng số phần mềm bị xóa, tính theo khoản thời gian được chọn.">
                        </i>
                    </p>
                    <h4 id="software-deleted">--</h4>
                </div>
            </div>

            <!-- Thêm block mới dưới phần đã xóa -->
            <div class="row text-center mt-3">
                <div class="col-md-6 border-end">
                    <p class="text-muted mb-1">Tổng dung lượng</p>
                    <h5 id="software-space-saved">-- MB</h5>
                </div>
                <div class="col-md-6">
                    <p class="text-muted mb-1">Tiết kiệm được từ (xóa phần mềm)</p>
                    <h5 id="software-uninstall-saved">-- MB</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- PHẦN CỨNG -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="mb-3">
                <i class="bx bx-chip text-success"></i> Phần cứng
                <small class="text-info mx-2" id="hardware-range">(Tất cả thời gian)</small>
            </h5>
            <div class="row text-center">
                <div class="col-md-4 border-end">
                    <p class="text-muted mb-1">Tổng phần cứng được tạo
                        <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Tổng số phần cứng chưa bị xóa trong hệ thống,tính theo khoản thời gian được chọn.">
                        </i>
                    </p>

                    <h4 id="hardware-created">--</h4>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">số phần cứng đã bị xóa
                        <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Tổng số phần cứng đã bị xóa, tính theo khoản thời gian được chọn.">
                        </i>
                    </p>
                    <h4 id="hardware-deleted">--</h4>
                </div>
                <div class="col-md-4 border-end">
                    <p class="text-muted mb-1">Tổng dung lượng HDD tiêu hao
                        <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Tổng số dung lượng luu trữ HDD đã tiêu hao">
                        </i>
                    </p>
                    <h4 id="hardware-dark">--</h4>
                </div>

            </div>

            <hr class="my-3">

            <div class="row text-center">
                <div class="col-md-4 border-end">
                    <p class="text-muted mb-1">Phần cứng<medium class="text-primary">(ảo, vật lý)</medium><small
                            class="text-success">đang hoạt động</small>
                        <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Tổng số phần cứng được tạo và còn hoạt động trong hệ thống tính theo khoản thời gian được chọn.">
                        </i>
                    </p>
                    <h5 id="hardware-active">--</h5>
                </div>
                <div class="col-md-4 border-end">
                    <p class="text-muted mb-1">Tổng dung lượng HDD / RAM
                        <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Tổng số dung lượng HDD và RAM của phần cứng đang hoạt động,tính theo khoản thời gian được chọn.">
                        </i>
                    </p>
                    <h5><span id="hardware-average-storage">--</span>/<span id="totalRam">--</span></h5>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">tổng dung lượng HDD còn trống</p>
                    <h5 id="hardware-storage-saved">--</h5>
                </div>
            </div>
            <hr class="my-3">

            <div class="row text-center">
                <div class="col-md-4 border-end">
                    <p class="text-muted mb-1">Phần cứng<medium class="text-primary">(vật lý) <small
                                class="text-success">(đang hoạt động)</small>
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Tổng số phần cứng được tạo và còn hoạt động trong hệ thống tính theo khoản thời gian được chọn.">
                            </i>
                    </p>
                    <h5 id="physicalCount">--</h5>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">tổng dung lượng HDD</p>
                    <h5 id="physicalHdd">--</h5>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">tổng dung lượng Ram</p>
                    <h5 id="physicalRam">--</h5>
                </div>
            </div>
            <hr class="my-3">

            <div class="row text-center">
                <div class="col-md-4 border-end">
                    <p class="text-muted mb-1">Phần cứng<medium class="text-primary">(ảo) <small
                                class="text-success">(đang hoạt động)</small>
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Tổng số phần cứng được tạo và còn hoạt động trong hệ thống tính theo khoản thời gian được chọn.">
                            </i>
                    </p>
                    <h5 id="virtualCount">--</h5>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">tổng dung lượng HDD</p>
                    <h5 id="virtualHdd">--</h5>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">tổng dung lượng Ram</p>
                    <h5 id="virtualRam">--</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@vite('resources/js/pages/dashboard.js')

@endhasPermission
@endsection