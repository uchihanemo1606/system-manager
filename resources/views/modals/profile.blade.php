<div id="profileModal" tabindex="-1" role="dialog">

    <form id="profile-form" class="modal-content p-4" novalidate>
        <h4 class="modal-title mb-4 w-full text-center">Thông tin cá nhân</h4>
        <div class="form-group">
            <label class="" for="username">Tên đăng nhập <small class="text-muted">(không thể thay đổi)</small></label>
            <input type="text" id="username" name="username" class="form-control readonly-input" readonly>
        </div>
        <div class="form-group">
            <label class="" for="email">Email <small class="text-muted">(liên hệ quản admin để thay đổi)</small></label>
            <input type="email" id="email" name="email" class="form-control readonly-input" readonly>
        </div>
        <div class="form-group">
            <label class="required" for="fullName">Họ và tên</label>
            <input type="text" id="fullName" name="fullName" class="form-control" readonly>
        </div>


        <div class="form-group d-none" >
            <label for="phone_number">Số điện thoại</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control" readonly>
        </div>
        <div class="mt-3">
            <button type="button" id="edit-btn" class="btn btn-primary">Chỉnh sửa</button>
            <button type="submit" id="save-btn" class="btn btn-success d-none">Lưu</button>
            <button type="button" id="cancel-btn" class="btn btn-secondary d-none">Hủy</button>
        </div>
    </form>
</div>