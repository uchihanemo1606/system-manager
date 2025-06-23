<!-- Thông tin Role -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4 text-primary">Thông tin Role</h4>

        <div class="mb-3">
            <i class="mdi mdi-shield-account text-info mr-2"></i>

            <strong>Tên Role:</strong>
            <span id="role-name" class="font-weight-bold text-dark"></span>
        </div> 
        <div class="d-flex justify-content-between mb-3">
            <h4 class="card-title  text-primary">Danh sách Quyền hiện tại</h4>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addPermissionModal">
                <i class="bx bx-plus mr-1"></i> Thêm Permission
            </button>
        </div>

        <ul class="list-group" id="permission-list">
            <!-- Danh sách permission sẽ render vào đây -->
        </ul>
    </div>
</div>

<div class="modal modal_permission_select fade" id="addPermissionModal" tabindex="-1"
    data-backdrop="static" data-keyboard="false"
    style="background-color: rgba(0, 0, 0, 0.8);">
    <div class="modal-dialog">
        <form id="permission-form" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Danh sách Permission của role</h5>
                <button type="button" class="close" onclick="$('#addPermissionModal').modal('hide');">&times;</button>
            </div>

            <div class="modal-body">

                <!-- Bộ lọc -->
                <div class="form-row mb-3">
                    <div class="col">
                        <input type="text" class="form-control" id="filter-name" placeholder="Tìm theo tên">
                    </div>
                    <div class="col">
                        <select class="form-control" id="filter-type">
                            <option value="">Tất cả loại</option>
                            <option value="phần cứng">phần cứng</option>
                            <option value="phần mềm">phần mềm</option>
                            <option value="người dùng">người dùng</option>
                            <!-- Thêm loại khác nếu cần -->
                        </select>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col">
                        <input type="date" class="form-control" id="filter-created-date" placeholder="Ngày tạo">
                    </div>
                    <div class="col">
                        <select class="form-control" id="filter-selected">
                            <option value="">Tất cả</option>
                            <option value="selected">Đã chọn</option>
                            <option value="unselected">Chưa chọn</option>
                        </select>
                    </div>
                </div>

                <!-- Danh sách checkbox permission -->
                <div id="permission-checkboxes"></div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>