import { get_log_by_software } from "../../api/log";
import { getIconClass, formatDateTimeVN, filterLog, resetFilters, toggleFilter, renderPagination } from "./log_utils";

let ITEMS_PER_PAGE = 4;
let allLogs = [];
let currentLogs = [];
let currentPage = 1;

fetchLogs();

async function fetchLogs() {
    const id = new URLSearchParams(window.location.search).get("id");
    if (!id) return console.error("Không tìm thấy ID trên URL");

    try {
        allLogs = await get_log_by_software(id);
        allLogs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at)); // Sắp xếp giảm dần theo ngày tạo
        renderTimeline(allLogs, 1);
    } catch (err) {
        console.error("Lỗi khi gọi API:", err);
    }
}


window.fetchSoftwareLogs = fetchLogs;

document.getElementById("items-per-page").addEventListener("change", e => {
    ITEMS_PER_PAGE = parseInt(e.target.value);
    renderTimeline(currentLogs, 1);
});

document.getElementById("btn-filter").addEventListener("click", () => {
    const filtered = allLogs.filter(log => filterLog(log));
    renderTimeline(filtered, 1);
});

document.getElementById("btn-reset").addEventListener("click", () => {
    resetFilters();
    renderTimeline(allLogs, 1);
});

document.getElementById("toggle-filter").addEventListener("click", toggleFilter);

function renderTimeline(logs = [], page = 1) {
    currentLogs = logs;
    currentPage = page;

    const timeline = document.getElementById("log-timeline");
    timeline.innerHTML = logs.length
        ? logs.slice((page - 1) * ITEMS_PER_PAGE, page * ITEMS_PER_PAGE).map(renderLog).join('')
        : `<li class="event-list"><div>Không có lịch sử thay đổi</div></li>`;

    renderPagination(logs.length, ITEMS_PER_PAGE, currentPage, (newPage) => renderTimeline(currentLogs, newPage));
}

function renderLog(log) {
    const iconClass = getIconClass(log.message);
    const createdStr = formatDateTimeVN(log.created_at);
    const updatedStr = formatDateTimeVN(log.updated_at);

    return `
        <li class="event-list">
            <div class="event-timeline-dot">
                <i class="bx bx-right-arrow-circle"></i>
            </div>
            <div class="media">
                <div class="mr-3">
                    <i class="bx ${iconClass} h4 text-primary"></i>
                </div>
                <div class="media-body">
                    <h5 class="font-size-15">
                        <a href="#" class="text-dark">${log.message || "Không rõ nội dung"}</a>
                    </h5>
                    <div class="small text-muted">Ngày tạo: <b>${createdStr}</b></div>
                    <div class="small text-muted">Ngày cập nhật: <b>${updatedStr}</b></div>
                </div>
            </div>
        </li>`;
}
