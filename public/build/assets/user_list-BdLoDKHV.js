import{g}from"./user-DYdThU7v.js";import{g as p}from"./role-DWAQ50LF.js";import{r as y}from"./log_utils-DGHGoPDW.js";import"./api_config-C1dH2VF8.js";import"./toast-DwbAm--J.js";let f=!1,c=[],h=1;const o=10;let i=[];async function b(){if(document.getElementById("user-table-body"))try{c=await g(),i=c,d(1)}catch(a){console.error("Lỗi khi tải danh sách người dùng:",a)}}function d(t=1){h=t;const a=(t-1)*o,e=a+o,n=i.slice(a,e);w(n),y(i.length,o,h,d)}function l(t){var a;return(a=window.userPermissionCodes)==null?void 0:a.includes(t)}function w(t){const a=document.getElementById("user-table-body");a&&(a.innerHTML=t.map(e=>{var s,r;let n="";return l("user.update")&&(n+='<li class="list-inline-item px-2"><a href="#"><a href="#"><i class="bx bx-show"></i></a></li>'),l("user.delete")&&(n+='<li class="list-inline-item px-2"><a href="#"><i class="bx bx-trash"></i></a></li>'),l("user.update")&&(n+=`
                <li class="list-inline-item px-2"><a href="#"><i class="bx bx-wrench" 
                    onclick="loadModal('user_edit', { username: '${e.username}' })" title="Chỉnh sửa người dùng"
                >
                    </i></a>
                </li>`),l("userrole.update")&&(n+=`
                        <li class="list-inline-item px-2"><a href="#"><i class="mdi mdi-shield-account"
                        onclick="loadModal('user_role_edit', { username: '${e.username}' })"
                        >
                            </i></a>
                        </li>`),`
                <tr>
                    <td>
                        <div class="avatar-xs">
                            <span class="avatar-title rounded-circle">
                                ${((r=(s=e.username)==null?void 0:s.charAt(0))==null?void 0:r.toUpperCase())||"?"}
                            </span>
                        </div>
                    </td>
                    <td>
                        <h5 class="font-size-14 mb-1">
                            <a href="#" class="text-dark">${e.username}</a>
                        </h5>
                    </td>
                    <td class="text-center">${e.fullName||`  <div class="team">
                        <span class="badge badge-secondary">Chưa có dữ liệu</span>
                    </div>`}</td>



                    <td class="text-center">${e.email??0}</td>
                    <td class="text-right">
                        <ul class="list-inline font-size-20 contact-links mb-0">
                            ${n}
                        </ul>
                    </td>
                </tr>`}).join(""))}async function x(){if(f)return;f=!0;const t=document.getElementById("filter-role");if(t)try{(await p()).data.forEach(e=>{const n=document.createElement("option");n.value=e.role_name,n.textContent=e.role_name.charAt(0).toUpperCase()+e.role_name.slice(1),t.appendChild(n)})}catch(a){console.error("Lỗi khi tải quyền lọc:",a)}}document.addEventListener("DOMContentLoaded",async()=>{const t=document.getElementById("filter-form");t==null||t.addEventListener("submit",a=>{a.preventDefault();const e=Object.fromEntries(new FormData(t).entries());i=c.filter(s=>{var r,m,u;return(!e.username||((r=s.username)==null?void 0:r.toLowerCase().includes(e.username.toLowerCase())))&&(!e.email||((m=s.email)==null?void 0:m.toLowerCase().includes(e.email.toLowerCase())))&&(!e.fullName||((u=s.fullName)==null?void 0:u.toLowerCase().includes(e.fullName.toLowerCase())))&&(!e.role||(s.roles||[]).includes(e.role))}),d(1)}),await b(),await x()});window.initUserCreateModal=async function(){const t=document.getElementById("role-checkboxes");if(t){t.innerHTML="";try{const a=await p();if(!a.data.length){t.innerHTML="<p class='text-muted'>Không có quyền nào để hiển thị</p>";return}t.innerHTML=a.data.map(e=>`
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" id="role_${e.role_name}" value="${e.role_name}">
                    <label class="form-check-label" for="role_${e.role_name}">
                        ${e.role_name.charAt(0).toUpperCase()+e.role_name.slice(1)}
                    </label>
                </div>`).join("")}catch(a){console.error("Lỗi khi tải quyền:",a),t.innerHTML="<p class='text-danger'>Không thể tải quyền</p>"}}};window.addEventListener("userCreated",()=>{b()});
