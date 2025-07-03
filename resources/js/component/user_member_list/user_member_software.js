import { get_all_user_permission_software } from "../../api/software"; 

async function getSoftwarePermissions() {
    const id = new URLSearchParams(window.location.search).get("id");
    if (!id) {
        console.error("Thiếu tham số id trên URL");
        return;
    }
    console.log("Fetching software permissions for ID:", id);
    const res = await get_all_user_permission_software(id); 
    const userListTbody = document.getElementById("user-list-software");
    console.log("Software permissions:", res);
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
            const remainingCount = permissions.length - visiblePermissions.length;

            let permissionsHTML = `<div class="d-flex flex-wrap gap-1">`;

            visiblePermissions.forEach(p => {
                permissionsHTML += `<span class="badge bg-primary text-white">${p}</span>`;
            });

            if (remainingCount > 0) {
                permissionsHTML += `<span class="badge bg-secondary text-white">+${remainingCount}</span>`;
            }

            permissionsHTML += `</div>`;

            tr.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <div class="fw-bold">${item.user_info.fullName}</div>   
                    <small class="text-muted">(${item.user_info.username})</small>
                </td>
                <td>${permissionsHTML}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="loadModal('user_software_permission_edit', { username: '${item.user_info.username}', targetId: '${id}' })">
                        <i class="mdi mdi-pencil"></i> Sửa  
                    </button>
                </td>
            `;

            userListTbody.appendChild(tr);
        });
    } else {
        userListTbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Không có dữ liệu</td></tr>`;
    }
}

getSoftwarePermissions();
window.addEventListener("software_permission_created", () => {
    getSoftwarePermissions();
});
