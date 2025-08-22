import{k as l}from"./software-BinQehaT.js";import"./api_config-C1dH2VF8.js";document.addEventListener("DOMContentLoaded",function(){const i=new URLSearchParams(window.location.search).get("id");if(!i)return;const n=document.createElement("li");n.className="list-inline-item px-2",n.innerHTML=`
        <a href="#" title="Tạo tập tin mới"
            onclick="loadModal('software_file_create', { id: '${i}', type: 'software_file' })">
            <i class="bx bx-plus"></i> Thêm tập tin
        </a>
    `;const d=document.getElementById("create_software_file");d&&d.appendChild(n);async function s(){try{const a=(await l(i)).data||[],r=document.getElementById("software-file-list");if(!r)return;if(a.length===0){r.innerHTML='<tr><td colspan="3" class="text-muted text-center">Chưa có tập tin nào.</td></tr>';return}r.innerHTML=a.map(e=>`
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
                            <a href="${e.file_path}" class="text-dark" target="_blank">${e.file_name}</a>
                        </h5>
                        <small>Người tạo: ${e.username} | Mô tả: ${e.description||"Không có"}</small>
                    </td>
                    <td>
                        <div class="text-center">
                            <a href="#" class="edit-file-link" data-file='${JSON.stringify(e)}'>sửa</a>
                        </div>
                    </td>
                </tr>
            `).join("")}catch(t){console.error("Lỗi khi lấy danh sách file phần mềm:",t)}}s(),window.addEventListener("softwareFileUpdated",s),window.addEventListener("softwareFileCreated",s),document.addEventListener("click",function(t){if(t.target.matches(".edit-file-link")){t.preventDefault();const a=JSON.parse(t.target.dataset.file);loadModal("software_file_edit",{filedata:a})}})});
