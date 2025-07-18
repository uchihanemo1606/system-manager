@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">
                <i class="bx bx-bar-chart-alt-2"></i> Thống kê chi tiết hệ thống
            </h4>
        </div>

        <!-- Bộ lọc thời gian -->
        <div class="row mt-3">
            <div class="col-md-3">
                <label>Từ ngày:</label>
                <input type="date" id="filter-from" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Đến ngày:</label>
                <input type="date" id="filter-to" class="form-control">
            </div>
            <div class="col-md-3 align-self-end">
                <button class="btn btn-primary w-100" id="btn-filter">
                    <i class="bx bx-search"></i> Lọc dữ liệu
                </button>
            </div>
        </div>

        <!-- Tổng quan -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted fw-medium">Tổng phần mềm</p>
                            <h4 id="total-software">--</h4>
                        </div>
                        <i class="bx bx-grid-alt h1 text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted fw-medium">Tổng phần cứng</p>
                            <h4 id="total-hardware">--</h4>
                        </div>
                        <i class="bx bx-chip h1 text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted fw-medium">Tổng người dùng</p>
                            <h4 id="total-user">--</h4>
                        </div>
                        <i class="bx bx-user h1 text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted fw-medium">Tổng lượt truy cập</p>
                            <h4 id="total-visit">--</h4>
                        </div>
                        <i class="bx bx-globe h1 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted fw-medium">Người quản lý phần mềm</p>
                            <h4 id="software-manager-count">--</h4>
                        </div>
                        <i class="bx bx-user-check h1 text-info"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted fw-medium">Người quản lý phần cứng</p>
                            <h4 id="hardware-manager-count">--</h4>
                        </div>
                        <i class="bx bx-user-check h1 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ thống kê -->
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="justify-content-between d-flex mb-3 gap-2">
                            <h4 class="card-title mb-4 text-nowrap">Tỉ lệ thành phần hệ thống</h4>
                            <button class="btn btn-success" id="btn-refresh-chart">
                                <i class="bx bx-refresh"></i>Chọn hệ thống
                            </button>
                        </div>
                        <div id="detailed-pie-chart" class="apex-charts"></div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Số lượng theo tháng</h4>
                        <div id="detailed-bar-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Thống kê theo quyền hạn hệ thống</h4>
                        <div id="role-pie-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng chi tiết -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <h4 class="card-title mb-4">Chi tiết thống kê từng thành phần</h4>
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Ngày</th>
                                    <th>Phần mềm</th>
                                    <th>Phần cứng</th>
                                    <th>Người dùng</th>
                                    <th>Lượt truy cập</th>
                                </tr>
                            </thead>
                            <tbody id="detailed-statistics">
                                <tr>
                                    <td colspan="5" class="text-center">Vui lòng chọn thời gian để xem thống kê</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endpush
    @vite('resources/js/pages/dashboard.js')
@endsection
