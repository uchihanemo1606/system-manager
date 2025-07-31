import { update_software_file_by_id, delete_software_file_by_id } from "../api/software";
import { showToast } from "../component/toast";

async function initSoftwareFileEditModal(data) {
    console.log(data);
    const softwareFileData = data?.filedata;
    const file = data?.filedata;
    if (!file || !file.id) return;

    const form = document.getElementById("edit-software-file-form");
    const fileNameInput = document.getElementById("edit-file-name");
    const newFileInput = document.getElementById("edit-new-file");
    const descriptionInput = document.getElementById("edit-description");
    const deleteBtn = document.getElementById("delete-software-file"); 
    // Gán dữ liệu ban đầu
    fileNameInput.value = softwareFileData.file_name || "a";
    descriptionInput.value = softwareFileData.description || "a"; 
    form.onsubmit = async (e) => {
        e.preventDefault();

        const software_id = file.software_id;
        const file_name = fileNameInput.value.trim();
        const description = descriptionInput.value.trim();
        const newFile = newFileInput.files[0];

        try {
            await update_software_file_by_id(file.id, {
                software_id,
                file_name,
                file: newFile, // có thể là undefined nếu không chọn file mới
                description,
            });

            showToast({ message: "Cập nhật thành công", type: "success" });
            window.dispatchEvent(new Event("softwareFileUpdated"));
        } catch (err) {
            showToast({
                message: err?.message || "Cập nhật thất bại",
                type: "error",
            });
        }
    };

    // Xóa tập tin
    deleteBtn.onclick = async () => {
        const confirmed = confirm(`Bạn có chắc chắn muốn xóa tập tin "${file.file_name}" không?`);
        if (!confirmed) return;

        try {
            await delete_software_file_by_id(file.id);
            showToast({ message: "Đã xóa tập tin thành công", type: "success" });
            window.dispatchEvent(new Event("softwareFileUpdated"));
        } catch (err) {
            showToast({ message: err.message || "Xóa thất bại", type: "error" });
        }
    };
}

window.initSoftwareFileEditModal = initSoftwareFileEditModal;
