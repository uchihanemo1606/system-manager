import{a as x,c as C,r as S}from"./domain-C2mOs3WS.js";import{s as _}from"./toast-DwbAm--J.js";import{get_all_hardware_connect_domain as $}from"./hardware-BVsb7eyA.js";import"./api_config-C1dH2VF8.js";async function q(i){console.log(i);const c=new Set,p=new Set,d=document.querySelector("#hardware-select-table tbody"),u=document.querySelector("#select-all-hw"),L=document.querySelector("#link-selected-hardware"),f=document.querySelector("#filter-deleted"),g=document.querySelector("#filter-ip"),k=document.querySelector("#filter-os"),b=document.querySelector("#filter-db");if(d){d.innerHTML=`
        <tr>
            <td colspan="5" class="text-center text-muted">
                <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                Đang tải danh sách phần cứng...
            </td>
        </tr>
    `;try{let v=function(t){d.innerHTML=t.length?t.map(e=>{const r=c.has(e.ip)?"checked":"",o=e.is_delete,a=o?"bg-light text-muted":"",l=o?"disabled":"";return`
                        <tr class="hardware-row ${a}" data-ip="${e.ip}">
                            <td><input type="checkbox" class="hw-checkbox" data-ip="${e.ip}" ${r} ${l}></td>
                            <td>${e.ip}</td>
                            <td>${e.OS||"?"}</td>
                            <td>${e.dbname||"?"} - ${e.dbversion||""}</td>
                            <td><a href="/hardware_detail?id=${encodeURIComponent(e.ip)}" target="_blank" class="btn btn-sm btn-link">Xem</a></td>
                        </tr>`}).join(""):'<tr><td colspan="5" class="text-center text-muted">Không có phần cứng nào.</td></tr>',d.querySelectorAll(".hardware-row").forEach(e=>{const n=e.querySelector(".hw-checkbox"),r=e.dataset.ip;e.addEventListener("click",o=>{o.target.tagName==="INPUT"||o.target.tagName==="A"||n&&!n.disabled&&(n.checked=!n.checked,n.checked?c.add(r):c.delete(r))}),n==null||n.addEventListener("change",()=>{n.checked?c.add(r):c.delete(r)})})},m=function(){const t=g.value.toLowerCase(),e=k.value.toLowerCase(),n=b.value.toLowerCase(),r=f.value,o=s.filter(a=>(!t||a.ip.toLowerCase().includes(t))&&(!e||(a.OS||"").toLowerCase().includes(e))&&(!n||`${a.dbname||""} ${a.dbversion||""}`.toLowerCase().includes(n))&&(r==="all"||r==="true"&&a.is_delete===!0||r==="false"&&a.is_delete===!1));v(o)};const s=(await $()).data||[];d.innerHTML=`
            <tr>
                <td colspan="5" class="text-center text-muted">
                    <div class="spinner-border spinner-border-sm text-info me-2"></div>
                    Đang kiểm tra domain đã liên kết trong phần cứng...
                </td>
            </tr>
        `,await Promise.all(s.map(t=>x({ip:t.ip}).then(e=>{(Array.isArray(e)?e:[]).some(r=>r.id==i.id)&&(p.add(t.ip),c.add(t.ip))}).catch(e=>{console.error("Lỗi khi gọi get_domain_by_hardware:",e)}))),[g,k,b,f].forEach(t=>{t.addEventListener("input",m),t.addEventListener("change",m)}),u.onclick=()=>{document.querySelectorAll(".hw-checkbox:not(:disabled)").forEach(t=>{const e=t.dataset.ip;t.checked=u.checked,t.checked?c.add(e):c.delete(e)})},m(),L.onclick=async()=>{if(!s.length)return _({message:"Không có phần cứng nào để xử lý.",type:"warning"});let t=0,e=0,n=0,r=0;for(const o of s){const a=o.ip,l=c.has(a),y=p.has(a);if(l&&!y)try{await C({hardware_ip:a,domain_id:i.id}),t++}catch(h){console.error(`Lỗi tạo domain cho ${a}`,h),e++}if(!l&&y)try{await S(a,i.id),n++}catch(h){console.error(`Lỗi gỡ domain khỏi ${a}`,h),r++}}_({message:"cập nhật thành công",type:e||r?"warning":"success",timeout:6e3}),window.dispatchEvent(new CustomEvent("domainUpdated"))}}catch(w){d.innerHTML='<tr><td colspan="5" class="text-danger text-center">Lỗi khi tải danh sách phần cứng.</td></tr>',console.error(w)}}}window.initHardwareDomainCreateModal=q;
