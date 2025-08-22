import{u as T,b as M,e as H,f as N,h as S,i as q,p as I,j as D,k as K}from"./role-DWAQ50LF.js";import{s as g}from"./toast-DwbAm--J.js";import"./api_config-C1dH2VF8.js";let p=new Set,f=[],c=[];const E=document.getElementById("role-name"),_=document.getElementById("edit-role-btn");_.addEventListener("click",()=>{const e=E.textContent.trim(),t=document.createElement("input");t.type="text",t.value=e,t.className="form-control d-inline-block w-auto mr-2";const s=document.createElement("button");s.className="btn btn-sm btn-success mr-1",s.textContent="Lưu";const o=document.createElement("button");o.className="btn btn-sm btn-secondary",o.textContent="Hủy",E.replaceWith(t),_.replaceWith(s,o),s.addEventListener("click",async()=>{const n=t.value.trim();if(!n)return alert("Tên role không được rỗng");try{await T({old_role_name:e,new_role_name:n}),t.replaceWith(E),E.textContent=n,s.replaceWith(_),o.remove()}catch(m){console.error(m)}}),o.addEventListener("click",()=>{t.replaceWith(E),s.replaceWith(_),o.remove()})});function v(){const e=[];for(const t of I)for(const s of D)e.push({permissions_name:`${s} ${t.toLowerCase()}`,type:t,description:""});return e}const d=e=>(e||"").trim().toLowerCase().replace(/\s+/g," ");async function L(e){try{const t=await S(e.role_name);return{role:e,permissions:t}}catch(t){console.error("Lỗi khi tải quyền role:",t)}}async function B(){try{return await q()}catch(e){console.error("Lỗi khi tải toàn bộ permission:",e)}}function j(e,t){return Promise.resolve(!0)}function z(e=""){const t=document.getElementById("filter-type");if(!t)return;t.innerHTML="";const s=document.createElement("option");s.value="",s.textContent="Tất cả loại",t.appendChild(s);for(const o of I){const n=document.createElement("option");n.value=o,n.textContent=o,o===e&&(n.selected=!0),t.appendChild(n)}}function R(e,t,s=!1,o){const n=e.permissions_name;return f.some(i=>d(i.permissions_name)===d(n))?`
            <tr>
                <td class="align-middle">
                    <div class="custom-control custom-checkbox text-center">
                        <input 
                            type="checkbox" 
                            class="custom-control-input" 
                            id="${n}" 
                            value="${n}" 
                            ${t?"checked":""}
                        >
                        <label class="custom-control-label" for="${n}"></label>
                    </div>
                </td>
                <td>
                    <span class="font-weight-bold text-dark">
                        <i class="mdi mdi-shield-key-outline text-primary mr-1"></i>
                        ${n}
                    </span>
                </td>
                <td>
                    <span class="badge badge-info">${e.type||"Không xác định"}</span>
                </td>
                <td>
                    ${e.description?`<span class="text-muted">${e.description}</span>`:'<span class="text-muted fst-italic">Không có mô tả</span>'}
                </td>
            </tr>

    `:(d(e.permissions_name),`
            <tr class="bg-light text-muted">
            <td>
            </td> 
                <td>
                    <span class="font-italic text-dark">
                        <i class="mdi mdi-alert-circle-outline text-warning mr-1"></i>
                        ${e.permissions_name}
                    </span>
                </td>
                <td>
                    <span class="badge badge-secondary">${e.type||"Không xác định"}</span>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-success create-missing-permission-btn shadow-sm"
                        data-role="${o}" 
                        data-permission="${e.permissions_name}"
                        data-type="${e.type||""}" 
                        data-description="${e.description||""}">
                        <i class="mdi mdi-plus-circle-outline mr-1"></i> Tạo permission
                    </button>
                </td>
            </tr>

    `)}function w(e,t,s=""){const o=document.getElementById("permission-checkboxes");o.innerHTML="",z(),p.size===0&&t.forEach(i=>p.add(i));const n={};for(const i of e){const r=i.type||"Không xác định";n[r]||(n[r]=[]),n[r].push(i)}const m=Object.entries(n).map(([i,r])=>{const y=r.map(l=>{const a=d(l.permissions_name),b=f.some(x=>d(x.permissions_name)===a),u=p.has(a);return R(l,u,!b,s)});return`
            <div class="mb-4">
                <h5 class="text-primary mb-2 border-bottom pb-1">${i}</h5>
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Chọn</th>
                            <th>Tên Permission</th>
                            <th>Loại</th>
                            <th>Mô tả / Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${y.join("")}
                    </tbody>
                </table>
            </div>
        `}).join("");o.innerHTML=m,o.querySelectorAll('input[type="checkbox"]').forEach(i=>{i.addEventListener("change",()=>{const r=d(i.value);i.checked?p.add(r):p.delete(r)})}),document.querySelectorAll(".create-missing-permission-btn").forEach(i=>{i.addEventListener("click",async function(r){r.preventDefault();const y=this.dataset.permission,l=this.dataset.type,a=this.dataset.description,b=this.dataset.role;try{await K({permissions_name:y,type:l,description:a}),g({message:`Đã tạo permission "${y}"`,type:"success",timeout:2e3});const[u,h]=await Promise.all([L({role_name:b}),B()]);f=h,c=u.permissions.map(C=>d(C.permission_name));const x=v();w(x,c,b),k(u.permissions)}catch(u){console.error("Lỗi khi tạo permission:",u),g({message:u.message||"Lỗi khi tạo permission",type:"error",timeout:2e3})}})})}function k(e){const t=document.getElementById("permission-list");t.innerHTML=e.length?e.map(s=>`
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>${s.permission_name}</span>
            </li>
        `).join(""):"<li>Chưa có permission nào</li>"}function P(){const e=d(document.getElementById("filter-name").value),t=document.getElementById("filter-type").value,s=document.getElementById("filter-selected").value,o=v().filter(n=>{const m=d(n.permissions_name),i=n.type||"",r=c.includes(m);return m.includes(e)&&(t?i===t:!0)&&(s==="selected"?r:s==="unselected"?!r:!0)});w(o,c)}function W(){["filter-name","filter-type","filter-selected"].forEach(e=>document.getElementById(e).addEventListener("input",P))}async function F(e){var o;const t=document.getElementById("permission-form");if(!t)return;t.dataset.initialized="",p=new Set,c=[],f=[],document.getElementById("role-name").textContent="",document.getElementById("permission-checkboxes").innerHTML="",document.getElementById("permission-list").innerHTML="",document.getElementById("filter-name").value="",document.getElementById("filter-type").value="",document.getElementById("filter-selected").value="",t.dataset.initialized="true";const s=document.getElementById("role-name");try{const[n,m]=await Promise.all([L(e),B()]);f=m,c=n.permissions.map(r=>d(r.permission_name)),p=new Set(c),s.textContent=n.role.role_name;const i=v();w(i,c,e.role_name),k(n.permissions),W()}catch(n){console.error("Lỗi khi load dữ liệu:",n),g({message:n.message||"Không thể tải dữ liệu",type:"error",timeout:2e3});return}(o=document.getElementById("delete-role-btn"))==null||o.addEventListener("click",async()=>{if(confirm("Bạn có chắc chắn muốn xóa role này không?"))try{await M(e.role_name),$("#addPermissionModal").modal("hide"),window.dispatchEvent(new CustomEvent("roleListUpdated"))}catch(n){console.error("Lỗi khi xóa role:",n),g({message:"Không thể xóa role này",type:"error",timeout:2e3})}}),t.addEventListener("submit",async n=>{n.preventDefault();const m=document.activeElement;if(m&&m.classList.contains("create-missing-permission-btn"))return;const i=Array.from(p),r=c.filter(a=>!i.includes(a)),y=i.filter(a=>!c.includes(a)),l=e.role_name;if(l==="admin"||l==="quản lý phần cứng"||l==="quản lý phần mềm"||l==="quản lý hệ thống"||l==="người dùng cơ bản"){g({message:`CẢNH BÁO:  đây là 'Vai trò' được thiết lập sẵn ảnh hưởng đến hệ thống chúng tôi khuyến cáo nên tạo một 'Vai trò' mới thay vì sửa 'Vai trò' này : ${l}`,type:"warning",timeout:4e3});return}try{for(const h of r)await H({role_name:l,permission_name:h});await Promise.all(y.map(h=>N({role_name:l,permission_name:h}))),await j(e.role_id,i);const[a,b]=await Promise.all([L(e),B()]);f=b||[],c=(a.permissions||[]).map(h=>d(h.permission_name)),p=new Set(c);const u=v();w(u,c,e.role_name),k(a.permissions),P(),g({message:"Cập nhật quyền thành công!",type:"success",timeout:2e3}),$("#addPermissionModal").modal("hide"),window.dispatchEvent(new CustomEvent("rolePermissionUpdated"))}catch(a){console.error("Lỗi khi cập nhật quyền:",a),g({message:a.message||"Đã có lỗi xảy ra khi cập nhật quyền",type:"error",timeout:2e3})}})}document.addEventListener("DOMContentLoaded",()=>{$("#addPermissionModal").on("hidden.bs.modal",()=>{p=new Set,c=[],f=[],document.getElementById("role-name").textContent="",document.getElementById("permission-checkboxes").innerHTML="",document.getElementById("permission-list").innerHTML="",document.getElementById("filter-name").value="",document.getElementById("filter-type").value="",document.getElementById("filter-selected").value="";const e=document.getElementById("permission-form");e&&(e.dataset.initialized="")})});window.initRoleDetailModal=F;
