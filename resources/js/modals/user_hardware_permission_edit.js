import {
    get_all_permission_hardware_by_user,
    create_hardware_permission,
    remove_user_permission_in_hardware
} from "../api/hardware";
import { showToast } from "../component/toast";
import { permissionSets } from "./type_permission_create"; // thêm dòng này ở đầu file nếu chưa có

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
            const selected = Array.from(document.querySelectorAll("#permissionCheckboxList input.form-check-input:checked"))
                .map(input => input.value);
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

    // 1. Render default permissions
    permissionSets.hardware.default.forEach(perm => {
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
    permissionSets.hardware.group.forEach(groupObj => {
        for (const groupName in groupObj) {
            const groupPerms = groupObj[groupName];

            const normalize = str => str.trim().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            const currentPermsNormalized = currentEditing.permissions.map(normalize);

            const hasAll = groupPerms.every(p => currentPermsNormalized.includes(normalize(p)));
            const hasSome = groupPerms.some(p => currentPermsNormalized.includes(normalize(p)));

            const showWarning = hasSome && !hasAll;

            const safeId = groupName.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");
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

    // 3. Bắt sự kiện click nhóm
    container.querySelectorAll(".group-permission").forEach(input => {
        input.addEventListener("change", () => {
            const children = JSON.parse(input.dataset.children || "[]");
            children.forEach(p => {
                const childId = "perm-" + p.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                let el = document.getElementById(childId);
                if (!el) {
                    const hiddenInput = document.createElement("input");
                    hiddenInput.type = "checkbox";
                    hiddenInput.id = childId;
                    hiddenInput.value = p;
                    hiddenInput.checked = input.checked;
                    hiddenInput.classList.add("hidden-child", "form-check-input");
                    hiddenInput.style.display = "none";
                    container.appendChild(hiddenInput);
                } else {
                    el.checked = input.checked;
                }
            });
        });
    });
}
