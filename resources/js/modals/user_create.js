import { create_user } from "../api/user";
import { get_all_role } from "../api/role";
import { showToast } from "../component/toast";

function initUserCreateModal() {
    const createUserForm = document.getElementById("create-user-form");
    const roleContainer = document.getElementById("role-checkboxes");

    if (!createUserForm) {
        console.error("Không tìm thấy form tạo user");
        return;
    }

    if (createUserForm.dataset.initialized) return;
    createUserForm.dataset.initialized = "true";

    // Gọi API lấy danh sách roles
    async function fetchRoles() {
        try {
            const roles = await get_all_role();
            renderRoles(roles.data);
        } catch (err) { 
            showToast({
                message: err.message || "Không thể tải danh sách quyền!",
                type: "error",
                timeout: 2000,
            })
        }
    }

    function renderRoles(roles) {
        roleContainer.innerHTML = ""; // Clear cũ trước khi render

        roles.forEach((role) => {
            const div = document.createElement("div");
            div.className = "form-check";

            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.className = "form-check-input";
            checkbox.id = `role-${role.role_name}`;
            checkbox.value = role.role_name;

            const label = document.createElement("label");
            label.className = "form-check-label";
            label.htmlFor = `role-${role.role_name}`;
            label.innerText = role.role_name;

            div.appendChild(checkbox);
            div.appendChild(label);

            roleContainer.appendChild(div);
        });
    }

    // Gọi API load roles khi khởi tạo
    fetchRoles();

    // Xử lý submit tạo user
    createUserForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(createUserForm);
        const data = Object.fromEntries(formData.entries());

        if (data.password !== data.verifyPassword) {
            showToast({
                message: "Mật khẩu và xác nhận mật khẩu không khớp!",
                type: "error",
                timeout: 2000,
            })
            return;
        }

        const roles = [
            ...document.querySelectorAll("#role-checkboxes input:checked"),
        ].map((el) => el.value);

        try {
            await create_user({
                username: data.username,
                password: data.password,
                roles: roles,
            });

            showToast({
                message: "Tạo user thành công!",
                type: "success",
                timeout: 2000,
            });
            $("#createUserModal").modal("hide");
            window.dispatchEvent(new CustomEvent("userCreated"));
        } catch (err) {
            showToast({
                message: err.message || "Có lỗi xảy ra khi tạo user!",
                type: "error",
                timeout: 2000,
            });
        }
    });
}

// Đưa hàm lên global
window.initUserCreateModal = initUserCreateModal;
