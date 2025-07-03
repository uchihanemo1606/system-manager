<div class="row g-3 align-items-end">
    <div class="col-md-6">
        <label class="form-label mb-1">Ngày tạo</label>
        <input type="date" id="filter-created-date" class="form-control form-control-sm">
        <input type="time" id="filter-created-time" class="form-control form-control-sm mt-1">
    </div>
    <div class="col-md-6">
        <label class="form-label mb-1">Ngày cập nhật</label>
        <input type="date" id="filter-updated-date" class="form-control form-control-sm">
        <input type="time" id="filter-updated-time" class="form-control form-control-sm mt-1">
    </div>
</div>

<div class="row g-3 align-items-end mt-2">
    <div class="col-md-6">
        <label class="form-label mb-1">Tên đăng nhập</label>
        <input type="text" id="filter-username" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label mb-1">Trạng thái</label>
        <select id="filter-is-delete" class="form-select form-select-sm">
            <option value="">-- Chọn --</option>
            <option value="true">Đã xóa</option>
            <option value="false">Chưa xóa</option>
        </select>
    </div>
</div>

<div class="row g-3 align-items-end mt-2">
    <div class="col-md-9">
        <label class="form-label mb-1">Nội dung</label>
        <input type="text" id="filter-message" class="form-control form-control-sm">
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        <button class="btn btn-sm btn-primary me-2" id="btn-filter">
            <i class="bx bx-search"></i> Tìm
        </button>
        <button class="btn btn-sm btn-secondary" id="btn-reset">
            <i class="bx bx-reset"></i> Reset
        </button>
    </div>
</div>
