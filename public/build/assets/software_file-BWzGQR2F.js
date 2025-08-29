import{k as d,l as c}from"./software-DnIRmO8P.js";import{g as f}from"./api_config-DJf1M6P2.js";document.addEventListener("DOMContentLoaded",function(){const n=new URLSearchParams(window.location.search).get("id"),l=f("auth_token");if(!n)return;let o=!1;(async function(){try{const t=await d(n);console.log("User permissions for this software:",t);const s=t.data.map(e=>e.permissions_name).includes("sửa phần mềm");if(s){const e=document.createElement("li");e.className="list-inline-item px-2",e.innerHTML=`
                    <a href="#" title="Tạo tập tin mới"
                        onclick="loadModal('software_file_create', { id: '${n}', type: 'software_file' })">
                        <i class="bx bx-plus"></i> Thêm tập tin
                    </a>
                `;const a=document.getElementById("create_software_file");a&&a.appendChild(e)}await r(s)}catch(t){console.error("Lỗi khi kiểm tra quyền hoặc tải file:",t)}window.addEventListener("softwareFileUpdated",()=>r(o)),window.addEventListener("softwareFileCreated",()=>r(o))})();async function r(t){try{const s=(await c(n)).data||[],e=document.getElementById("software-file-list");if(!e)return;if(s.length===0){e.innerHTML='<tr><td colspan="3" class="text-muted text-center">Chưa có tập tin nào.</td></tr>';return}e.innerHTML=s.map(a=>`
                <tr>
                    <td style="width: 45px;">
                        <div class="avatar-sm">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-24">
                                <i class="bx bxs-file-doc"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <h5 class="font-size-14 mb-1">
                            <a href="api/${a.file_path}/${a.software_id}?token=${l}" class="text-dark" target="_blank">${a.file_name}</a>
                        </h5>
                        <small>Người tạo: ${a.username} | Mô tả: ${a.description||"Không có"}</small>
                    </td>
                    ${t?`
                    <td>
                        <div class="text-center">
                            <a href="#" class="edit-file-link" data-file='${JSON.stringify(a)}'>sửa</a>
                        </div>
                    </td>`:""}
                </tr>
            `).join("")}catch(i){console.error("Lỗi khi lấy danh sách file phần mềm:",i)}}document.addEventListener("click",function(t){if(t.target.matches(".edit-file-link")){t.preventDefault();const i=JSON.parse(t.target.dataset.file);loadModal("software_file_edit",{filedata:i})}})});
