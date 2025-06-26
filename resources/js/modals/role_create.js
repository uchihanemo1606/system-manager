import {
    get_all_permission as get_all_per,
    create_role,
    create_role_permission,
    create_permission,
    permissionActions,
    permissionTypes,
} from "../api/role";
let selectedPermissionsGlobal = new Set();
// Tạo danh sách tất cả các permission nên có
function generateExpectedPermissions() {
    const result = [];

    for (const type of permissionTypes) {
        for (const action of permissionActions) {
            result.push({
                permissions_name: `${action} ${type.toLowerCase()}`,
                type: type,
                description: "",
            });
        }
    }

    return result;
}
let allPermissionsGlobal = [];
let rolePermissionsGlobal = [];

// Chuẩn hóa string
const normalize = (str) =>
    (str || "").trim().toLowerCase().replace(/\s+/g, " "); // Chuẩn hoá khoảng trắng giữa các từ

// Lấy tất cả permission
async function get_all_permission() {
    try {
        return await get_all_per();
    } catch (err) {
        console.error("Lỗi khi tải toàn bộ permission:", err);
    }
}
function renderTypeOptions(selected = "") {
    const selectEl = document.getElementById("filter-type");
    if (!selectEl) return;

    // Xóa hết options cũ
    selectEl.innerHTML = "";

    // Thêm option "Tất cả loại"
    const allOption = document.createElement("option");
    allOption.value = "";
    allOption.textContent = "Tất cả loại";
    selectEl.appendChild(allOption);

    // Thêm các permissionTypes
    for (const type of permissionTypes) {
        const option = document.createElement("option");
        option.value = type;
        option.textContent = type;
        if (type === selected) option.selected = true;
        selectEl.appendChild(option);
    }
}

function renderTableRow(p, isChecked, roleName) {
    const name = p.permissions_name;
    const isExisting = allPermissionsGlobal.some(
        (perm) => normalize(perm.permissions_name) === normalize(name)
    ); 
    if (!isExisting) {
        const normalized = normalize(p.permissions_name);
        return `
            <tr class="bg-light text-muted">
            <td>
            </td> 
                <td>
                    <span class="font-italic text-dark">
                        <i class="mdi mdi-alert-circle-outline text-warning mr-1"></i>
                        ${p.permissions_name}
                    </span>
                </td>
                <td>
                    <span class="badge badge-secondary">${p.type || "Không xác định"}</span>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-success create-missing-permission-btn shadow-sm"
                        data-role="${roleName}" 
                        data-permission="${p.permissions_name}"
                        data-type="${p.type || ""}" 
                        data-description="${p.description || ""}">
                        <i class="mdi mdi-plus-circle-outline mr-1"></i> Tạo permission
                    </button>
                </td>
            </tr>

    `;
    }

    return `
            <tr>
                <td class="align-middle">
                    <div class="custom-control custom-checkbox text-center">
                        <input 
                            type="checkbox" 
                            class="custom-control-input" 
                            id="${name}" 
                            value="${name}" 
                            ${isChecked ? "checked" : ""}
                        >
                        <label class="custom-control-label" for="${name}"></label>
                    </div>
                </td>
                <td class="align-middle font-weight-bold text-dark">
                    <i class="mdi mdi-shield-key-outline text-primary mr-1"></i>
                    ${name}
                </td>
                <td class="align-middle">
                    <span class="badge badge-info">${p.type || "Không xác định"}</span>
                </td>
                <td class="align-middle text-muted">
                    ${p.description || '<span class="font-italic">Không có mô tả</span>'}
                </td>
            </tr>

    `;
}
function renderPermissionTable(permissions, selectedNames, roleName = "") {
    const container = document.getElementById("permission-checkboxes");
    container.innerHTML = "";
    renderTypeOptions();
    // Nhóm theo type
    const grouped = {};
    for (const p of permissions) {
        const type = p.type || "Không xác định";
        if (!grouped[type]) grouped[type] = [];
        grouped[type].push(p);
    }

    const groupTables = Object.entries(grouped)
        .map(([type, groupPermissions]) => {
            const rows = groupPermissions.map((p) => {
                const normalized = normalize(p.permissions_name);
                const isKnown = allPermissionsGlobal.some(
                    (perm) => normalize(perm.permissions_name) === normalized
                );
                const isChecked = selectedPermissionsGlobal.has(normalized);

                const isMissing = !isKnown;

                return renderTableRow(p, isChecked, isMissing, roleName);
            });

            return `
            <div class="mb-4">
                <h5 class="text-primary mb-2 border-bottom pb-1">${type}</h5>
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Chọn</th>
                            <th>Tên Permission</th>
                            <th>Loại</th>
                            <th>Mô tả / Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rows.join("")}
                    </tbody>
                </table>
            </div>
        `;
        })
        .join("");

    container.innerHTML = groupTables;
    container.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            const value = normalize(checkbox.value);
            if (checkbox.checked) {
                selectedPermissionsGlobal.add(value);
            } else {
                selectedPermissionsGlobal.delete(value);
            }
        });
    });

    // Gắn sự kiện cho nút "Tạo permission này"
    document
        .querySelectorAll(".create-missing-permission-btn")
        .forEach((btn) => {
            btn.addEventListener("click", async function (event) {
                event.preventDefault();
                const permissionName = this.dataset.permission;
                const permissionType = this.dataset.type;
                const permissionDescription = this.dataset.description;
                const roleName = this.dataset.role;

                try {
                    // 1. Tạo permission mới
                    await create_permission({
                        permissions_name: permissionName,
                        type: permissionType,
                        description: permissionDescription,
                    });

                    // 2. Gán vào role
                    // await create_role_permission({
                    //     role_name: roleName,
                    //     permission_name: permissionName,
                    // });

                    alert(`Đã tạo permission "${permissionName}"`);

                    // 3. Reload lại dữ liệu
                    const [allPermissions] = await Promise.all([
                        get_all_permission(),
                    ]);

                    allPermissionsGlobal = allPermissions;
                    // rolePermissionsGlobal = roleData.permissions.map((p) =>
                    //     normalize(p.permission_name)
                    // );

                    const expectedPermissions = generateExpectedPermissions();
                    renderPermissionTable(
                        expectedPermissions,
                        rolePermissionsGlobal,
                        roleName
                    );
                    // renderPermissionList(roleData.permissions);
                } catch (err) {
                    console.error("Lỗi khi tạo permission:", err);
                    alert("Lỗi khi tạo permission: " + err.message);
                }
            });
        });
}

// Lọc permission theo filter
function applyFilters() {
    const nameFilter = normalize(document.getElementById("filter-name").value);
    const typeFilter = document.getElementById("filter-type").value;
    const selectedFilter = document.getElementById("filter-selected").value;

    const filtered = generateExpectedPermissions().filter((p) => {
        const name = normalize(p.permissions_name);
        const type = p.type || "";
        const isSelected = rolePermissionsGlobal.includes(name);

        const matchName = name.includes(nameFilter);
        const matchType = typeFilter ? type === typeFilter : true;
        const matchSelected =
            selectedFilter === "selected"
                ? isSelected
                : selectedFilter === "unselected"
                ? !isSelected
                : true;

        return matchName && matchType && matchSelected;
    });

    renderPermissionTable(filtered, rolePermissionsGlobal);
}

// Gắn sự kiện lọc
function bindFilterEvents() {
    ["filter-name", "filter-type", "filter-selected"].forEach((id) =>
        document.getElementById(id).addEventListener("input", applyFilters)
    );
}

// Khởi tạo modal quyền
async function initRoleCreateModal() {
    const form = document.getElementById("permission-form");
    if (!form || form.dataset.initialized) return;
    form.dataset.initialized = "true";
    selectedPermissionsGlobal = new Set(); // reset cho role mới

    try {
        const allPermissions = await get_all_permission();
        allPermissionsGlobal = allPermissions;
        rolePermissionsGlobal = []; // Vai trò mới, chưa có permission

        const expectedPermissions = generateExpectedPermissions();
        renderPermissionTable(expectedPermissions, []);
        bindFilterEvents();
    } catch (err) {
        console.error("Lỗi khi load dữ liệu:", err);
        alert("Không thể tải dữ liệu.");
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const roleNameInput = document.getElementById("role-name");
        const roleName = roleNameInput.value.trim();

        if (!roleName) {
            alert("Vui lòng nhập tên vai trò.");
            return;
        }
        const selectedPermissions = Array.from(selectedPermissionsGlobal);

        try {
            await create_role({ role_name: roleName });

            await Promise.all(
                selectedPermissions.map((permission_name) =>
                    create_role_permission({
                        role_name: roleName,
                        permission_name,
                    })
                )
            );

            alert("Tạo vai trò thành công!");
            $("#modalContainer").modal("hide");
            window.dispatchEvent(new CustomEvent("rolePermissionUpdated"));
        } catch (err) {
            console.error("Lỗi khi tạo vai trò:", err);
            alert(err.message || "Đã xảy ra lỗi khi tạo vai trò.");
        }
    });
}

// Gọi khi window load
window.initRoleCreateModal = initRoleCreateModal;
