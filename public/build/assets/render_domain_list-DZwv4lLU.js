function d(e,s=!1,r=!0){const n=document.querySelector("#domain_list tbody");if(n){if(n.innerHTML="",e.length===0){n.innerHTML='<tr><td colspan="4" class="text-center text-muted">Chưa có tên miền nào.</td></tr>';return}e.forEach(t=>{const a=document.createElement("tr");let i="";r&&(i=`
                <button class="btn btn-sm btn-outline-primary me-2"
                    data-name="${t.name}"
                    data-link="${t.link}"
                    data-id="${t.id}"
                    onclick="loadModal('hardware_domain_create', {
                        name: this.dataset.name,
                        link: this.dataset.link,
                        id: this.dataset.id
                    })"
                >Kết nối</button>
            `);const l=s?`<button class="btn btn-sm btn-outline-danger"
                onclick="deleteDomain('${t.id}')">
            Xoá
       </button>`:"";a.innerHTML=`
            <td style="width: 10px;"> 
                <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                    <i class="bx bx-world"></i>
                </span> 
            </td>
            <td>
                <h5 class="font-size-14 mb-1"> 
                    <a href="${t.link}" target="_blank" class="text-primary">${t.link}</a>
                </h5> 
            </td> 
            <td class="text-right text-nowrap">
                <button class="btn btn-sm btn-light me-2"
                    data-domain='${JSON.stringify(t)}'
                    onclick="loadModal('domain_detail', JSON.parse(this.dataset.domain))">
                    Chi tiết
                </button>
                ${i}
                ${l} 
            </td>
        `,n.appendChild(a)})}}export{d as r};
