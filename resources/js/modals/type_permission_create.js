import { get_all_user } from "../api/user";
import { create_hardware_permission } from "../api/hardware";
import { create_software_permission } from "../api/software";
import { showToast } from "../component/toast";

const permissionSets = {
    hardware: {
        default: ["xem phần cứng", "sửa phần cứng", "xóa phần cứng"],
        groupValues: ["sửa người dùng quản lý phần cứng", "thêm người dùng quản lý phần cứng", "xoá người dùng quản lý phần cứng"]
    },
    software: {
        default: ["xem phần mềm", "sửa phần mềm", "xóa phần mềm"],
        groupValues: ["sửa người dùng quản lý phần mềm", "thêm người dùng quản lý phần mềm", "xoá người dùng quản lý phần mềm"]
    }
};

let modalState = {
    type: "", // hardware | software
    targetId: "", // ip hoặc software_id
    allUsers: []
};

window.initTypePermissionCreateModal = async function (data) {
    modalState = {
        type: data.type,
        targetId: data.id,
        allUsers: []
    };

    document.getElementById("modalTypeLabel").innerText = data.type === "hardware" ? "phần cứng" : "phần mềm";

    await loadUserList();
    renderPermissionCheckboxList();
    document.getElementById("addPermissionBtn").onclick = async () => {
        const selectedItem = document.querySelector("#userListContainer .list-group-item.active");
        if (!selectedItem) {
            showToast({ message: "Vui lòng chọn người dùng!", type: "warning" });
            return;
        }

        const username = selectedItem.dataset.username;
        const { default: defaultPermissions, groupValues } = permissionSets[modalState.type];

        let selected = Array.from(document.querySelectorAll("#permissionCheckboxList input.form-check-input:checked"))
            .filter(input => input.id !== "perm-group")
            .map(input => input.value);

        const groupChecked = document.getElementById("perm-group").checked;
        if (groupChecked) {
            groupValues.forEach(p => {
                if (!selected.includes(p)) selected.push(p);
            });
        }

        if (selected.length === 0) {
            showToast({ message: "Vui lòng chọn ít nhất một quyền!", type: "warning" });
            return;
        }

        try {
            if (modalState.type === "hardware") {
                await create_hardware_permission({
                    hardware_ip: modalState.targetId,
                    users: [
                        {
                            user_name: username,
                            permissions: selected
                        }
                    ]
                });
                const event = new CustomEvent("hardware_permission_created");
                window.dispatchEvent(event);
            } else {
                await create_software_permission({
                    software_id: modalState.targetId,
                    user_name: username,
                    permissions: selected
                });
                const event = new CustomEvent("software_permission_created");
                window.dispatchEvent(event);
            }

            showToast({ message: "Thêm quyền thành công!", type: "success" });
        } catch (e) {
            showToast({ message: "Lỗi khi thêm quyền: " + e.message, type: "error" });
        }
    };
};

async function loadUserList() {
    try {
        const res = await get_all_user();
        modalState.allUsers = res;
        renderFilteredUserList();
    } catch (e) {
        showToast({ message: "Lỗi tải danh sách người dùng: " + e.message, type: "error" });
    }
}

function renderFilteredUserList() {
    const container = document.getElementById("userListContainer");
    const keyword = document.getElementById("userSearchInput").value.trim().toLowerCase();

    container.innerHTML = "";

    const filtered = modalState.allUsers.filter(user =>
        user.username.toLowerCase().includes(keyword) ||
        user.fullName.toLowerCase().includes(keyword) ||
        (user.email && user.email.toLowerCase().includes(keyword))
    );

    if (filtered.length === 0) {
        container.innerHTML = `<div class="text-muted text-center">Không tìm thấy người dùng phù hợp</div>`;
        return;
    }

    filtered.forEach(user => {
        const item = document.createElement("button");
        item.className = "list-group-item list-group-item-action d-flex justify-content-between align-items-center";
        item.type = "button";
        item.innerHTML = `
            <div>
                <div class="fw-bold">${user.fullName} (${user.username})</div>
                <small class="text-muted">${user.email || "Không có email"}</small>
            </div>
            <i class="mdi mdi-check-circle text-success d-none"></i>
        `;
        item.dataset.username = user.username;

        item.onclick = () => {
            container.querySelectorAll(".list-group-item").forEach(el => el.classList.remove("active"));
            container.querySelectorAll(".mdi-check-circle").forEach(icon => icon.classList.add("d-none"));

            item.classList.add("active");
            item.querySelector(".mdi-check-circle").classList.remove("d-none");
        };

        container.appendChild(item);
    });
}

document.getElementById("userSearchInput").addEventListener("input", renderFilteredUserList);

function renderPermissionCheckboxList() {
    const { default: defaultPermissions, groupValues } = permissionSets[modalState.type];
    const container = document.getElementById("permissionCheckboxList");

    container.innerHTML = "";

    defaultPermissions.forEach(perm => {
        const safeId = perm.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        container.innerHTML += `
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm-${safeId}" value="${perm}">
                <label class="form-check-label" for="perm-${safeId}">${perm}</label>
            </div>
        `;
    });

    container.innerHTML += `
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="perm-group">
            <label class="form-check-label" for="perm-group">Cấp quyền cho người dùng</label>
        </div>
    `;
}


