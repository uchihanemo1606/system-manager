<div class="p-4">
    <form id="edit-software-file-form">
        <div class="form-group mb-3">
            <label for="edit-file-name" class="form-label fw-semibold required">Tên tập tin</label>
            <input type="text" class="form-control" id="edit-file-name" required maxlength="255">
        </div>

        <div class="form-group mb-3">
            <label for="edit-file-path" class="form-label fw-semibold required">Đường dẫn</label>
            <input type="text" class="form-control" id="edit-file-path" required maxlength="10000">
        </div>

        <div class="form-group mb-3">
            <label for="edit-description" class="form-label fw-semibold">Mô tả</label>
            <textarea class="form-control" id="edit-description" rows="3" maxlength="10000"></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-danger" id="delete-software-file">Xóa</button>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>

    </form>
</div>