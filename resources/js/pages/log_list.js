import {
    get_all_logs,
    get_log_by_time
} from "../api/log";
import { showToast } from "../component/toast";

document.addEventListener("DOMContentLoaded", () => {
    const usernameInput = document.getElementById("filter-username");
    const hardwareIpInput = document.getElementById("filter-hardware-ip");
    const softwareIdInput = document.getElementById("filter-software-id");
    const permissionNameInput = document.getElementById("filter-permission-name");
    const messageInput = document.getElementById("filter-message");
    const domainInput = document.getElementById("filter-domain");
    const fromDateInput = document.getElementById("filter-from-date");
    const toDateInput = document.getElementById("filter-to-date");
    const fromTimeInput = document.getElementById("filter-from-time");
    const toTimeInput = document.getElementById("filter-to-time");

    const btnFilter = document.getElementById("btn-filter");
    const btnReset = document.getElementById("btn-reset");

    const tbody = document.getElementById("log-table-body");
    const loading = document.getElementById("log-loading");
    const pagination = document.getElementById("pagination");
    const paginationInfo = document.getElementById("pagination-info");

    let allLogs = [];
    const PAGE_SIZE = 10;
    let currentPage = 1;

    btnFilter.addEventListener("click", applyFilters);
    btnReset.addEventListener("click", () => {
        clearFilters();
        loadAllLogs();
    });

    loadAllLogs();

    function removeAccents(str) {
        return str.normalize("NFD").replace(/\p{Diacritic}/gu, "").toLowerCase();
    }

    function fuzzyIncludes(text, keywords) {
        const normalized = removeAccents(text || "");
        return keywords.every(kw => normalized.includes(kw));
    }

    function applyFilters() {
        const filters = {
            username: usernameInput.value.trim(),
            hardware_ip: hardwareIpInput.value.trim(),
            software_id: softwareIdInput.value.trim(),
            permission_name: permissionNameInput.value.trim(),
            message: messageInput.value.trim(),
            link_domain: domainInput.value.trim(),
            from_date: fromDateInput.value,
            to_date: toDateInput.value,
            from_time: fromTimeInput.value,
            to_time: toTimeInput.value
        };

        showLoading(true);

        const fetchData = (filters.from_date || filters.to_date)
            ? get_log_by_time(formatDate(filters.from_date), formatDate(filters.to_date))
            : get_all_logs();

        fetchData
            .then(data => filterClientSide(data, filters))
            .catch(() => showToast("Lỗi tải dữ liệu", "error"))
            .finally(() => showLoading(false));
    }

    function filterClientSide(data, filters) {
        const from = filters.from_date ? new Date(filters.from_date) : null;
        const to = filters.to_date ? new Date(filters.to_date) : null;

        const filtered = data.filter(log => {
            const test = (val, key) => {
                const keywords = removeAccents(filters[key]).split(/\s+/).filter(Boolean);
                return keywords.length === 0 || fuzzyIncludes(val, keywords);
            };

            if (!test(log.username, "username")) return false;
            if (!test(log.hardware_ip, "hardware_ip")) return false;
            if (!test(log.permission_name, "permission_name")) return false;
            if (!test(log.message, "message")) return false;
            if (!test(log.link_domain, "link_domain")) return false;
            if (filters.software_id && String(log.software_id || "") !== filters.software_id && !fuzzyIncludes(log.software, [filters.software_id])) return false;
            if (filters.from_time || filters.to_time) {
                const logDate = new Date(log.created_at);
                const logMinutes = logDate.getHours() * 60 + logDate.getMinutes();

                if (filters.from_time) {
                    const [h, m] = filters.from_time.split(":").map(Number);
                    const fromMinutes = h * 60 + m;
                    if (logMinutes < fromMinutes) return false;
                }

                if (filters.to_time) {
                    const [h, m] = filters.to_time.split(":").map(Number);
                    const toMinutes = h * 60 + m;
                    if (logMinutes > toMinutes) return false;
                }
            }

            if (from || to) {
                const logDate = new Date(log.created_at);
                if (from && logDate < from) return false;
                if (to && logDate > to) return false;
            }

            return true;
        });

        renderTable(filtered);
    }

    function clearFilters() {
        usernameInput.value = "";
        hardwareIpInput.value = "";
        softwareIdInput.value = "";
        permissionNameInput.value = "";
        messageInput.value = "";
        domainInput.value = "";
        fromDateInput.value = "";
        toDateInput.value = "";
        fromTimeInput.value = "";
        toTimeInput.value = "";
    }

    function loadAllLogs() {
        showLoading(true);
        get_all_logs()
            .then(renderTable)
            .catch(() => showToast("Lỗi tải dữ liệu", "error"))
            .finally(() => showLoading(false));
    }

    function renderTable(logs) {
        logs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        allLogs = logs;
        currentPage = 1;
        renderPage();
    }

    function escapeHtml(str) {
        return (str || "").replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function renderPage() {
        tbody.innerHTML = "";

        const totalPages = Math.ceil(allLogs.length / PAGE_SIZE);
        const start = (currentPage - 1) * PAGE_SIZE;
        const end = start + PAGE_SIZE;
        const pageLogs = allLogs.slice(start, end);

        if (!pageLogs.length) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center">Không có dữ liệu phù hợp</td></tr>`;
            pagination.innerHTML = "";
            paginationInfo.textContent = "";
            return;
        }

        pageLogs.forEach(log => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${escapeHtml(log.username || "")}</td>
                <td>${escapeHtml(log.message || "")}</td>
                <td>${formatDatetime(log.created_at)}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-info btn-detail"
                        onclick="loadModal('log_detail', { id: '${log.id}' })"
                    >Xem</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        renderPagination(totalPages);
        paginationInfo.innerHTML = `Trang ${currentPage} / ${totalPages}<br>Tổng ${allLogs.length} bản ghi`;

    }

    function renderPagination(totalPages) {
        pagination.innerHTML = "";
        if (totalPages <= 1) return;

        const ul = document.createElement("ul");
        ul.className = "pagination pagination-sm justify-content-center";

        const addPage = (page, text = page, isActive = false, isDisabled = false) => {
            const li = document.createElement("li");
            li.className = `page-item ${isActive ? "active" : ""} ${isDisabled ? "disabled" : ""}`;
            li.innerHTML = `<a class="page-link" href="#">${text}</a>`;
            if (!isDisabled) {
                li.addEventListener("click", e => {
                    e.preventDefault();
                    currentPage = page;
                    renderPage();
                });
            }
            ul.appendChild(li);
        };

        addPage(currentPage - 1, "‹", false, currentPage === 1);

        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);

        if (endPage - startPage + 1 < maxVisiblePages) {
            if (startPage === 1) endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
            else if (endPage === totalPages) startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        if (startPage > 1) {
            addPage(1);
            if (startPage > 2) {
                const li = document.createElement("li");
                li.className = "page-item disabled";
                li.innerHTML = `<span class="page-link">...</span>`;
                ul.appendChild(li);
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            addPage(i, i, i === currentPage);
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                const li = document.createElement("li");
                li.className = "page-item disabled";
                li.innerHTML = `<span class="page-link">...</span>`;
                ul.appendChild(li);
            }
            addPage(totalPages);
        }

        addPage(currentPage + 1, "›", false, currentPage === totalPages);

        pagination.appendChild(ul);
    }


    function formatDatetime(datetimeStr) {
        if (!datetimeStr) return "";
        const date = new Date(datetimeStr);
        return date.toLocaleString("vi-VN");
    }

    function formatDate(dateStr) {
        if (!dateStr) return "";
        const [year, month, day] = dateStr.split("-");
        return `${day}/${month}/${year}`;
    }

    function showLoading(show) {
        loading.classList.toggle("d-none", !show);
    }
});
