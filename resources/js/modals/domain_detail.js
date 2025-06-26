import { get_hardware_software_by_domain } from "../api/domain";
import { showToast } from "../component/toast";
function renderHardwareList(hardwareList) {
    const tbody = document.querySelector("#hardware-list tbody");
    tbody.innerHTML = "";

    if (!hardwareList || hardwareList.length === 0) {
        tbody.innerHTML = `<tr><td class="text-center text-muted">Chưa có phần cứng nào sử dụng tên miền này.</td></tr>`;
        return;
    } 
    hardwareList.forEach(hw => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>${hw.ip}</strong><br>
                        <small>${hw.OS} - ${hw.OSver}</small>
                    </div>
                    <a href="/hardware_detail?id=${encodeURIComponent(hw.ip)}" class="btn btn-sm btn-outline-primary ms-2" title="Đi đến phần cứng">
                        <i class="bx bx-right-arrow-circle"></i>
                    </a>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function formatDate(dateString) {
    if (!dateString) return "N/A";
    const date = new Date(dateString);
    return date.toLocaleDateString("vi-VN");
}

async function initDomainDetailModal(domain) {
    if (!domain) return;
    document
        .getElementById("software-detail-link")
        .addEventListener("click", function (e) {
            e.preventDefault();
            if (window.softwareId) {
                window.location.href = `/software_detail?id=${window.softwareId}`;
            } else {
                showToast({
                    message: "Không tìm thấy thông tin phần mềm.",
                    type: "error",
                });
            }
        });

    try {
        const { domain: fullDomain, hardware } =
            await get_hardware_software_by_domain({
                link: domain.link,
                name: domain.name,
            }); 
        // Hiển thị thông tin domain
        document.getElementById("domain-name").textContent = fullDomain.name;
        const linkEl = document.getElementById("domain-link");
        linkEl.textContent = fullDomain.link;
        linkEl.href = fullDomain.link;
        document.getElementById("domain-createdby").textContent =
            fullDomain.createBy;
        document.getElementById("domain-createdat").textContent = formatDate(
            fullDomain.created_at
        );
        // Thông tin phần mềm
        if (fullDomain.software) {
            document.getElementById("software-name").textContent =
                fullDomain.software.softwareName;
            document.getElementById("software-language").textContent =
                fullDomain.software.language;
            document.getElementById("software-version").textContent =
                fullDomain.software.version;
            window.softwareId = fullDomain.software.id;
        }

        // // Danh sách phần cứng
        renderHardwareList(hardware);
    } catch (err) {
        console.error(err);
        showToast({
            message: err.message || "Đã xảy ra lỗi khi tải thông tin.",
            type: "error",
            timeout: 3000,
        });
    }
}

window.initDomainDetailModal = initDomainDetailModal;
