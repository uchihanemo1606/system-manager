 @extends('layouts.app')
 @section('content')
 <div class="row">
     <div class="col-12">
         <div class="page-title-box d-flex align-items-center justify-content-between">
             <h4 class="mb-0 font-size-18">Danh sách vai trò</h4>
            <button class="btn btn-primary" onclick="loadModal('role_create')">Thêm vai trò</button> 

         </div>
     </div>
 </div>
 <form class="form-row mb-3">
     <div class="col">
         <input type="text" class="form-control" id="filter-name" placeholder="Tìm theo tên">
     </div>
     <div class="col">
         <select class="form-control" id="filter-type">
             <option value="">Tất cả loại</option>
             <option value="">ô nô đang phát triển</option>
             <!-- Thêm loại khác nếu cần -->
         </select>
     </div>
     <div class="col">
         <input type="date" class="form-control" id="filter-created-date" placeholder="Ngày tạo">
     </div>
     <div class="col">
         <select class="form-control" id="filter-selected">
             <option value="">Tất cả</option>
             <option value="selected">Đang hoạt động</option>
             <option value="unselected">Ô nô</option>
         </select>
     </div>
     <div class="col">
         <select class="form-control" id="filter-selected" disabled>
             <option value="">permission liên quan</option> 
         </select>
     </div>
     <div class="col-md-3">
         <button type="submit" class="btn btn-secondary">Lọc</button>
     </div>
 </form>

 <div class="row">
     <div class="col-lg-12">
         <div class="">
             <div class="table-responsive">
                 <div class="card">
                 </div>
                 <table class="table project-list-table table-nowrap table-centered table-borderless">
                     <thead>
                         <tr>
                             <th scope="col">Tên Quyền Hạng</th>
                             <th scope="col">Permission</th>
                             <th scope="col">Ngày tạo</th>
                             <th scope="col">Người dùng liên quan</th>
                             <th scope="col">Action</th>
                         </tr>
                     </thead>
                     <tbody id="role-table-body"></tbody>
                 </table>
             </div>
         </div>
     </div>
 </div>

 <div class="row">
     <div class="col-12">
         <div class="text-center my-3">
             <a href="javascript:void(0);" class="text-success"><i class="bx bx-loader bx-spin font-size-18 align-middle mr-2"></i> Load more </a>
         </div>
     </div> <!-- end col-->
 </div>
 @vite('resources/js/pages/roles.js')
 @endsection