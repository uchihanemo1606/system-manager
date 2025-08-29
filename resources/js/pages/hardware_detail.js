import { get_hardware_by_ip, update_hardware } from "../api/hardware";
import {
    get_all_hardware_database,
    get_versions_by_dbname,
    get_all_hardware_os,
    get_versions_by_os
} from "../api/hardware_data";
import { validateHardwareDataUpdate } from "../component/requiredFields/hardware_required";
import { showToast } from "../component/toast";

let isEditMode = false;
const urlParams = new URLSearchParams(window.location.search);
const ip = urlParams.get("id");
const isEditParam = urlParams.get("edit") === "true";

const detailBlock = document.getElementById("hardware-detail");
const toggleBtn = document.getElementById("toggle-edit-btn");
// const addDomainBtn = document.getElementById("add-hardware-domain-btn");
const viewDomainBtn = document.getElementById("view-domain-btn");

detailBlock.style.display = "none";

if (ip) {
    get_hardware_by_ip({ ip })
        .then((hardware) => {
            if (!hardware) {
                showToast({ message: "Không tìm thấy thông tin phần cứng cho IP này.", type: "error" });
                return;
            }
            // Nếu phần cứng đã bị xóa
            if (hardware.is_delete) {
                detailBlock.innerHTML = `
                <div class="alert alert-warning text-center">
                    <i class="mdi mdi-alert-circle-outline mr-2"></i>
                    Phần cứng với IP <strong>${hardware.ip}</strong> đã bị xóa khỏi hệ thống.
                </div>
            `;
                detailBlock.style.display = "block";
                return;
            }
            renderHardwareInfo(hardware);
            detailBlock.style.display = "block";

            // addDomainBtn.addEventListener("click", () => {
            //     loadModal("hardware_domain_create", { ip: hardware.ip });
            // });

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
            console.log("Full error:", err);

            let message = "Lỗi lấy dữ liệu phần cứng.";

            if (err?.response?.status === 403) {
                message = "Bạn không có quyền xem phần cứng này.";
            } else if (err?.response?.status) {
                message = "Phần cứng không tồn tại.";
            } else if (err?.message) {
                message = err.message;
            }

            showToast({ message, type: "error" });
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

async function showField(field) {
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
        viewEl.classList.add("d-none");
        inputEl.classList.remove("d-none");

        if (field === "os") {
            const osList = await get_all_hardware_os();
            inputEl.innerHTML = osList.data
                .map(e => `<option value="${e.name}" ${e.name === viewEl.textContent.trim() ? "selected" : ""}>${e.name}</option>`)
                .join("");
            inputEl.dispatchEvent(new Event("change")); // <-- Thêm dòng này để trigger load OS version
        }

        else if (field === "osver") {
            const osValue = getValue("os");
            if (!osValue) return;
            const versionList = await get_versions_by_os(osValue);
            renderSelect(inputEl, versionList, viewEl.textContent.trim());
        }

        else if (field === "db") {
            const dbList = await get_all_hardware_database();
            inputEl.innerHTML = dbList.data
                .map(e => `<option value="${e.dbname}" ${e.dbname === viewEl.textContent.trim() ? "selected" : ""}>${e.dbname}</option>`)
                .join("");
            inputEl.dispatchEvent(new Event("change")); // <-- Thêm dòng này để trigger load DB version
        }

        else if (field === "dbver") {
            const dbValue = getValue("db");
            if (!dbValue) return;
            const versionList = await get_versions_by_dbname(dbValue);
            renderSelect(inputEl, versionList, viewEl.textContent.trim());
        }

        else {
            inputEl.value = viewEl.textContent.trim();
        }
    }
}
document.getElementById("hardware-os-input")?.addEventListener("change", async () => {
    const osverInput = document.getElementById("hardware-osver-input");
    if (!osverInput) return;
    const os = getValue("os");
    const versions = await get_versions_by_os(os);
    renderSelect(osverInput, versions.data);
});

document.getElementById("hardware-db-input")?.addEventListener("change", async () => {
    const dbverInput = document.getElementById("hardware-dbver-input");
    if (!dbverInput) return;
    const db = getValue("db");
    const versions = await get_versions_by_dbname(db);
    console.log("Versions for DB:", versions);
    renderSelect(dbverInput, versions.data);
});

function renderSelect(selectEl, options, selectedValue = "") {
    if (!selectEl || !Array.isArray(options)) {
        console.error("renderSelect - options không hợp lệ", options);
        return;
    }

    selectEl.innerHTML = options
        .map(opt => `<option value="${opt.version}" ${opt.version === selectedValue ? "selected" : ""}>${opt.version}</option>`)
        .join("");
}


const deleteBtn = document.getElementById("delete-hardware-btn");

deleteBtn.addEventListener("click", () => {
    if (!ip) {
        showToast({ message: "Không lấy được địa chỉ IP của phần cứng.", type: "error" });
        return;
    }

    if (!confirm("Bạn có chắc chắn muốn xóa phần cứng này không?")) return;

    import("../api/hardware").then(({ delete_hardware }) => {
        delete_hardware(ip)
            .then(() => {
                showToast({ message: "Xóa phần cứng thành công!", type: "success" });
                window.location.href = "/hardware_list"; // Điều hướng về danh sách hoặc trang phù hợp
            })
            .catch(err => {
                showToast({ message: err.message || "Đã xảy ra lỗi khi xóa.", type: "error" });
            });
    });
});

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

    update_hardware(data, ip)
        .then(() => {
            showToast({ message: "Cập nhật thành công!", type: "success" });

            const newIp = data.ip;
            if (newIp !== ip) {
                // Nếu IP thay đổi, chuyển hướng trang
                window.location.href = `/hardware_detail?id=${encodeURIComponent(newIp)}`;
                return;
            }

            // IP không đổi, chỉ cần load lại dữ liệu
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
