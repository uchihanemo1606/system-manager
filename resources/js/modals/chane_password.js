import { chane_password } from "../api/user";
import { showToast } from "../component/toast"; // nếu bạn dùng showToast

async function initChanePasswordModal() {
    const form = document.getElementById("changePasswordForm");
    form.reset(); // Xóa dữ liệu cũ nếu có

    form.onsubmit = async (e) => {
        e.preventDefault();

        const currentPassword = document.getElementById("current-password").value.trim();
        const newPassword = document.getElementById("new-password").value.trim();
        const confirmPassword = document.getElementById("confirm-password").value.trim();

        if (newPassword !== confirmPassword) {
            showToast({ message: "Mật khẩu mới không khớp xác nhận!", type: "error" });
            return;
        }

        try {
            const res = await chane_password({
                current_password: currentPassword,
                new_password: newPassword
            });

            if (res.success) {
                showToast({ message: "Đổi mật khẩu thành công!", type: "success" });
            } else {
                showToast({ message: res.message || "Đổi mật khẩu thất bại!", type: "success" });
            }
            fetch("/api/logout", {
                method: "POST",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("jwt_token"),
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.status === "success") {
                        localStorage.removeItem("jwt_token");
                        window.location.href = "/login";
                    } else {
                        alert("Logout failed");
                    }
                });
        } catch (err) {
            console.error(err);
            showToast({ message: "Lỗi khi đổi mật khẩu!", type: "error" });
        }
    };
}

window.initChanePasswordModal = initChanePasswordModal;
