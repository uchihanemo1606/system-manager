import { create_software_file } from "../api/software";
import { showToast } from "../component/toast";

async function initSoftwareFileCreateModal(data) {
    console.log("initSoftwareFileCreateModal", data);

    // Gán software_id vào input
    const softwareIdInput = document.getElementById("software-id");
    if (softwareIdInput) {
        softwareIdInput.value = data.id;
        softwareIdInput.readOnly = true; // Không cho chỉnh sửa
    }

    const form = document.getElementById("create-software-file-form");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const file_name = document.getElementById("file-name").value.trim();
        const file_path = document.getElementById("file-path").value.trim();
        const description = document.getElementById("description").value.trim(); // nếu bạn cần

        try {
            const result = await create_software_file({
                software_id: data.id,
                file_name,
                file_path,
                // nếu cần gửi thêm description, thêm dòng này:
                description,
            });

            showToast({
                message: "Tạo tập tin thành công!",
                type: "success",
                timeout: 2000,
            });
            if (window.closeModal) window.closeModal(); // giả sử bạn có hàm đóng modal
        } catch (err) {
            console.error(err);
            showToast({
                message: `Lỗi khi tạo tập tin: ${err.message || "Không rõ"}`,
                type: "error",
                timeout: 3000,
            });
        }
    }); // chỉ gắn 1 lần để tránh bị trùng sự kiện nhiều lần
}

window.initSoftwareFileCreateModal = initSoftwareFileCreateModal;
