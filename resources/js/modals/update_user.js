import { get_user_by_username, updateuserbyadmin } from "../api/user";
import { showToast } from "../component/toast";

function initUpdateUserModal(data) {
    const username = data.username;
    const profileForm = document.getElementById("update-user-form");
    if (!profileForm) {
        console.error("Không tìm thấy form cập nhật");
        return;
    }

    async function fetchProfile() {
        try {
            const user = await get_user_by_username(username);
            renderProfile(user);
        } catch (err) {
            console.error("Lỗi khi tải thông tin người dùng:", err);
        }
    }

    function renderProfile(userData) {
        if (!userData) return;
        document.getElementById("username").value = userData.username || "";
        document.getElementById("fullName").value = userData.fullName || "";
        document.getElementById("email").value = userData.email || "";
    }

    // Mở modal thì gọi fetchProfile để load dữ liệu mới nhất
    fetchProfile();

    profileForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(profileForm);
        const userData = Object.fromEntries(formData.entries());

        try {
            await updateuserbyadmin(userData);
            showToast("Cập nhật người dùng thành công!", "success"); 
            // Phát sự kiện reload danh sách user
            window.dispatchEvent(new Event('userUpdated'));
        } catch (err) {
            console.error("Lỗi khi cập nhật:", err);
            alert(err.message || "Có lỗi xảy ra khi cập nhật");
        }

    });
}

window.initUpdateUserModal = initUpdateUserModal;
