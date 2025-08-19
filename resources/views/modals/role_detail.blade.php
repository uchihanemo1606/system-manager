<!-- Thông tin Role -->
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex flex-column" style="max-height: 90vh; overflow: hidden;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title text-primary">Thông tin Role</h4>
            @hasPermission('role.delete')
            <button id="delete-role-btn" class="btn btn-danger btn-sm mr-4">
                <i class="bx bx-trash mr-1"></i> Xóa Role
            </button>
            @endhasPermission
        </div>

        <div class="mb-3">
            <i class="mdi mdi-shield-account text-info mr-2"></i>
            <strong>Tên Role:</strong>
            <span id="role-name" class="font-weight-bold text-dark">Admin</span>

            <!-- Nút edit -->
            <button id="edit-role-btn" class="btn btn-sm btn-outline-primary ml-2">Thay đổi</button>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="text-primary mb-0">Danh sách Quyền hiện tại</h5>
            @hasPermission('permission.list')
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addPermissionModal">
                <i class="bx bx-plus mr-1"></i> Thêm Permission
            </button>
            @endhasPermission
        </div>
        <div class="flex-grow-1 overflow-auto border rounded p-2" style="max-height: 60vh;">
            <ul class="list-group" id="permission-list">
                <!-- Danh sách Permission sẽ được chèn vào đây -->
            </ul>
        </div>
    </div>
</div>

<div class="modal fade modal_permission_select" id="addPermissionModal" tabindex="-1" data-backdrop="static"
    data-keyboard="false" style="background-color: rgba(0, 0, 0, 0.75);">
    <div class="modal-dialog modal-xl">
        <form id="permission-form" class="modal-content shadow-lg border-0 rounded-lg"
            style="display: flex; flex-direction: column; max-height: 90vh;">

            <!-- Header -->
            <div class="modal-header text-white">
                <h5 class="modal-title mb-0">
                    <i class="mdi mdi-shield-account-outline mr-2"></i>Phân quyền cho vai trò
                </h5>
                <button type="button" class="close text-white" onclick="$('#addPermissionModal').modal('hide');">
                    &times;
                </button>
            </div>
            <div class="px-4">
                <div class="d-flex justify-content-between align-items-center ">
                    <h5 class="text-primary border-bottom pb-2 mb-0">Danh sách Permission</h5>
                    <button class="btn btn-link px-0" type="button" data-toggle="collapse"
                        data-target="#permissionFilters">
                        <i class="mdi mdi-filter-variant mr-1"></i> Bộ lọc
                    </button>
                </div>

                <div class="collapse show" id="permissionFilters">
                    <div class="form-row">
                        <div class="form-group col">
                            <input type="text" class="form-control" id="filter-name" placeholder="Tìm theo tên">
                        </div>
                        <div class="form-group col">
                            <select class="form-control" id="filter-type" name="type"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <input type="date" class="form-control" id="filter-created-date">
                        </div>
                        <div class="form-group col">
                            <select class="form-control" id="filter-selected">
                                <option value="">Tất cả</option>
                                <option value="selected">Đã chọn</option>
                                <option value="unselected">Chưa chọn</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Danh sách permission cuộn được -->
            <div class="modal-body overflow-auto px-4 py-3" style="flex-grow: 1; background-color: #f8f9fa;">
                <div id="permission-checkboxes"></div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="submit" class="btn btn-success">
                    <i class="mdi mdi-content-save-outline mr-1"></i> Lưu thay đổi
                </button>
                <button type="button" class="btn btn-secondary" onclick="$('#addPermissionModal').modal('hide')">
                    <i class="mdi mdi-close-circle-outline mr-1"></i> Đóng
                </button>
            </div>
        </form>
    </div>
</div>