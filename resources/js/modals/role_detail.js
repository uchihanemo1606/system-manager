import {
    get_all_permission_by_role_name,
    get_all_permission as get_all_per,
    delete_role_permission,
    create_role_permission,
    create_permission,
    permissionTypes,
    permissionActions,
    delete_role,
    update_role
} from "../api/role";
import { showToast } from "../component/toast";
let selectedPermissionsGlobal = new Set(); // chứa normalize(permission_name)
let allPermissionsGlobal = [];
let rolePermissionsGlobal = [];
// Tạo danh sách tất cả các permission nên có
const roleNameEl = document.getElementById("role-name");
const editBtn = document.getElementById("edit-role-btn");

editBtn.addEventListener("click", () => {
    // Lấy giá trị hiện tại
    const currentRole = roleNameEl.textContent.trim();

    // Tạo input và nút lưu/hủy
    const input = document.createElement("input");
    input.type = "text";
    input.value = currentRole;
    input.className = "form-control d-inline-block w-auto mr-2";

    const saveBtn = document.createElement("button");
    saveBtn.className = "btn btn-sm btn-success mr-1";
    saveBtn.textContent = "Lưu";

    const cancelBtn = document.createElement("button");
    cancelBtn.className = "btn btn-sm btn-secondary";
    cancelBtn.textContent = "Hủy";

    // Thay span + nút edit bằng input + nút
    roleNameEl.replaceWith(input);
    editBtn.replaceWith(saveBtn, cancelBtn);

    // Lưu thay đổi
    saveBtn.addEventListener("click", async () => {
        const newRoleName = input.value.trim();
        if (!newRoleName) return alert("Tên role không được rỗng");

        try {
            await update_role({ old_role_name: currentRole, new_role_name: newRoleName });
            // Cập nhật span hiển thị
            input.replaceWith(roleNameEl);
            roleNameEl.textContent = newRoleName;
            saveBtn.replaceWith(editBtn);
            cancelBtn.remove();
        } catch (err) {
            console.error(err);
        }
    });

    // Hủy thay đổi
    cancelBtn.addEventListener("click", () => {
        input.replaceWith(roleNameEl);
        saveBtn.replaceWith(editBtn);
        cancelBtn.remove();
    });
});

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
// Chuẩn hóa string
const normalize = (str) =>
    (str || "").trim().toLowerCase().replace(/\s+/g, " "); // Chuẩn hoá khoảng trắng giữa các từ

// Lấy quyền của role
async function get_role_detail(data) {
    try {
        const res = await get_all_permission_by_role_name(data.role_name);
        return { role: data, permissions: res };
    } catch (err) {
        console.error("Lỗi khi tải quyền role:", err);
    }
}

// Lấy tất cả permission
async function get_all_permission() {
    try {
        return await get_all_per();
    } catch (err) {
        console.error("Lỗi khi tải toàn bộ permission:", err);
    }
}

// Cập nhật quyền cho role
function update_role_permission(roleId, permissionIds) {
    return Promise.resolve(true);
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

function renderTableRow(p, isChecked, isMissing = false, roleName) {
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
                    <span class="badge badge-secondary">${p.type || "Không xác định"
            }</span>
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
                <td>
                    <span class="font-weight-bold text-dark">
                        <i class="mdi mdi-shield-key-outline text-primary mr-1"></i>
                        ${name}
                    </span>
                </td>
                <td>
                    <span class="badge badge-info">${p.type || "Không xác định"
        }</span>
                </td>
                <td>
                    ${p.description
            ? `<span class="text-muted">${p.description}</span>`
            : '<span class="text-muted fst-italic">Không có mô tả</span>'
        }
                </td>
            </tr>

    `;
}
function renderPermissionTable(permissions, selectedNames, roleName = "") {
    const container = document.getElementById("permission-checkboxes");
    container.innerHTML = "";
    renderTypeOptions();

    // Cập nhật tạm thời selectedPermissionsGlobal từ selectedNames (nếu chưa có)
    if (selectedPermissionsGlobal.size === 0) {
        selectedNames.forEach((name) => selectedPermissionsGlobal.add(name));
    }

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

    // Gắn sự kiện checkbox cập nhật selectedPermissionsGlobal
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

    // Gắn lại nút tạo permission
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
                    await create_permission({
                        permissions_name: permissionName,
                        type: permissionType,
                        description: permissionDescription,
                    });
                    showToast({
                        message: `Đã tạo permission "${permissionName}"`,
                        type: "success",
                        timeout: 2000,
                    })
                    const [roleData, allPermissions] = await Promise.all([
                        get_role_detail({ role_name: roleName }),
                        get_all_permission(),
                    ]);

                    allPermissionsGlobal = allPermissions;
                    rolePermissionsGlobal = roleData.permissions.map((p) =>
                        normalize(p.permission_name)
                    );

                    const expectedPermissions = generateExpectedPermissions();
                    renderPermissionTable(
                        expectedPermissions,
                        rolePermissionsGlobal,
                        roleName
                    );
                    renderPermissionList(roleData.permissions);
                } catch (err) {
                    console.error("Lỗi khi tạo permission:", err);
                    showToast({
                        message: err.message || "Lỗi khi tạo permission",
                        type: "error",
                        timeout: 2000,
                    });
                }
            });
        });
}
function renderPermissionList(permissions) {
    const list = document.getElementById("permission-list");
    list.innerHTML = permissions.length
        ? permissions
            .map(
                (p) => `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>${p.permission_name}</span>
            </li>
        `
            )
            .join("")
        : "<li>Chưa có permission nào</li>";
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
async function initRoleDetailModal(data) {
    const form = document.getElementById("permission-form");
    if (!form) return;

    // Reset toàn bộ giao diện và biến global
    form.dataset.initialized = "";
    selectedPermissionsGlobal = new Set();
    rolePermissionsGlobal = [];
    allPermissionsGlobal = [];
    document.getElementById("role-name").textContent = "";
    document.getElementById("permission-checkboxes").innerHTML = "";
    document.getElementById("permission-list").innerHTML = "";
    document.getElementById("filter-name").value = "";
    document.getElementById("filter-type").value = "";
    document.getElementById("filter-selected").value = "";

    // Khóa không cho init lại nhiều lần trong 1 lần mở modal
    form.dataset.initialized = "true";

    const roleNameEl = document.getElementById("role-name");

    try {
        const [roleData, allPermissions] = await Promise.all([
            get_role_detail(data),
            get_all_permission(),
        ]);

        allPermissionsGlobal = allPermissions;
        rolePermissionsGlobal = roleData.permissions.map((p) =>
            normalize(p.permission_name)
        );
        selectedPermissionsGlobal = new Set(rolePermissionsGlobal);

        roleNameEl.textContent = roleData.role.role_name;

        const expectedPermissions = generateExpectedPermissions();
        renderPermissionTable(
            expectedPermissions,
            rolePermissionsGlobal,
            data.role_name
        );
        renderPermissionList(roleData.permissions);
        bindFilterEvents();
    } catch (err) {
        console.error("Lỗi khi load dữ liệu:", err);
        showToast({
            message: err.message || "Không thể tải dữ liệu",
            type: "error",
            timeout: 2000,
        });
        return;
    }
    document.getElementById("delete-role-btn")?.addEventListener("click", async () => {
        if (!confirm("Bạn có chắc chắn muốn xóa role này không?")) return;

        try {
            await delete_role(data.role_name); 

            $("#addPermissionModal").modal("hide");
            window.dispatchEvent(new CustomEvent("roleListUpdated"));
        } catch (err) {
            console.error("Lỗi khi xóa role:", err);
            showToast({
                message: "Không thể xóa role này",
                type: "error",
                timeout: 2000,
            });
        }
    });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const activeElement = document.activeElement;
        if (
            activeElement &&
            activeElement.classList.contains("create-missing-permission-btn")
        ) {
            return;
        }
        const selected = Array.from(selectedPermissionsGlobal);
        const removed = rolePermissionsGlobal.filter(
            (oldPerm) => !selected.includes(oldPerm)
        );
        const added = selected.filter(
            (newPerm) => !rolePermissionsGlobal.includes(newPerm)
        );

        const selectedRole = data.role_name;
        if (selectedRole === "admin" || selectedRole === "quản lý phần cứng" || selectedRole === "quản lý phần mềm" || selectedRole === "quản lý hệ thống" || selectedRole === "người dùng cơ bản") {
            showToast({
                message: "CẢNH BÁO:  đây là 'Vai trò' được thiết lập sẵn ảnh hưởng đến hệ thống chúng tôi khuyến cáo nên tạo một 'Vai trò' mới thay vì sửa 'Vai trò' này :" + ` ${selectedRole}`,
                type: "warning",
                timeout: 4000,
            });
            return;
        }

        try {
            for (const permission_name of removed) {
                await delete_role_permission({
                    role_name: selectedRole,
                    permission_name,
                });
            }

            await Promise.all(
                added.map((permission_name) =>
                    create_role_permission({
                        role_name: selectedRole,
                        permission_name,
                    })
                )
            );

            await update_role_permission(data.role_id, selected);

            const [roleData, allPermissions] = await Promise.all([
                get_role_detail(data),
                get_all_permission(),
            ]);

            allPermissionsGlobal = allPermissions || [];
            rolePermissionsGlobal = (roleData.permissions || []).map((p) =>
                normalize(p.permission_name)
            );
            selectedPermissionsGlobal = new Set(rolePermissionsGlobal);

            const expectedPermissions = generateExpectedPermissions();
            renderPermissionTable(
                expectedPermissions,
                rolePermissionsGlobal,
                data.role_name
            );
            renderPermissionList(roleData.permissions);
            applyFilters();

            showToast({
                message: "Cập nhật quyền thành công!",
                type: "success",
                timeout: 2000,
            });
            $("#addPermissionModal").modal("hide");
            window.dispatchEvent(new CustomEvent("rolePermissionUpdated"));
        } catch (err) {
            console.error("Lỗi khi cập nhật quyền:", err);
            showToast({
                message: err.message || "Đã có lỗi xảy ra khi cập nhật quyền",
                type: "error",
                timeout: 2000,
            });
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    $("#addPermissionModal").on("hidden.bs.modal", () => {

        selectedPermissionsGlobal = new Set();
        rolePermissionsGlobal = [];
        allPermissionsGlobal = [];
        document.getElementById("role-name").textContent = "";
        document.getElementById("permission-checkboxes").innerHTML = "";
        document.getElementById("permission-list").innerHTML = "";
        document.getElementById("filter-name").value = "";
        document.getElementById("filter-type").value = "";
        document.getElementById("filter-selected").value = "";

        const form = document.getElementById("permission-form");
        if (form) form.dataset.initialized = "";
    });
});

// Gọi khi window load
window.initRoleDetailModal = initRoleDetailModal;
