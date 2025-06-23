import { get_all_role } from "../api/role";

async function loadRoles() {
    const tbody = document.getElementById("role-table-body");
    if (!tbody) return;

    try {
        const response = await get_all_role();

        const roles = response.data; // lấy mảng data từ response
        console.log(roles);
        renderRoles(roles);
    } catch (err) {
        console.error("Lỗi khi tải danh sách quyền hạng:", err);
    }   
}

function renderRoles(roles) {
    const tbody = document.getElementById("role-table-body");
    if (!tbody) return;

    tbody.innerHTML = roles
        .map((role) => {
            // Format ngày tạo
            const createdAt = role.created_at
                ? new Date(role.created_at).toLocaleDateString()
                : "-";

            return `
            <tr>
                <td>
                    <h5 class="text-truncate font-size-14"><a href="#" class="text-dark">${role.role_name}</a></h5>
                </td>
                <td>
                    <div class="role_permission_list">
                        <span class="badge badge-secondary">Chưa có dữ liệu</span>
                    </div>
                </td>
                <td>${createdAt}</td>
                <td>
                    <div class="team">
                        <span class="badge badge-secondary">Chưa có dữ liệu</span>
                    </div>
                </td>
                <td>
                    <div class="dropdown" >
                        <button class="btn btn-link p-0 dropdown-toggle" type="button" data-toggle="dropdown" onclick="loadModal('role_detail')">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">Sửa</button>
                            <button class="dropdown-item" type="button">Xem permission</button>
                            <button class="dropdown-item" type="button" onclick="loadModal('role_detail')">Xem chi tiết</button>
                        </div>
                    </div>
                </td>
            </tr>
        `;
        })
        .join("");
}

document.addEventListener("DOMContentLoaded", async () => {
    await loadRoles();
});
