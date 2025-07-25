@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">
                <i class="bx bx-bar-chart-alt-2"></i> Thống kê hệ thống
            </h4>
        </div>

        <!-- Bộ lọc thời gian -->
        <div class="card mt-3">
            <div class="card-body">
                <form id="filter-form">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label mb-1">Từ ngày</label>
                            <input type="date" id="filter-start-date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Đến ngày</label>
                            <input type="date" id="filter-end-date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Từ giờ</label>
                            <input type="time" id="filter-start-time" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Đến giờ</label>
                            <input type="time" id="filter-end-time" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-sm btn-primary me-2">
                            <i class="bx bx-filter-alt"></i> Thống kê
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" id="btn-reset-time">
                            <i class="bx bx-reset"></i> Đặt lại
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- PHẦN MỀM -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="mb-3"><i class="bx bx-code-alt text-primary"></i> Phần mềm
                    <small class="text-info mx-2">từ ngày ... đến ngày ...</small>
                </h5>

                <div class="row text-center">
                    <div class="col-md-4 border-end">
                        <p class="text-muted mb-1">Đã tạo</p>
                        <h4 id="software-created">6.230</h4>
                    </div>
                    <div class="col-md-4 border-end">
                        <p class="text-muted mb-1">Đã cập nhật</p>
                        <h4 id="software-updated">2.030.000 lần</h4>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Đã xóa</p>
                        <h4 id="software-deleted">400</h4>
                    </div>
                </div>

                <!-- Thêm block mới dưới phần đã xóa -->
                <div class="row text-center mt-3">
                    <div class="col-md-6 border-end">
                        <p class="text-muted mb-1">Tổng dung lượng đã giải phóng</p>
                        <h5 id="software-space-saved">-- MB</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Tiết kiệm được từ (gỡ phần mềm)</p>
                        <h5 id="software-uninstall-saved">-- MB</h5>
                    </div>
                </div>

                <hr class="my-3">

                <div class="row text-center">
                    <div class="col-md-12">
                        <p class="text-muted mb-1">Số phần mềm đang hoạt động</p>
                        <h5 id="software-active">5.770</h5>
                    </div>
                </div>
            </div>
        </div>


        <!-- PHẦN CỨNG -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="mb-3"><i class="bx bx-chip text-success"></i> Phần cứng
                    <small class="text-info mx-2">từ ngày ... đến ngày ...</small>
                </h5>

                <div class="row text-center">
                    <div class="col-md-4 border-end">
                        <p class="text-muted mb-1">Đã tạo</p>
                        <h4 id="hardware-created">60</h4>
                    </div>
                    <div class="col-md-4 border-end">
                        <p class="text-muted mb-1">Số lần cập nhật</p>
                        <h4 id="hardware-updated">100.000</h4>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Đã xóa</p>
                        <h4 id="hardware-deleted">6</h4>
                    </div>
                </div>

                <hr class="my-3">

                <div class="row text-center">
                    <div class="col-md-4 border-end">
                        <p class="text-muted mb-1">Phần cứng đang hoạt động</p>
                        <h5 id="hardware-active">54</h5>
                    </div>
                    <div class="col-md-4 border-end">
                        <p class="text-muted mb-1">Dung lượng trung bình</p>
                        <h5 id="hardware-average-storage">1.022 TB</h5>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">tổng dung lượng còn trống</p>
                        <h5 id="hardware-storage-saved">6 TB</h5>
                    </div>
                </div>
            </div>
        </div>


        <!-- NGƯỜI DÙNG -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="mb-3"><i class="bx bx-user text-info"></i> Người dùng<small class="text-info mx-2">từ ngày ...
                        đến ngày ...</small></h5>
                <div class="row text-center">
                    <div class="col-md-4 border-end">
                        <p class="text-muted mb-1">Số người dùng bị khóa</p>
                        <h4 id="user-total">--</h4>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Số người được tạo</p>
                        <h4 id="user-new">--</h4>
                    </div>
                    <div class="col-md-4 border-end">
                        <p class="text-muted mb-1">Số người dùng bị xóa</p>
                        <h4 id="user-total">--</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/pages/dashboard.js')
@endsection