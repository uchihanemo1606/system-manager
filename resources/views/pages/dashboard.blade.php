@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="mb-0 font-size-18">
            <i class="bx bx-bar-chart-alt-2"></i> Thống kê
        </h4>
    </div> 

    <!-- Tổng quan -->
    <div class="row">
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
                        <p class="text-muted fw-medium">Người dùng mưới </p>
                        <h4 id="total-visit">--</h4>
                    </div>
                    <i class="bx bx-globe h1 text-info"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê chi tiết -->
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

        <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-medium">Số lần cập nhật phần mềm</p>
                        <h4 id="software-update-count">--</h4>
                    </div>
                    <i class="bx bx-refresh h1 text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-medium">Số lần cập nhật phần cứng</p>
                        <h4 id="hardware-update-count">--</h4>
                    </div>
                    <i class="bx bx-refresh h1 text-warning"></i>
                </div>
            </div>
        </div>
    </div> 
</div>
 
@vite('resources/js/pages/dashboard.js')
@endsection
