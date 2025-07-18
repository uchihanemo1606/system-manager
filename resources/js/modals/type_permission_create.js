import { get_all_user } from "../api/user";
import { create_hardware_permission } from "../api/hardware";
import { create_software_permission } from "../api/software";
import { showToast } from "../component/toast";

const permissionSets = {
    hardware: {
        default: [
            "xem phần cứng",
            "sửa phần cứng",
            "xóa phần cứng",
            "sửa người dùng quản lý phần cứng",
            "thêm người dùng quản lý phần cứng", 
            "xoá người dùng quản lý phần cứng"
        ]
    },
    software: {
        default: [
            "xem phần mềm",
            "sửa phần mềm",
            "xóa phần mềm",
            "sửa người dùng quản lý phần mềm",
            "thêm người dùng quản lý phần mềm",
            "xoá người dùng quản lý phần mềm"
        ]
    }
};

let modalState = {
    type: "",         // hardware | software
    targetId: "",     // ip hoặc software_id
    allUsers: [],
    selectedUsers: {} // key = username, value = { fullName, email, permissions: [] }
};

window.initTypePermissionCreateModal = async function (data) {
    modalState = {
        type: data.type,
        targetId: data.id,
        allUsers: [],
        selectedUsers: {}
    };

    document.getElementById("modalTypeLabel").innerText = data.type === "hardware" ? "phần cứng" : "phần mềm";

    await loadUserList();
    renderFilteredUserList();
    renderSelectedUsers();
    const searchInput = document.getElementById("userSearchInput");
    if (searchInput) {
        searchInput.addEventListener("input", renderFilteredUserList);
    }
    document.getElementById("addPermissionBtn").onclick = async () => {
        const button = document.getElementById("addPermissionBtn");
        const spinner = document.getElementById("addPermissionSpinner");

        // Bắt đầu loading
        button.disabled = true;
        spinner.classList.remove("d-none");

        const users = Object.entries(modalState.selectedUsers).map(([username, data]) => ({
            user_name: username,
            permissions: data.permissions
        }));

        if (users.length === 0) {
            showToast({ message: "Vui lòng chọn ít nhất một người dùng!", type: "warning" });
            spinner.classList.add("d-none");
            button.disabled = false;
            return;
        }

        if (users.some(u => u.permissions.length === 0)) {
            showToast({ message: "Vui lòng chọn quyền cho tất cả người dùng!", type: "warning" });
            spinner.classList.add("d-none");
            button.disabled = false;
            return;
        }

        try {
            if (modalState.type === "hardware") {
                await create_hardware_permission({
                    hardware_ip: modalState.targetId,
                    users
                });
                window.dispatchEvent(new CustomEvent("hardware_permission_created"));
                showToast({ message: "Thêm quyền thành công!", type: "success" });
            } else {
                let successCount = 0;
                let failCount = 0;

                for (const user of users) {
                    try {
                        await create_software_permission({
                            software_id: modalState.targetId,
                            user_name: user.user_name,
                            permissions: user.permissions
                        });
                        successCount++;
                    } catch (err) {
                        console.error(`❌ Lỗi với ${user.user_name}: ${err.message}`);
                        failCount++;
                    }
                }

                window.dispatchEvent(new CustomEvent("software_permission_created"));

                if (successCount > 0) {
                    showToast({ message: `Đã thêm ${successCount} người dùng. ${failCount > 0 ? `Thất bại ${failCount} người.` : ''}`, type: "success" });
                } else {
                    showToast({ message: "Không thể thêm quyền cho bất kỳ người dùng nào.", type: "error" });
                }
            }
        } catch (e) {
            showToast({ message: "Lỗi khi thêm quyền: " + e.message, type: "error" });
        }

        // Kết thúc loading
        spinner.classList.add("d-none");
        button.disabled = false;
    };

};
// document.getElementById("userSearchInput").addEventListener("input", renderFilteredUserList);
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

    const filtered = modalState.allUsers.filter(user => {
        const notSelected = !modalState.selectedUsers[user.username];
        const text = `${user.username} ${user.fullName} ${user.email || ''}`.toLowerCase();
        return notSelected && text.includes(keyword);
    });

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
            <i class="mdi mdi-arrow-right-bold text-primary"></i>
        `;
        item.onclick = () => {
            if (!modalState.selectedUsers[user.username]) {
                modalState.selectedUsers[user.username] = {
                    fullName: user.fullName,
                    email: user.email,
                    permissions: []
                };
                renderSelectedUsers();
                renderFilteredUserList(); // cập nhật lại bên trái
            }
        };

        container.appendChild(item);
    });
}
function renderSelectedUsers() {
    const container = document.getElementById("selectedUsersContainer");
    container.innerHTML = "";

    const { default: defaultPermissions } = permissionSets[modalState.type];

    Object.entries(modalState.selectedUsers).forEach(([username, user]) => {
        const userBlock = document.createElement("div");
        userBlock.className = "border p-2 mb-3 rounded";
        userBlock.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <div class="fw-bold">${user.fullName} (${username})</div>
                    <small class="text-muted">${user.email || "Không có email"}</small>
                </div>
                <button class="btn btn-sm btn-outline-danger" onclick="removeSelectedUser('${username}')">
                    <i class="mdi mdi-close"></i>
                </button>
            </div>
            <div id="perm-${username}"></div>
        `;

        const permContainer = userBlock.querySelector(`#perm-${username}`);
        defaultPermissions.forEach(perm => {
            const permId = perm.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            const inputId = `perm-${username}-${permId}`;
            const checked = user.permissions.includes(perm);

            const checkbox = document.createElement("div");
            checkbox.className = "form-check mb-1";
            checkbox.innerHTML = `
                <input class="form-check-input" type="checkbox" id="${inputId}" ${checked ? "checked" : ""}>
                <label class="form-check-label" for="${inputId}">${perm}</label>
            `;
            checkbox.querySelector("input").addEventListener("change", e => {
                if (e.target.checked) {
                    if (!user.permissions.includes(perm)) user.permissions.push(perm);
                } else {
                    user.permissions = user.permissions.filter(p => p !== perm);
                }
            });

            permContainer.appendChild(checkbox);
        });

        container.appendChild(userBlock);
    });
}

function removeSelectedUser(username) {
    delete modalState.selectedUsers[username];
    renderSelectedUsers();
    renderFilteredUserList(); // hiển thị lại user ở bên trái
}

window.removeSelectedUser = removeSelectedUser;
