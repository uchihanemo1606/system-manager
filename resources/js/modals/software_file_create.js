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
        const fileInput = document.getElementById("file-path");
        const file = fileInput.files[0]; // Lấy file thực
        const description = document.getElementById("description").value.trim();

        if (!file) {
            showToast({ message: "Vui lòng chọn tập tin.", type: "error" });
            return;
        }

        try {
            const result = await create_software_file({
                software_id: data.id,
                file_name,
                file,
                description,
            });
            window.dispatchEvent(new Event("softwareFileCreated"));
            showToast({
                message: "Tạo tập tin thành công!",
                type: "success",
                timeout: 2000,
            });
        } catch (err) {
            console.error(err);
            showToast({
                message: `Lỗi khi tạo tập tin: ${err.message || "Không rõ"}`,
                type: "error",
                timeout: 3000,
            });
        }
    });

}

window.initSoftwareFileCreateModal = initSoftwareFileCreateModal;
