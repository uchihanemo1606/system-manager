import{u as p,g as b}from"./user-DaycjWAo.js";import{g as w}from"./role-OrKpkcSW.js";import{r as x}from"./log_utils-DGHGoPDW.js";import{s as y}from"./toast-DwbAm--J.js";import"./api_config-DJf1M6P2.js";let f=!1,d=[],g=1;const c=10;let o=[];async function i(){if(document.getElementById("user-table-body"))try{d=await b(),o=d.filter(t=>t.is_delete!=!0),m(1)}catch(t){console.error("Lỗi khi tải danh sách người dùng:",t)}}function m(n=1){g=n;const t=(n-1)*c,e=t+c,a=o.slice(t,e);_(a),x(o.length,c,g,m)}function l(n){var t;return(t=window.userPermissionCodes)==null?void 0:t.includes(n)}function _(n){const t=document.getElementById("user-table-body");t&&(t.innerHTML=n.map(e=>{var s,r;let a="";return l("user.delete")&&(a+=`<li class="list-inline-item px-2">
                    <a href="#" onclick="handleDeleteUser('${e.username}')">
                        <i class="bx bx-trash"></i>
                    </a>
                </li>`),l("user.update")&&(a+=`<li class="list-inline-item px-2">
                    <a href="#" onclick="handleHideUser('${e.username}', ${e.hidden})" title="${e.hidden?"Hiện":"Ẩn"} người dùng">
                        <i class="bx ${e.hidden?"bx-hide":"bx-show"}"></i>
                    </a>
                </li>`),l("user.update")&&(a+=`
                <li class="list-inline-item px-2"><a href="#"><i class="bx bx-wrench" 
                    onclick="loadModal('update_user', { username: '${e.username}' })" title="Chỉnh sửa người dùng"
                >
                    </i></a>
                </li>`),l("userrole.update")&&(a+=`
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
                        ${e.is_delete?'<span class="badge badge-danger ml-1">Đã xóa</span>':""}
                    </h5> 
                    </td>
                    <td class="text-center">${e.fullName||`  <div class="team">
                        <span class="badge badge-secondary">Chưa có dữ liệu</span>
                    </div>`}</td>



                    <td class="text-center">${e.email??0}</td>
                    <td class="text-right">
                        <ul class="list-inline font-size-20 contact-links mb-0">
                            ${a}
                        </ul>
                    </td>
                </tr>`}).join(""))}async function L(){if(f)return;f=!0;const n=document.getElementById("filter-role");if(n)try{(await w()).data.forEach(e=>{const a=document.createElement("option");a.value=e.role_name,a.textContent=e.role_name.charAt(0).toUpperCase()+e.role_name.slice(1),n.appendChild(a)})}catch(t){console.error("Lỗi khi tải quyền lọc:",t)}}document.addEventListener("DOMContentLoaded",async()=>{const n=document.getElementById("filter-form");n==null||n.addEventListener("submit",t=>{t.preventDefault();const e=Object.fromEntries(new FormData(n).entries());o=d.filter(s=>{var r,u,h;return(!e.username||((r=s.username)==null?void 0:r.toLowerCase().includes(e.username.toLowerCase())))&&(!e.email||((u=s.email)==null?void 0:u.toLowerCase().includes(e.email.toLowerCase())))&&(!e.fullName||((h=s.fullName)==null?void 0:h.toLowerCase().includes(e.fullName.toLowerCase())))&&(!e.role||(s.roles||[]).includes(e.role))&&(e.deletedStatus==="deleted"&&s.is_delete==!0||e.deletedStatus==="all"||!e.deletedStatus&&s.is_delete!=!0)}),m(1)}),await i(),await L()});window.handleDeleteUser=async function(n){if(confirm(`Bạn có chắc muốn xóa tài khoản ${n}?`))try{const t=await p({username:n,is_delete:!0});y({type:"success",title:"Thành công",message:"xóa người dùng thành công"}),await i()}catch(t){alert(t.message)}};window.handleHideUser=async function(n,t){if(confirm(`Bạn có chắc muốn ẩn tài khoản ${n}?`))try{const e=await p({username:n,hidden:!t});y({type:"success",title:"Thành công",message:t?"hiện người dùng thành công":"ẩn người dùng thành công"}),await i()}catch(e){alert(e.message)}};window.initUserCreateModal=async function(){const n=document.getElementById("role-checkboxes");if(n){n.innerHTML="";try{const t=await w();if(!t.data.length){n.innerHTML="<p class='text-muted'>Không có quyền nào để hiển thị</p>";return}n.innerHTML=t.data.map(e=>`
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" id="role_${e.role_name}" value="${e.role_name}">
                    <label class="form-check-label" for="role_${e.role_name}">
                        ${e.role_name.charAt(0).toUpperCase()+e.role_name.slice(1)}
                    </label>
                </div>`).join("")}catch(t){console.error("Lỗi khi tải quyền:",t),n.innerHTML="<p class='text-danger'>Không thể tải quyền</p>"}}};window.addEventListener("userCreated",()=>{i()});window.addEventListener("userUpdated",()=>{i()});
