<div id="typePermissionCreateModal">

    <div class="modal-header">
        <h5 class="modal-title">Thêm người dùng vào <span id="modalTypeLabel"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body row">

        <div class="col-md-5">
            <label class="form-label">Tìm kiếm người dùng:</label>
            <input type="text" id="userSearchInput" class="form-control mb-2"
                placeholder="Tìm theo tên, tài khoản hoặc email...">
            <div id="userListContainer" class="list-group" style="max-height: 300px; overflow-y: auto;">
                <!-- Danh sách người dùng sẽ được JS đẩy vào đây -->
            </div>
        </div>

        <div class="col-md-7">
            <label class="form-label">Chọn quyền:</label>
            <div id="permissionCheckboxList">
                <!-- Checkbox quyền sẽ được JS đẩy vào đây -->
            </div>
        </div>

    </div>

    <div class="modal-footer">
        <button id="addPermissionBtn" class="btn btn-success">Thêm</button>
    </div>
</div>