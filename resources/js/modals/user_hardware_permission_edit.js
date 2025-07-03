import { get_all_permission_hardware_by_user, create_hardware_permission, remove_user_permission_in_hardware } from "../api/hardware";
import { showToast } from "../component/toast";

const defaultPermissions = [
    "xem phần cứng",
    "sửa phần cứng",
    "xóa phần cứng"
];

const groupPermissionLabel = "Cấp quyền cho người dùng";
const groupPermissionValues = [
    "sửa người dùng quản lý phần cứng",
    "thêm người dùng quản lý phần cứng",
    "xoá người dùng quản lý phần cứng"
];

let currentEditing = {
    username: "",
    hardwareIp: "",
    permissions: []
};

window.initUserHardwarePermissionEditModal = function (data) {
    const { username, ip } = data;
    if (!username || !ip) {
        showToast({ message: "Thiếu thông tin!", type: "error" });
        return;
    }

    currentEditing = { username, hardwareIp: ip, permissions: [] };
    document.getElementById("savePermissionBtn").onclick = async () => {
        try {
            // Thu thập quyền được chọn
            const selected = Array.from(document.querySelectorAll("#permissionCheckboxList input:checked")).map(input => input.value);
            console.log("Selected permissions:", selected);
            await remove_user_permission_in_hardware({
                username: currentEditing.username,
                hardwareIp: currentEditing.hardwareIp
            });

            if (selected.length > 0) {
                await create_hardware_permission({
                    hardware_ip: currentEditing.hardwareIp,
                    users: [
                        {
                            user_name: currentEditing.username,
                            permissions: selected
                        }
                    ]
                });
            }

            showToast({ message: "Cập nhật quyền thành công!", type: "success" });
        } catch (e) {
            showToast({ message: "Lỗi: " + e.message, type: "error" });
        }
    };
    fetchPermissions();
};

async function fetchPermissions() {
    try {
        const permissionsData = await get_all_permission_hardware_by_user({
            username: currentEditing.username,
            hardwareIp: currentEditing.hardwareIp
        });

        currentEditing.permissions = permissionsData.map(p => p.permissions_name);
        renderPermissionCheckboxList();
    } catch (e) {
        showToast({ message: "Lỗi lấy quyền: " + e.message, type: "error" });
    }
}

function renderPermissionCheckboxList() {
    const container = document.getElementById("permissionCheckboxList");
    container.innerHTML = "";

    // Render các quyền cơ bản
    defaultPermissions.forEach(perm => {
        const isChecked = currentEditing.permissions.includes(perm);
        const div = document.createElement("div");
        div.className = "form-check mb-2";
        const safeId = perm.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        div.innerHTML = `
            <input class="form-check-input" type="checkbox" id="perm-${safeId}" value="${perm}" ${isChecked ? "checked" : ""}>
            <label class="form-check-label" for="perm-${safeId}">${perm}</label>
        `;

        container.appendChild(div);
    });

    // Kiểm tra nếu có đủ cả 3 quyền quản lý người dùng thì tick sẵn checkbox gom nhóm
    const hasGroupPermissions = groupPermissionValues.every(p => currentEditing.permissions.includes(p));
    const groupDiv = document.createElement("div");
    groupDiv.className = "form-check mb-2";
    groupDiv.innerHTML = `
        <input class="form-check-input" type="checkbox" id="perm-group" ${hasGroupPermissions ? "checked" : ""}>
        <label class="form-check-label" for="perm-group">${groupPermissionLabel}</label>
    `;
    container.appendChild(groupDiv);
}


