import { get_all_role_permission } from "../api/role";
async function get_role_detail(roleId = 1) {
    try {
        const response = await get_all_role_permission("admin");
        const permissionsRaw = response;
        console.log(permissionsRaw);
        // Xử lý map về đúng format như cũ
        const permissions = permissionsRaw.map((p) => ({
            id: p.id,
            name: p.permission_name,
            description: "", // vì API chưa có description, tạm để rỗng
        }));
        return Promise.resolve({
            id: 1,
            role_name: "admin",
            permissions: permissions,
        });
    } catch (err) {
        console.error("Lỗi khi tải danh sách quyền hạng:", err);
    }
}

function get_all_permission() {
    return Promise.resolve([
        {
            id: 1,
            name: "Thêm phần cứng",
            type: "phần cứng",
            description: "Cho phép thêm các thiết bị phần cứng",
        },
        {
            id: 2,
            name: "Thêm phần mềm",
            type: "phần cứng",
            description: "Cho phép thêm phần mềm quản lý",
        },
        {
            id: 3,
            name: "Xem báo cáo",
            type: "phần cứng",
            description: "Truy cập báo cáo thống kê hệ thống",
        },
        {
            id: 4,
            name: "Quản lý tài khoản",
            type: "hardware",
            description: "Thêm, sửa, xóa người dùng",
        },
        {
            id: 5,
            name: "Cấu hình hệ thống",
            type: "phần cứng",
            description: "Chỉnh sửa các thiết lập hệ thống",
        },
    ]);
}
let allPermissionsGlobal = [];
let rolePermissionsGlobal = [];
function update_role_permission(roleId, permissionIds) {
    console.log("Cập nhật role", roleId, "với permission", permissionIds);
    return Promise.resolve(true);
}

// Khởi tạo modal edit permission
async function initRoleDetailModal() {
    const permissionForm = document.getElementById("permission-form");
    const permissionContainer = document.getElementById(
        "permission-checkboxes"
    );
    const roleNameEl = document.getElementById("role-name");
    const roleId = 1;

    if (!permissionForm) {
        console.error("Không tìm thấy form edit permission");
        return;
    }

    if (permissionForm.dataset.initialized) return;
    permissionForm.dataset.initialized = "true";

    try {
        const [roleData, allPermissions] = await Promise.all([
            get_role_detail(roleId),
            get_all_permission(),
        ]);

        allPermissionsGlobal = allPermissions;
        rolePermissionsGlobal = roleData.permissions.map((p) => p.id);
        roleNameEl.textContent = roleData.role_name;

        renderPermissionTable(allPermissionsGlobal, rolePermissionsGlobal);
        renderPermissionList(roleData.permissions);
        // Gắn sự kiện lọc
        document
            .getElementById("filter-name")
            .addEventListener("input", applyFilters);
        document
            .getElementById("filter-type")
            .addEventListener("change", applyFilters);
        document
            .getElementById("filter-selected")
            .addEventListener("change", applyFilters);
    } catch (err) {
        console.error("Lỗi khi load dữ liệu role/permission:", err);
        alert("Không thể tải dữ liệu");
    }

    permissionForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const selected = Array.from(
            document.querySelectorAll(
                "#permission-checkboxes input[type=checkbox]:checked"
            )
        ).map((input) => parseInt(input.value));

        try {
            await update_role_permission(roleId, selected);
            alert("Cập nhật permission thành công");
            $("#addPermissionModal").modal("hide");
            window.dispatchEvent(new CustomEvent("rolePermissionUpdated"));
        } catch (err) {
            console.error(err);
            alert(err.message || "Đã có lỗi xảy ra");
        }
    });
}

function renderPermissionTable(permissions, rolePermissions) {
    const permissionContainer = document.getElementById(
        "permission-checkboxes"
    );
    permissionContainer.innerHTML = "";

    const table = document.createElement("table");
    table.className =
        "table table-hover table-bordered align-middle text-center";

    table.innerHTML = `
        <thead class="table-light">
            <tr>
                <th>Chọn</th>
                <th>Tên Permission</th>
                <th>Loại Permission</th>
                <th>Mô tả</th>
            </tr>
        </thead>
        <tbody>
            ${permissions
                .map(
                    (p) => `
                <tr>
                    <td>
                        <div class="checkbox-wrapper-mail">
                            <input 
                                type="checkbox" 
                                id="chk-${p.id}" 
                                value="${p.id}" 
                                ${
                                    rolePermissions.includes(p.id)
                                        ? "checked"
                                        : ""
                                }
                                style="width: 20px; height: 20px;"
                            >
                            <label for="chk-${p.id}" class="toggle"></label>
                        </div>
                    </td>
                    <td>${p.name}</td>
                    <td>${p.type || "Không xác định"}</td>
                    <td>${p.description || ""}</td>
                </tr>
            `
                )
                .join("")}
        </tbody>
    `;

    permissionContainer.appendChild(table);
}
function applyFilters() {
    const nameFilter = document
        .getElementById("filter-name")
        .value.trim()
        .toLowerCase();
    const typeFilter = document.getElementById("filter-type").value;
    const selectedFilter = document.getElementById("filter-selected").value;

    const filteredPermissions = allPermissionsGlobal.filter((p) => {
        const matchName = p.name.toLowerCase().includes(nameFilter);
        const matchType = typeFilter ? p.type === typeFilter : true;

        const isSelected = rolePermissionsGlobal.includes(p.id);
        let matchSelected = true;
        if (selectedFilter === "selected") {
            matchSelected = isSelected;
        } else if (selectedFilter === "unselected") {
            matchSelected = !isSelected;
        }

        return matchName && matchType && matchSelected;
    });

    renderPermissionTable(filteredPermissions, rolePermissionsGlobal);
}
function renderPermissionList(permissions) {
    const permissionList = document.getElementById("permission-list");
    permissionList.innerHTML = "";

    if (permissions.length === 0) {
        permissionList.innerHTML = "<li>Chưa có permission nào</li>";
        return;
    }

    permissions.forEach((p) => {
        const li = document.createElement("li");
        li.className =
            "list-group-item d-flex justify-content-between align-items-center";
        li.innerHTML = `
            <span>${p.name}</span>
            <span class="badge badge-info">${
                p.description || "Không có mô tả"
            }</span>
        `;
        permissionList.appendChild(li);
    });
}

// Gọi khi window load
window.initRoleDetailModal = initRoleDetailModal;
