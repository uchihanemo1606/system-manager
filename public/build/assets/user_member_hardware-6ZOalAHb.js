import{get_all_user_permission_hardware as _}from"./hardware-BVsb7eyA.js";import{r as P}from"./log_utils-DGHGoPDW.js";import"./api_config-C1dH2VF8.js";const i=6;let o=[],d=1;async function u(){const e=new URLSearchParams(window.location.search).get("id");if(!e){console.error("Thiếu tham số IP trên URL");return}try{const t=await _(e);o=Array.isArray(t.data)?t.data:[],h(d)}catch(t){console.error("Lỗi khi gọi API:",t)}}function h(e){d=e;const t=(e-1)*i,l=o.slice(t,t+i),s=document.getElementById("user-list-hardware");if(s.innerHTML="",!l.length){s.innerHTML='<tr><td colspan="4" class="text-center text-muted">Không có dữ liệu</td></tr>';return}const w=new URLSearchParams(window.location.search).get("id");l.forEach((a,f)=>{const c=document.createElement("tr"),n=a.user_info||{},m=Array.isArray(a.permissions)?a.permissions:[],b=m.slice(0,2),p=m.slice(2),g=p.length;let r='<div class="d-flex flex-wrap align-items-start">';b.forEach(y=>{r+=`<span class="badge badge-primary mr-1 mb-1 px-2 py-1" style="font-size: 0.65rem;">${y}</span>`}),g>0&&(r+=`<span class="badge badge-light border mr-1 mb-1 px-2 py-1 text-primary" 
                                  data-toggle="tooltip" title="${p.join(", ")}" 
                                  style="font-size: 0.85rem; cursor: pointer;">+${g}</span>`),r+="</div>",c.innerHTML=`
            <td>${t+f+1}</td>
            <td>
                <div class="font-weight-bold">${n.fullName||"Không rõ"}</div>
                <small class="text-muted">(${n.username||""})</small>
            </td>
            <td>${r}</td>
            <td>
                <button class="btn btn-primary btn-sm"
                    onclick="loadModal('user_hardware_permission_edit', { username: '${n.username}', ip: '${w}' })">
                    <i class="mdi mdi-pencil"></i> Sửa
                </button>
            </td>
        `,s.appendChild(c)}),P(o.length,i,d,h,"pagination-user-list"),$('[data-toggle="tooltip"]').tooltip()}u();window.addEventListener("hardware_permission_created",()=>{u()});
