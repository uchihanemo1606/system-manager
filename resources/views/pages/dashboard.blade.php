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
    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0">
                    <i class="bx bx-code-alt text-primary"></i> Phần mềm
                </h5>
                <small class="text-info" id="software-range">(Tất cả thời gian)</small>
            </div>
            <!-- Tổng quan -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="stat-box p-3 rounded bg-light border h-100">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-apps text-primary fs-3 me-2 mr-2"></i>
                            <div>
                                <div class="fw-bold text-muted">Số phần mềm của hệ thống</div>
                                <h4 class="mb-0" id="totalSoftwareAllTime">--</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-box p-3 rounded bg-light border h-100">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-delete-variant text-danger fs-3 me-2 mr-2"></i>

                            <div>
                                <div class="fw-bold text-muted">Số phần mềm đã xóa</div>
                                <h4 class="mb-0" id="deletedSoftwareAllTime">--</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Số liệu theo khoảng thời gian -->
             <h6 class="fw-bold mb-2 text-center text-primary">Thống kê theo khoảng thời gian đã chọn</h6>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="stat-box p-3 rounded border h-100">
                        <p class="mb-1 text-muted">
                            Số phần mềm đã tạo
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                title="Tổng số phần mềm được tạo trong khoảng thời gian đã chọn."></i>
                        </p>
                        <h4 class="fw-bold text-primary mb-0" id="software-active">--</h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-box p-3 rounded border h-100">
                        <p class="mb-1 text-muted">
                            Số phần mềm đã xóa
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                title="Tổng số phần mềm bị xóa trong khoảng thời gian đã chọn."></i>
                        </p>
                        <h4 class="fw-bold text-danger mb-0" id="software-deleted">--</h4>
                    </div>
                </div>
            </div>

            <!-- Dung lượng -->
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="stat-box p-3 rounded border h-100">
                        <p class="mb-1 text-muted">
                            Tổng dung lượng tệp tin phần mềm đang chiếm dụng
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                title="Tổng dung lượng các tệp tin của phần mềm đã tạo."></i>
                        </p>
                        <h5 class="fw-bold text-warning mb-0" id="software-space-saved">-- MB</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-box p-3 rounded border h-100">
                        <p class="mb-1 text-muted">
                            Dung lượng tiết kiệm được
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                title="Dung lượng tiết kiệm được nhờ gỡ bỏ phần mềm."></i>
                        </p>
                        <h5 class="fw-bold text-success mb-0" id="software-uninstall-saved">-- MB</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stat-box {
            transition: all 0.2s ease;
        }

        .stat-box:hover {
            background-color: #f8f9fa;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.05);
        }
    </style>

    <!-- PHẦN CỨNG -->
    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <!-- Tiêu đề -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="bx bx-chip text-success"></i> Phần cứng
                </h5>
                <small class="text-info d-none" id="hardware-range">(Tất cả thời gian)</small>
            </div>

            <!-- Tổng quan toàn hệ thống -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="stat-box p-3 border bg-light  rounded h-100">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-desktop-classic text-primary fs-3 me-2 mr-2"></i>
                            <div>
                                <div class="fw-bold text-muted">Số phần cứng của hệ thống</div>
                                <h4 class="mb-0" id="totalHardwareAllTime">--</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-box p-3 bg-light  border rounded h-100">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-delete-forever text-danger fs-3 me-2 mr-2"></i>
                            <div>
                                <div class="fw-bold text-muted">Số phần cứng đã xóa</div>
                                <h4 class="mb-0" id="deletedHardwareAllTime">--</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thống kê theo khoảng thời gian -->
            <h6 class="fw-bold mb-2 text-center text-primary">Thống kê theo khoảng thời gian đã chọn</h6>
            <div class="row g-3 mb-3 text-center">
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100">
                        <p class="text-muted mb-1">
                            Số phần cứng đã tạo
                            <i class="mdi mdi-help-circle-outline text-info"
                                title="Tổng số phần cứng chưa bị xóa trong khoảng thời gian đã chọn"></i>
                        </p>
                        <h4 class="text-primary mb-0" id="hardware-created">--</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100">
                        <p class="text-muted mb-1">
                            Số phần cứng đang hoạt động
                            <i class="mdi mdi-help-circle-outline text-info" title="Tổng số phần cứng chưa bị xóa"></i>
                        </p>
                        <h4 class="text-success mb-0" id="hardware-active">--</h4>
                        <!-- <h4 class="text-warning mb-0" id="hardware-dark">--</h4> -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100">
                        <p class="text-muted mb-1">
                            Số phần cứng đã xóa
                            <i class="mdi mdi-help-circle-outline text-info"
                                title="Tổng số phần cứng đã bị xóa trong khoảng thời gian đã chọn"></i>
                        </p>
                        <h4 class="text-danger mb-0" id="hardware-deleted">--</h4>
                    </div>
                </div>

            </div>
            <h6 class="fw-bold mb-0">Thống kê thông số phần cứng<medium class="text-success">(đang hoạt động)</medium>
            </h6>
            <!-- Hoạt động & dung lượng -->
            <div class="row g-3 mb-3 text-center">
                <!-- <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100">
                        <p class="text-muted mb-1">
                            Số phần cứng đang hoạt động
                        </p>
                        <h5 class="text-success mb-0" id="hardware-active">--</h5>
                    </div>
                </div> -->
                <!-- <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100 shadow-sm">
                        <p class="text-muted mb-1 fw-bold">
                            Dung lượng HDD tổng /đã sử dụng:
                        </p>
                        <div class="mt-2 mb-2">
                            <span id="hardware-average-storage" class="fw-bold text-primary">--</span>
                            /
                            <span id="hardware-storage-saved" class="fw-bold text-warning">--</span>
                        </div>

                        <div class="progress d-none"
                            style="height: 28px; border-radius: 8px; overflow: hidden; background-color: #f1f1f1;">
                            <div id="hdd-used-bar" class="progress-bar position-relative"
                                style="background: linear-gradient(to right, #FFD700, #FFC107); width: 0%;">
                                <span id="hdd-used-text" class="position-absolute w-100 text-center fw-bold text-dark">
                                    0 GB (0%)
                                </span>
                            </div> 
                        </div>
                    </div>
                </div> -->

                <!-- <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100">
                        <p class="text-muted mb-1">RAM</p>
                        <h5 class="text-success" id="totalRam">--</h5>
                    </div>
                </div> -->
            </div>
            <div class="row g-2 text-center">

                <!-- Cột 1: Máy vật lý / Máy ảo -->
                <!-- <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100">
                        <div class="mb-3">
                            <h5 id="physicalCount">--</h5>
                            <p class="text-muted mb-0">Máy vật lý</p>
                        </div>
                        <div>
                            <h5 id="virtualCount">--</h5>
                            <p class="text-muted mb-0">Máy ảo</p>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-4">
                    <div class="stat-box p-4 border rounded text-center" style="height: 22em;">
                        <h6 class="fw-bold mb-2">Số máy Vật lý / Ảo</h6>
                        <canvas id="vmPieChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Cột 2: HDD -->
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                        <h6 class="fw-bold mb-2">HDD</h6>
                        <p class="text-muted mb-1 fw-bold">Tổng dung lượng HDD / đã sử dụng:</p>
                        <div class="mb-2">
                            <span id="hardware-average-storage" class="fw-bold text-primary">--</span> /
                            <span id="hardware-storage-saved" class="fw-bold text-warning">--</span>
                        </div>

                        <div class="progress mb-3"
                            style="height: 28px; border-radius: 8px; overflow: hidden; background-color: #f1f1f1;">
                            <div id="hdd-used-bar" class="progress-bar position-relative"
                                style="background: linear-gradient(to right, #FFD700, #FFC107); width: 0%;">
                                <span id="hdd-used-text" class="position-absolute w-100 text-center fw-bold text-dark">
                                    0 GB (0%)
                                </span>
                            </div>
                        </div>
                        <canvas id="hddChart" height="150"></canvas>
                    </div>
                </div>

                <!-- Cột 3: RAM -->
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                        <p class="text-muted mb-1">Tổng dung lượng RAM:</p>
                        <h5 class="text-success mb-3" id="totalRam">--</h5>

                        <h6 class="fw-bold mb-2">RAM</h6>
                        <canvas id="ramChart" height="150"></canvas>
                    </div>
                </div>

            </div>

            <h6 class="fw-bold mb-2 mt-3">Thống kê thông số phần cứng<medium class="text-danger">(đã xóa)</medium>
            </h6>
            <!-- Hoạt động & dung lượng -->
            <div class="row g-3 mb-3 text-center">
            </div>
            <div class="row g-3 text-center">

                <!-- Cột 1: Máy vật lý / Máy ảo -->
                <div class="col-md-4">
                    <div class="stat-box p-4 border rounded text-center" style="height: 22em;">
                        <h6 class="fw-bold mb-2">Số máy Vật lý / Ảo</h6>
                        <canvas id="vmPieChartDeleted" height="200"></canvas>
                    </div>
                </div>

                <!-- Cột 2: HDD -->
                <div class="col-md-4">

                    <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                        <h6 class="fw-bold mb-2">HDD</h6>
                        <p class="text-muted mb-1 fw-bold">Tổng dung lượng HDD: <span
                                id="hardware-average-storage-delete" class="fw-bold text-primary">--</span></p>

                        <canvas id="hddChart-delete" height="150"></canvas>
                    </div>
                </div>

                <!-- Cột 3: RAM -->
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                        <h6 class="fw-bold mb-2">RAM</h6>
                        <p class="text-muted mb-1">Tổng dung lượng RAM:
                            <span class="text-success mb-3" id="totalRamDelete">--</span>
                        </p>

                        <canvas id="ramChart-delete" height="150"></canvas>
                    </div>
                </div>

            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

        </div>
    </div>

    <style>
        .stat-box {
            background-color: #fff;
            transition: all 0.2s ease;
        }

        .stat-box:hover {
            background-color: #f9fafb;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.05);
        }
    </style>

</div>
@vite('resources/js/pages/dashboard.js')

@endhasPermission
@endsection