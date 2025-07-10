<link rel="stylesheet" href="{{ asset('css/modal/hardware_create.css') }}">

<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="text-primary mb-0">
                <i class="mdi mdi-server me-2"></i> Tạo Phần Cứng
            </h5>
        </div>
        <div class="card-body">
            <form id="hardware-form" class="row" novalidate>
                <!-- IP -->
                <div class="form-group col-md-6">
                    <label class="fw-semibold required">Địa chỉ IP</label>
                    <input type="text" name="ip" class="form-control" required maxlength="255"
                        placeholder="VD: 192.168.1.10">
                </div>

                <!-- Is Virtual -->
                <div class="form-group col-md-6">
                    <label class="fw-semibold required">Là máy ảo?</label>
                    <select name="isVirtualServer" class="form-control" required>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>

                <!-- DB Name + Version -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold required">Tên CSDL (Database)</label>
                    <div class="d-flex gap-2 align-items-center">
                        <select name="dbname" class="form-control select2 flex-grow-1" required>
                            <option></option>
                        </select>
                        <button type="button" id="btn-create-dbname" class="btn btn-outline-secondary"
                            onclick="openCreateModal('dbname', {}, async () => await populateDropdowns())"
                            title="Tạo tên CSDL">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold required">Phiên bản CSDL</label>
                    <div class="d-flex gap-2 align-items-start">
                        <select name="dbversion" class="form-control select2 flex-grow-1" required></select>
                        <button type="button" id="btn-create-dbversion" class="btn btn-outline-secondary"
                            onclick="openCreateModal('dbversion', { dbname: document.querySelector('select[name=dbname]').value || '' }, async () => await populateDropdowns())"
                            title="Tạo phiên bản CSDL">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>
                </div>
                <!-- OS Name + Version -->
                <div class="form-group col-md-6">
                    <label class="fw-semibold required">Hệ điều hành</label>
                    <div class="d-flex gap-2 align-items-start">
                        <select name="OS" class="form-control select2 flex-grow-1" required></select>
                        <button type="button" id="btn-create-osname" class="btn btn-outline-secondary"
                            onclick="openCreateModal('OS', {}, async () => await populateDropdowns())"
                            title="Tạo tên OS">
                            <i class="mdi mdi-plus"></i>
                        </button>

                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="fw-semibold required">Phiên bản HĐH</label>
                    <div class="d-flex gap-2 align-items-start">
                        <select name="OSver" class="form-control select2 flex-grow-1" required></select>
                        <button type="button" id="btn-create-osversion" class="btn btn-outline-secondary"
                            onclick="openCreateModal('OSver', { OS: document.querySelector('select[name=OS]').value || '' }, async () => await populateDropdowns())"
                            title="Tạo phiên bản OS">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>
                </div>


                <!-- HDD -->
                <div class="form-group col-md-6">
                    <label class="fw-semibold required">Ổ cứng (HDD)</label>
                    <div class="input-group">
                        <input type="number" name="hdd" class="form-control" required min="1" placeholder="Dung lượng" onkeydown="return event.key !== 'e' && event.key !== 'E' && event.key !== '+' && event.key !== '-'" >
                        <select name="hdd_unit" class="form-control" required style="max-width: 100px;">
                            <option value="MB">MB</option>
                            <option value="GB" selected>GB</option>
                            <option value="TB">TB</option>
                        </select>
                    </div>
                </div>

                <!-- RAM -->
                <div class="form-group col-md-6">
                    <label class="fw-semibold required">Dung lượng RAM</label>
                    <div class="input-group">
                        <input type="number" name="ram" class="form-control" required min="1" placeholder="Dung lượng" onkeydown="return event.key !== 'e' && event.key !== 'E' && event.key !== '+' && event.key !== '-'" >
                        <select name="ram_unit" class="form-control" required style="max-width: 100px;">
                            <option value="MB">MB</option>
                            <option value="GB" selected>GB</option>
                            <option value="TB">TB</option>
                        </select>
                    </div>
                </div>

                <!-- Services -->
                <div class="form-group col-12">
                    <label class="fw-semibold required">Dịch vụ cài đặt</label>
                    <textarea name="services" class="form-control" required maxlength="1000" rows="3"
                        placeholder="VD: MySQL, Apache, Docker..."></textarea>
                </div>

                <!-- Submit -->
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4 mt-3">
                        <i class="mdi mdi-plus-circle-outline me-1"></i> Tạo Phần Cứng
                    </button>
                </div>

            </form>
        </div>
    </div>
</div> 
<div class="modal fade " style="background-color: rgba(0, 0, 0, 0.6);" id="hardware-data-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-4">
            <h5 class="mb-3" id="modal-title">Tạo Dữ Liệu</h5>
            <form id="create-os-form">
                <div class="form-group mb-3">
                    <label for="os-name" id="label-name">Tên</label>
                    <input type="text" class="form-control" id="os-name" name="name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="os-version" id="label-version">Phiên Bản</label>
                    <input type="text" class="form-control" id="os-version" name="version" required>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Tạo</button>
                </div>
            </form>
        </div>
    </div>
</div>
