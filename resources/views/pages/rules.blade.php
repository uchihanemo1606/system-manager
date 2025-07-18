@extends('layouts.app')
@section('content')
    <div class=" mt-4">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-4">Danh sách loại quy chế</h4>

            <!-- @hasPermission('software.create') -->
            <a href="#" class="btn btn-primary" onclick="loadModal('category_rule_create')">Thêm
                loại quy chế</a>
            <!-- @endhasPermission -->
        </div>
        <div class="row mb-3">

            <div class="col-md-6">
                <input type="text" id="search-name" class="form-control" placeholder="Tìm theo tên...">
            </div>
            <div class="col-md-6">
                <input type="text" id="search-description" class="form-control" placeholder="Tìm theo mô tả...">
            </div>
        </div>

        <div id="category-rule-list">
            <!-- Dữ liệu sẽ được render bằng JS -->
        </div>
    </div>

    @vite('resources/js/pages/rules.js')
@endsection