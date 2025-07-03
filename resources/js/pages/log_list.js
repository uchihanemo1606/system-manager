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

    function applyFilters() {
        const filters = {
            username: usernameInput.value.trim().toLowerCase(),
            hardware_ip: hardwareIpInput.value.trim().toLowerCase(),
            software_id: softwareIdInput.value.trim(),
            permission_name: permissionNameInput.value.trim().toLowerCase(),
            message: messageInput.value.trim().toLowerCase(),
            link_domain: domainInput.value.trim().toLowerCase(),
            department: departmentInput.value.trim().toLowerCase(),
            sw_permission_user: swPermissionInput.value.trim().toLowerCase(),
            hw_permission_user: hwPermissionInput.value.trim().toLowerCase(),
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
            if (filters.username && !(log.username || "").toLowerCase().includes(filters.username)) return false;
            if (filters.hardware_ip && !(log.hardware_ip || "").toLowerCase().includes(filters.hardware_ip)) return false;
            if (filters.software_id && String(log.software_id || "") !== filters.software_id) return false;
            if (filters.permission_name && !(log.permission_name || "").toLowerCase().includes(filters.permission_name)) return false;
            if (filters.message && !(log.message || "").toLowerCase().includes(filters.message)) return false;
            if (filters.link_domain && !(log.link_domain || "").toLowerCase().includes(filters.link_domain)) return false;
            if (filters.department && !(log.department || "").toLowerCase().includes(filters.department)) return false;
            if (filters.sw_permission_user && !(log.sw_permission_user || "").toLowerCase().includes(filters.sw_permission_user)) return false;
            if (filters.hw_permission_user && !(log.hw_permission_user || "").toLowerCase().includes(filters.hw_permission_user)) return false;

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
        allLogs = logs;
        currentPage = 1;
        renderPage();
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
            let resource = "-";
            if (log.link_domain) {
                resource = `Domain: <strong>${log.link_domain}</strong>`;
            } else if (log.software_id) {
                resource = `Phần mềm ID: <strong>${log.software_id}</strong>`;
                if (log.sw_permission_user) {
                    resource += `<br><small>Quyền phần mềm: ${log.sw_permission_user}</small>`;
                }
            } else if (log.hardware_ip) {
                resource = `Phần cứng IP: <strong>${log.hardware_ip}</strong>`;
                if (log.hw_permission_user) {
                    resource += `<br><small>Quyền phần cứng: ${log.hw_permission_user}</small>`;
                }
            }

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${log.id}</td>
                <td>${log.username || ""}</td>
                <td>${log.hardware_ip || ""}</td>
                <td>${log.software_id || ""}</td>
                <td>${log.permission_name || ""}</td>
                <td>${log.message || ""}</td>
                <td>${formatDatetime(log.created_at)}</td>
                <td>
                    <button class="btn btn-sm btn-info btn-detail" >Chi tiết</button>
                </td>
            `;
            // data-log='${JSON.stringify(log)}'
            tbody.appendChild(tr);
        });

        document.querySelectorAll(".btn-detail").forEach(btn => {
            btn.addEventListener("click", () => showDetail(JSON.parse(btn.dataset.log)));
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

    function showDetail(log) {
        document.getElementById("detail-id").textContent = log.id || "";
        document.getElementById("detail-username").textContent = log.username || "";
        document.getElementById("detail-hardware").textContent = log.hardware_ip || "";
        document.getElementById("detail-software").textContent = log.software_id || "";
        document.getElementById("detail-permission").textContent = log.permission_name || "";
        document.getElementById("detail-message").textContent = log.message || "";
        document.getElementById("detail-domain").textContent = log.link_domain || "";
        document.getElementById("detail-created").textContent = formatDatetime(log.created_at);
        document.getElementById("detail-updated").textContent = formatDatetime(log.updated_at);

        const modal = new bootstrap.Modal(document.getElementById("logDetailModal"));
        modal.show();
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
