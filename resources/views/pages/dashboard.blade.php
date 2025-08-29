@extends('layouts.app')
@section('content')
@hasPermission('system.get')
<div class="container-fluid">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="mb-0 font-size-18">
            <i class="bx bx-bar-chart-alt-2"></i> Thống kê hệ thống
        </h4>
    </div>
    <!-- Tổng quan -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex align-items-center justify-content-between mb-3">
                <!-- Tiêu đề -->
                <h4 class="mb-0 d-flex align-items-center text-primary">
                    <i class="bx bx-bar-chart-alt-2 text-primary me-2"></i>
                    Tổng quan hệ thống
                </h4>

                <!-- Filter form -->
                <div class="form-inline pull-right">
                    <label for="overview-filter-start-date" class="muted">Từ ngày</label>
                    <input type="date" id="overview-filter-start-date" class="input-small" style="margin-right:8px;">

                    <label for="overview-filter-end-date" class="muted">Đến ngày</label>
                    <input type="date" id="overview-filter-end-date" class="input-small" style="margin-right:12px;">

                    <button type="submit" id="overviewLoadAnalytics" class="btn btn-mini">
                        <i class="icon-filter"></i> Thống kê
                    </button>
                    <button type="button" class="btn btn-mini" id="overview-btn-reset-time" style="margin-left:4px;">
                        <i class="icon-refresh"></i> Đặt lại
                    </button>
                </div>

            </div>

            <!-- phần mềm -->
            <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0 text-info">
                        <i class="bx bx-code-alt text-primary"></i> Phần mềm
                    </h5>
                </div>


                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="stat-box p-3 rounded border bg-light  h-100">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-apps text-primary fs-3 me-2 mr-2"></i>
                                <div>
                                    <div class="fw-bold text-muted">Số phần mềm đang hoạt động</div>
                                    <h4 class="mb-0" id="totalSoftwareOverview">--</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-box p-3 rounded border bg-light  h-100">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-update text-danger fs-3 me-2 mr-2"></i>

                                <div>
                                    <div class="fw-bold text-muted">Số lần cập nhật phần mềm</div>
                                    <h4 class="mb-0" id="softwareUpdateCountOverview">--</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-box p-3 rounded border bg-light  h-100">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-delete-variant text-danger fs-3 me-2 mr-2"></i>

                                <div>
                                    <div class="fw-bold text-muted">Số phần mềm đã xóa</div>
                                    <h4 class="mb-0" id="deletedSoftwareOverview">--</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dung lượng -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="stat-box p-3 rounded border bg-light  h-100">
                            <p class="mb-1 text-muted">
                                Tổng dung lượng tệp tin phần mềm đang chiếm dụng
                                <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                    title="Tổng dung lượng các tệp tin của phần mềm còn hoạt động đang chiếm dụng."></i>
                            </p>
                            <h5 class="fw-bold text-warning mb-0" id="storageSoftwareOverview">-- MB</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-box p-3 rounded border  bg-light h-100">
                            <p class="mb-1 text-muted">
                                Tổng dung lượng tiếc kiệm được
                                <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                    title="Tổng dung lượng tiếc kiệm được từ việc xóa phần mềm."></i>
                            </p>
                            <h5 class="fw-bold text-success mb-0" id="storageSoftwareDeletedOverview">-- MB</h5>
                        </div>
                    </div>
                </div>

            </div>
            <!-- phần cứng -->
            <div class="">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-info">
                        <i class="bx bx-chip text-success"></i> Phần cứng
                    </h5>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="stat-box p-3 border bg-light  rounded h-100">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-desktop-classic text-primary fs-3 me-2 mr-2"></i>
                                <div>
                                    <div class="fw-bold text-muted">Số phần cứng đang hoạt động</div>
                                    <h4 class="mb-0" id="totalHardwareOverview">--</h4>
                                    <span class="d-none">[
                                        <span class="text-success" id="totalHardwareVOverviewDetail">--</span> máy ảo,
                                        <span class="text-info" id="totalHardwarePOverviewDetail">--</span> máy vật lý
                                        ]
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box p-3  border  bg-light  rounded h-100">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-update text-danger fs-3 me-2 mr-2"></i>
                                <div>
                                    <div class="fw-bold text-muted">Số lần cập nhật phần cứng</div>
                                    <h4 class="mb-0" id="updateCountOverview">--</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box p-3  border  bg-light  rounded h-100">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-delete-forever text-danger fs-3 me-2 mr-2"></i>
                                <div>
                                    <div class="fw-bold text-muted">Số phần cứng đã xóa</div>
                                    <h4 class="mb-0" id="totalHardwareDeletedOverview">--</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <!-- <h5 class="fw-bold">Thống kê phần cứng</h5> -->
                    <!-- <button id="btnThuPhong" class="btn btn-sm btn-primary">
                        <i class="icon-fullscreen"></i> Thu phóng
                    </button> -->
                </div>

                <div>
                    <h6 class="fw-bold mb-0">Biểu đồ thống kê phần cứng<medium class="text-success">(đang hoạt động)
                        </medium>
                    </h6>
                    <!-- Hoạt động & dung lượng -->
                    <div class="row g-3 text-center">
                        <div class="col-md-4">
                            <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">

                                <p class="text-muted mb-1 fw-bold">Tổng số phần cứng: </p>
                                <h4 id="totalHardwareOverviewChart" class="fw-bold text-primary">--</h4>
                                <canvas id="totalHardwareChart" height="150"></canvas>
                            </div>
                        </div>
                        <!-- Cột 2: HDD -->
                        <div class="col-md-4">
                            <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                                <h6 class="fw-bold mb-2">HDD</h6>
                                <p class="text-muted mb-1 fw-bold">Tổng :
                                    <span id="sumHddOverviewChart" class="fw-bold text-primary">--</span>
                                </p>
                                <canvas id="hddOverviewChart" height="150"></canvas>
                            </div>
                        </div>
                        <!-- Cột 3: RAM -->
                        <div class="col-md-4">
                            <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                                <h6 class="fw-bold mb-2">RAM</h6>
                                <p class="text-muted mb-1">Tổng :
                                    <span id="sumRamOverviewChart" class="fw-bold text-success">--</span>
                                </p>
                                <canvas id="ramOverviewChart" height="150"></canvas>
                            </div>
                        </div>

                    </div>
                    <h6 class="fw-bold mb-2 mt-3">Biểu đồ thống kê phần cứng<medium class="text-danger">(đã xóa)
                        </medium>
                    </h6>
                    <!-- Hoạt động & dung lượng -->
                    <div class="row g-3 text-center">
                        <!-- Cột 1: Máy vật lý / Máy ảo -->
                        <div class="col-md-4">
                            <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">

                                <p class="text-muted mb-1 fw-bold">Tổng số phần cứng: </p>
                                <h4 id="totalHardwareDeletedOverviewChart" class="fw-bold text-primary">--</h4>
                                <canvas id="totalHardDeletedwareChart" height="150"></canvas>
                            </div>
                        </div>
                        <!-- Cột 2: HDD -->
                        <div class="col-md-4">
                            <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                                <h6 class="fw-bold mb-2">HDD</h6>
                                <p class="text-muted mb-1 fw-bold">Tổng : <span id="sumHddOverviewChartDelete"
                                        class="fw-bold text-primary">--</span></p>
                                <canvas id="hddDeletedOverviewChart" height="150"></canvas>
                            </div>
                        </div>
                        <!-- Cột 3: RAM -->
                        <div class="col-md-4">
                            <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                                <h6 class="fw-bold mb-2">RAM</h6>
                                <p class="text-muted mb-1">Tổng :
                                    <span class="text-success mb-3" id="sumRamOverviewChartDelete">--</span>
                                </p>

                                <canvas id="ramDeletedOverviewChart" height="150"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bộ lọc thời gian -->
    <div class="card shadow-sm border-0 mt-3">
        <div class="card-header bg-light d-flex align-items-center justify-content-between">
            <h6 class="mb-0">
                <i class="bx bx-calendar me-1"></i> Thống kê theo thời gian
            </h6>
            <div>
                <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="btn-reset-time">
                    <i class="bx bx-reset"></i> Đặt lại
                </button>
                <button type="submit" id="loadAnalytics" class="btn btn-sm btn-primary">
                    <i class="bx bx-filter-alt"></i> Thống kê
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="filter-form">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label mb-1 fw-semibold">Từ ngày</label>
                        <input type="date" id="filter-start-date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label mb-1 fw-semibold">Đến ngày</label>
                        <input type="datetime-local" id="filter-end-date" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- PHẦN MỀM -->
    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0 text-info">
                    <i class="bx bx-code-alt text-primary"></i> Phần mềm
                </h5>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="stat-box p-3 rounded border h-100">
                        <p class="mb-1 text-muted">
                            Số phần mềm đã tạo
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                title="Tổng số phần mềm được tạo trong khoảng thời gian đã chọn."></i>
                        </p>
                        <h4 class="fw-bold text-primary mb-0" id="softwareCreated">--</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box p-3 rounded border h-100">
                        <p class="mb-1 text-muted">
                            Số lần câp nhật phần mềm
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                title="Số lần phần mềm được cập nhật."></i>
                        </p>
                        <h4 class="fw-bold text-danger mb-0" id="softwareUpdateCount">--</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box p-3 rounded border h-100">
                        <p class="mb-1 text-muted">
                            Số phần mềm đã xóa
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                title="Tổng số phần mềm bị xóa."></i>
                        </p>
                        <h4 class="fw-bold text-danger mb-0" id="softwareDeletedDetail">--</h4>
                    </div>
                </div>
            </div>

            <!-- Dung lượng -->
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="stat-box p-3 rounded border h-100">
                        <p class="mb-1 text-muted">
                            Tổng dung lượng tệp tin của phần mềm đã tạo
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                title="Tổng dung lượng các tệp tin của phần mềm đã tạo bao gồm phần mềm bị xóa."></i>
                        </p>
                        <h5 class="fw-bold text-warning mb-0" id="storageSoftwareDetail">-- MB</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-box p-3 rounded border h-100">
                        <p class="mb-1 text-muted">
                            Dung lượng tiết kiệm được
                            <i class="mdi mdi-help-circle-outline text-info" data-bs-toggle="tooltip"
                                title="Dung lượng tiết kiệm được nhờ gỡ bỏ phần mềm."></i>
                        </p>
                        <h5 class="fw-bold text-success mb-0" id="storageSoftwareDeletedDetail">-- MB</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PHẦN CỨNG -->
    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <!-- Tiêu đề -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 text-info">
                    <i class="bx bx-chip text-success"></i> Phần cứng
                </h5>
            </div>
            <!-- Thống kê theo khoảng thời gian -->
            <div class="row g-3 mb-3 text-center">
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100">
                        <p class="text-muted mb-1">
                            Số phần cứng đã tạo
                            <i class="mdi mdi-help-circle-outline text-info"
                                title="Tổng số phần cứng được tạo trong khoảng thời gian đã chọn"></i>
                        </p>
                        <h4 class="text-primary mb-0" id="hardware-created">--</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100">
                        <p class="text-muted mb-1">
                            Số lần cập nhật phần cứng
                            <i class="mdi mdi-help-circle-outline text-info"
                                title="Tổng số lần phần cứng được cập nhật"></i>
                        </p>
                        <h4 class="text-success mb-0" id="hardwareUpdateCount">--</h4>
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
            <h6 class="fw-bold mb-0">Thống kê phần cứng  đã tạo
            </h6>
            <div class="row g-3 text-center">
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">

                        <p class="text-muted mb-1 fw-bold">Tổng số phần cứng: </p>
                        <h4 id="totalSumHardwareDetailChart" class="fw-bold text-primary">--</h4>
                        <canvas id="totalHardwareDetailChart" height="150"></canvas>
                    </div>
                </div>
                <!-- Cột 2: HDD -->
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                        <h6 class="fw-bold mb-2">HDD</h6>
                        <p class="text-muted mb-1 fw-bold">Tổng :
                            <span id="sumHddDetailChart" class="fw-bold text-primary">--</span>
                        </p>
                        <canvas id="hddDetailChart" height="150"></canvas>
                    </div>
                </div>
                <!-- Cột 3: RAM -->
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                        <h6 class="fw-bold mb-2">RAM</h6>
                        <p class="text-muted mb-1">Tổng :
                            <span id="sumRamDetailChart" class="fw-bold text-success">--</span>
                        </p>
                        <canvas id="ramDetailChart" height="150"></canvas>
                    </div>
                </div>

            </div>
            <h6 class="fw-bold mb-2 mt-3">Thống kê phần cứng<medium class="text-danger">(đã xóa)</medium>
            </h6>
            <div class="row g-3 text-center">
                <!-- Cột 1: Máy vật lý / Máy ảo -->
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">

                        <p class="text-muted mb-1 fw-bold">Tổng số phần cứng: </p>
                        <h4 id="totalSumHardwareDeletedDetailChart" class="fw-bold text-primary">--</h4>
                        <canvas id="totalHardwareDeletedDetailChart" height="150"></canvas>
                    </div>
                </div>
                <!-- Cột 2: HDD -->
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                        <h6 class="fw-bold mb-2">HDD</h6>
                        <p class="text-muted mb-1 fw-bold">Tổng : <span id="sumHddDetailChartDelete"
                                class="fw-bold text-primary">--</span></p>
                        <canvas id="hddDeletedDetailChart" height="150"></canvas>
                    </div>
                </div>
                <!-- Cột 3: RAM -->
                <div class="col-md-4">
                    <div class="stat-box p-3 border rounded h-100 d-flex flex-column justify-content-between">
                        <h6 class="fw-bold mb-2">RAM</h6>
                        <p class="text-muted mb-1">Tổng :
                            <span class="text-success mb-3" id="sumRamDetailChartDelete">--</span>
                        </p>

                        <canvas id="ramDeletedDetailChart" height="150"></canvas>
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