<div id="profileModal" tabindex="-1" role="dialog">
    <form id="profile-form" class="modal-content p-4">
        <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="fullName">Họ và tên</label>
            <input type="text" id="fullName" name="fullName" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="phone_number">Số điện thoại</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="created_at">Ngày tạo</label>
            <p id="created_at" class="form-control-plaintext"></p>
        </div>

        <div class="mt-3">
            <button type="button" id="edit-btn" class="btn btn-primary">Chỉnh sửa</button>
            <button type="submit" id="save-btn" class="btn btn-success d-none">Lưu</button>
            <button type="button" id="cancel-btn" class="btn btn-secondary d-none">Hủy</button>
        </div>
    </form>
</div>
