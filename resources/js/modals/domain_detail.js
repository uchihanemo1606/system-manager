import { get_hardware_software_by_domain, delete_domain_by_name, update_domain_by_name } from "../api/domain";
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
    let isEditMode = false;
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
    }
    document.getElementById("delete-domain-btn").addEventListener("click", async () => {
        if (!domain || !domain.name) {
            showToast({ message: "Không tìm thấy thông tin tên miền.", type: "error" });
            return;
        }

        if (!confirm(`Bạn có chắc chắn muốn xóa tên miền "${domain.name}" không?`)) {
            return;
        }
        return showToast({
            message: "Tính năng bảo trì?",
            type: "warning",
            timeout: 3000,
        })
        try {
            await delete_domain_by_name({ name: domain.name });
            showToast({ message: "Xóa tên miền thành công!", type: "success" });
            window.location.reload(); // Hoặc chuyển trang nếu cần
        } catch (err) {
            console.error(err);
            showToast({ message: err.message || "Lỗi khi xóa tên miền.", type: "error" });
        }
    });
    document.getElementById("edit-domain-btn").addEventListener("click", async () => {
        isEditMode = !isEditMode;

        const nameView = document.getElementById("domain-name");
        const nameInput = document.getElementById("domain-name-input");

        const linkView = document.getElementById("domain-link");
        const linkInput = document.getElementById("domain-link-input");

        const editBtn = document.getElementById("edit-domain-btn");

        if (isEditMode) {
            // Hiện input để chỉnh sửa
            nameInput.value = nameView.textContent;
            linkInput.value = linkView.textContent;

            nameView.classList.add("d-none");
            linkView.classList.add("d-none");

            nameInput.classList.remove("d-none");
            linkInput.classList.remove("d-none");

            editBtn.innerHTML = `<i class="mdi mdi-content-save"></i>`;
        } else {
            const newName = nameInput.value.trim();
            const newLink = linkInput.value.trim();

            if (!newName || !newLink) {
                showToast({ message: "Tên miền và link không được để trống.", type: "warning" });
                return;
            }

            try {
                if (newName === domain.name && newLink === domain.link) {
                    showToast({
                        message: "Không có thay đổi nào để cập nhật.", type: "info"
                    });
                } else {
                    await update_domain_by_name({
                        id: domain.id,
                        name: newName,
                        link: newLink,
                    });

                    domain.name = newName;
                    domain.link = newLink;

                    nameView.textContent = newName;
                    linkView.textContent = newLink;
                    linkView.href = newLink;

                    showToast({ message: "Cập nhật tên miền thành công!", type: "success" });
                } 
            } catch (err) {
                console.error(err);
                showToast({ message: err.message || "Lỗi khi cập nhật tên miền.", type: "error" });
            }

            nameView.classList.remove("d-none");
            linkView.classList.remove("d-none");

            nameInput.classList.add("d-none");
            linkInput.classList.add("d-none");

            editBtn.innerHTML = `<i class="bx bx-pencil"></i>`;
        }
    });
}

window.initDomainDetailModal = initDomainDetailModal;
