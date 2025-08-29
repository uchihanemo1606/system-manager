export function getIconClass(message = "") {
    const msg = message?.toLowerCase() || "";
    if (msg.includes("added domain")) return "bx-code";
    if (msg.includes("changed")) return "bx-server";
    return "bx-edit";
}

export function formatDateTimeVN(dateStr) {
    if (!dateStr) return "Không rõ thời gian";
    const date = new Date(dateStr);
    const datePart = date.toLocaleDateString("vi-VN");
    const timePart = date.toLocaleTimeString("vi-VN", { hour: "2-digit", minute: "2-digit" });
    return `${datePart} ${timePart}`;
}

export function matchDateTime(dateStr, dateInput, timeInput) {
    if (!dateStr) return false;
    const date = new Date(dateStr);

    // So khớp ngày
    if (dateInput) {
        const inputDate = new Date(dateInput);
        if (
            date.getFullYear() !== inputDate.getFullYear() ||
            date.getMonth() !== inputDate.getMonth() ||
            date.getDate() !== inputDate.getDate()
        ) return false;
    }

    // So khớp giờ:phút
    if (timeInput) {
        const [hStr, mStr] = timeInput.split(":");
        const hour = parseInt(hStr, 10);
        const minute = parseInt(mStr, 10);
        if (!isNaN(hour) && date.getHours() !== hour) return false;
        if (!isNaN(minute) && date.getMinutes() !== minute) return false;
    }

    return true;
}
function normalizeText(text) {
    return text
        .normalize("NFD")                  // Tách dấu khỏi chữ (vd: "ẽ" -> "e" + "~")
        .replace(/[\u0300-\u036f]/g, "")   // Loại bỏ các dấu
        .replace(/\s+/g, "")               // Xoá khoảng trắng
        .toLowerCase();                    // Chuyển về chữ thường
}

export function filterLog(log) {
    const startDate = document.getElementById("filter-start-date")?.value;
    const endDate = document.getElementById("filter-end-date")?.value;
    const startTime = document.getElementById("filter-start-time")?.value;
    const endTime = document.getElementById("filter-end-time")?.value;
    const username = document.getElementById("filter-username")?.value.trim().toLowerCase();
    const messageInput = document.getElementById("filter-message")?.value.trim();
    const isDelete = document.getElementById("filter-is-delete")?.value;

    const logDate = new Date(log.created_at);
    if (isNaN(logDate)) return false;

    // So sánh khoảng thời gian từ ngày -> đến ngày
    if (startDate) {
        const start = new Date(startDate);
        if (logDate < start) return false;
    }

    if (endDate) {
        const end = new Date(endDate);
        end.setHours(23, 59, 59, 999); // để bao gồm cả ngày đó
        if (logDate > end) return false;
    }

    // So sánh khoảng giờ:phút
    if (startTime) {
        const [h, m] = startTime.split(":").map(Number);
        if (logDate.getHours() < h || (logDate.getHours() === h && logDate.getMinutes() < m)) return false;
    }

    if (endTime) {
        const [h, m] = endTime.split(":").map(Number);
        if (logDate.getHours() > h || (logDate.getHours() === h && logDate.getMinutes() > m)) return false;
    }

    // So khớp username
    if (username && !log.username?.toLowerCase().includes(username)) return false;

    // So khớp message không dấu
    if (messageInput) {
        const msgNorm = normalizeText(log.message || "");
        const inputNorm = normalizeText(messageInput);
        if (!msgNorm.includes(inputNorm)) return false;
    }

    // So khớp is_delete
    if (isDelete) {
        const boolValue = isDelete === "true";
        if (log.is_delete !== boolValue) return false;
    }

    return true;
}


export function resetFilters() {
    [
        "filter-start-date",
        "filter-end-date",
        "filter-start-time",
        "filter-end-time",
        "filter-username",
        "filter-message",
        "filter-is-delete"
    ].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = "";
    });
}


export function toggleFilter() {
    const content = document.getElementById("filter-content");
    const icon = document.getElementById("toggle-icon");
    const btn = document.getElementById("toggle-filter");

    const isHidden = content.style.display === "none" || !content.style.display;
    content.style.display = isHidden ? "block" : "none";
    icon.className = `bx ${isHidden ? "bx-chevron-down" : "bx-chevron-up"}`;
    btn.innerHTML = `<i class="bx ${isHidden ? "bx-chevron-down" : "bx-chevron-up"}"></i> ${isHidden ? "Thu gọn" : "Mở rộng"}`;
}

// export function renderPagination(totalItems, ITEMS_PER_PAGE, currentPage, renderPageCallback) {
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
//             if (page >= 1 && page <= totalPages) renderPageCallback(page);
//         });
//     });
// }
export function renderPagination(totalItems, ITEMS_PER_PAGE, currentPage, renderPageCallback,id = "pagination") {
    const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
    const pagination = document.getElementById(id);
    pagination.innerHTML = "";

    if (totalPages <= 1) return;

    let html = `<nav><ul class="pagination pagination-sm justify-content-center">`;

    // Trang trước
    html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" data-page="${currentPage - 1}">‹</a>
    </li>`;

    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (endPage - startPage + 1 < maxVisiblePages) {
        if (startPage === 1) {
            endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
        } else if (endPage === totalPages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
    }

    if (startPage > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
        if (startPage > 2) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
            <a class="page-link" href="#" data-page="${i}">${i}</a>
        </li>`;
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        html += `<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`;
    }

    // Trang sau
    html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" data-page="${currentPage + 1}">›</a>
    </li>`;

    html += `</ul></nav>`;
    pagination.innerHTML = html;

    pagination.querySelectorAll(".page-link").forEach(link => {
        const page = parseInt(link.dataset.page);
        if (!isNaN(page)) {
            link.addEventListener("click", e => {
                e.preventDefault();
                if (page >= 1 && page <= totalPages) {
                    renderPageCallback(page);
                }
            });
        }
    });
}
