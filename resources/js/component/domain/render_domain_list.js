export function renderDomainList(domains) {
    const tbody = document.querySelector("#domain_list tbody");
    if (!tbody) return;

    tbody.innerHTML = ""; // Xóa dữ liệu cũ

    if (domains.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Chưa có tên miền nào.</td></tr>`;
        return;
    }

    domains.forEach((domain) => {
        const tr = document.createElement("tr");

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
            <td style="width: 40px;" class="text-center">
                <button class="btn btn-link p-0 dropdown-toggle"
                    type="button"
                    data-domain='${JSON.stringify(domain)}'
                    onclick="loadModal('domain_detail', JSON.parse(this.dataset.domain))">
                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                </button>
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
