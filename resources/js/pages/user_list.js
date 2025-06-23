import { get_all_user } from "../api/user";
import { get_all_role } from "../api/role";
let hasLoadedRolesForFilter = false;
let allUsers = [];
async function loadUsers() {
    const tbody = document.getElementById("user-table-body");
    if (!tbody) return;

    try {
        allUsers = await get_all_user();
        renderUsers(allUsers);
    } catch (err) {
        console.error("Lỗi khi tải danh sách người dùng:", err);
    }
}
function hasPermission(code) {
    return window.userPermissionCodes?.includes(code);
}
function renderUsers(users) {
    const tbody = document.getElementById("user-table-body");
    if (!tbody) return;

    tbody.innerHTML = users
        .map((u) => {
            let actions = "";
            if (hasPermission("user.delete")) {
                actions += `<li class="list-inline-item px-2"><a href="#"><i class="bx bx-trash"></i></a></li>`;
            }
            if (hasPermission("user.update")) {
                actions += `<li class="list-inline-item px-2"><a href="#"><i class="bx bx-wrench"></i></a></li>`;
            }

            if (hasPermission("user.detail")) {
                actions += `<li class="list-inline-item px-2"><a href="#"><i class="bx bx-user-circle"></i></a></li>`;
            }
            return `
                <tr>
                    <td>
                        <div class="avatar-xs">
                            <span class="avatar-title rounded-circle">
                                ${u.username?.charAt(0)?.toUpperCase() || "?"}
                            </span>
                        </div>
                    </td>
                    <td>
                        <h5 class="font-size-14 mb-1">
                            <a href="#" class="text-dark">${u.username}</a>
                        </h5>
                    </td>
                    <td>${
                        u.email ||
                        `  <div class="team">
                        <span class="badge badge-secondary">Chưa có dữ liệu</span>
                    </div>`
                    }</td>
                    <td>${(u.roles || [])
                        .map(
                            (r) =>
                                `<a href="#" class="badge badge-soft-primary font-size-11 m-1">${r}</a>`
                        )
                        .join("")}</td>
                    <td>${u.projects_count ?? 0}</td>
                    <td>
                        <ul class="list-inline font-size-20 contact-links mb-0">
                            ${actions}
                        </ul>
                    </td>
                </tr>`;
        })
        .join("");
}
async function loadRolesForFilter() {
    if (hasLoadedRolesForFilter) return;
    hasLoadedRolesForFilter = true;

    const selectRole = document.getElementById("filter-role");
    if (!selectRole) return;

    try {
        const roles = await get_all_role();
        roles.data.forEach((role) => {
            const opt = document.createElement("option");
            opt.value = role.role_name;
            opt.textContent =
                role.role_name.charAt(0).toUpperCase() +
                role.role_name.slice(1);
            selectRole.appendChild(opt);
        });
    } catch (err) {
        console.error("Lỗi khi tải quyền lọc:", err);
    }
}
document.addEventListener("DOMContentLoaded", async () => {
    const filterForm = document.getElementById("filter-form");
    filterForm?.addEventListener("submit", (e) => {
        e.preventDefault();
        const params = Object.fromEntries(new FormData(filterForm).entries());
        const filtered = allUsers.filter(
            (u) =>
                (!params.username ||
                    u.username
                        ?.toLowerCase()
                        .includes(params.username.toLowerCase())) &&
                (!params.email ||
                    u.email?.toLowerCase().includes(params.email.toLowerCase()))
        );
        renderUsers(filtered);
    });

    await loadUsers();
    await loadRolesForFilter();
});
window.initUserCreateModal = async function () {
    const container = document.getElementById("role-checkboxes");
    if (!container) return;
    container.innerHTML = "";

    try {
        const roles = await get_all_role();
        if (!roles.data.length) {
            container.innerHTML =
                "<p class='text-muted'>Không có quyền nào để hiển thị</p>";
            return;
        }

        container.innerHTML = roles.data
            .map(
                (r) => `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" id="role_${
                        r.role_name
                    }" value="${r.role_name}">
                    <label class="form-check-label" for="role_${r.role_name}">
                        ${
                            r.role_name.charAt(0).toUpperCase() +
                            r.role_name.slice(1)
                        }
                    </label>
                </div>`
            )
            .join("");
    } catch (err) {
        console.error("Lỗi khi tải quyền:", err);
        container.innerHTML = "<p class='text-danger'>Không thể tải quyền</p>";
    }
};
window.addEventListener("userCreated", () => {
    console.log("Reload danh sách user sau khi tạo user thành công");
    loadUsers();
});
