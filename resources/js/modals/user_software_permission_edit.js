import { create_software_permission, get_all_permission_software_by_user, remove_user_permission_in_software } from "../api/software";
import { showToast } from "../component/toast";
import { permissionSets } from "./type_permission_create";
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
                .map(input => input.value);

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

    // 1. Render default permissions
    permissionSets.software.default.forEach(perm => {
        const isChecked = currentEditing.permissions.includes(perm);
        const safeId = perm.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        container.innerHTML += `
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm-${safeId}" value="${perm}" ${isChecked ? "checked" : ""}>
                <label class="form-check-label" for="perm-${safeId}">${perm}</label>
            </div>
        `;
    });

    // 2. Render group permissions 
    permissionSets.software.group.forEach(groupObj => {
        for (const groupName in groupObj) {
            const groupPerms = groupObj[groupName];

            // Chuẩn hoá tên để so sánh
            const normalize = str => str.trim().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

            const currentPermsNormalized = currentEditing.permissions.map(normalize);

            const hasAll = groupPerms.every(p => currentPermsNormalized.includes(normalize(p)));
            const hasSome = groupPerms.some(p => currentPermsNormalized.includes(normalize(p)));

            const showWarning = hasSome && !hasAll;

            const safeId = groupName.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");

            // Tooltip nội dung liệt kê các quyền con
            const tooltipTitle = groupPerms.map(p => `• ${p}`).join("\n");

            container.innerHTML += `
            <div class="form-check mb-2 position-relative" title="${tooltipTitle}">
                <input class="form-check-input group-permission" type="checkbox"
                    id="perm-${safeId}"
                    value="${groupName}"
                    data-children='${JSON.stringify(groupPerms)}'
                    ${hasAll ? "checked" : ""}
                >
                <label class="form-check-label fw-bold text-primary" for="perm-${safeId}">
                    ${groupName}
                    ${showWarning ? '<span class="text-danger ms-1" title="Thiếu quyền con">❗</span>' : ""}
                </label>
            </div>
        `;
        }
    });


    // 3. Bắt sự kiện khi click nhóm → cập nhật các quyền con tương ứng
    container.querySelectorAll(".group-permission").forEach(input => {
        input.addEventListener("change", (e) => {
            const children = JSON.parse(input.dataset.children || "[]");
            children.forEach(p => {
                const childId = "perm-" + p.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                let el = document.getElementById(childId);
                if (!el) {
                    // Nếu quyền con không hiển thị → tạo input ẩn và gán class "hidden-child"
                    const hiddenInput = document.createElement("input");
                    hiddenInput.type = "checkbox";
                    hiddenInput.id = childId;
                    hiddenInput.value = p;
                    hiddenInput.checked = input.checked;
                    hiddenInput.classList.add("hidden-child");
                    hiddenInput.style.display = "none";
                    hiddenInput.classList.add("form-check-input"); // để khớp selector
                    container.appendChild(hiddenInput);
                } else {
                    el.checked = input.checked;
                }
            });
        });
    });

}
