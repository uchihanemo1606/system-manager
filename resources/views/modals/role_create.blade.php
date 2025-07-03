<div class="card  shadow-sm m-0">
    <div class="card-body d-flex flex-column" style="max-height: 92vh; overflow: hidden;">
        <h4 class="card-title text-primary ">
            <i class="mdi mdi-account-key mr-2 text-info"></i> Tạo Vai Trò
        </h4>
        <form id="permission-form" class="d-flex flex-column" style="flex-grow: 1; overflow: hidden;">
            <!-- Tên Role -->
            <div class="form-group mb-2">
                <label for="role-name" class="font-weight-bold text-dark">
                    <i class="mdi mdi-shield-account text-info mr-2"></i> Tên Vai trò
                </label>
                <input type="text" id="role-name" class="form-control font-weight-bold"
                    placeholder="Nhập tên vai trò" required>
            </div>

            <!-- Permission + Filter + Checkbox -->
            <div class="d-flex flex-column" style="flex-grow: 1; overflow: hidden;">


                <!-- Bộ lọc -->
                <div class="">
                    <div class="d-flex justify-content-between align-items-center ">
                        <h5 class="text-primary border-bottom pb-2 mb-0">Danh sách Permission</h5>
                        <button class="btn btn-link px-0" type="button" data-toggle="collapse"
                            data-target="#permissionFilters">
                            <i class="mdi mdi-filter-variant mr-1"></i> Bộ lọc
                        </button>
                    </div>

                    <div class="collapse show" id="permissionFilters">
                        <div class="form-row">
                            <div class="form-group col">
                                <input type="text" class="form-control" id="filter-name" placeholder="Tìm theo tên">
                            </div>
                            <div class="form-group col">
                                <select class="form-control" id="filter-type" name="type"></select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <input type="date" class="form-control" id="filter-created-date">
                            </div>
                            <div class="form-group col">
                                <select class="form-control" id="filter-selected">
                                    <option value="">Tất cả</option>
                                    <option value="selected">Đã chọn</option>
                                    <option value="unselected">Chưa chọn</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danh sách quyền -->
                <div class="overflow-auto border rounded" id="permission-checkboxes"
                    style="flex-grow: 1; min-height: 0;">
                    <!-- Checkbox render ở đây -->
                </div>
            </div>

            <!-- Nút tạo -->
            <div class="modal-footer p-0" style="flex-shrink: 0;">
                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                    <i class="mdi mdi-check-circle-outline mr-1"></i> Tạo vai trò
                </button>
            </div>
        </form>
    </div>
</div>
