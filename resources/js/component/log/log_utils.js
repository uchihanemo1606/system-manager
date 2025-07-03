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
    if (!dateInput) return true;

    const date = new Date(dateStr);
    const inputDate = new Date(dateInput);

    if (date.getFullYear() !== inputDate.getFullYear() || date.getMonth() !== inputDate.getMonth() || date.getDate() !== inputDate.getDate()) return false;

    if (timeInput) {
        const [hStr, mStr] = timeInput.split(":");
        if (hStr && date.getHours() !== parseInt(hStr, 10)) return false;
        if (mStr && date.getMinutes() !== parseInt(mStr, 10)) return false;
    }

    return true;
}

export function filterLog(log) {
    const createdDate = document.getElementById("filter-created-date")?.value;
    const createdTime = document.getElementById("filter-created-time")?.value;
    const updatedDate = document.getElementById("filter-updated-date")?.value;
    const updatedTime = document.getElementById("filter-updated-time")?.value;
    const username = document.getElementById("filter-username")?.value.trim().toLowerCase();
    const message = document.getElementById("filter-message")?.value.trim().toLowerCase();
    const isDelete = document.getElementById("filter-is-delete")?.value;

    if (!matchDateTime(log.created_at, createdDate, createdTime)) return false;
    if (!matchDateTime(log.updated_at, updatedDate, updatedTime)) return false;
    if (username && !log.username?.toLowerCase().includes(username)) return false;
    if (message && !log.message?.toLowerCase().includes(message)) return false;
    if (isDelete && log.is_delete !== (isDelete === "true")) return false;

    return true;
}

export function resetFilters() {
    ["filter-created-date", "filter-created-time", "filter-updated-date", "filter-updated-time", "filter-username", "filter-message", "filter-is-delete"].forEach(id => {
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

export function renderPagination(totalItems, ITEMS_PER_PAGE, currentPage, renderPageCallback) {
    const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    if (totalPages <= 1) return;

    let html = `<nav><ul class="pagination pagination-sm justify-content-center">`;

    html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage - 1}">Trang trước</a>
             </li>`;

    for (let i = 1; i <= totalPages; i++) {
        html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                 </li>`;
    }

    html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage + 1}">Trang sau</a>
             </li></ul></nav>`;

    pagination.innerHTML = html;

    pagination.querySelectorAll(".page-link").forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const page = parseInt(link.dataset.page);
            if (page >= 1 && page <= totalPages) renderPageCallback(page);
        });
    });
}
