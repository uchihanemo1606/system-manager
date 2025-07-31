<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">Quy chế</h4>

            <!-- Nút mở modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRuleModal">
                <i class="mdi mdi-plus"></i> Tạo Quy Chế
            </button>
        </div>

        <!-- Bộ lọc -->
        <div class="row mb-3 g-3">
            <div class="col-12 col-md-3">
                <label for="filter-name">Tên quy chế</label>
                <input type="text" id="filter-name" class="form-control" placeholder="Tên quy chế">
            </div>

            <!-- Ẩn trên mobile (ẩn nâng cao) -->
            <div class="col-12 col-md-3 filter-advanced d-none d-md-block">
                <label for="filter-category">Loại quy chế</label>
                <select id="filter-category" class="form-control">
                    <option value="">-- Loại quy chế --</option>
                </select>
            </div>

            <div class="col-12 col-md-6 filter-advanced d-none d-md-block">
                <label class="fw-semibold">Ngày tạo (Từ - Đến)</label>
                <div class="d-flex flex-column flex-md-row gap-2">
                    <input type="date" id="filter-createdat-from" class="form-control">
                    <input type="date" id="filter-createdat-to" class="form-control">
                </div>
            </div>

            <!-- Nút mở rộng / thu gọn: chỉ hiện trên màn nhỏ -->
            <div class="col-12 d-md-none">
                <button class="btn btn-sm btn-outline-primary w-100" type="button" onclick="toggleFilterAdvanced()">Hiện
                    thêm bộ lọc</button>
            </div>
        </div>

        <div id="software-rule-list" class="table-responsive">

            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Tên quy chế</th>
                        <th>Loại</th>
                        <th class="text-right">Tệp</th>
                    </tr>
                </thead>

                <tbody id="software-rule-table-body">
                    <tr>
                        <td colspan="5" class="text-center">Đang tải...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="createRuleModal" tabindex="-1" role="dialog" aria-labelledby="createRuleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id="create-rule-form" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createRuleModalLabel">Tạo Quy Chế</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="rule-name">Tên quy chế</label>
                                <input type="text" class="form-control" id="rule-name" required>
                            </div>
                            <div class="form-group">
                                <label for="rule-description">Mô tả</label>
                                <textarea class="form-control" id="rule-description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="rule-category">Loại quy chế</label>
                                <select class="form-control" id="rule-category" required>
                                    <option value="">-- Chọn loại --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="rule-file">Tệp đính kèm</label>
                                <input type="file" class="form-control" id="rule-file" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editRuleModal" tabindex="-1" role="dialog" aria-labelledby="editRuleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="edit-rule-form">
            <input type="hidden" id="edit-rule-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập Nhật Quy Chế</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-rule-name">Tên quy chế</label>
                        <input type="text" class="form-control" id="edit-rule-name" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-rule-category">Loại quy chế</label>
                        <select class="form-control" id="edit-rule-category" required>
                            <option value="">-- Chọn loại --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-rule-file">Tệp quy chế mới(nếu không đổi có thể bỏ qua)</label>
                        <input type="file" class="form-control" id="edit-rule-file" accept=".pdf,.doc,.docx">
                    </div>
                    <div class="form-group">
                        <label for="edit-rule-description">Mô tả</label>
                        <textarea class="form-control" id="edit-rule-description"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function toggleFilterAdvanced() {
        const advanced = document.querySelectorAll(".filter-advanced");
        advanced.forEach(el => el.classList.toggle("d-none"));

        const btn = event.target;
        btn.textContent = btn.textContent.includes("Hiện thêm") ? "Ẩn bớt bộ lọc" : "Hiện thêm bộ lọc";
    }
</script>