<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h4 class="mb-0">Tạo Phần Mềm</h4>
        </div>
        <div class="card-body">
            <form id="software-form">
                <div class="mb-3">
                    <label for="softwareName" class="form-label">Tên Phần Mềm <span class="text-danger">*</span></label>
                    <input type="text" id="softwareName" name="softwareName" class="form-control" required maxlength="255">
                </div>

                <div class="mb-3">
                    <label for="language" class="form-label">Ngôn Ngữ <span class="text-danger">*</span></label>
                    <input type="text" id="language" name="language" class="form-control" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label for="version" class="form-label">Phiên Bản</label>
                    <input type="text" id="version" name="version" class="form-control" maxlength="255">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô Tả</label>
                    <textarea id="description" name="description" class="form-control" rows="3" maxlength="1000"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Tạo Mới</button>
            </form>
        </div>
    </div>
</div>
