import { get_all_user_permission_hardware } from "../../api/hardware.js";
import { renderPagination } from "../log/log_utils.js";

const ITEMS_PER_PAGE =6;
let allHardwarePermissions = [];
let currentPage = 1;

async function getHardwarePermissions() {
    const ip = new URLSearchParams(window.location.search).get("id");
    if (!ip) {
        console.error("Thiếu tham số IP trên URL");
        return;
    }

    try {
        const res = await get_all_user_permission_hardware(ip);
        allHardwarePermissions = Array.isArray(res.data) ? res.data : [];
        renderHardwarePage(currentPage);
    } catch (err) {
        console.error("Lỗi khi gọi API:", err);
    }
}

function renderHardwarePage(page) {
    currentPage = page;
    const start = (page - 1) * ITEMS_PER_PAGE;
    const data = allHardwarePermissions.slice(start, start + ITEMS_PER_PAGE);

    const tbody = document.getElementById("user-list-hardware");
    tbody.innerHTML = "";

    if (!data.length) {
        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Không có dữ liệu</td></tr>`;
        return;
    }

    const ip = new URLSearchParams(window.location.search).get("id");

    data.forEach((item, index) => {
        const tr = document.createElement("tr");
        const user = item.user_info || {};
        const permissions = Array.isArray(item.permissions) ? item.permissions : [];
        const visible = permissions.slice(0, 2);
        const remaining = permissions.slice(2);
        const remainingCount = remaining.length;

        let permissionsHTML = `<div class="d-flex flex-wrap align-items-start">`;
        visible.forEach(p => {
            permissionsHTML += `<span class="badge badge-primary mr-1 mb-1 px-2 py-1" style="font-size: 0.65rem;">${p}</span>`;
        });
        if (remainingCount > 0) {
            permissionsHTML += `<span class="badge badge-light border mr-1 mb-1 px-2 py-1 text-primary" 
                                  data-toggle="tooltip" title="${remaining.join(", ")}" 
                                  style="font-size: 0.85rem; cursor: pointer;">+${remainingCount}</span>`;
        }
        permissionsHTML += `</div>`;

        tr.innerHTML = `
            <td>${start + index + 1}</td>
            <td>
                <div class="font-weight-bold">${user.fullName || "Không rõ"}</div>
                <small class="text-muted">(${user.username || ""})</small>
            </td>
            <td>${permissionsHTML}</td>
            <td>
                <button class="btn btn-primary btn-sm"
                    onclick="loadModal('user_hardware_permission_edit', { username: '${user.username}', ip: '${ip}' })">
                    <i class="mdi mdi-pencil"></i> Sửa
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    renderPagination(
        allHardwarePermissions.length,
        ITEMS_PER_PAGE,
        currentPage,
        renderHardwarePage,
        "pagination-user-list"
    );

    $('[data-toggle="tooltip"]').tooltip();
}

getHardwarePermissions();

window.addEventListener("hardware_permission_created", () => {
    getHardwarePermissions();
});
