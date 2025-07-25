<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3 text-primary">Lịch sử thay đổi {{ $type === 'hardware' ? 'phần cứng' : 'phần mềm' }}</h4>

        <div class="border rounded mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0 fs-6 text-primary">Bộ lọc tìm kiếm</h5>
                <button class="btn btn-sm btn-outline-primary" id="toggle-filter">
                    <i class="bx bx-chevron-up" id="toggle-icon"></i> Mở rộng
                </button>
            </div>

            <div id="filter-content" class="mt-2" style="display: none;">
                @include('components.log_filter_form')
            </div>
        </div>

        <div class="d-flex justify-content-end mb-2">
            <label class="me-2">Số lượng mỗi trang:</label>
            <select id="items-per-page" class="form-select form-select-sm" style="width: auto;">
                <option value="4" selected>4</option>
                <option value="8">8</option>
                <option value="16">16</option>
            </select>
        </div>

        <ul class="verti-timeline list-unstyled" id="log-timeline">
            <!-- Timeline sẽ được render bằng JS -->
        </ul>
        
        <div id="pagination" class="mt-3"></div>
    </div>
</div>



<!-- <div class="card" >
    <div class="card-body">
        <h4 class="card-title mb-5">Lịch sử thay đổi</h4>
        <div class="">
            <ul class="verti-timeline list-unstyled">
                <li class="event-list active">
                    <div class="event-timeline-dot">
                        <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                    </div>
                    <div class="media">
                        <div class="mr-3">
                            <i class="bx bx-server h4 text-primary"></i>
                        </div>
                        <div class="media-body">
                            <div>
                                <h5 class="font-size-15">
                                    <a href="#" class="text-dark">Dung lượng ở cứng vừa được thay
                                        đổi</a>
                                </h5>
                                <span class="text-primary">3/6/2025</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="event-list">
                    <div class="event-timeline-dot">
                        <i class="bx bx-right-arrow-circle"></i>
                    </div>
                    <div class="media">
                        <div class="mr-3">
                            <i class="bx bx-code h4 text-primary"></i>
                        </div>
                        <div class="media-body">
                            <div>
                                <h5 class="font-size-15">
                                    <a href="#" class="text-dark">Mini đã thay đổi thông tin dịch
                                        vụ</a>
                                </h5>
                                <span class="text-primary">16/5/2013</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="event-list">
                    <div class="event-timeline-dot">
                        <i class="bx bx-right-arrow-circle"></i>
                    </div>
                    <div class="media">
                        <div class="mr-3">
                            <i class="bx bx-edit h4 text-primary"></i>
                        </div>
                        <div class="media-body">
                            <div>
                                <h5 class="font-size-15">
                                    <a href="#" class="text-dark">Admin đã sửa ip phần cứng</a>
                                </h5>
                                <span class="text-primary">10/5/2013</span>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div> -->