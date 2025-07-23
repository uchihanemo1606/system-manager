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
    const departmentInput = document.getElementById("filter-department");
    const swPermissionInput = document.getElementById("filter-sw-permission");
    const hwPermissionInput = document.getElementById("filter-hw-permission");
    const fromDateInput = document.getElementById("filter-from-date");
    const toDateInput = document.getElementById("filter-to-date");

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
            department: departmentInput.value.trim(),
            sw_permission_user: swPermissionInput.value.trim(),
            hw_permission_user: hwPermissionInput.value.trim(),
            from_date: fromDateInput.value,
            to_date: toDateInput.value
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
            if (!test(log.department, "department")) return false;
            if (!test(log.sw_permission_user, "sw_permission_user")) return false;
            if (!test(log.hw_permission_user, "hw_permission_user")) return false;
            if (filters.software_id && String(log.software_id || "") !== filters.software_id) return false;

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
        departmentInput.value = "";
        swPermissionInput.value = "";
        hwPermissionInput.value = "";
        fromDateInput.value = "";
        toDateInput.value = "";
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
        return str.replace(/&/g, "&amp;")
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
            const safeLogJson = escapeHtml(JSON.stringify(log));
            tr.innerHTML = `
                <td>${log.username || ""}</td>
                <td>${log.message || ""}</td>
                <td>${formatDatetime(log.created_at)}</td>
                <td>
                    <button class="btn btn-sm btn-info btn-detail"
                    onclick="loadModal('log_detail', { id: '${log.id}' })"
                    >Xem</button>
                </td>
            `; 
            tbody.appendChild(tr);
        }); 
        renderPagination(totalPages);
        paginationInfo.textContent = `Trang ${currentPage} / ${totalPages}, Tổng ${allLogs.length} bản ghi`;
    }
 

    function renderPagination(totalPages) {
        pagination.innerHTML = "";

        if (totalPages <= 1) return;

        const createPageItem = (page, text = page, active = false) => {
            const li = document.createElement("li");
            li.className = `page-item ${active ? "active" : ""}`;
            li.innerHTML = `<button class="page-link">${text}</button>`;
            li.addEventListener("click", () => {
                currentPage = page;
                renderPage();
            });
            return li;
        };

        if (currentPage > 1) {
            pagination.appendChild(createPageItem(currentPage - 1, "«"));
        }

        for (let i = 1; i <= totalPages; i++) {
            pagination.appendChild(createPageItem(i, i, i === currentPage));
        }

        if (currentPage < totalPages) {
            pagination.appendChild(createPageItem(currentPage + 1, "»"));
        }
    }

    function formatDatetime(datetimeStr) {
        if (!datetimeStr) return "";
        const date = new Date(datetimeStr);
        return date.toLocaleString();
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
