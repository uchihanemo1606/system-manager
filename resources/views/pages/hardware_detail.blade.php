@extends('layouts.app')
@section('content')
    @hasPermission('user.detail')
        <div id="hardware-detail" style="display: none;">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Chi tiết phần cứng</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-7">
                    <div class="card overflow-hidden shadow-sm border">
                        <div class="bg-soft-primary p-3">
                            <div class="row">
                                <div class="col-4">
                                    <div class="text-primary">
                                        <h6 class="mb-1 ">Máy ảo</h6>
                                        <p class="fw-bold mb-0" id="hardware-ip">192.168.1.140</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-primary">
                                        <h6 class="mb-1">Hệ điều hành</h6>
                                        <p class="fw-bold mb-0" id="hardware-os">Ubuntu 22.04</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-primary">
                                        <h6 class="mb-1">Phiên bản</h6>
                                        <p class="fw-bold mb-0" id="hardware-osver">v1.0.5</p>
                                    </div>
                                </div>
                            </div>
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
                                            <h6 class="text-primary mb-0">
                                                Domain: <span class="fw-bold" id="hardware-domain">example.com</span>
                                                <i class="mdi mdi-plus-circle-outline text-success ml-1"></i>
                                            </h6>
                                            <a href="#" class="btn btn-outline-primary btn-sm">
                                                View Domain <i class="mdi mdi-arrow-right ml-1"></i>
                                            </a>
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
                                            <td id="hardware-hdd">1 TG</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Ram :</th>
                                            <td id="hardware-ram">524 MB</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-primary">Database :</th>
                                            <td id="hardware-db">Mysql</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-primary"> Database Version:</th>
                                            <td id="hardware-dbver">1.0.0</td>
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
                                <p class="text-muted mb-4" id="hardware-services">
                                    cung cấp máy ảo VPS, server hosting,.. sẵn sàng hỗ trợ các bạn tậng tâm. chúng tôi vui lòng
                                    tiếp nhận nhận
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- rule --}}
                    @include('components.rule', ['type' => 'hardware'])
                    @vite('resources/js/component/rule/hardware_rule.js')  
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-5">Lịch sử thay đổi</h4>
                            <div class="">
                                <ul class="verti-timeline list-unstyled">
                                    <li class="event-list active">
                                        <div class="event-timeline-dot">
                                            <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                        </div>
                                        <div class="media">
                                            <div class="mr-3">
                                                <i class="bx bx-server h4 text-primary"></i>
                                            </div>
                                            <div class="media-body">
                                                <div>
                                                    <h5 class="font-size-15">
                                                        <a href="#" class="text-dark">Dung lượng ở cứng vừa được thay
                                                            đổi</a>
                                                    </h5>
                                                    <span class="text-primary">3/6/2025</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="event-list">
                                        <div class="event-timeline-dot">
                                            <i class="bx bx-right-arrow-circle"></i>
                                        </div>
                                        <div class="media">
                                            <div class="mr-3">
                                                <i class="bx bx-code h4 text-primary"></i>
                                            </div>
                                            <div class="media-body">
                                                <div>
                                                    <h5 class="font-size-15">
                                                        <a href="#" class="text-dark">Mini đã thay đổi thông tin dịch
                                                            vụ</a>
                                                    </h5>
                                                    <span class="text-primary">16/5/2013</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="event-list">
                                        <div class="event-timeline-dot">
                                            <i class="bx bx-right-arrow-circle"></i>
                                        </div>
                                        <div class="media">
                                            <div class="mr-3">
                                                <i class="bx bx-edit h4 text-primary"></i>
                                            </div>
                                            <div class="media-body">
                                                <div>
                                                    <h5 class="font-size-15">
                                                        <a href="#" class="text-dark">Admin đã sửa ip phần cứng</a>
                                                    </h5>
                                                    <span class="text-primary">10/5/2013</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>
        @vite('resources/js/pages/hardware_detail.js')
    @endhasPermission
@endsection
