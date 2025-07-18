import { create_category_rule } from "../api/rule";
import { showToast } from "../component/toast";

window.initCategoryRuleCreateModal = function () {
  const form = document.getElementById("category-rule-form");
  if (!form || form.dataset.initialized) return;

  form.dataset.initialized = "true";

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const name = form.querySelector("#rule-name").value.trim();
    const description = form.querySelector("#rule-description").value.trim();

    if (!name) {
      showToast("Tên loại quy chế không được để trống", "error");
      return;
    }

    try {
      await create_category_rule({ name, description });
      showToast("Tạo loại quy chế thành công", "success");
      $("#default-modal").modal("hide");

      // Bắn sự kiện nếu cần reload danh sách loại quy chế
      window.dispatchEvent(new Event("category_rule_created"));
    } catch (error) {
      showToast(error.message || "Đã có lỗi xảy ra", "error");
    }
  });
};
