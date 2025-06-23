import {
    get_all_role,
    create_user_role,
    get_all_user_role,
    delete_user_role,
} from "../api/role";

async function initUserRoleEditModal(data) {
    console.log("initUserRoleEditModal", data);

    const res = await get_all_role(); // Tất cả roles
    const r2 = await get_all_user_role(); // Tất cả user-role
    const all_user_role = r2.data || [];

    document.getElementById("username").value = data.username;

    const allRoles = res.data || [];

    const selectedRoles = all_user_role
        .filter((item) => item.username === data.username)
        .map((item) => item.role_name);

    renderRoleCheckboxes(allRoles, selectedRoles);

    document
        .getElementById("edit-user-role-form")
        .addEventListener("submit", async function (e) {
            e.preventDefault();

            const username = document.getElementById("username").value;

            // Danh sách role đang được check
            const checkedRoles = [];
            document
                .querySelectorAll(
                    "#role-checkboxes input[type=checkbox]:checked"
                )
                .forEach((checkbox) => {
                    checkedRoles.push(checkbox.value);
                });

            // Danh sách role trước đó của user (đã lấy lúc init)
            const previousRoles = all_user_role
                .filter((r) => r.username === username)
                .map((r) => r.role_name);

            // Các role cần thêm mới
            const rolesToAdd = checkedRoles.filter(
                (r) => !previousRoles.includes(r)
            );

            // Các role cần xóa
            const rolesToDelete = previousRoles.filter(
                (r) => !checkedRoles.includes(r)
            );

            let successAdd = 0,
                successDelete = 0;

            for (const role of rolesToAdd) {
                const res = await create_user_role({
                    username,
                    role_name: role,
                });
                if (res !== false) successAdd++;
            }

            for (const role of rolesToDelete) {
                const res = await delete_user_role({
                    username,
                    role_name: role,
                });
                if (res !== false) successDelete++;
            }

            alert(
                ` Gán vai trò hoàn tất cho ${username}\n➕ Thêm mới: ${successAdd}\n➖ Xóa: ${successDelete}`
            );
        });
}

function renderRoleCheckboxes(allRoles, selectedRoles = []) {
    const container = document.getElementById("role-checkboxes");
    if (!container) return;

    // Reset nội dung
    container.innerHTML = "";

    // Tạo bảng
    const table = document.createElement("table");
    table.className = "table table-sm table-hover mb-0";

    const tbody = document.createElement("tbody");

    for (const role of allRoles) {
        const isChecked = selectedRoles.includes(role.role_name);

        const row = document.createElement("tr");
        row.innerHTML = `
            <td class="align-middle text-center" style="width: 40px;">
                <div class="custom-control custom-checkbox">
                    <input 
                        type="checkbox" 
                        class="custom-control-input" 
                        id="role-${role.role_name}" 
                        value="${role.role_name}" 
                        ${isChecked ? "checked" : ""}
                    >
                    <label class="custom-control-label" for="role-${
                        role.role_name
                    }"></label>
                </div>
            </td>
            <td class="align-middle font-weight-bold text-dark">
                <i class="mdi mdi-account-key-outline text-primary mr-1"></i>
                ${role.role_name}
            </td>
            <td class="align-middle text-muted">
                ${
                    role.description ||
                    '<span class="font-italic">Không có mô tả</span>'
                }
            </td>
        `;
        tbody.appendChild(row);
    }

    table.appendChild(tbody);
    container.appendChild(table);
}

window.initUserRoleEditModal = initUserRoleEditModal;
