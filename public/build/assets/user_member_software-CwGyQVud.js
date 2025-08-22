import{f as _}from"./software-BinQehaT.js";import{r as P}from"./log_utils-DGHGoPDW.js";import"./api_config-C1dH2VF8.js";const a=6;let o=[],l=1;const d=new URLSearchParams(window.location.search).get("id");async function f(){if(!d){console.error("Thiếu tham số id trên URL");return}try{const t=await _(d);o=Array.isArray(t.data)?t.data:[],h(l)}catch(t){console.error("Lỗi khi gọi API:",t)}}function h(t){l=t;const s=(t-1)*a,c=o.slice(s,s+a),r=document.getElementById("user-list-software");if(r.innerHTML="",!c.length){r.innerHTML='<tr><td colspan="4" class="text-center text-muted">Không có dữ liệu</td></tr>';return}c.forEach((n,b)=>{const m=document.createElement("tr"),i=n.user_info||{},p=Array.isArray(n.permissions)?n.permissions:[],w=p.slice(0,2),g=p.slice(2),u=g.length;let e='<div class="d-flex flex-wrap align-items-start">';w.forEach(y=>{e+=`<span class="badge badge-primary mr-1 mb-1 px-2 py-1" style="font-size: 0.65rem;">${y}</span>`}),u>0&&(e+=`<span class="badge badge-light border mr-1 mb-1 px-2 py-1 text-primary" 
                data-toggle="tooltip" title="${g.join(", ")}" 
                style="font-size: 0.85rem; cursor: pointer;">+${u}</span>`),e+="</div>",m.innerHTML=`
            <td>${s+b+1}</td>
            <td>
                <div class="font-weight-bold">${i.fullName||"Không rõ"}</div>
                <small class="text-muted">(${i.username||""})</small>
            </td>
            <td>${e}</td>
            <td>
                <button class="btn btn-primary btn-sm"
                    onclick="loadModal('user_software_permission_edit', { username: '${i.username}', targetId: '${d}' })">
                    <i class="mdi mdi-pencil"></i> Sửa
                </button>
            </td>
        `,r.appendChild(m)}),P(o.length,a,l,h,"pagination-user-list"),$('[data-toggle="tooltip"]').tooltip()}f();window.addEventListener("software_permission_created",()=>{f()});
