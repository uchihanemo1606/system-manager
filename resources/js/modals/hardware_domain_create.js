import {
    create_domain_hardware,
    get_all_domain,
    get_domain_by_hardware,
} from "../api/domain";
import { showToast } from "../component/toast";

let allDomains = [];
let selectedDomainId = null;

async function initHardwareDomainCreateModal(data) {
    const nameInput = document.getElementById("hardware-domain-search-name");
    const linkInput = document.getElementById("hardware-domain-search-link");
    const createByInput = document.getElementById(
        "hardware-domain-search-createby"
    );
    const dateInput = document.getElementById("hardware-domain-search-date");
    const saveBtn = document.getElementById("hardware-domain-save");
    const listContainer = document.getElementById("domain-list-container");
    console.log(data);
    selectedDomainId = null;
    saveBtn.disabled = true;

    listContainer.innerHTML = `<p class="text-center text-muted mt-2">Đang tải dữ liệu...</p>`;

    let myDomainIds = [];

    const [allRes, myDomainRes] = await Promise.all([
        get_all_domain(),
        get_domain_by_hardware({ ip: data.ip }),
    ]);

    allDomains = allRes.data || [];
    let availableDomains = []; // <-- Sửa thành let

    if (!allDomains || allDomains.length === 0) {
        listContainer.innerHTML = `<p class="text-center text-muted mt-2">Không có tên miền nào để gán.</p>`;
        return;
    } 
    if (myDomainRes?.data && myDomainRes?.data?.domains) {
        const myDomainIds = (myDomainRes.data.domains || []).map((d) => d.id);
        // Lọc bỏ những domain đã gán
        availableDomains = allDomains.filter(
            (d) => !myDomainIds.includes(d.id)
        );
    } else {
        availableDomains = allDomains;
    } 
    renderDomainList(availableDomains); 
    const applyFilter = () => {
        const nameKeyword = nameInput.value.toLowerCase();
        const linkKeyword = linkInput.value.toLowerCase();
        const createByKeyword = createByInput.value.toLowerCase();
        const dateFilter = dateInput.value;

        const filtered = allDomains
            .filter((d) => !myDomainIds.includes(d.id)) // Vẫn giữ lọc bỏ domain đã gán
            .filter((d) => {
                const matchesName = d.name.toLowerCase().includes(nameKeyword);
                const matchesLink = d.link.toLowerCase().includes(linkKeyword);
                const matchesCreateBy = (d.createBy || "")
                    .toLowerCase()
                    .includes(createByKeyword);

                let matchesDate = true;
                if (dateFilter) {
                    const createdDate = new Date(d.created_at)
                        .toISOString()
                        .slice(0, 10);
                    matchesDate = createdDate === dateFilter;
                }

                return (
                    matchesName && matchesLink && matchesCreateBy && matchesDate
                );
            });

        renderDomainList(filtered);
    };

    nameInput.addEventListener("input", applyFilter);
    linkInput.addEventListener("input", applyFilter);
    createByInput.addEventListener("input", applyFilter);
    dateInput.addEventListener("change", applyFilter);

    saveBtn.onclick = async () => {
        if (!selectedDomainId) {
            showToast({ message: "Vui lòng chọn tên miền.", type: "error" });
            return;
        }

        try {
            await create_domain_hardware({
                hardware_ip: data.ip,
                domain_id: selectedDomainId,
            });
            showToast({ message: "Gán tên miền thành công!", type: "success" });
            // closeModal();
        } catch (err) {
            showToast({
                message: err.message || "Lỗi khi gán tên miền.",
                type: "error",
            });
        }
    };
}

function renderDomainList(domains) {
    const listContainer = document.getElementById("domain-list-container");

    if (domains.length === 0) {
        listContainer.innerHTML = `<p class="text-center text-muted mt-2">Không tìm thấy tên miền nào.</p>`;
        return;
    }

    listContainer.innerHTML = domains
        .map((d) => {
            const link = d.link
                ? `<a href="${d.link}" target="_blank" class="badge badge-info ml-2">${d.link}</a>`
                : `<span class="badge badge-secondary ml-2">Không có liên kết</span>`;
            const createdBy = d.createBy || "Không rõ";
            const createdAt = d.created_at
                ? new Date(d.created_at).toLocaleDateString("vi-VN")
                : "Không rõ";

            const activeClass =
                d.id == selectedDomainId ? "border-primary" : "border-light";

            return `
            <div class="border rounded p-2 mb-2 d-flex justify-content-between align-items-center domain-item ${activeClass}" style="cursor:pointer;" data-id="${d.id}" data-name="${d.name}" data-link="${d.link}">
                <div style="flex:1;">
                    <strong>${d.name}</strong>
                    ${link}
                    <div class="small text-muted">Người tạo: ${createdBy} | Ngày tạo: ${createdAt}</div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <i class="mdi mdi-checkbox-blank-circle-outline text-muted mb-2 select-indicator"></i>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-view-domain">
                        <i class="mdi mdi-eye-outline"></i> Xem
                    </button>
                </div>
            </div>
        `;
        })
        .join("");

    // Gán lại sự kiện click cho từng thẻ
    listContainer.querySelectorAll(".domain-item").forEach((item) => {
        const id = item.dataset.id;
        const name = item.dataset.name;
        const link = item.dataset.link;

        // Bấm chọn domain
        item.addEventListener("click", (e) => {
            if (e.target.closest(".btn-view-domain")) return; // Không chọn khi bấm nút Xem

            selectedDomainId = id;

            listContainer.querySelectorAll(".domain-item").forEach((el) => {
                el.classList.remove("border-primary");
                el.querySelector(".select-indicator").className =
                    "mdi mdi-checkbox-blank-circle-outline text-muted select-indicator";
            });

            item.classList.add("border-primary");
            item.querySelector(".select-indicator").className =
                "mdi mdi-check-circle text-success select-indicator";

            document.getElementById("hardware-domain-save").disabled = false;
        });

        // Bấm nút "Xem"
        item.querySelector(".btn-view-domain").addEventListener("click", () => {
            loadModal("domain_detail", {
                id: id,
                name: name,
                link: link,
            });
        });
    });
}

window.initHardwareDomainCreateModal = initHardwareDomainCreateModal;
