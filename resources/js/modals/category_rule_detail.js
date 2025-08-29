import { update_category_rule, get_category_by_id } from "../api/rule";
import { showToast } from "../component/toast";

function initCategoryRuleDetailModal(data) {
    const rule_id = data.rule_id
    const form = document.getElementById("category-rule-edit-form");
    if (!form || form.dataset.initialized) return;

    form.dataset.initialized = "true";

    const nameInput = document.createElement("input");
    nameInput.type = "text";
    nameInput.name = "name";
    nameInput.id = "edit-rule-name";
    nameInput.className = "form-control mb-2";
    nameInput.placeholder = "Tên loại quy chế";

    const descriptionInput = document.createElement("textarea");
    descriptionInput.name = "description";
    descriptionInput.id = "edit-rule-description";
    descriptionInput.className = "form-control mb-2";
    descriptionInput.placeholder = "Mô tả (tùy chọn)";

    const submitBtn = document.createElement("button");
    submitBtn.type = "submit";
    submitBtn.className = "btn btn-primary";
    submitBtn.textContent = "Cập nhật";

    form.appendChild(nameInput);
    form.appendChild(descriptionInput);
    form.appendChild(submitBtn);

    // Load data từ API theo ID
    get_category_by_id(rule_id).then((res) => {
        const category = res.data;
        nameInput.value = category.name || "";
        descriptionInput.value = category.description || "";
    });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const name = nameInput.value.trim();
        const description = descriptionInput.value.trim();

        // Validate
        if (!name) {
            showToast("Tên không được để trống", "error");
            return;
        }

        try {
            await update_category_rule({
                id: rule_id,
                name,
                description,
            });
            window.dispatchEvent(new Event("category_rule_updated")); 
            showToast("Cập nhật loại quy chế thành công", "success");
        } catch (err) {
            const msg =
                err?.response?.data?.message ||
                err?.response?.data?.errors?.name?.[0] ||
                "Đã xảy ra lỗi khi cập nhật";
            showToast(msg, "error");
        }
    });
}

window.initCategoryRuleDetailModal = initCategoryRuleDetailModal;
