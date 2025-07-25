import { create_hardware_os_data, create_hardware_database } from '../api/hardware_data.js';
import { showToast } from '../component/toast.js';

window.initHardwareDataCreateModal = function (data) {
    console.log('is run', data);

    const form = document.getElementById("create-os-form");
    const nameInput = document.getElementById("os-name");
    const versionInput = document.getElementById("os-version");
    const title = document.getElementById("modal-title");
    const labelName = document.getElementById("label-name");
    const labelVersion = document.getElementById("label-version");

    // Reset form & enable inputs
    form.reset();
    nameInput.disabled = false;

    const type = data.type;

    // Set dynamic labels & title
    const isDb = type.includes("db");
    const nameLabel = isDb ? "Tên CSDL" : "Tên Hệ Điều Hành";
    const versionLabel = isDb ? "Phiên bản CSDL" : "Phiên bản HĐH";

    labelName.textContent = nameLabel;
    labelVersion.textContent = versionLabel;

    const titleMap = {
        dbname: "Tạo Tên CSDL Mới",
        dbversion: "Tạo Phiên Bản CSDL",
        OS: "Tạo Hệ Điều Hành Mới",
        OSver: "Tạo Phiên Bản HĐH"
    };
    title.textContent = titleMap[type] || "Tạo Dữ Liệu";

    // Nếu là tạo phiên bản, gán tên sẵn & disable
    if (type === "dbversion" && data.data?.dbname) {
        nameInput.value = data.data.dbname;
        nameInput.disabled = true;
    }
    if (type === "OSver" && data.data?.OS) {
        nameInput.value = data.data.OS;
        nameInput.disabled = true;
    }

    // Submit handler
    form.onsubmit = async function (e) {
        e.preventDefault();

        const name = nameInput.value.trim();
        const version = versionInput.value.trim();

        if (!name || !version) {
            showToast("Vui lòng nhập đầy đủ thông tin", "error");
            return;
        }

        try {
            if (isDb) {
                await create_hardware_database({ dbname: name, dbversion: version });
            } else {
                await create_hardware_os_data({ OS: name, OSver: version });
            }

            showToast("Tạo thành công!", "success");
            // Bạn có thể gọi reload select2 dropdown ở đây nếu muốn
            // Ví dụ: reloadSelectOptions('select[name=OS]');
        } catch (error) {
            console.error(error);
            showToast("Đã có lỗi xảy ra", "error");
        }
    };
};
