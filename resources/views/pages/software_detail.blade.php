@extends('layouts.app')
@section('content')
@hasPermission('software.detail')
<div class="container-fluid" id="software-detail" style="display: none;">

    <div class="d-flex justify-content-between mb-3">
        <h4 class="mb-0 font-size-18">Chi tiết phần mềm</h4>
        @hasPermission('software.update')
        <button id="toggle-edit-btn" class="btn btn-primary">
            <i class="mdi mdi-pencil"></i> Sửa
        </button>
        @endhasPermission
        @hasPermission('software.delete')
        <button id="toggle-edit-btn" class="btn btn-primary">
            <i class="mdi mdi-pencil"></i> Xóa
        </button>
        @endhasPermission
    </div>
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="media mb-3">
                        <img src="/images/software_default.png" alt="" class="avatar-sm mr-3">
                        <div class="media-body overflow-hidden">
                            <h5 class="text-truncate font-size-15">
                                <span id="software-name-view"></span>
                                <input id="software-name-input" class="form-control d-none" />
                            </h5>
                            <p class="text-muted mb-0">Version: <span id="software-version-view"></span></p>
                            <input id="software-version-input" class="form-control d-none mt-2" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5 class="font-size-15 d-inline">Ngôn ngữ:</h5>
                        <span id="software-language-view" class="ml-2"></span>
                        <input id="software-language-input" class="form-control d-none mt-2" />
                    </div>

                    <h5 class="font-size-15 mt-3">Mô tả phần mềm:</h5>
                    <p id="software-description-view" class="text-muted"></p>
                    <textarea id="software-description-input" class="form-control d-none mt-2"></textarea>

                    <div class="row mt-4">
                        <div class="col-sm-4">
                            <h5 class="font-size-14"><i class="bx bx-calendar mr-1 text-primary"></i> Ngày tạo</h5>
                            <p class="text-muted mb-0" id="software-created-view"></p>
                        </div>
                        <div class="col-sm-4">
                            <h5 class="font-size-14"><i class="bx bx-calendar-check mr-1 text-primary"></i> Ngày cập
                                nhật</h5>
                            <p class="text-muted mb-0" id="software-updated-view"></p>
                        </div>
                        <div class="col-sm-4">
                            <h5 class="font-size-14"><i class="bx bx-user mr-1 text-primary"></i> Người tạo</h5>
                            <p class="text-muted mb-0" id="software-createdby-view"></p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h5 class="font-size-14 d-inline">Trạng thái:</h5>
                        <span id="software-is-delete-view" class="ml-2"></span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Quy chế</h4>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Thành viên quản lý phần mềm</h4>
                    @include('components.user_member_list', ['type' => 'software'])
                    @vite('resources/js/component/user_member_list/user_member_software.js')
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="card-title mb-4">Tên miền</h4>
                        @hasPermission('domain.create')
                        <button id="add_domain" class="btn btn-primary" type="button" data-software='{}'
                            onclick="loadModal('domain_create', JSON.parse(this.dataset.software))">
                            <i class="mdi mdi-plus"></i>Tạo tên miền
                        </button>
                        @endhasPermission
                    </div>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-nowrap table-centered table-hover mb-0" id="domain_list">
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Danh sách file của phần mềm</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-centered table-hover mb-0">
                            <tbody>
                                <tr>
                                    <td style="width: 45px;">
                                        <div class="avatar-sm">
                                            <span
                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-24">
                                                <i class="bx bxs-file-doc"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">Skote
                                                Landing.Zip</a></h5>
                                        <small>Size : 3.25 MB</small>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <a href="#" class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="avatar-sm">
                                            <span
                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-24">
                                                <i class="bx bxs-file-doc"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">Skote
                                                Admin.Zip</a></h5>
                                        <small>Size : 3.15 MB</small>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <a href="#" class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @include('components.log_by_type', ['type' => 'software'])
            @vite('resources/js/component/log/software_log.js')
        </div>
    </div>
</div>
@vite('resources/js/pages/software_detail.js')
@endhasPermission
@endsection