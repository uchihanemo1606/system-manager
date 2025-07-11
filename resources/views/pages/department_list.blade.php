<div class="container mt-4">

    <!-- Giao diện danh sách phòng ban -->
    <div id="department-list-view">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="mdi mdi-office-building"></i> Danh sách phòng ban</h4>
        </div>
        <div id="department-list" class="list-group mb-4"></div>
    </div>

    <!-- Giao diện danh sách phần mềm/phần cứng phòng ban quản lý -->
    <div id="department-detail-view" class="d-none">
        <button class="btn btn-secondary mb-3" id="btn-back-to-department">
            <i class="mdi mdi-arrow-left"></i> Quay lại danh sách phòng ban
        </button>
        
        <h5>Phòng ban: <span id="selected-department-name"></span></h5>

        <div class="row mt-3">
            <div class="col-md-6">
                <h6><i class="mdi mdi-chip"></i> Danh sách phần cứng quản lý</h6>
                <ul class="list-group" id="hardware-list">
                    <li class="list-group-item text-muted">Không có dữ liệu</li>
                </ul>
            </div>

            <div class="col-md-6">
                <h6><i class="mdi mdi-application"></i> Danh sách phần mềm quản lý</h6>
                <ul class="list-group" id="software-list">
                    <li class="list-group-item text-muted">Không có dữ liệu</li>
                </ul>
            </div>
        </div>
    </div>

</div>
