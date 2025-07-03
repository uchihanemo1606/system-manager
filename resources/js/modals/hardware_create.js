import { create_hardware } from "../api/hardware";
import { showToast } from "../component/toast"; 
import { validateHardwareData } from "../component/requiredFields/hardware_required";

async function initHardwareCreateModal() {
    const form = document.getElementById("hardware-form"); // Bắt form từ DOM

    form.addEventListener("submit", async (e) => {
        e.preventDefault(); // Ngăn reload

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        data.isVirtualServer = data.isVirtualServer === "1";
        data.hdd = `${data.hdd} ${data.hdd_unit}`;
        data.ram = `${data.ram} ${data.ram_unit}`;

        if (!validateHardwareData(data)) return;

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
                message: err.message || "Lỗi khi tạo phần cứng.",
                type: "error",
                timeout: 3000,
            });
        }
    });
}

window.initHardwareCreateModal = initHardwareCreateModal;
