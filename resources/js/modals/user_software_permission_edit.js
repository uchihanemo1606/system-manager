import { create_software_permission, get_all_permission_software_by_user, remove_user_permission_in_software } from "../api/software";
import { showToast } from "../component/toast";

const defaultPermissions = [
    "xem phần mềm",
    "sửa phần mềm",
    "xóa phần mềm"
];

const groupPermissionLabel = "Cấp quyền cho người dùng";
const groupPermissionValues = [
    "sửa người dùng quản lý phần mềm",
    "thêm người dùng quản lý phần mềm",
    "xoá người dùng quản lý phần mềm"
];

let currentEditing = {
    username: "",
    softwareId: "",
    permissions: []
};

window.initUserSoftwarePermissionEditModal = function (data) {
    console.log("Initializing user software permission edit modal with data:", data);
    const { username, targetId } = data;
    if (!username || !targetId) {
        showToast({ message: "Thiếu thông tin!", type: "error" });
        return;
    }

    currentEditing = { username, softwareId: targetId, permissions: [] };

    const container = document.getElementById("permissionCheckboxList");
    if (container) container.innerHTML = ""; // Reset giao diện checkbox
    document.getElementById("savePermissionBtn").onclick = async () => {
        try {
            let selected = Array.from(document.querySelectorAll("#permissionCheckboxList input.form-check-input:checked"))
                .filter(input => input.id !== "perm-group")
                .map(input => input.value);

            const groupChecked = document.getElementById("perm-group").checked;
            if (groupChecked) {
                groupPermissionValues.forEach(p => {
                    if (!selected.includes(p)) selected.push(p);
                });
            }

            await remove_user_permission_in_software({
                username: currentEditing.username,
                softwareId: currentEditing.softwareId
            });

            if (selected.length > 0) {
                await create_software_permission({
                    software_id: currentEditing.softwareId,
                    user_name: currentEditing.username,
                    permissions: selected
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
        const permissionsData = await get_all_permission_software_by_user({
            username: currentEditing.username,
            softwareId: currentEditing.softwareId
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

    defaultPermissions.forEach(perm => {
        const isChecked = currentEditing.permissions.includes(perm);
        const safeId = perm.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        container.innerHTML += `
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm-${safeId}" value="${perm}" ${isChecked ? "checked" : ""}>
                <label class="form-check-label" for="perm-${safeId}">${perm}</label>
            </div>
        `;
    });

    const hasGroupPermissions = groupPermissionValues.every(p => currentEditing.permissions.includes(p));
    container.innerHTML += `
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="perm-group" ${hasGroupPermissions ? "checked" : ""}>
            <label class="form-check-label" for="perm-group">${groupPermissionLabel}</label>
        </div>
    `;
}

