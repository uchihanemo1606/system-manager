import { get_all_role } from "../api/role";

async function loadRoles() {
    const tbody = document.getElementById("role-table-body");
    if (!tbody) return;

    const response = await get_all_role();

    const roles = response.data;
    renderRoles(roles);
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
            const safeRoleData = JSON.stringify(role).replace(/"/g, "&quot;");
            return `
            <tr>
                <td>
                    <h5 class="text-truncate font-size-14"><a href="#" class="text-dark">${role.role_name}</a></h5>
                </td> 
                <td>${createdAt}</td> 
                <td class="text-right">
                    <div class="dropdown" >
                        <button class="btn btn-link p-0 dropdown-toggle" 
                                type="button"
                                data-role="${safeRoleData|| '{}'}"
                                onclick="loadModal('role_detail', JSON.parse(this.dataset.role))"
                        >
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </button>
                        
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
