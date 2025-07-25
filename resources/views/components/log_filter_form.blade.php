<!-- Dòng 1: Từ ngày, Đến ngày, Từ giờ, Đến giờ -->
<div class="row g-3 align-items-end">
    <div class="col-md-12 col-lg-6">
        <label class="form-label mb-1">Từ ngày</label>
        <input type="date" id="filter-start-date" class="form-control form-control-sm">
    </div>
    <div class="col-md-12 col-lg-6">
        <label class="form-label mb-1">Đến ngày</label>
        <input type="date" id="filter-end-date" class="form-control form-control-sm">
    </div> 
</div>
<div class="row g-3 align-items-end"> 
    <div class="col-md-12 col-lg-6">
        <label class="form-label mb-1">Từ giờ</label>
        <input type="time" id="filter-start-time" class="form-control form-control-sm">
    </div>
    <div class="col-md-12 col-lg-6">
        <label class="form-label mb-1">Đến giờ</label>
        <input type="time" id="filter-end-time" class="form-control form-control-sm">
    </div>
</div>

<!-- Dòng 2: Tên đăng nhập, Nội dung -->
<div class="row g-3 align-items-end mt-2">
    <div class="col-md-6 col-lg-4">
        <label class="form-label mb-1">Tên đăng nhập</label>
        <input type="text" id="filter-username" class="form-control form-control-sm">
    </div>
    <div class="col-md-6 col-lg-5">
        <label class="form-label mb-1">Nội dung</label>
        <input type="text" id="filter-message" class="form-control form-control-sm">
    </div>
    <div class="col-md-6 col-lg-3">
        <label class="form-label mb-1">Trạng thái</label>
        <select id="filter-is-delete" class="form-select form-select-sm"> 
            <option value="false">Chưa xóa</option>
            <option value="true">Đã xóa</option>
        </select>
    </div>
</div>

<!-- Dòng 3: Nút tìm kiếm + reset -->
<div class="row mt-3">
    <div class="col-12 d-flex justify-content-end">
        <button class="btn btn-sm btn-primary me-2 mr-2" id="btn-filter">
            <i class="bx bx-search"></i> Tìm
        </button>
        <button class="btn btn-sm btn-secondary" id="btn-reset">
            <i class="bx bx-reset"></i> Reset
        </button>
    </div>
</div>
