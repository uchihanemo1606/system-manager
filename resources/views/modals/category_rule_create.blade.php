<form id="category-rule-form" class="p-4">
  <div class="form-group">
    <label for="rule-name">Tên loại quy chế <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="rule-name" name="name" required maxlength="100">
  </div>
  <div class="form-group">
    <label for="rule-description">Mô tả</label>
    <textarea class="form-control" id="rule-description" name="description" maxlength="200"></textarea>
  </div>
  <div class="text-right mt-3">
    <button type="submit" class="btn btn-primary">Tạo</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
  </div>
</form>
