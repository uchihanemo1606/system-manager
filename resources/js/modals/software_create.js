import { create_software } from "../api/software";
import { showToast } from "../component/toast";

async function initSoftwareCreateModal() {
    const form = document.getElementById("software-form");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
 
        try {
            const res = await create_software(data);
            showToast({
                message: res.message || "Tạo phần mềm thành công!",
                type: "success",
                timeout: 2000,
            });
            form.reset();
            window.dispatchEvent(new CustomEvent("softwareCreated"));
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
