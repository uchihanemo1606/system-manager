<div id="createUserModal" tabindex="-1" role="dialog">
    <form id="create-user-form" class="modal-content p-4">
        <div class="modal-header pb-4">
            <h5 class="modal-title w-100 text-center text-success" id="createUserModalLabel">
                Tạo người dùng mới
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body pt-2">
            @csrf
            <div class="row">
                <div class="col-md-8 ">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required />
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required />
                    </div>
                    <div class="form-group">
                        <label for="verifyPassword">Nhập lại mật khẩu</label>
                        <input type="password" class="form-control" id="verifyPassword" name="verifyPassword" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Quyền</label>
                    <p class="text-primary1">Chức năng thêm quyền cho tài khoản tạo đang bảo trì chưa thể thêm quyền</p>
                    <div id="role-checkboxes"></div>
                </div>
            </div>
        </div>

        <div class="modal-footer pt-2">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-primary">Tạo người dùng</button>
        </div>
    </form>
</div>