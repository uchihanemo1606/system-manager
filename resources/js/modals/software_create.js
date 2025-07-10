import { create_software } from "../api/software";
import { showToast } from "../component/toast";
import { validateSoftwareData } from "../component/requiredFields/software_required";

async function initSoftwareCreateModal() {
    const form = document.getElementById("software-form");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        if (!validateSoftwareData(data)) return;

        try {
            const res = await create_software(data);
            showToast({
                message: res.message || "Tạo phần mềm thành công!",
                type: "success",
                timeout: 1000,
            });

            // Nếu API trả về ID phần mềm vừa tạo
            console.log(res)
            if (res.data.id) {
                const id = res.data.id;
                setTimeout(() => {
                    window.location.href = `/software_detail?id=${encodeURIComponent(id)}`;
                }, 1000); // chờ hiển thị toast xong rồi mới chuyển trang
            } else {
                // fallback nếu không có ID trả về
                form.reset();
                window.dispatchEvent(new CustomEvent("softwareCreated"));
            }
        } catch (err) {
            showToast({
                message: err?.message || "Có lỗi xảy ra!",
                type: "error",
                timeout: 2000,
            });
        }

    });
}

window.initSoftwareCreateModal = initSoftwareCreateModal;

document.addEventListener("DOMContentLoaded", () => {
    initSoftwareCreateModal();
});
