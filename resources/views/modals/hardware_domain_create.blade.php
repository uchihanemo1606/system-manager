<div class="p-4">
    <div class="mb-3">
        <strong>Chọn phần cứng cần liên kết với domain:</strong>
    </div>

    <div class="row mb-3">
        <div class="col">
            <input type="text" id="filter-ip" class="form-control" placeholder="Lọc theo IP">
        </div>
        <div class="col">
            <input type="text" id="filter-os" class="form-control" placeholder="Lọc theo Hệ điều hành">
        </div>
        <div class="col">
            <input type="text" id="filter-db" class="form-control" placeholder="Lọc theo Database">
        </div>
        <div class="col">
            <select id="filter-deleted" class="form-select">
                <option value="false" selected>Chưa xóa</option>
                <option value="true">Đã xóa</option>
                <option value="all">Tất cả</option>
            </select>
        </div>
    </div>


    <table class="table table-bordered table-hover" id="hardware-select-table">
        <thead class="table-light">
            <tr>
                <th style="width: 40px;"><input type="checkbox" id="select-all-hw" /></th>
                <th>IP</th>
                <th>Hệ điều h</th>
                <th>Database</th>
                <th style="width: 60px;">Xem</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" class="text-center text-muted">Đang tải danh sách phần cứng...</td>
            </tr>
        </tbody>
    </table>

    <div class="text-end">
        <button class="btn btn-primary" id="link-selected-hardware">Liên kết</button>
    </div>
</div>