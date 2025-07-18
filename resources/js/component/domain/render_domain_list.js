
export function renderDomainList(domains, is_Delete_Hardware_Domain = false, is_connect = true) {
    const tbody = document.querySelector("#domain_list tbody");
    if (!tbody) return;

    tbody.innerHTML = "";

    if (domains.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Chưa có tên miền nào.</td></tr>`;
        return;
    }

    domains.forEach((domain) => {
        const tr = document.createElement("tr");

        let connectButton = "";
        if (is_connect) {
            connectButton = `
                <button class="btn btn-sm btn-outline-primary me-2"
                    data-name="${domain.name}"
                    data-link="${domain.link}"
                    data-id="${domain.id}"
                    onclick="loadModal('hardware_domain_create', {
                        name: this.dataset.name,
                        link: this.dataset.link,
                        id: this.dataset.id
                    })"
                >Kết nối</button>
            `;
        }

        const deleteButton = is_Delete_Hardware_Domain
            ? `<button class="btn btn-sm btn-outline-danger"
                onclick="deleteDomain('${domain.link}')">
            Xoá
       </button>`
            : "";

        tr.innerHTML = `
            <td style="width: 10px;"> 
                <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                    <i class="bx bx-world"></i>
                </span> 
            </td>
            <td>
                <h5 class="font-size-14 mb-1">
                    <a href="${domain.link}" target="_blank" class="text-dark">${domain.name}</a> 
                    | <a href="${domain.link}" target="_blank" class="text-primary">${domain.link}</a>
                </h5>
                <small>Ngày tạo: ${formatDate(domain.created_at)}</small>
            </td> 
            <td class="text-right text-nowrap">
                <button class="btn btn-sm btn-light me-2"
                    data-domain='${JSON.stringify(domain)}'
                    onclick="loadModal('domain_detail', JSON.parse(this.dataset.domain))">
                    Chi tiết
                </button>
                ${connectButton}
                ${deleteButton} 
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

