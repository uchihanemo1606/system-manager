import { get_profile, update_profile } from "../api/user";
import { formatDateTime } from "../component/formatDateTime";

function initProfileModal() {
    const profileForm = document.getElementById("profile-form");
    if (!profileForm) {
        console.error("Không tìm thấy form profile");
        return;
    }
    if (profileForm.dataset.initialized) return;
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
        if (!userData) return;
        document.getElementById("username").value = userData.username || "";
        document.getElementById("fullName").value = userData.fullName || "";
        document.getElementById("email").value = userData.email || "";
        document.getElementById("phone_number").value =
            userData.phone_number || "";
        // document.getElementById("created_at").value = userData.created_at || "";
        document.getElementById("created_at").innerText = formatDateTime(
            userData.created_at
        );
    }

    function setReadOnly(isReadOnly) {
        ["fullName", "email", "phone_number"].forEach((id) => {
            document.getElementById(id).readOnly = isReadOnly;
        });

        editBtn.classList.toggle("d-none", !isReadOnly);
        saveBtn.classList.toggle("d-none", isReadOnly);
        cancelBtn.classList.toggle("d-none", isReadOnly);
    }
    editBtn.addEventListener("click", () => setReadOnly(false));
    cancelBtn.addEventListener("click", () => {
        fetchProfile();
    });
    profileForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(profileForm);
        const data = Object.fromEntries(formData.entries());

        try {
            await update_profile(data);
            alert("Cập nhật profile thành công!");
            fetchProfile();
        } catch (err) {
            console.error("Lỗi khi cập nhật profile:", err);
            alert(err.message || "Có lỗi xảy ra khi cập nhật profile");
        }
    });
    fetchProfile();
}

window.initProfileModal = initProfileModal;
