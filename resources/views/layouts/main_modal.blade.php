<style>
    .modal-content {
        max-height: 90vh; /* Giới hạn chiều cao tối đa modal là 90% chiều cao màn hình */
        overflow: hidden; /* Không cho toàn bộ modal tràn */
    }

    #modalContent {
        max-height: 99%; /* Trừ đi header/nút đóng nếu có */
        overflow-y: auto; /* Cuộn theo chiều dọc khi vượt quá */ 
        overflow-x:hidden;
    }
</style>

<div id="modalContainer" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="position: relative;">
            <!-- Nút X ở góc phải -->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                style="position: absolute; top: 0.5rem; right: 1rem; font-size: 2rem; z-index: 10;">
                <span aria-hidden="true">&times;</span>
            </button>

            <div id="modalContent">
                <!-- Nội dung modal sẽ được chèn vào đây -->
            </div>
        </div>
    </div>
</div>
