import{b as f,g,e as b,f as _,h as v,i as w}from"./rule-qfv58np9.js";import{k as E}from"./software-DnIRmO8P.js";import{s as i}from"./toast-DwbAm--J.js";import"./api_config-DJf1M6P2.js";document.addEventListener("DOMContentLoaded",async function(){const d=document.getElementById("create-rule-form"),s=document.getElementById("software-rule-table-body"),u=new URLSearchParams(window.location.search).get("id");if(!u){s.innerHTML='<tr><td colspan="5" class="text-danger text-center">Không tìm thấy ID phần mềm trên URL</td></tr>';return}let m=!1;const p=(await E(u)).data.map(t=>t.permissions_name);if(m=p.includes("sửa phần mềm")||p.includes("quản lý quy chế"),!m){const t=document.getElementById("create-rule-button");t&&(t.style.display="none")}async function c(){try{const{data:t=[]}=await w(u);if(t.length===0){s.innerHTML='<tr><td colspan="5" class="text-center">Chưa có quy chế nào</td></tr>';return}s.innerHTML="",t.forEach((e,a)=>{const n=e.rule_name.length>50?e.rule_name.slice(0,50)+"...":e.rule_name,o=`ruleModal${a}`,l=document.createElement("tr");l.innerHTML=`
                                <td>
                                    <span title="${e.rule_name}">${n}</span>
                                </td> 
                                <td>${e.category_rule_name||"<span class='text-muted'>Không có</span>"}</td>
                                <td class="text-right">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#${o}" title="Xem chi tiết">
                                            <i class="mdi mdi-eye-outline"></i>
                                        </button>
                                        ${e.file_url?`<a href="${e.file_url}" class="btn btn-outline-primary btn-sm" target="_blank" title="Tải tệp">
                                                    <i class="mdi mdi-download"></i>
                                                </a>`:`<button class="btn btn-outline-secondary btn-sm" disabled title="Không có tệp">
                                                    <i class="mdi mdi-file-remove-outline"></i>
                                                </button>`}
                                        ${m?`<button class="btn btn-outline-warning btn-sm btn-edit-rule" 
                                                data-id="${e.rule_id}" 
                                                data-name="${e.rule_name}"
                                                data-description="${e.rule_description||""}"
                                                data-category="${e.category_rule_id}"
                                                data-file="${e.file_url||""}"
                                                title="Sửa">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </button>

                                            <button class="btn btn-outline-danger btn-sm btn-delete-rule" 
                                                data-id="${e.software_rule_id}" 
                                                title="Xóa">
                                                <i class="mdi mdi-delete-outline"></i>
                                            </button>`:""}

                                    </div>
                                </td>
                            `;const r=document.createElement("div");r.innerHTML=`
                                    <div class="modal fade" id="${o}" tabindex="-1" role="dialog" aria-labelledby="ruleModalLabel${a}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                            <div class="modal-content shadow">
                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title fw-bold" id="ruleModalLabel${a}">
                                                        <i class="mdi mdi-file-document-outline text-primary me-1"></i> ${e.rule_name}
                                                    </h5> 
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Mô tả:</strong><br>${e.rule_description||"<span class='text-muted'>Không có</span>"}</p>
                                                    <hr>
                                                    <p><strong>Loại quy chế:</strong> ${e.category_rule_name||"<span class='text-muted'>Không có</span>"}</p>
                                                    <p><strong>Tệp:</strong> ${e.file_url?`<a href="${e.file_url}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="mdi mdi-download"></i> Tải tệp
                                                            </a>`:"<span class='text-muted'>Không có</span>"}</p>
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `,document.body.appendChild(r),s.appendChild(l)})}catch(t){s.innerHTML='<tr><td colspan="5" class="text-primary text-center">Không có quy chế nào</td></tr>',console.error(t)}}if(document.addEventListener("click",async function(t){const e=t.target.closest(".btn-delete-rule");if(e){const a=e.dataset.id;if(!confirm("Bạn có chắc muốn xóa quy chế này khỏi phần mềm?"))return;try{await f(a),i("Đã xóa quy chế khỏi phần mềm","success"),await c()}catch(n){console.error("Lỗi khi xóa:",n),i("Xóa thất bại","error")}}}),document.addEventListener("click",async function(t){if(t.target.closest(".btn-edit-rule")){const e=t.target.closest(".btn-edit-rule");document.getElementById("edit-rule-id").value=e.dataset.id,document.getElementById("edit-rule-name").value=e.dataset.name,document.getElementById("edit-rule-description").value=e.dataset.description;const a=e.dataset.category,n=document.getElementById("edit-rule-category");if(n.options.length>0)n.value=a;else{const{data:o=[]}=await g();n.innerHTML="",o.forEach(l=>{const r=document.createElement("option");r.value=l.id,r.textContent=l.name,l.id===parseInt(a)&&(r.selected=!0),n.appendChild(r)})}$("#editRuleModal").modal("show")}}),document.getElementById("edit-rule-form").addEventListener("submit",async function(t){t.preventDefault();const e=document.getElementById("edit-rule-id").value,a=document.getElementById("edit-rule-name").value.trim(),n=document.getElementById("edit-rule-description").value.trim(),o=document.getElementById("edit-rule-category").value,l=document.getElementById("edit-rule-file"),r=l.files.length>0?l.files[0]:null;if(!e||!a||!o){i("Vui lòng nhập đầy đủ thông tin","error");return}const y={id:parseInt(e),name:a,description:n,category_rule_id:parseInt(o),file:r};try{await b(y),i("Cập nhật quy chế thành công","success"),$("#editRuleModal").modal("hide"),await c()}catch(h){console.error("Lỗi cập nhật:",h),i("Cập nhật thất bại","error")}}),d.dataset.initialized)await c();else{d.dataset.initialized="true";try{const{data:t=[]}=await g(),e=document.getElementById("rule-category"),a=document.getElementById("edit-rule-category");a.innerHTML="",t.forEach((n,o)=>{const l=document.createElement("option");l.value=n.id,l.textContent=n.name,o===0&&(l.selected=!0),e.appendChild(l);const r=document.createElement("option");r.value=n.id,r.textContent=n.name,o===0&&(r.selected=!0),a.appendChild(r)})}catch(t){console.error("Không tải được loại quy chế:",t)}await c(),d.addEventListener("submit",async function(t){t.preventDefault();const e=new FormData;e.append("name",d.querySelector("#rule-name").value.trim()),e.append("description",d.querySelector("#rule-description").value.trim()),e.append("category_rule_id",d.querySelector("#rule-category").value);const a=d.querySelector("#rule-file");a.files.length>0&&e.append("file",a.files[0]);try{const{id:n}=await _(e);await v({software_id:parseInt(u),rule_id:parseInt(n)}),i("Tạo và gán quy chế thành công","success"),$("#createRuleModal").modal("hide"),d.reset(),await c()}catch(n){console.error(n),i("Lỗi khi tạo hoặc gán quy chế","error")}})}});
