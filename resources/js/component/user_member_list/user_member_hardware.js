import { get_all_user_permission_hardware } from "../../api/hardware.js";

async function getHardwarePermissions() {
    const ip = new URLSearchParams(window.location.search).get("id");
    if (!ip) {
        console.error("Thiếu tham số IP trên URL");
        return;
    }

    const res = await get_all_user_permission_hardware(ip);
    const userListTbody = document.getElementById("user-list-hardware");

    if (!userListTbody) {
        console.error("Không tìm thấy phần tử tbody!");
        return;
    }

    userListTbody.innerHTML = "";

    if (res.data && Array.isArray(res.data) && res.data.length) {
        res.data.forEach((item, index) => {
            const tr = document.createElement("tr");

            const permissions = item.permissions || [];
            const visiblePermissions = permissions.slice(0, 2);
            // const hiddenPermissions = permissions.slice(2); 
            const remainingCount = permissions.length - visiblePermissions.length;
            // Tạo HTML badge
            let permissionsHTML = `<div class="d-flex flex-wrap align-items-start">`;

            visiblePermissions.forEach(p => {
                permissionsHTML += `
                    <span class="badge badge-primary mr-1 mb-1 px-2 py-1" style="font-size: 0.65rem;">
                        ${p}
                    </span>`;
            });

            if (remainingCount > 0) {
                const remaining = permissions.slice(2).join(", ");
                permissionsHTML += `
                <span class="badge badge-light border mr-1 mb-1 px-2 py-1 text-primary" 
                    data-toggle="tooltip" 
                    title="${remaining}" 
                    style="font-size: 0.85rem; cursor: pointer;">+${remainingCount}</span>`;
                    }

            permissionsHTML += `</div>`;

            tr.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <div class="font-weight-bold">${item.user_info.fullName}</div>   
                    <small class="text-muted">(${item.user_info.username})</small>
                </td>
                <td>${permissionsHTML}</td>
                <td>
                    <button class="btn btn-primary btn-sm"
                        onclick="loadModal('user_hardware_permission_edit', { username: '${item.user_info.username}', ip: '${ip}' })">
                        <i class="mdi mdi-pencil"></i> Sửa
                    </button>
                </td>
            `;

            userListTbody.appendChild(tr);
        });

        // // Kích hoạt tooltip Bootstrap
        // $(function () {
        //     $('[data-toggle="tooltip"]').tooltip();
        // });

    } else {
        userListTbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Không có dữ liệu</td></tr>`;
    }
}

getHardwarePermissions();
window.addEventListener("hardware_permission_created", () => {
    getHardwarePermissions();
});
