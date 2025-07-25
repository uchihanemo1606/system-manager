import { create_user } from "../api/user";
import { get_all_role } from "../api/role";
import { showToast } from "../component/toast";
import { validateUserData } from "../component/requiredFields/user_required";

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
            });
        }
    }

    function renderRoles(roles) {
        roleContainer.innerHTML = "";
        roles.forEach((role) => {
            roleContainer.insertAdjacentHTML(
                "beforeend",
                `
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="role-${role.role_name}" value="${role.role_name}">
                    <label class="form-check-label" for="role-${role.role_name}">${role.role_name}</label>
                </div>
                `
            );
        });
    }

    fetchRoles();

    createUserForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(createUserForm);
        const data = Object.fromEntries(formData.entries());

        if (!validateUserData(data)) return;

        const roles = [
            ...document.querySelectorAll("#role-checkboxes input:checked"),
        ].map((el) => el.value);

        try {
            await create_user({
                username: data.username.trim(),
                password: data.password,
                fullName: data.fullName.trim(),
                email: data.email.trim(),
                roles,
            });

            showToast({
                message: "Tạo người dùng thành công!",
                type: "success",
                timeout: 2000,
            });
            $("#createUserModal").modal("hide");
            window.dispatchEvent(new CustomEvent("userCreated"));
        } catch (err) {
            showToast({
                message: err.message || "Đã xảy ra lỗi khi tạo người dùng!",
                type: "error",
                timeout: 2000,
            });
        }
    });
}

window.initUserCreateModal = initUserCreateModal;
