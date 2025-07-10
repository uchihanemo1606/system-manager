import { get_domain_by_hardware, delete_domain_by_name } from "../api/domain";
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
            renderDomainList(res.data.domains, true);
        } else {
            renderDomainList([]);
        }
    } catch (err) {
        console.error(err);
        renderDomainList([]);
    }
}
window.deleteDomain = async function (domainLink) {
    if (!confirm(`Bạn có chắc muốn xoá tên miền  "${domainLink}" khỏi phần cứng này không?`)) return;

    try {
        const res = await delete_domain_by_name(domainLink);
        if (res.success) {
            showToast("Hủy liên kết tên miền với phần cứng thành công", "success");
            const ip = document.querySelector("#modal-hardware-ip")?.value || ""; // nếu bạn lưu IP phần cứng đang xem
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
