import { get_all_category_rule, delete_category_rule } from "../api/rule";
import { showToast } from "../component/toast";

let allCategoryRules = [];

function normalize(str) {
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
}

function fuzzyIncludes(source, keyword) {
    const words = normalize(keyword).split(" ");
    const target = normalize(source);
    return words.every(word => target.includes(word));
}

function renderCategoryRules(filterName = "", filterDescription = "") {
    const container = document.getElementById("category-rule-list");
    container.innerHTML = "";

    const filtered = allCategoryRules.filter(rule => {
        const matchesName = fuzzyIncludes(rule.name, filterName);
        const matchesDesc = fuzzyIncludes(rule.description || "", filterDescription);
        return matchesName && matchesDesc;
    });

    if (filtered.length === 0) {
        container.innerHTML = `<p class="text-muted fst-italic">Không tìm thấy loại quy chế phù hợp.</p>`;
        return;
    }

    filtered.forEach(rule => {
        const item = document.createElement("div");
        item.className = " mb-3 border-start border-3 border-primary shadow-sm";

        item.innerHTML = `
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-start">
                    <div class="me-3 text-primary mr-2">
                        <i class="mdi mdi-file-document-outline fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-semibold">${rule.name}</h5>
                        <p class="mb-0 text-muted">${rule.description || "<em>Không có mô tả</em>"}</p>
                    </div>
                </div>
                <div class="text-nowrap">
                    <button class="btn btn-outline-primary btn-sm me-2"  onclick="loadModal('category_rule_detail', { rule_id: '${rule.id}' })" title="Xem thêm">
                        <i class="mdi mdi-pencil"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteCategoryRule(${rule.id})" title="Xóa">
                        <i class="mdi mdi-trash-can-outline"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(item);
    });
}

async function loadCategoryRules() {
    const container = document.getElementById("category-rule-list");
    container.innerHTML = `<p>Đang tải dữ liệu...</p>`;

    try {
        const { data } = await get_all_category_rule();
        allCategoryRules = data || [];
        const name = document.getElementById("search-name").value || "";
        const desc = document.getElementById("search-description").value || "";
        renderCategoryRules(name, desc);
    } catch (error) {
        container.innerHTML = `<p class="text-danger">Lỗi tải dữ liệu: ${error.message}</p>`;
    }
}

window.deleteCategoryRule = async function (id) {
    if (!confirm("Bạn có chắc muốn xóa loại quy chế này?")) return;

    try {
        await delete_category_rule(id);
        showToast("Xóa thành công", "success");
        await loadCategoryRules();
    } catch (error) {
        showToast("Xóa thất bại", "error");
        console.error(error);
    }
};

window.editCategoryRule = function (id) {
    // Mở modal sửa (tùy hệ thống bạn đang dùng)
    loadModal("category_rule_edit", { id });
};

document.addEventListener("DOMContentLoaded", () => {
    loadCategoryRules();

    document.getElementById("search-name").addEventListener("input", () => {
        const name = document.getElementById("search-name").value;
        const desc = document.getElementById("search-description").value;
        renderCategoryRules(name, desc);
    });

    document.getElementById("search-description").addEventListener("input", () => {
        const name = document.getElementById("search-name").value;
        const desc = document.getElementById("search-description").value;
        renderCategoryRules(name, desc);
    });

    // Reload khi tạo mới
    window.addEventListener("category_rule_created", () => {
        loadCategoryRules();
    });

    // Reload khi cập nhật
    window.addEventListener("category_rule_updated", () => {
        loadCategoryRules();
    });
});
