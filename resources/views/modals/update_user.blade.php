<div id="updateUserModal" tabindex="-1" role="dialog">
    <form id="update-user-form" class="modal-content p-4" novalidate>
        <h4 class="modal-title mb-4 w-full text-center">Cập nhật thông tin</h4>
        <div class="form-group">
            <label class="readonly" for="username ">Tên đăng nhập</label>
            <input type="text" id="username" name="username" class="form-control readonly" readonly>
        </div>

        <div class="form-group">
            <label class="required" for="fullName ">Họ và tên</label>
            <input type="text" id="fullName" name="fullName" class="form-control" >
        </div>

        <div class="form-group">
            <label class="required" for="email ">Email</label>
            <input type="email" id="email" name="email" class="form-control" >
        </div> 
        <div class="mt-3"> 
            <button type="submit" id="save-btn" class="btn btn-success">Lưu</button> 
        </div>
    </form>
</div>
<style>
  input.readonly {
    background-color: #e9ecef;
    opacity: 0.7;
    cursor: not-allowed;
  }
</style>
