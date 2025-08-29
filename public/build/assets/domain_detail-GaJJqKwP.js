import{b as d,r as c,d as m,u as l}from"./domain-S8asXOxc.js";import{s as r}from"./toast-DwbAm--J.js";import"./api_config-DJf1M6P2.js";function g(t,s){const e=document.querySelector("#hardware-list tbody");if(e.innerHTML="",!t||t.length===0){e.innerHTML='<tr><td class="text-center text-muted">Chưa có phần cứng nào sử dụng tên miền này.</td></tr>';return}t.forEach(n=>{const i=document.createElement("tr");i.innerHTML=`
            <td>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>${n.ip}</strong><br>
                        <small>${n.OS} - ${n.OSver}</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="/hardware_detail?id=${encodeURIComponent(n.ip)}"
                           class="btn btn-sm btn-outline-primary"
                           title="Đi đến phần cứng">
                            <i class="bx bx-right-arrow-circle"></i>
                        </a>
                        <button class="btn btn-sm btn-outline-danger"
                                data-ip="${n.ip}"
                                title="Xoá liên kết"
                                onclick="unlinkHardwareFromDomain(this, '${s.id}')">
                            <i class="mdi mdi-link-off"></i>
                        </button>
                    </div>
                </div>
            </td>
        `,e.appendChild(i)})}function u(t){return t?new Date(t).toLocaleDateString("vi-VN"):"N/A"}async function f(t){let s=!1;if(t){document.getElementById("software-detail-link").addEventListener("click",function(e){e.preventDefault(),window.softwareId?window.location.href=`/software_detail?id=${window.softwareId}`:r({message:"Không tìm thấy thông tin phần mềm.",type:"error"})});try{const{domain:e,hardware:n}=await d({link:t.link,name:t.name}),i=document.getElementById("domain-link");i.textContent=e.link,i.href=e.link,document.getElementById("domain-createdby").textContent=e.createBy,document.getElementById("domain-createdat").textContent=u(e.created_at),e.software&&(document.getElementById("software-name").textContent=e.software.softwareName,document.getElementById("software-language").textContent=e.software.language,document.getElementById("software-version").textContent=e.software.version,window.softwareId=e.software.id),g(n,e)}catch(e){console.error(e)}window.unlinkHardwareFromDomain=async function(e,n){const i=e.dataset.ip;if(!(!i||!n||!confirm(`Bạn có chắc chắn muốn xoá liên kết IP "${i}" khỏi tên miền?`)))try{await c(i,n),r({message:`Đã xoá liên kết IP "${i}" khỏi tên miền.`,type:"success"}),e.closest("tr").remove();const a=document.querySelector("#hardware-list tbody");a.children.length===0&&(a.innerHTML='<tr><td class="text-center text-muted">Chưa có phần cứng nào sử dụng tên miền này.</td></tr>')}catch(a){console.error(a),r({message:a.message||"Không thể xoá liên kết phần cứng.",type:"error"})}},document.getElementById("delete-domain-btn").addEventListener("click",async()=>{if(!t||!t.name){r({message:"Không tìm thấy thông tin tên miền.",type:"error"});return}if(confirm(`Bạn có chắc chắn muốn xóa tên miền "${t.name}" không?`)){r({message:"Tính năng bảo trì?",type:"warning",timeout:3e3});try{await m(t.link),r({message:"Xóa tên miền thành công!",type:"success"}),window.location.reload()}catch(e){console.error(e),r({message:"err.message lỗi ràng buộc khóa",type:"error"})}}}),document.getElementById("edit-domain-btn").addEventListener("click",async()=>{s=!s;const e=document.getElementById("domain-link"),n=document.getElementById("domain-link-input"),i=document.getElementById("edit-domain-btn");if(s)n.value=e.textContent,e.classList.add("d-none"),n.classList.remove("d-none"),i.innerHTML='<i class="mdi mdi-content-save"></i>';else{const o=n.value.trim();if(!o){r({message:"Tên miền và link không được để trống.",type:"warning"});return}try{o===t.link?r({message:"Không có thay đổi nào để cập nhật.",type:"info"}):(await l({id:t.id,name:t.name,link:o}),t.link=o,e.textContent=o,e.href=o,window.dispatchEvent(new CustomEvent("domainUpdated")),r({message:"Cập nhật tên miền thành công!",type:"success"}))}catch(a){console.error(a),r({message:a.message||"Lỗi khi cập nhật tên miền.",type:"error"})}e.classList.remove("d-none"),n.classList.add("d-none"),i.innerHTML='<i class="bx bx-pencil"></i>'}})}}window.initDomainDetailModal=f;
