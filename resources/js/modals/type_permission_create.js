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

    const filtered = modalState.allUsers
        .filter(user => !modalState.selectedUsers[user.username]) // lọc đã chọn
        .filter(user =>
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
                renderFilteredUserList(); // cập nhật danh sách bên trái
            }
        };

        container.appendChild(item);
    });
}


function renderSelectedUsers() {
    const container = document.getElementById("selectedUsersContainer");
    container.innerHTML = "";

    const { default: defaultPermissions, groupValues } = permissionSets[modalState.type];

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
        [...defaultPermissions, "Cấp quyền cho người dùng"].forEach(perm => {
            const permId = perm.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            const isGroup = perm === "Cấp quyền cho người dùng";
            const inputId = `perm-${username}-${permId}`;
            const checked = isGroup
                ? groupValues.every(p => user.permissions.includes(p))
                : user.permissions.includes(perm);

            const checkbox = document.createElement("div");
            checkbox.className = "form-check mb-1";
            checkbox.innerHTML = `
                <input class="form-check-input" type="checkbox" id="${inputId}" ${checked ? "checked" : ""}>
                <label class="form-check-label" for="${inputId}">${perm}</label>
            `;
            checkbox.querySelector("input").addEventListener("change", e => {
                if (e.target.checked) {
                    if (isGroup) {
                        groupValues.forEach(p => {
                            if (!user.permissions.includes(p)) user.permissions.push(p);
                        });
                    } else {
                        if (!user.permissions.includes(perm)) user.permissions.push(perm);
                    }
                } else {
                    if (isGroup) {
                        user.permissions = user.permissions.filter(p => !groupValues.includes(p));
                    } else {
                        user.permissions = user.permissions.filter(p => p !== perm);
                    }
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


document.getElementById("userSearchInput").addEventListener("input", renderFilteredUserList);

document.getElementById("addPermissionBtn").onclick = async () => {
    const users = Object.entries(modalState.selectedUsers).map(([username, data]) => ({
        user_name: username,
        permissions: data.permissions
    }));

    if (users.length === 0) {
        showToast({ message: "Vui lòng chọn ít nhất một người dùng!", type: "warning" });
        return;
    }

    if (users.some(u => u.permissions.length === 0)) {
        showToast({ message: "Vui lòng chọn quyền cho tất cả người dùng!", type: "warning" });
        return;
    }

    try {
        if (modalState.type === "hardware") {
            await create_hardware_permission({
                hardware_ip: modalState.targetId,
                users
            });
            window.dispatchEvent(new CustomEvent("hardware_permission_created"));
        } else {
            for (const user of users) {
                await create_software_permission({
                    software_id: modalState.targetId,
                    user_name: user.user_name,
                    permissions: user.permissions
                });
            }
            window.dispatchEvent(new CustomEvent("software_permission_created"));
        }

        showToast({ message: "Thêm quyền thành công!", type: "success" });
    } catch (e) {
        showToast({ message: "Lỗi khi thêm quyền: " + e.message, type: "error" });
    }
};



// import { get_all_user } from "../api/user";
// import { create_hardware_permission } from "../api/hardware";
// import { create_software_permission } from "../api/software";
// import { showToast } from "../component/toast";

// const permissionSets = {
//     hardware: {
//         default: ["xem phần cứng", "sửa phần cứng", "xóa phần cứng"],
//         groupValues: ["sửa người dùng quản lý phần cứng", "thêm người dùng quản lý phần cứng", "xoá người dùng quản lý phần cứng"]
//     },
//     software: {
//         default: ["xem phần mềm", "sửa phần mềm", "xóa phần mềm"],
//         groupValues: ["sửa người dùng quản lý phần mềm", "thêm người dùng quản lý phần mềm", "xoá người dùng quản lý phần mềm"]
//     }
// };

// let modalState = {
//     type: "", // hardware | software
//     targetId: "", // ip hoặc software_id
//     allUsers: []
// };

// window.initTypePermissionCreateModal = async function (data) {
//     modalState = {
//         type: data.type,
//         targetId: data.id,
//         allUsers: []
//     };

//     document.getElementById("modalTypeLabel").innerText = data.type === "hardware" ? "phần cứng" : "phần mềm";

//     await loadUserList();
//     renderPermissionCheckboxList();
//     document.getElementById("addPermissionBtn").onclick = async () => {
//         const selectedItems = document.querySelectorAll("#userListContainer .list-group-item.active");
//         if (selectedItems.length === 0) {
//             showToast({ message: "Vui lòng chọn ít nhất một người dùng!", type: "warning" });
//             return;
//         }

//         const { default: defaultPermissions, groupValues } = permissionSets[modalState.type];

//         let selected = Array.from(document.querySelectorAll("#permissionCheckboxList input.form-check-input:checked"))
//             .filter(input => input.id !== "perm-group")
//             .map(input => input.value);

//         const groupChecked = document.getElementById("perm-group").checked;
//         if (groupChecked) {
//             groupValues.forEach(p => {
//                 if (!selected.includes(p)) selected.push(p);
//             });
//         }

//         if (selected.length === 0) {
//             showToast({ message: "Vui lòng chọn ít nhất một quyền!", type: "warning" });
//             return;
//         }

//         const users = Array.from(selectedItems).map(item => ({
//             user_name: item.dataset.username,
//             permissions: selected
//         }));

//         try {
//             if (modalState.type === "hardware") {
//                 await create_hardware_permission({
//                     hardware_ip: modalState.targetId,
//                     users
//                 });
//                 const event = new CustomEvent("hardware_permission_created");
//                 window.dispatchEvent(event);
//             } else {
//                 for (const user of users) {
//                     await create_software_permission({
//                         software_id: modalState.targetId,
//                         user_name: user.user_name,
//                         permissions: selected
//                     });
//                 }
//                 const event = new CustomEvent("software_permission_created");
//                 window.dispatchEvent(event);
//             }

//             showToast({ message: "Thêm quyền thành công!", type: "success" });
//         } catch (e) {
//             showToast({ message: "Lỗi khi thêm quyền: " + e.message, type: "error" });
//         }
//     };

// };

// async function loadUserList() {
//     try {
//         const res = await get_all_user();
//         modalState.allUsers = res;
//         renderFilteredUserList();
//     } catch (e) {
//         showToast({ message: "Lỗi tải danh sách người dùng: " + e.message, type: "error" });
//     }
// }

// function renderFilteredUserList() {
//     const container = document.getElementById("userListContainer");
//     const keyword = document.getElementById("userSearchInput").value.trim().toLowerCase();

//     container.innerHTML = "";

//     const filtered = modalState.allUsers.filter(user =>
//         user.username.toLowerCase().includes(keyword) ||
//         user.fullName.toLowerCase().includes(keyword) ||
//         (user.email && user.email.toLowerCase().includes(keyword))
//     );

//     if (filtered.length === 0) {
//         container.innerHTML = `<div class="text-muted text-center">Không tìm thấy người dùng phù hợp</div>`;
//         return;
//     }

//     filtered.forEach(user => {
//         const item = document.createElement("button");
//         item.className = "list-group-item list-group-item-action d-flex justify-content-between align-items-center";
//         item.type = "button";
//         item.innerHTML = `
//             <div>
//                 <div class="fw-bold">${user.fullName} (${user.username})</div>
//                 <small class="text-muted">${user.email || "Không có email"}</small>
//             </div>
//             <i class="mdi mdi-check-circle text-success d-none"></i>
//         `;
//         item.dataset.username = user.username;

//         item.onclick = () => {
//             item.classList.toggle("active");
//             const icon = item.querySelector(".mdi-check-circle");
//             icon.classList.toggle("d-none");
//         };

//         container.appendChild(item);
//     });
// }


// document.getElementById("userSearchInput").addEventListener("input", renderFilteredUserList);

// function renderPermissionCheckboxList() {
//     const { default: defaultPermissions, groupValues } = permissionSets[modalState.type];
//     const container = document.getElementById("permissionCheckboxList");

//     container.innerHTML = "";

//     defaultPermissions.forEach(perm => {
//         const safeId = perm.replace(/\s+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "");
//         container.innerHTML += `
//             <div class="form-check mb-2">
//                 <input class="form-check-input" type="checkbox" id="perm-${safeId}" value="${perm}">
//                 <label class="form-check-label" for="perm-${safeId}">${perm}</label>
//             </div>
//         `;
//     });

//     container.innerHTML += `
//         <div class="form-check mb-2">
//             <input class="form-check-input" type="checkbox" id="perm-group">
//             <label class="form-check-label" for="perm-group">Cấp quyền cho người dùng</label>
//         </div>
//     `;
// }


