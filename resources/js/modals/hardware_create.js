import { create_hardware } from "../api/hardware";
import { showToast } from "../component/toast";
import { closeModal } from "../component/modal";

async function initHardwareCreateModal(data) {
    const form = document.getElementById("hardware-form");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        data.isVirtualServer = data.isVirtualServer === "1";

        try {
            const res = await create_hardware(data);
            showToast({
                message: res.message || "Tạo phần cứng thành công!",
                type: "success",
                timeout: 2000,
            });
            form.reset(); 
            window.dispatchEvent(new CustomEvent("hardwareCreated"));
        } catch (err) {
            showToast({
                message: err.message || "Có lỗi xảy ra!",
                type: "error",
                timeout: 2000,
            });
        }
    });
}

window.initHardwareCreateModal = initHardwareCreateModal;
