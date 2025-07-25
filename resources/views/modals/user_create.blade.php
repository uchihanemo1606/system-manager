<div id="createUserModal" tabindex="-1" role="dialog">
    <form id="create-user-form" class="modal-content p-4" novalidate>
        <div class="modal-header pb-2">
            <h5 class="modal-title w-100 text-center text-success" id="createUserModalLabel">
                Tạo người dùng mới
            </h5> 
        </div>

        <div class="modal-body pt-2">
            @csrf
            <div class="row">
                <div class="col-md-8 ">
                    <div class="form-group">
                        <label for="fullName required">Họ và tên</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required />
                    </div>

                    <div class="form-group">
                        <label for="email required">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required />
                    </div>

                    <div class="form-group">
                        <label for="username required">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required />
                    </div>
                    <div class="form-group">
                        <label for="password required">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required />
                    </div>
                    <div class="form-group">
                        <label for="verifyPassword required">Nhập lại mật khẩu</label>
                        <input type="password" class="form-control" id="verifyPassword" name="verifyPassword"
                            required />
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