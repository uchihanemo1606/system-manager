<div class="modal-body">
    <div>
        <h5 class="mb-3">Danh sách tên miền</h5>
        <p>danh sách các tên miền chưa liên kết với phần cứng này</p>
    </div>
    <div class="row">
        <div class="col-md-3 mb-2">
            <input type="text" id="hardware-domain-search-name" class="form-control" placeholder="Tên miền">
        </div>
        <div class="col-md-3 mb-2">
            <input type="text" id="hardware-domain-search-link" class="form-control" placeholder="Liên kết">
        </div>
        <div class="col-md-3 mb-2">
            <input type="text" id="hardware-domain-search-createby" class="form-control" placeholder="Người tạo">
        </div>
        <div class="col-md-3 mb-2">
            <input type="date" id="hardware-domain-search-date" class="form-control">
        </div>
    </div>

    <div id="domain-list-container" class="mt-3" style="max-height: 450px; overflow-y: auto;">
        <p class="text-center text-muted mt-2">Đang tải dữ liệu...</p>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        <button id="hardware-domain-save" class="btn btn-primary" disabled>
            <i class="mdi mdi-check-circle-outline mr-1"></i> Gán tên miền
        </button>
    </div>
</div>