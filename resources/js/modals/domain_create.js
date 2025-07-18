import { create_domain } from "../api/domain";
import { showToast } from "../component/toast";

async function initDomainCreateModal(datasoftware) {
    const form = document.getElementById("domain-form");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        data.software_id = datasoftware.id||datasoftware;
        try {
            const res = await create_domain(data);
            showToast({
                message: res.message || "Thêm tên miền thành công!",
                type: "success",
                timeout: 2000,
            });
            form.reset();
            window.dispatchEvent(new CustomEvent("domainCreated")); 
        } catch (err) {
            showToast({
                message: err?.message || "Có lỗi xảy ra!",
                type: "error",
                timeout: 2000,
            });
        }
    });
}

window.initDomainCreateModal = initDomainCreateModal; 