// Gộp tất cả mã thành một file hoàn chỉnh

import {
    get_all_hardware_database, 
    get_versions_by_dbname,
    get_all_hardware_os,
    get_versions_by_os,
    create_hardware_database,
    create_hardware_database_version,
    create_hardware_os,
    create_hardware_os_version
} from "../api/hardware_data";
import { create_hardware } from "../api/hardware";
import { showToast } from "../component/toast";
import { validateHardwareData } from "../component/requiredFields/hardware_required";

async function populateDropdowns() {
    const dbSelect = document.querySelector("select[name='dbname']");
    const dbVersionSelect = document.querySelector("select[name='dbversion']");
    const osSelect = document.querySelector("select[name='OS']");
    const osVersionSelect = document.querySelector("select[name='OSver']");

    dbVersionSelect.disabled = true;
    osVersionSelect.disabled = true;

    const dbs = await get_all_hardware_database();
    const oss = await get_all_hardware_os();
    const uniqueDbNames = [...new Set(dbs.data.map(d => d.dbname))];
    const uniqueOSNames = [...new Set(oss.data.map(o => o.name))];

    dbSelect.innerHTML = `<option></option>` + uniqueDbNames.map(name => `<option value="${name}">${name}</option>`).join('');
    osSelect.innerHTML = `<option></option>` + uniqueOSNames.map(name => `<option value="${name}">${name}</option>`).join('');

    $(".select2").select2({
        width: "100%",
        placeholder: "Chọn hoặc tìm...",
        allowClear: true,
        dropdownParent: $('#hardware-form')
    });

    $(dbSelect).on("change", async function () {
        const name = this.value;
        dbVersionSelect.disabled = true;
        dbVersionSelect.innerHTML = `<option></option>`;
        $(dbVersionSelect).val(null).trigger('change');

        if (!name) return;

        try {
            const res = await get_versions_by_dbname(name);
            console.log(res)
            dbVersionSelect.innerHTML = `<option></option>` + res.data.map(ver => `<option value="${ver.version}">${ver.version}</option>`).join('');
            dbVersionSelect.disabled = false;
        } catch (err) {
            console.error("Lỗi lấy phiên bản DB:", err);
        }
    });

    $(osSelect).on("change", async function () {
        const name = this.value;
        osVersionSelect.disabled = true;
        osVersionSelect.innerHTML = `<option></option>`;
        $(osVersionSelect).val(null).trigger('change');

        if (!name) return;

        try {
            const res = await get_versions_by_os(name);
            osVersionSelect.innerHTML = `<option></option>` + res.data.map(ver => `<option value="${ver.version}">${ver.version}</option>`).join('');
            osVersionSelect.disabled = false;
        } catch (err) {
            console.error("Lỗi lấy phiên bản OS:", err);
        }
    });
}
window.populateDropdowns = populateDropdowns;

window.initHardwareCreateModal = async function () {
    await populateDropdowns();

    const form = document.getElementById("hardware-form");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // Chuyển kiểu bool
        data.isVirtualServer = data.isVirtualServer === "1";

        // Gộp RAM và HDD, sau đó loại bỏ *_unit
        data.hdd = `${data.hdd} ${data.hdd_unit}`;
        data.ram = `${data.ram} ${data.ram_unit}`;
        delete data.hdd_unit;
        delete data.ram_unit;

        // Thêm trường mặc định nếu cần
        data.is_active = true;

        if (!validateHardwareData(data)) return;

        try {
            const res = await create_hardware(data);
            showToast({ message: res.message || "Tạo phần cứng thành công!", type: "success" });

            setTimeout(() => {
                window.location.href = `/hardware_detail?id=${encodeURIComponent(data.ip)}`;
            }, 1000); // chờ 1s cho người dùng thấy thông báo

        } catch (err) {
            showToast({ message: err.message || "Lỗi khi tạo phần cứng.", type: "error" });
        }
    });
};

window.initHardwareDataCreateModal = function (data) {
    const form = document.getElementById("create-os-form");
    const nameInput = document.getElementById("os-name");
    const versionInput = document.getElementById("os-version");
    const title = document.getElementById("modal-title");
    const labelName = document.getElementById("label-name");
    const labelVersion = document.getElementById("label-version");

    form.reset();
    nameInput.disabled = false;
    nameInput.classList.remove("disabled-input");


    const type = data.type;
    const isDb = type.includes("db");
    labelName.textContent = isDb ? "Tên CSDL" : "Tên Hệ Điều Hành";
    labelVersion.textContent = isDb ? "Phiên bản CSDL" : "Phiên bản HĐH";

    const titleMap = {
        dbname: "Tạo Tên CSDL Mới",
        dbversion: "Tạo Phiên Bản CSDL",
        OS: "Tạo Hệ Điều Hành Mới",
        OSver: "Tạo Phiên Bản HĐH"
    };
    title.textContent = titleMap[type] || "Tạo Dữ Liệu";

    if (type === "dbversion" && data.data?.dbname) {
        nameInput.value = data.data.dbname;
        nameInput.disabled = true;
        nameInput.classList.add("disabled-input");
    }
    if (type === "OSver" && data.data?.OS) {
        nameInput.value = data.data.OS;
        nameInput.disabled = true;
        nameInput.classList.add("disabled-input");
    }


    form.onsubmit = async function (e) {
        e.preventDefault();
        const name = nameInput.value.trim();
        const version = versionInput.value.trim();

        if (!name || !version) {
            showToast({ message: "Vui lòng nhập đầy đủ thông tin", type: "error" });
            return;
        }

        try {
            if (isDb) {
                if (type === "dbname") {
                    try {
                        await create_hardware_database({ dbname: name });
                    } catch (err) {
                        if (err.message.includes("Duplicate entry")) {
                            showToast({ message: "Tên database đã tồn tại!", type: "error" });
                            return; // Không tạo version nếu đã tồn tại
                        } else {
                            throw err;
                        }
                    }
                }

                // Tạo version nếu không phải đang tạo tên mới hoặc tên mới đã tạo thành công
                await create_hardware_database_version({ dbname: name, version: version });

            } else {
                if (type === "OS") {
                    try {
                        await create_hardware_os({ name: name, architecture: "bug", version_description: "bug" });
                    } catch (err) {
                        if (err.message.includes("Duplicate entry")) {
                            showToast({ message: "Tên hệ điều hành đã tồn tại!", type: "error" });
                            return; // Không tạo version nếu đã tồn tại
                        } else {
                            throw err;
                        }
                    }
                }

                await create_hardware_os_version({ os_name: name, version: version });
            }

            showToast({ message: "Tạo thành công!", type: "success" });

            if (typeof data.onSuccess === "function") {
                await data.onSuccess();
            } else {
                await populateDropdowns();
            }

            $('#hardware-data-modal').modal('hide');

        } catch (err) {
            showToast({ message: err.message || "Lỗi khi tạo dữ liệu.", type: "error" });
        }

    };


};

window.openCreateModal = function (type, data = {}, onSuccess = null) {
    if ((type === "dbversion" && !data.dbname) || (type === "OSver" && !data.OS)) {
        showToast(
            { message: `! vui lòng chọn ${type === "dbversion" ? "Tên Database" : "Hệ Điều Hành"} trước`, type: "info" }
        )
        return;
    }

    // Lưu thông tin modal
    window.currentModalData = { type, data, onSuccess };
    initHardwareDataCreateModal(window.currentModalData);

    // Mở modal
    $('#hardware-data-modal').modal('show');
};
