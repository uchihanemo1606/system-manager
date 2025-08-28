import { get_domain_software } from "../api/domain";
import { delete_software, get_software_by_id, update_software } from "../api/software";
import { renderDomainList } from "../component/domain/render_domain_list";
import { showToast } from "../component/toast";

const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get("id");
const isEditParam = urlParams.get("edit") === "true";

const detailBlock = document.getElementById("software-detail");
const toggleBtn = document.getElementById("toggle-edit-btn");

let isEditMode = false;

if (id) {
    loadDomainList(id);
    loadSoftware(id);
    window.addEventListener("domainCreated", () => {
        if (id) loadDomainList(id);
    });
    window.addEventListener("domainUpdated", () => {
        if (id) loadDomainList(id);
    });
}

toggleBtn?.addEventListener("click", handleToggleEdit);
document.getElementById("software-delete-btn")?.addEventListener("click", async () => {
    if (!confirm("Bạn có chắc muốn xóa phần mềm này?")) return;

    try {
        await delete_software({ id });
        showToast({ message: "Xóa phần mềm thành công!", type: "success" });

        // Redirect hoặc reload
        // window.location.href = "/software_list"; // hoặc nơi bạn muốn quay lại
    } catch (err) {
        showToast({ message: err.message || "Lỗi khi xóa phần mềm.", type: "error" });
    }
});

function handleToggleEdit() {
    isEditMode = !isEditMode;
    updateURLParam("edit", isEditMode);

    if (isEditMode) {
        showInputFields();
    } else {
        saveData();
    }
    updateToggleBtn();
}

function loadDomainList(softwareId) {
    get_domain_software(softwareId)
        .then(renderDomainList)
        .catch(() => console.log({ message: "Lỗi lấy danh sách tên miền.", type: "error" }));
}

function loadSoftware(softwareId) {
    get_software_by_id({ id: softwareId })
        .then(({ data }) => {
            console.log(data); 
            if (data.is_delete) {
                document.getElementById("software-deleted-warning").classList.remove("d-none");
                detailBlock.style.display = "none";
                document.getElementById("toggle-edit-btn")?.classList.add("d-none");
                document.getElementById("software-delete-btn")?.classList.add("d-none");
                return;
            }

            // Nếu chưa bị xóa → render info
            renderSoftwareInfo(data);
            detailBlock.style.display = "block";

            document.getElementById("add_domain").dataset.software = JSON.stringify(data);
            if (isEditParam) {
                isEditMode = true;
                showInputFields();
            }
            updateToggleBtn();
        })
        .catch((err) => {
            console.log("Full error:", err);

            let message = "Lỗi lấy dữ liệu phần mềm.";

            if (err?.response?.status === 403) {
                message = "Bạn không có quyền xem phần mềm này.";
            } else if (err?.response?.status) {
                message = "Phần mềm không tồn tại.";
            } else if (err?.message) {
                message = err.message;
            }

            showToast({ message, type: "error" });
        });


}

function renderSoftwareInfo(software) {
    setText("software-name-view", software.softwareName);
    setText("software-language-view", software.language);
    setText("software-version-view", software.version);
    setText("software-description-view", software.description);
    setText("software-createdby-view", software.user_createby);
    setText("software-created-view", formatDate(software.created_at));
    setText("software-updated-view", formatDate(software.updated_at));
    setText("software-is-delete-view", software.is_delete ? "Đã xóa" : "Hoạt động", software.is_delete ? "text-danger" : "text-success");
}

function showInputFields() {
    ["name", "language", "version", "description"].forEach(field => toggleField(field, true));
}

function hideInputFields() {
    ["name", "language", "version", "description"].forEach(field => toggleField(field, false));
}

function toggleField(field, showInput) {
    const viewEl = document.getElementById(`software-${field}-view`);
    const inputEl = document.getElementById(`software-${field}-input`);

    if (viewEl && inputEl) {
        if (showInput) inputEl.value = viewEl.textContent;
        viewEl.classList.toggle("d-none", showInput);
        inputEl.classList.toggle("d-none", !showInput);
    }
}

function saveData() {
    const data = {
        softwareName: getValue("name"),
        language: getValue("language"),
        version: getValue("version"),
        description: getValue("description"),
    };

    update_software({ id, ...data })
        .then(() => {
            setText("software-name-view", data.softwareName);
            setText("software-language-view", data.language);
            setText("software-version-view", data.version);
            setText("software-description-view", data.description);

            hideInputFields();
            isEditMode = false;
            updateURLParam("edit", false);
            updateToggleBtn();
            showToast({ message: "Cập nhật thành công!", type: "success" });

            if (typeof window.fetchSoftwareLogs === "function") {
                window.fetchSoftwareLogs();
            }
        })
        .catch(err => {
            showToast({ message: err.message || "Lỗi cập nhật.", type: "error" });
            isEditMode = true;
            updateToggleBtn();
        });
}

function getValue(field) {
    const el = document.getElementById(`software-${field}-input`);
    return el ? el.value.trim() : "";
}

function setText(id, text, colorClass = "") {
    const el = document.getElementById(id);
    if (el) {
        el.textContent = text || "N/A";
        el.classList.remove("text-success", "text-danger");
        if (colorClass) el.classList.add(colorClass);
    }
}

function updateToggleBtn() {
    if (!toggleBtn) return;
    toggleBtn.innerHTML = isEditMode ? `<i class="mdi mdi-content-save"></i> Lưu` : `<i class="mdi mdi-pencil"></i> Sửa`;
}

function updateURLParam(key, value) {
    const url = new URL(window.location);
    value ? url.searchParams.set(key, "true") : url.searchParams.delete(key);
    window.history.replaceState({}, "", url);
}

function formatDate(dateString) {
    if (!dateString) return "N/A";
    return new Date(dateString).toLocaleDateString("vi-VN");
}
