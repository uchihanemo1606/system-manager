import { get_profile, update_profile } from "../api/user";
import { validateUserDataUpdate } from "../component/requiredFields/user_required";
import { showToast } from "../component/toast";

function initProfileModal() {
    const profileForm = document.getElementById("profile-form");
    if (!profileForm || profileForm.dataset.initialized) return;
    profileForm.dataset.initialized = "true";

    const editBtn = document.getElementById("edit-btn");
    const saveBtn = document.getElementById("save-btn");
    const cancelBtn = document.getElementById("cancel-btn");

    async function fetchProfile() {
        try {
            const profile = await get_profile();
            renderProfile(profile);
            setReadOnly(true);
        } catch (err) {
            console.error("Lỗi khi tải profile:", err);
        }
    }

    function renderProfile(userData) {
        ["username", "fullName", "email", "phone_number"].forEach((id) => {
            document.getElementById(id).value = userData[id] || "";
        });
    }

    function setReadOnly(isReadOnly) {
        ["fullName",  "phone_number"].forEach((id) => {
            document.getElementById(id).readOnly = isReadOnly;
        });
        editBtn.classList.toggle("d-none", !isReadOnly);
        saveBtn.classList.toggle("d-none", isReadOnly);
        cancelBtn.classList.toggle("d-none", isReadOnly);
    }

    editBtn.addEventListener("click", () => setReadOnly(false));
    cancelBtn.addEventListener("click", fetchProfile);

    profileForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(profileForm).entries());
        if (!validateUserDataUpdate(data, "profile")) return;

        try {
            await update_profile(data);
            showToast({
                message: "Cập nhật thông tin thành công!",
                type: "success",
                timeout: 2000,
            });
            fetchProfile();
        } catch (err) {
            showToast({
                message: err.message || "Có lỗi xảy ra khi cập nhật thông tin!",
                type: "error",
                timeout: 2000,
            });
        }
    });

    fetchProfile();
}

window.initProfileModal = initProfileModal;
