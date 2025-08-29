import{l as k,f as L,i as P,p as w,j as T,k as C}from"./role-OrKpkcSW.js";import{s as m}from"./toast-DwbAm--J.js";import"./api_config-DJf1M6P2.js";let h=new Set;function f(){const e=[];for(const t of w)for(const i of T)e.push({permissions_name:`${i} ${t.toLowerCase()}`,type:t,description:""});return e}let y=[],b=[];const c=e=>(e||"").trim().toLowerCase().replace(/\s+/g," ");async function x(){try{return await P()}catch(e){console.error("Lỗi khi tải toàn bộ permission:",e)}}function I(e=""){const t=document.getElementById("filter-type");if(!t)return;t.innerHTML="";const i=document.createElement("option");i.value="",i.textContent="Tất cả loại",t.appendChild(i);for(const s of w){const n=document.createElement("option");n.value=s,n.textContent=s,s===e&&(n.selected=!0),t.appendChild(n)}}function N(e,t,i){const s=e.permissions_name;return y.some(o=>c(o.permissions_name)===c(s))?`
            <tr>
                <td class="align-middle">
                    <div class="custom-control custom-checkbox text-center">
                        <input 
                            type="checkbox" 
                            class="custom-control-input" 
                            id="${s}" 
                            value="${s}" 
                            ${t?"checked":""}
                        >
                        <label class="custom-control-label" for="${s}"></label>
                    </div>
                </td>
                <td class="align-middle font-weight-bold text-dark">
                    <i class="mdi mdi-shield-key-outline text-primary mr-1"></i>
                    ${s}
                </td>
                <td class="align-middle">
                    <span class="badge badge-info">${e.type||"Không xác định"}</span>
                </td>
                <td class="align-middle text-muted">
                    ${e.description||'<span class="font-italic">Không có mô tả</span>'}
                </td>
            </tr>

    `:(c(e.permissions_name),`
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
                        data-role="${i}" 
                        data-permission="${e.permissions_name}"
                        data-type="${e.type||""}" 
                        data-description="${e.description||""}">
                        <i class="mdi mdi-plus-circle-outline mr-1"></i> Tạo permission
                    </button>
                </td>
            </tr>

    `)}function v(e,t,i=""){const s=document.getElementById("permission-checkboxes");s.innerHTML="",I();const n={};for(const r of e){const a=r.type||"Không xác định";n[a]||(n[a]=[]),n[a].push(r)}const o=Object.entries(n).map(([r,a])=>{const d=a.map(p=>{const u=c(p.permissions_name),g=y.some(_=>c(_.permissions_name)===u),l=h.has(u);return N(p,l,!g)});return`
            <div class="mb-4">
                <h5 class="text-primary mb-2 border-bottom pb-1">${r}</h5>
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
                        ${d.join("")}
                    </tbody>
                </table>
            </div>
        `}).join("");s.innerHTML=o,s.querySelectorAll('input[type="checkbox"]').forEach(r=>{r.addEventListener("change",()=>{const a=c(r.value);r.checked?h.add(a):h.delete(a)})}),document.querySelectorAll(".create-missing-permission-btn").forEach(r=>{r.addEventListener("click",async function(a){a.preventDefault();const d=this.dataset.permission,p=this.dataset.type,u=this.dataset.description,g=this.dataset.role;try{await C({permissions_name:d,type:p,description:u}),m({message:`Đã tạo permission "${d}"`,type:"success",timeout:2e3});const[l]=await Promise.all([x()]);y=l;const E=f();v(E,b,g)}catch(l){console.error("Lỗi khi tạo permission:",l),m({message:(l==null?void 0:l.message)||"Lỗi khi tạo permission",type:"error",timeout:2e3})}})})}function B(){const e=c(document.getElementById("filter-name").value),t=document.getElementById("filter-type").value,i=document.getElementById("filter-selected").value,s=f().filter(n=>{const o=c(n.permissions_name),r=n.type||"",a=b.includes(o);return o.includes(e)&&(t?r===t:!0)&&(i==="selected"?a:i==="unselected"?!a:!0)});v(s)}function M(){["filter-name","filter-type","filter-selected"].forEach(e=>document.getElementById(e).addEventListener("input",B))}async function S(){const e=document.getElementById("permission-form");if(!(!e||e.dataset.initialized)){e.dataset.initialized="true",h=new Set;try{y=await x(),b=[];const i=f();v(i,[]),M()}catch(t){console.error("Lỗi khi load dữ liệu:",t),m({message:(t==null?void 0:t.message)||"Lỗi khi tải dữ liệu permission",type:"error",timeout:2e3})}e.addEventListener("submit",async t=>{t.preventDefault();const s=document.getElementById("role-name").value.trim();if(!s){m({message:"Vui lòng nhập tên vai trò.",type:"warning",timeout:2e3});return}const n=Array.from(h);try{await k({role_name:s}),await Promise.all(n.map(o=>L({role_name:s,permission_name:o}))),m({message:`Đã tạo vai trò "${s}" với ${n.length} quyền.`,type:"success",timeout:2e3}),$("#modalContainer").modal("hide"),window.dispatchEvent(new CustomEvent("rolePermissionUpdated"))}catch(o){console.error("Lỗi khi tạo vai trò:",o),m({message:(o==null?void 0:o.message)||"Lỗi khi tạo vai trò",type:"error",timeout:2e3})}})}}window.initRoleCreateModal=S;
