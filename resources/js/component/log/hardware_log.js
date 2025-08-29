import { get_log_by_hardware } from "../../api/log";
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
        allLogs = await get_log_by_hardware(id);
        allLogs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        renderTimeline(allLogs, 1);
    } catch (err) {
        console.error("Lỗi khi gọi API:", err);
    }
}

window.fetchHardwareLogs = fetchLogs;
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
        <li class="event-list" onclick="loadModal('log_detail', { id: '${log.id}' })" >
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


// import { get_log_by_hardware } from "../../api/log";

// let ITEMS_PER_PAGE = 4;

// let allLogs = [];
// let currentLogs = [];
// let currentPage = 1;

// fetchLogs();

// async function fetchLogs() {
//     const id = new URLSearchParams(window.location.search).get("id");
//     if (!id) return console.error("Không tìm thấy ID trên URL");

//     try {
//         allLogs = await get_log_by_hardware(id);
//         renderTimeline(allLogs);
//     } catch (err) {
//         console.error("Lỗi khi gọi API:", err);
//     }
// }
// document.getElementById("items-per-page").addEventListener("change", e => {
//     ITEMS_PER_PAGE = parseInt(e.target.value);
//     renderTimeline(currentLogs, 1);
// });

// document.getElementById("btn-filter").addEventListener("click", () => {
//     const filtered = allLogs.filter(log => filterLog(log));
//     renderTimeline(filtered, 1);
// });

// document.getElementById("btn-reset").addEventListener("click", () => {
//     resetFilters();
//     renderTimeline(allLogs, 1);
// });

// document.getElementById("toggle-filter").addEventListener("click", toggleFilter);

// function renderTimeline(logs = [], page = 1) {
//     currentLogs = logs;
//     currentPage = page;

//     const timeline = document.getElementById("log-timeline");
//     timeline.innerHTML = logs.length ? logs.slice((page - 1) * ITEMS_PER_PAGE, page * ITEMS_PER_PAGE).map((log, index) => renderLog(log, index)).join('') : `<li class="event-list"><div>Không có lịch sử thay đổi</div></li>`;

//     renderPagination(logs.length);
// }

// function renderLog(log, index) {
//     const iconClass = getIconClass(log.message);
//     const createdStr = formatDateTimeVN(log.created_at);
//     const updatedStr = formatDateTimeVN(log.updated_at);
//     const isActive = index === 0 ? " active" : "";

//     return `
//         <li class="event-list${isActive}">
//             <div class="event-timeline-dot">
//                 <i class="bx bx-right-arrow-circle${isActive ? " bx-fade-right" : ""}"></i>
//             </div>
//             <div class="media">
//                 <div class="mr-3">
//                     <i class="bx ${iconClass} h4 text-primary"></i>
//                 </div>
//                 <div class="media-body">
//                     <h5 class="font-size-15">
//                         <a href="#" class="text-dark">${log.message || "Không rõ nội dung"}</a>
//                     </h5>
//                     <div class="small text-muted">Ngày tạo: <b>${createdStr}</b></div>
//                     <div class="small text-muted">Ngày cập nhật: <b>${updatedStr}</b></div>
//                 </div>
//             </div>
//         </li>`;
// }

// function renderPagination(totalItems) {
//     const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
//     const pagination = document.getElementById("pagination");
//     pagination.innerHTML = "";

//     if (totalPages <= 1) return;

//     let html = `<nav><ul class="pagination pagination-sm justify-content-center">`;

//     html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
//                 <a class="page-link" href="#" data-page="${currentPage - 1}">Trang trước</a>
//              </li>`;

//     for (let i = 1; i <= totalPages; i++) {
//         html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
//                     <a class="page-link" href="#" data-page="${i}">${i}</a>
//                  </li>`;
//     }

//     html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
//                 <a class="page-link" href="#" data-page="${currentPage + 1}">Trang sau</a>
//              </li></ul></nav>`;

//     pagination.innerHTML = html;

//     pagination.querySelectorAll(".page-link").forEach(link => {
//         link.addEventListener("click", e => {
//             e.preventDefault();
//             const page = parseInt(link.dataset.page);
//             if (page >= 1 && page <= totalPages) renderTimeline(currentLogs, page);
//         });
//     });
// }

// function getIconClass(message = "") {
//     const msg = message?.toLowerCase() || "";
//     if (msg.includes("added domain")) return "bx-code";
//     if (msg.includes("changed")) return "bx-server";
//     return "bx-edit";
// }

// function formatDateTimeVN(dateStr) {
//     if (!dateStr) return "Không rõ thời gian";
//     const date = new Date(dateStr);
//     const datePart = date.toLocaleDateString("vi-VN");
//     const timePart = date.toLocaleTimeString("vi-VN", { hour: "2-digit", minute: "2-digit" });
//     return `${datePart} ${timePart}`;
// }

// function matchDateTime(dateStr, dateInput, timeInput) {
//     if (!dateInput) return true;

//     const date = new Date(dateStr);
//     const inputDate = new Date(dateInput);

//     if (date.getFullYear() !== inputDate.getFullYear() || date.getMonth() !== inputDate.getMonth() || date.getDate() !== inputDate.getDate()) return false;

//     if (timeInput) {
//         const [hStr, mStr] = timeInput.split(":");
        
//         // So sánh giờ nếu nhập
//         if (hStr) {
//             const h = parseInt(hStr, 10);
//             if (date.getHours() !== h) return false;
//         }

//         // So sánh phút nếu nhập
//         if (mStr) {
//             const m = parseInt(mStr, 10);
//             if (date.getMinutes() !== m) return false;
//         }
//     }

//     return true;
// }


// function filterLog(log) {
//     const createdDate = document.getElementById("filter-created-date").value;
//     const createdTime = document.getElementById("filter-created-time").value;
//     const updatedDate = document.getElementById("filter-updated-date").value;
//     const updatedTime = document.getElementById("filter-updated-time").value;
//     const username = document.getElementById("filter-username").value.trim().toLowerCase();
//     const message = document.getElementById("filter-message").value.trim().toLowerCase();
//     const isDelete = document.getElementById("filter-is-delete").value;

//     if (!matchDateTime(log.created_at, createdDate, createdTime)) return false;
//     if (!matchDateTime(log.updated_at, updatedDate, updatedTime)) return false;
//     if (username && !log.username?.toLowerCase().includes(username)) return false;
//     if (message && !log.message?.toLowerCase().includes(message)) return false;
//     if (isDelete && log.is_delete !== (isDelete === "true")) return false;

//     return true;
// }

// function resetFilters() {
//     ["filter-created-date", "filter-created-time", "filter-updated-date", "filter-updated-time", "filter-username", "filter-message", "filter-is-delete"].forEach(id => {
//         document.getElementById(id).value = "";
//     });
// }

// function toggleFilter() {
//     const content = document.getElementById("filter-content");
//     const icon = document.getElementById("toggle-icon");
//     const btn = document.getElementById("toggle-filter");

//     const isHidden = content.style.display === "none" || !content.style.display;
//     content.style.display = isHidden ? "block" : "none";
//     icon.className = `bx ${isHidden ? "bx-chevron-down" : "bx-chevron-up"}`;
//     btn.innerHTML = `<i class="bx ${isHidden ? "bx-chevron-down" : "bx-chevron-up"}"></i> ${isHidden ? "Thu gọn" : "Mở rộng"}`;
// }
