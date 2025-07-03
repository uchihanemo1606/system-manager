import { get_hardware_by_ip, update_hardware } from "../api/hardware";
import { validateHardwareDataUpdate } from "../component/requiredFields/hardware_required";
import { showToast } from "../component/toast";

let isEditMode = false;
const urlParams = new URLSearchParams(window.location.search);
const ip = urlParams.get("id");
const isEditParam = urlParams.get("edit") === "true";

const detailBlock = document.getElementById("hardware-detail");
const toggleBtn = document.getElementById("toggle-edit-btn");
const addDomainBtn = document.getElementById("add-hardware-domain-btn");
const viewDomainBtn = document.getElementById("view-domain-btn");

detailBlock.style.display = "none";

if (ip) {
    get_hardware_by_ip({ ip })
        .then((hardware) => {
            if (!hardware) {
                showToast({ message: "Không tìm thấy thông tin phần cứng cho IP này.", type: "error" });
                return;
            }

            renderHardwareInfo(hardware);
            detailBlock.style.display = "block";

            addDomainBtn.addEventListener("click", () => {
                loadModal("hardware_domain_create", { ip: hardware.ip });
            });

            viewDomainBtn.addEventListener("click", () => {
                loadModal("hardware_list_domain", { ip: hardware.ip });
            });

            if (isEditParam) {
                isEditMode = true;
                showInputFields();
                updateToggleBtn();
            }
        })
        .catch((err) => {
            console.error("Lỗi lấy dữ liệu phần cứng:", err);
            showToast({ message: "Lỗi khi lấy thông tin phần cứng. Vui lòng thử lại sau.", type: "error" });
        });
}

toggleBtn.addEventListener("click", () => {
    isEditMode = !isEditMode;
    updateURLParam("edit", isEditMode);

    if (isEditMode) {
        showInputFields();
    } else {
        saveData();
    }
    updateToggleBtn();
});

viewDomainBtn.addEventListener("click", () => {
    if (!ip) {
        showToast({ message: "Không lấy được địa chỉ ip của máy.", type: "error" });
        return;
    }
    loadModal("hardware_list_domain", { ip });
});

function renderHardwareInfo(hardware) {
    setText("hardware-ip-view", hardware.ip);
    setText("hardware-os-view", hardware.OS);
    setText("hardware-osver-view", hardware.OSver);
    setText("hardware-domain-view", hardware.domain);
    setText("hardware-hdd-view", hardware.hdd);
    setText("hardware-ram-view", hardware.ram);
    setText("hardware-db-view", hardware.dbname);
    setText("hardware-dbver-view", hardware.dbversion);
    setText("hardware-services-view", hardware.services);
    setText("hardware-updated", formatDate(hardware.updated_at));
    setText("hardware-createdby", hardware.created_by);
    setText("hardware-is-active", hardware.is_active ? "Hoạt động" : "Dừng hoạt động", hardware.is_active ? "text-success" : "text-danger");
}

function showInputFields() {
    ["ip", "os", "osver", "domain", "hdd", "ram", "db", "dbver", "services"].forEach(showField);
}

function hideInputFields() {
    ["ip", "os", "osver", "domain", "hdd", "ram", "db", "dbver", "services"].forEach(hideField);
}

function showField(field) {
    const viewEl = document.getElementById(`hardware-${field}-view`);
    const inputEl = document.getElementById(`hardware-${field}-input`);
    const groupEl = document.getElementById(`hardware-${field}-input-group`);
    const unitEl = document.getElementById(`hardware-${field}-unit`);

    if (groupEl && unitEl) {
        const [value, unit] = (viewEl.textContent || "").trim().split(" ");
        inputEl.value = parseInt(value) || "";
        unitEl.value = unit || "GB";
        viewEl.classList.add("d-none");
        groupEl.classList.remove("d-none");
    } else if (viewEl && inputEl) {
        inputEl.value = viewEl.textContent;
        viewEl.classList.add("d-none");
        inputEl.classList.remove("d-none");
    }
}

function hideField(field) {
    const viewEl = document.getElementById(`hardware-${field}-view`);
    const inputEl = document.getElementById(`hardware-${field}-input`);
    const groupEl = document.getElementById(`hardware-${field}-input-group`);
    const unitEl = document.getElementById(`hardware-${field}-unit`);

    if (groupEl && unitEl) {
        viewEl.classList.remove("d-none");
        groupEl.classList.add("d-none");
    } else if (viewEl && inputEl) {
        viewEl.classList.remove("d-none");
        inputEl.classList.add("d-none");
    }
}

function saveData() {
    const data = {
        ip: getValue("ip"),
        OS: getValue("os"),
        OSver: getValue("osver"),
        domain: getValue("domain"),
        hdd: `${getValue("hdd")} ${getUnit("hdd")}`,
        ram: `${getValue("ram")} ${getUnit("ram")}`,
        dbname: getValue("db"),
        dbversion: getValue("dbver"),
        services: getValue("services"),
    };

    if (!validateHardwareDataUpdate(data)) {
        isEditMode = true;
        updateURLParam("edit", true);
        updateToggleBtn();
        return;
    }

    update_hardware(data)
        .then(() => {
            showToast({ message: "Cập nhật thành công!", type: "success" });

            // Gọi lại dữ liệu từ server
            get_hardware_by_ip({ ip })
                .then((hardware) => {
                    renderHardwareInfo(hardware);
                    hideInputFields();
                    isEditMode = false;
                    updateURLParam("edit", false);
                    updateToggleBtn();
                    if (typeof window.fetchHardwareLogs === "function") {
                        window.fetchHardwareLogs();
                    }
                })
                .catch((err) => {
                    console.error("Lỗi lấy lại dữ liệu sau khi cập nhật:", err);
                    showToast({
                        message: "Đã lưu nhưng lỗi khi lấy lại dữ liệu. Vui lòng tải lại trang.",
                        type: "warning",
                    });
                });
        })
        .catch(err =>
            showToast({
                message: err.message || "Đã xảy ra lỗi khi cập nhật.",
                type: "error",
            })
        );
}

function setText(id, text, colorClass = "") {
    const el = document.getElementById(id);
    if (el) {
        el.textContent = text || "N/A";
        el.classList.remove("text-success", "text-danger");
        if (colorClass) el.classList.add(colorClass);
    }
}

function getValue(field) {
    const el = document.getElementById(`hardware-${field}-input`);
    return el ? el.value.trim() : "";
}

function getUnit(field) {
    const el = document.getElementById(`hardware-${field}-unit`);
    return el ? el.value : "GB";
}

function formatDate(dateString) {
    if (!dateString) return "N/A";
    const date = new Date(dateString);
    return date.toLocaleDateString("vi-VN");
}

function updateToggleBtn() {
    toggleBtn.innerHTML = isEditMode ? `<i class="mdi mdi-content-save"></i> Lưu` : `<i class="mdi mdi-pencil"></i> Sửa`;
}

function updateURLParam(key, value) {
    const url = new URL(window.location);
    if (value) {
        url.searchParams.set(key, "true");
    } else {
        url.searchParams.delete(key);
    }
    window.history.replaceState({}, "", url);
}
