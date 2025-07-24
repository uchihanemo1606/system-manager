<div id="userEditModal" tabindex="-1" role="dialog">
    <form id="edit-user-form" class="modal-content p-4" novalidate>
        <h4 class="modal-title mb-4 w-full text-center">Thông tin cá nhân</h4>
        <div class="form-group">
            <label class="readonly" for="username ">Tên đăng nhập</label>
            <input type="text" id="username" name="username" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label class="required" for="fullName ">Họ và tên</label>
            <input type="text" id="fullName" name="fullName" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label class="required" for="email ">Email</label>
            <input type="email" id="email" name="email" class="form-control" readonly>
        </div>

        <div class="form-group d-none">
            <label class="required" for="phone_number ">Số điện thoại</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control" readonly>
        </div> 
        <div class="mt-3">
            <button type="button" id="edit-user-btn" class="btn btn-primary">Chỉnh sửa</button>
            <button type="submit" id="save-btn" class="btn btn-success d-none">Lưu</button>
            <button type="button" id="cancel-btn" class="btn btn-secondary d-none">Hủy</button>
        </div>
    </form>
</div>