import { get_hardware_by_ip, update_hardware } from "../api/hardware";
import { showToast } from "../component/toast";

let isEditMode = false;
const urlParams = new URLSearchParams(window.location.search);
const ip = urlParams.get("id");
const detailBlock = document.getElementById("hardware-detail");
detailBlock.style.display = "none"; 
const isEditParam = urlParams.get("edit") === "true";
const toggleBtn = document.getElementById("toggle-edit-btn"); 
const addDomainBtn = document.getElementById("add-hardware-domain-btn");
const viewDomainBtn = document.getElementById("view-domain-btn"); 
if (ip) {
    get_hardware_by_ip({ ip })
        .then((hardware) => {
            if (!hardware) {
                showToast({
                    message: "Không tìm thấy thông tin phần cứng cho IP này.",
                    type: "error",
                });
                return;
            }

            // Hiển thị thông tin
            setTextOrCreate("hardware-ip-view", hardware.ip || "N/A");
            setTextOrCreate("hardware-os-view", hardware.OS || "N/A");
            setTextOrCreate("hardware-osver-view", hardware.OSver || "N/A");
            setTextOrCreate("hardware-domain-view", hardware.domain || "N/A");
            setTextOrCreate("hardware-hdd-view", hardware.hdd || "N/A");
            setTextOrCreate("hardware-ram-view", hardware.ram || "N/A");
            setTextOrCreate("hardware-db-view", hardware.dbname || "N/A");
            setTextOrCreate("hardware-dbver-view", hardware.dbversion || "N/A");
            setTextOrCreate(
                "hardware-services-view",
                hardware.services || "N/A"
            );
            setTextOrCreate(
                "hardware-updated",
                formatDate(hardware.updated_at)
            );
            setTextOrCreate("hardware-createdby", hardware.created_by || "N/A");
            setTextOrCreate(
                "hardware-is-active",
                hardware.is_active ? "Hoạt động" : "Dừng hoạt động",
                hardware.is_active ? "text-success" : "text-danger"
            );

            detailBlock.style.display = "block";

            // Chỉ bắt sự kiện sau khi có dữ liệu chính xác
            addDomainBtn.addEventListener("click", () => {
                loadModal("hardware_domain_create", { ip: hardware.ip });
            });

            viewDomainBtn.addEventListener("click", () => {
                loadModal("hardware_list_domain", { ip: hardware.ip });
            });

            if (isEditParam) {
                isEditMode = true;
                toggleBtn.innerHTML = `<i class="mdi mdi-content-save"></i> Lưu`;
                switchToEdit();
            }
        })
        .catch((err) => {
            console.error("Lỗi lấy dữ liệu phần cứng:", err);
            showToast({
                message:
                    "Lỗi khi lấy thông tin phần cứng. Vui lòng thử lại sau.",
                type: "error",
                timeout: 3000,
            });
        });
}

viewDomainBtn.addEventListener("click", function () {
    if (!ip) {
        showToast({
            message: "Không lấy được địa chỉ ip của máy.",
            type: "error",
            timeout: 3000,
        });
        return;
    }
    loadModal("hardware_list_domain", { ip: ip });
});

function setTextOrCreate(id, text, colorClass = "") {
    let el = document.getElementById(id);
    if (el) {
        el.textContent = text;
        el.classList.remove("text-success", "text-danger"); // Xóa class cũ
        if (colorClass) el.classList.add(colorClass); // Thêm class mới nếu có
    } else {
        console.warn(`Phần tử với id ${id} không tồn tại.`);
    }
}
function formatDate(dateString) {
    if (!dateString) return "N/A";
    const date = new Date(dateString);
    return date.toLocaleDateString("vi-VN");
}
toggleBtn.addEventListener("click", () => {
    isEditMode = !isEditMode;
    const url = new URL(window.location);
    url.searchParams.set("edit", isEditMode ? "true" : "false");
    window.history.replaceState({}, "", url);
    if (isEditMode) {
        toggleBtn.innerHTML = `<i class="mdi mdi-content-save"></i> Lưu`;
        switchToEdit();
    } else {
        toggleBtn.innerHTML = `<i class="mdi mdi-pencil"></i> Sửa`;
        saveData();
    }
});

function switchToEdit() {
    toggleDisplay("hardware-ip");
    toggleDisplay("hardware-os");
    toggleDisplay("hardware-osver");
    toggleDisplay("hardware-domain");
    toggleDisplay("hardware-hdd");
    toggleDisplay("hardware-ram");
    toggleDisplay("hardware-db");
    toggleDisplay("hardware-dbver");
    toggleDisplay("hardware-services");
}

function toggleDisplay(field) {
    const viewEl = document.getElementById(`${field}-view`);
    const inputEl = document.getElementById(`${field}-input`);

    if (viewEl && inputEl) {
        inputEl.value = viewEl.textContent;
        viewEl.classList.toggle("d-none");
        inputEl.classList.toggle("d-none");
    }
}

function saveData() {
    const data = {
        ip: getInputValue("hardware-ip"),
        OS: getInputValue("hardware-os"),
        OSver: getInputValue("hardware-osver"),
        domain: getInputValue("hardware-domain"),
        hdd: getInputValue("hardware-hdd"),
        ram: getInputValue("hardware-ram"),
        dbname: getInputValue("hardware-db"),
        dbversion: getInputValue("hardware-dbver"),
        services: getInputValue("hardware-services"),
    };
    // Ẩn input, hiện text
    switchToEdit();

    // Cập nhật giao diện
    for (let key in data) {
        const viewEl = document.getElementById(`${key}-view`);
        const inputEl = document.getElementById(`${key}-input`);
        if (viewEl && inputEl) {
            viewEl.textContent = data[key];
        }
    }
    update_hardware(data)
        .then((res) =>
            showToast({ message: "Cập nhật thành công!", type: "success" })
        )
        .catch((err) => showToast({ message: err.message, type: "error" }));
}

function getInputValue(field) {
    const el = document.getElementById(`${field}-input`);
    return el ? el.value : "";
}
