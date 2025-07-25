import { update_software_file_by_id, delete_software_file_by_id } from "../api/software";
import { showToast } from "../component/toast";

async function initSoftwareFileEditModal(data) {
    const file = data?.filedata;
    if (!file || !file.id) return;

    const form = document.getElementById("edit-software-file-form");
    const fileNameInput = document.getElementById("edit-file-name");
    // const filePathInput = document.getElementById("edit-file-path");
    const descriptionInput = document.getElementById("edit-description");
    const deleteBtn = document.getElementById("delete-software-file");
    const fileLink = document.getElementById("edit-file-link");
    const fileLinkText = document.getElementById("edit-file-link-text");
    fileLink.href = file.file_path || "#";
    fileLinkText.textContent = file.file_path || "Không có đường dẫn";

    // Gán giá trị ban đầu
    fileNameInput.value = file.file_name || "";
    // filePathInput.value = file.file_path || "";
    descriptionInput.value = file.description || "";

    // Sửa
    form.onsubmit = async (e) => {
        e.preventDefault();

        const updatedData = {
            software_id: file.software_id,
            file_name: fileNameInput.value.trim(),
            file_path: file.file_path, // dùng lại đường dẫn cũ vì không thay đổi
            description: descriptionInput.value.trim(),
        };

        try {
            await update_software_file_by_id(file.id, updatedData);
            showToast({ message: "Cập nhật thành công", type: "success" });
            window.dispatchEvent(new Event("softwareFileUpdated"));
        } catch (err) {
            showToast({ message: err.message || "Cập nhật thất bại", type: "error" });
        }
    };


    // Xóa
    deleteBtn.onclick = async () => {
        const confirmed = confirm(`Bạn có chắc chắn muốn xóa tập tin "${file.file_name}" không?`);
        if (!confirmed) return;

        try {
            await delete_software_file_by_id(file.id);
            showToast({ message: "Đã xóa tập tin thành công", type: "success" });
            window.dispatchEvent(new Event("softwareFileUpdated"));
            // Nếu bạn dùng modal có đóng tự động, gọi thêm closeModal();
        } catch (err) {
            showToast({ message: err.message || "Xóa thất bại", type: "error" });
        }
    };
}

window.initSoftwareFileEditModal = initSoftwareFileEditModal;
