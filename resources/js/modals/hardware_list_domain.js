import { get_domain_by_hardware } from "../api/domain";
import { renderDomainList } from "../component/domain/render_domain_list";
import { showToast } from "../component/toast";

export async function initHardwareListDomainModal(ip) {
    const tbody = document.querySelector("#domain_list tbody");
    if (tbody) {
        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Đang tải...</td></tr>`;
    }

    try {
        const res = await get_domain_by_hardware(ip);  
        if (res.data.domains) { 
            renderDomainList(res.data.domains);
        } else {
            renderDomainList([]);
        } 
    } catch (err) {
        console.error(err);
        showToast({
            message: "Lỗi khi tải danh sách tên miền.",
            type: "error",
            timeout: 3000,
        });
    }
}

window.initHardwareListDomainModal = initHardwareListDomainModal;
