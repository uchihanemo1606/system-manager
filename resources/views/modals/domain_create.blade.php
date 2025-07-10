 <div class="card-body">
     <form id="domain-form">
         <div class="modal-header">
             <h5 class="modal-title"><i class="mdi mdi-earth-plus"></i> Thêm tên miền</h5>
         </div>
         <div class="modal-body">

             <div class="mb-3">
                 <label for="domain-name" class="form-label required">Tên miền</label>
                 <input type="text" class="form-control" id="domain-name" name="name" required>
             </div>

             <div class="mb-3">
                 <label for="domain-link" class="form-label required">Liên kết</label>
                 <input type="text" class="form-control" id="domain-link" name="link" required>
             </div>

             <input type="hidden" name="software_id" id="domain-software-id">

         </div>
         <div class="modal-footer">
             <button type="submit" class="btn btn-primary">Thêm</button>
         </div>
     </form>
 </div>
