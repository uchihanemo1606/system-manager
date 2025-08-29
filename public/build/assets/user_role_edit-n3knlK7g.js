import{g as _,a as b,c as y,d as g}from"./role-OrKpkcSW.js";import{s as k}from"./toast-DwbAm--J.js";import"./api_config-DJf1M6P2.js";async function v(n){const r=await _(),l=(await b()).data||[];document.getElementById("username").value=n.username;const a=r.data||[],t=l.filter(o=>o.username===n.username).map(o=>o.role_name);x(a,t),document.getElementById("edit-user-role-form").addEventListener("submit",async function(o){o.preventDefault();const s=document.getElementById("username").value,d=[];document.querySelectorAll("#role-checkboxes input[type=checkbox]:checked").forEach(e=>{d.push(e.value)});const i=l.filter(e=>e.username===s).map(e=>e.role_name),f=d.filter(e=>!i.includes(e)),p=i.filter(e=>!d.includes(e));let m=0,u=0;for(const e of f)await y({username:s,role_name:e})!==!1&&m++;for(const e of p)await g({username:s,role_name:e})!==!1&&u++;k({message:`Gán vai trò hoàn tất cho ${s}
➕ Thêm mới: ${m}
➖ Xóa: ${u}`,type:"success",timeout:2e3})})}function x(n,r=[]){const c=document.getElementById("role-checkboxes");if(!c)return;c.innerHTML="";const l=document.createElement("table");l.className="table table-sm table-hover mb-0";const a=document.createElement("tbody");for(const t of n){const o=r.includes(t.role_name),s=document.createElement("tr");s.innerHTML=`
            <td class="align-middle text-center" style="width: 40px;">
                <div class="custom-control custom-checkbox">
                    <input 
                        type="checkbox" 
                        class="custom-control-input" 
                        id="role-${t.role_name}" 
                        value="${t.role_name}" 
                        ${o?"checked":""}
                    >
                    <label class="custom-control-label" for="role-${t.role_name}"></label>
                </div>
            </td>
            <td class="align-middle font-weight-bold text-dark">
                <i class="mdi mdi-account-key-outline text-primary mr-1"></i>
                ${t.role_name}
            </td>
            <td class="align-middle text-muted">
                ${t.description||'<span class="font-italic">Không có mô tả</span>'}
            </td>
        `,a.appendChild(s)}l.appendChild(a),c.appendChild(l)}window.initUserRoleEditModal=v;
