import { get_domain_by_hardware, remove_hardware_in_domain } from "../api/domain";
import { renderDomainList } from "../component/domain/render_domain_list";
import { showToast } from "../component/toast";
export async function initHardwareListDomainModal(ip) {
    const tbody = document.querySelector("#domain_list tbody");
    if (tbody) {
        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Đang tải...</td></tr>`;
    }
    try {
        const res = await get_domain_by_hardware(ip);
        if (res) {
            renderDomainList(res, true, false,ip);
        } else {
            renderDomainList([]);
        }
    } catch (err) {
        console.error(err);
        renderDomainList([]);
    }
}
window.deleteDomain = async function (domainLink) {
    if (!confirm(`Bạn có chắc muốn xoá tên miền  này khỏi phần cứng này không?`)) return;
    const ip = new URLSearchParams(window.location.search).get("id");
    try { 
        const res = await remove_hardware_in_domain(ip, domainLink);
        if (res.ok) {
            showToast("Hủy liên kết tên miền với phần cứng thành công", "success");

            initHardwareListDomainModal(ip); // refresh lại danh sách
        } else {
            showToast({ message: "Không thể xoá tên miền khỏi phần cứng", type: "error" });
        }
    } catch (err) {
        console.error(err);
        showToast({ message: "Lỗi khi xoá tên miền", type: "error" });
    }
};
window.initHardwareListDomainModal = initHardwareListDomainModal;
