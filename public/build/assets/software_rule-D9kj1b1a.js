import{b as h,g as m,e as y,f,h as b,i as _}from"./rule-D9dGEpRQ.js";import{s as i}from"./toast-DwbAm--J.js";import"./api_config-C1dH2VF8.js";document.addEventListener("DOMContentLoaded",async function(){const d=document.getElementById("create-rule-form"),s=document.getElementById("software-rule-table-body"),u=new URLSearchParams(window.location.search).get("id");if(!u){s.innerHTML='<tr><td colspan="5" class="text-danger text-center">Không tìm thấy ID phần mềm trên URL</td></tr>';return}async function c(){try{const{data:n=[]}=await _(u);if(n.length===0){s.innerHTML='<tr><td colspan="5" class="text-center">Chưa có quy chế nào</td></tr>';return}s.innerHTML="",n.forEach((e,a)=>{const t=e.rule_name.length>50?e.rule_name.slice(0,50)+"...":e.rule_name,o=`ruleModal${a}`,l=document.createElement("tr");l.innerHTML=`
                                <td>
                                    <span title="${e.rule_name}">${t}</span>
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
                                        <button class="btn btn-outline-warning btn-sm btn-edit-rule" 
                                            data-id="${e.rule_id}" 
                                            data-name="${e.rule_name}"
                                            data-description="${e.rule_description||""}"
                                            data-category="${e.category_rule_id}"
                                            data-file="${e.file_url||""}"
                                            title="Sửa">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </button>

                                        <button class="btn btn-outline-danger btn-sm btn-delete-rule" data-id="${e.software_rule_id}" title="Xóa">
                                            <i class="mdi mdi-delete-outline"></i>
                                        </button>
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
                                `,document.body.appendChild(r),s.appendChild(l)})}catch(n){s.innerHTML='<tr><td colspan="5" class="text-primary text-center">Không có quy chế nào</td></tr>',console.error(n)}}if(document.addEventListener("click",async function(n){const e=n.target.closest(".btn-delete-rule");if(e){const a=e.dataset.id;if(!confirm("Bạn có chắc muốn xóa quy chế này khỏi phần mềm?"))return;try{await h(a),i("Đã xóa quy chế khỏi phần mềm","success"),await c()}catch(t){console.error("Lỗi khi xóa:",t),i("Xóa thất bại","error")}}}),document.addEventListener("click",async function(n){if(n.target.closest(".btn-edit-rule")){const e=n.target.closest(".btn-edit-rule");document.getElementById("edit-rule-id").value=e.dataset.id,document.getElementById("edit-rule-name").value=e.dataset.name,document.getElementById("edit-rule-description").value=e.dataset.description;const a=e.dataset.category,t=document.getElementById("edit-rule-category");if(t.options.length>0)t.value=a;else{const{data:o=[]}=await m();t.innerHTML="",o.forEach(l=>{const r=document.createElement("option");r.value=l.id,r.textContent=l.name,l.id===parseInt(a)&&(r.selected=!0),t.appendChild(r)})}$("#editRuleModal").modal("show")}}),document.getElementById("edit-rule-form").addEventListener("submit",async function(n){n.preventDefault();const e=document.getElementById("edit-rule-id").value,a=document.getElementById("edit-rule-name").value.trim(),t=document.getElementById("edit-rule-description").value.trim(),o=document.getElementById("edit-rule-category").value,l=document.getElementById("edit-rule-file"),r=l.files.length>0?l.files[0]:null;if(!e||!a||!o){i("Vui lòng nhập đầy đủ thông tin","error");return}const p={id:parseInt(e),name:a,description:t,category_rule_id:parseInt(o),file:r};try{await y(p),i("Cập nhật quy chế thành công","success"),$("#editRuleModal").modal("hide"),await c()}catch(g){console.error("Lỗi cập nhật:",g),i("Cập nhật thất bại","error")}}),d.dataset.initialized)await c();else{d.dataset.initialized="true";try{const{data:n=[]}=await m(),e=document.getElementById("rule-category"),a=document.getElementById("edit-rule-category");a.innerHTML="",n.forEach((t,o)=>{const l=document.createElement("option");l.value=t.id,l.textContent=t.name,o===0&&(l.selected=!0),e.appendChild(l);const r=document.createElement("option");r.value=t.id,r.textContent=t.name,o===0&&(r.selected=!0),a.appendChild(r)})}catch(n){console.error("Không tải được loại quy chế:",n)}await c(),d.addEventListener("submit",async function(n){n.preventDefault();const e=new FormData;e.append("name",d.querySelector("#rule-name").value.trim()),e.append("description",d.querySelector("#rule-description").value.trim()),e.append("category_rule_id",d.querySelector("#rule-category").value);const a=d.querySelector("#rule-file");a.files.length>0&&e.append("file",a.files[0]);try{const{id:t}=await f(e);await b({software_id:parseInt(u),rule_id:parseInt(t)}),i("Tạo và gán quy chế thành công","success"),$("#createRuleModal").modal("hide"),d.reset(),await c()}catch(t){console.error(t),i("Lỗi khi tạo hoặc gán quy chế","error")}})}});
