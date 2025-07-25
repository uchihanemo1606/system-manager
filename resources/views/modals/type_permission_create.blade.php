<div id="typePermissionCreateModal">
    <div class="modal-header">
        <h5 class="modal-title">Thêm người dùng vào <span id="modalTypeLabel"></span></h5>
    </div>

    <div class="px-2 row">
        <!-- Danh sách người dùng -->
        <div class="col-md-5">
            <label class="form-label">Tìm kiếm người dùng:</label>
            <input type="text" id="userSearchInput" class="form-control mb-2"
                placeholder="Tìm theo tên, tài khoản hoặc email...">
            <div id="userListContainer" class="list-group border-top border-bottom mb-2 "
                style="max-height: 400px; overflow-y: auto;"></div>

        </div>
        <div class="col-md-7">
            <!-- ...bulkPermissionCollapse -->

            <label class="form-label">người dùng đã chọn:</label>
            <!-- Nút mở modal -->
            <div class="d-flex mb-2 align-items-stretch">
                <input type="text" id="selectedUserSearchInput" class="form-control  mr-2"
                    placeholder="Tìm người dùng đã chọn...">
                <a href="#" class="btn btn-outline-primary d-inline-flex align-items-center px-3 py-0"
                    data-toggle="modal" data-target="#bulkPermissionModal">
                    <i class="mdi mdi-account-multiple mr-1"></i> <small>Chọn cùng lúc</small>
                </a>
            </div>

            <!-- Modal cấp quyền hàng loạt -->
            <div class="modal fade" id="bulkPermissionModal" style="background-color: rgba(0, 0, 0, 0.7);" tabindex="-1"
                role="dialog" aria-labelledby="bulkPermissionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bulkPermissionModalLabel">Cấp quyền cho tất cả người dùng đã
                                chọn</h5>
                        </div>

                        <div class="modal-body">
                            <div id="bulkPermissionContainer" class="col border-top border-bottom"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="selectedUsersContainer" class="border-top border-bottom"
                style="max-height: 400px; overflow-y: auto;"></div>


        </div>
    </div>

    <div class="modal-footer">
        <button id="addPermissionBtn" class="btn btn-success" type="button">
            <span class="spinner-border spinner-border-sm me-2 d-none" id="addPermissionSpinner" role="status"
                aria-hidden="true"></span>
            Thêm
        </button>
    </div>
</div>


<!-- <div id="typePermissionCreateModal">

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
                 
            </div>
        </div>

        <div class="col-md-7">
            <label class="form-label">Chọn quyền:</label>
            <div id="permissionCheckboxList">
               
            </div>
        </div>

    </div> 
    <div class="modal-footer">
        <button id="addPermissionBtn" class="btn btn-success">Thêm</button>
    </div>
</div> -->