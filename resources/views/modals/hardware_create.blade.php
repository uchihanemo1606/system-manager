<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h4 class="mb-0">Tạo Phần Cứng</h4>
        </div>
        <div class="card-body">
            <form id="hardware-form">
                <div class="mb-3">
                    <label class="form-label">IP</label>
                    <input type="text" name="ip" class="form-control" required maxlength="255">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tên Database</label>
                    <input type="text" name="dbname" class="form-control" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phiên bản Database</label>
                    <input type="text" name="dbversion" class="form-control" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label class="form-label">Là máy ảo?</label>
                    <select name="isVirtualServer" class="form-select" required>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hệ điều hành</label>
                    <input type="text" name="OS" class="form-control" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phiên bản hệ điều hành</label>
                    <input type="text" name="OSver" class="form-control" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ổ cứng (HDD)</label>
                    <input type="text" name="hdd" class="form-control" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label class="form-label">RAM</label>
                    <input type="text" name="ram" class="form-control" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dịch vụ</label>
                    <textarea name="services" class="form-control" required maxlength="1000" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Tạo mới</button>
            </form>
        </div>
    </div>
</div>
