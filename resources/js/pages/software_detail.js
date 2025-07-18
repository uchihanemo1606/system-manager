import { get_domain_software } from "../api/domain";
import { get_software_by_id, update_software } from "../api/software";
import { renderDomainList } from "../component/domain/render_domain_list";

import { showToast } from "../component/toast";

const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get("id");
const isEditParam = urlParams.get("edit") === "true";

let isEditMode = false;
const detailBlock = document.getElementById("software-detail");
detailBlock.style.display = "none";

const toggleBtn = document.getElementById("toggle-edit-btn");

if (id) {
    get_domain_software(id)
        .then((domains) => {
            renderDomainList(domains);
        })
        .catch((err) => {
            console.error(err);
            showToast({
                message: "Lỗi lấy danh sách tên miền.",
                type: "error",
                timeout: 3000,
            });
        });

    get_software_by_id({ id })
        .then(({ data: software }) => {
            if (!software) {
                showToast({
                    message: "Không tìm thấy phần mềm.",
                    type: "error",
                    timeout: 3000,
                });
                return;
            }

            setTextOrCreate(
                "software-name-view",
                software.softwareName || "N/A"
            );
            setTextOrCreate(
                "software-language-view",
                software.language || "N/A"
            );
            setTextOrCreate("software-version-view", software.version || "N/A");
            setTextOrCreate(
                "software-description-view",
                software.description || "N/A"
            );
            setTextOrCreate(
                "software-createdby-view",
                software.user_createby || "N/A"
            );
            setTextOrCreate(
                "software-created-view",
                formatDate(software.created_at)
            );
            setTextOrCreate(
                "software-updated-view",
                formatDate(software.updated_at)
            );
            setTextOrCreate(
                "software-is-delete-view",
                software.is_delete ? "Đã xóa" : "Đang hoạt động",
                software.is_delete ? "text-danger" : "text-success"
            );
            detailBlock.style.display = "block";
            document
                .getElementById("add_domain")
                .setAttribute("data-software", JSON.stringify(software));
            if (isEditParam) {
                isEditMode = true;
                toggleBtn.innerHTML = `<i class="mdi mdi-content-save"></i> Lưu`;
                switchToEdit();
            }
        })
        .catch((err) => {
            console.error(err);
            showToast({
                message: "Lỗi lấy dữ liệu phần mềm.",
                type: "error",
                timeout: 3000,
            });
        });
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
    toggleDisplay("software-name");
    toggleDisplay("software-language");
    toggleDisplay("software-version");
    toggleDisplay("software-description");
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
        id: id,
        softwareName: getInputValue("software-name"),
        language: getInputValue("software-language"),
        version: getInputValue("software-version"),
        description: getInputValue("software-description"),
    }; 
    switchToEdit();

    for (let key in data) {
        const viewEl = document.getElementById(`${key}-view`);
        const inputEl = document.getElementById(`${key}-input`);
        if (viewEl && inputEl) {
            viewEl.textContent = data[key];
        }
    }

    update_software(data)
        .then(() => {
            showToast({ message: "Cập nhật thành công!", type: "success" });
        })
        .catch((err) => {
            showToast({ message: err.message, type: "error" });
        });
}

function getInputValue(field) {
    const el = document.getElementById(`${field}-input`);
    return el ? el.value : "";
}

function setTextOrCreate(id, text, colorClass = "") {
    const el = document.getElementById(id);
    if (el) {
        el.textContent = text;
        el.classList.remove("text-success", "text-danger");
        if (colorClass) el.classList.add(colorClass);
    }
}

function formatDate(dateString) {
    if (!dateString) return "N/A";
    const date = new Date(dateString);
    return date.toLocaleDateString("vi-VN");
}
