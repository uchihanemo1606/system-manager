@extends('layouts.app')
@section('content')
    <div class="">

        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="card-title">Cài đặt giao diện trang web</h4>
        </div> 
        <div class="row">
            <!-- Logo -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Logo hệ thống</h5>
                        <div class="form-group">
                            <label for="inputLogo">Chọn logo mới</label>
                            <input type="file" id="inputLogo" class="form-control-file">
                        </div>
                        <button type="button" class="btn btn-success mt-2" id="saveLogoBtn">
                            <i class="mdi mdi-content-save"></i> Lưu Logo
                        </button>

                        <div class="mt-3">
                            <label>Logo hiện tại:</label><br>
                            <img id="previewLogo" src="{{ asset('images/logo.png') }}?t={{ time() }}" alt="Logo hiện tại"
                                class="img-thumbnail" style="max-height: 100px;" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Giao diện website(footer)</h5> 
                        <div class="form-group mb-3">
                            <label for="inputCompanyName">Tên công ty</label>
                            <input type="text" id="inputCompanyName" class="form-control" placeholder="Nhập tên công ty">
                        </div> 
                        <div class="form-group mb-3">
                            <label for="inputSystemName">Tên hệ thống</label>
                            <input type="text" id="inputSystemName" class="form-control" placeholder="Nhập tên hệ thống">
                        </div>

                        <div class="form-group mb-3">
                            <label for="inputPhone">Liên hệ (số điện thoại)</label>
                            <textarea id="inputPhone" class="form-control" rows="3" placeholder="Nhập thông tin liên hệ"></textarea>
                        </div>

                        <button class="btn btn-primary" id="update_system_info">
                            <i class="mdi mdi-content-save"></i> Lưu lại
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/pages/setting.js')
@endsection
