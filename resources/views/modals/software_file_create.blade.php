<div class="p-4">
    <form id="create-software-file-form">
        <h4 class="mb-4">Tạo tập tin cho phần mềm</h4>
        <div class="form-group">
            <label for="software-id " class="required">Mã phần mềm (software_id)</label>
            <input type="text" class="form-control" id="software-id" name="software_id" maxlength="25" required>
        </div>

        <div class="form-group">
            <label for="file-name  " class="required">Tên tập tin (file_name)</label>
            <input type="text" class="form-control" id="file-name" name="file_name" maxlength="255" required>
        </div>

        <div class="form-group">
            <label for="file-path  " class="required">Đường dẫn tập tin (file_path)</label>
            <input type="text" class="form-control" id="file-path" name="file_path" maxlength="10000" required>
        </div>

        <div class="form-group">
            <label for="description " class="required">Mô tả (description)</label>
            <textarea class="form-control" id="description" name="description" rows="3" maxlength="10000"></textarea>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary">Tạo</button>
        </div>
    </form>
</div>