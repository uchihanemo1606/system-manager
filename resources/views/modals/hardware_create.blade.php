<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-primary">
                <i class="mdi mdi-server me-2"></i>Tạo Phần Cứng
            </h5>
        </div>
        <div class="card-body">
            <form id="hardware-form" class="row" novalidate>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Địa chỉ IP</label>
                    <input type="text" name="ip" class="form-control" required maxlength="255" placeholder="VD: 192.168.1.10">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tên CSDL (Database)</label>
                    <input type="text" name="dbname" class="form-control" required maxlength="100" placeholder="Tên Database">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phiên bản CSDL</label>
                    <input type="text" name="dbversion" class="form-control" required maxlength="100" placeholder="VD: 12.1">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Là máy ảo?</label>
                    <select name="isVirtualServer" class="form-select" required>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hệ điều hành</label>
                    <input type="text" name="OS" class="form-control" required maxlength="100" placeholder="VD: Windows Server, Ubuntu">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phiên bản hệ điều hành</label>
                    <input type="text" name="OSver" class="form-control" required maxlength="100" placeholder="VD: 20.04, 2019">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Ổ cứng (HDD)</label>
                    <div class="input-group">
                        <input type="number" name="hdd" class="form-control" required min="1" placeholder="Dung lượng">
                        <select name="hdd_unit" class="form-select" required>
                            <option value="MB">MB</option>
                            <option value="GB" selected>GB</option>
                            <option value="TB">TB</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Dung lượng RAM</label>
                    <div class="input-group">
                        <input type="number" name="ram" class="form-control" required min="1" placeholder="Dung lượng">
                        <select name="ram_unit" class="form-select" required>
                            <option value="MB">MB</option>
                            <option value="GB" selected>GB</option>
                            <option value="TB">TB</option>
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Dịch vụ cài đặt</label>
                    <textarea name="services" class="form-control" required maxlength="1000" rows="3" placeholder="VD: MySQL, Apache, Docker..."></textarea>
                </div>

                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="mdi mdi-plus-circle-outline me-1"></i> Tạo Phần Cứng
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
