import{d as g,g as y}from"./rule-D9dGEpRQ.js";import{s as d}from"./toast-DwbAm--J.js";import"./api_config-C1dH2VF8.js";let m=[];function o(e){return e.normalize("NFD").replace(/[\u0300-\u036f]/g,"").toLowerCase()}function l(e,t){const a=o(t).split(" "),i=o(e);return a.every(n=>i.includes(n))}function c(e="",t=""){const a=document.getElementById("category-rule-list");a.innerHTML="";const i=m.filter(n=>{const s=l(n.name,e),u=l(n.description||"",t);return s&&u});if(i.length===0){a.innerHTML='<p class="text-muted fst-italic">Không có dữ liệu.</p>';return}i.forEach(n=>{const s=document.createElement("div");s.className=" mb-3 border-start border-3 border-primary shadow-sm",s.innerHTML=`
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-start">
                    <div class="me-3 text-primary mr-2">
                        <i class="mdi mdi-file-document-outline fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-semibold">${n.name}</h5>
                        <p class="mb-0 text-muted">${n.description||"<em>Không có mô tả</em>"}</p>
                    </div>
                </div>
                <div class="text-nowrap">
                    <button class="btn btn-outline-primary btn-sm me-2"  onclick="loadModal('category_rule_detail', { rule_id: '${n.id}' })" title="Xem thêm">
                        <i class="mdi mdi-pencil"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteCategoryRule(${n.id})" title="Xóa">
                        <i class="mdi mdi-trash-can-outline"></i>
                    </button>
                </div>
            </div>
        `,a.appendChild(s)})}async function r(){const e=document.getElementById("category-rule-list");e.innerHTML="<p>Đang tải dữ liệu...</p>";try{const{data:t}=await y();m=t||[];const a=document.getElementById("search-name").value||"",i=document.getElementById("search-description").value||"";c(a,i)}catch(t){t.response&&t.response.status===404||t.status===404?e.innerHTML='<p class="text-warning">Không có dữ liệu.</p>':e.innerHTML=`<p class="text-danger">Lỗi tải dữ liệu: ${t.message}</p>`}}window.deleteCategoryRule=async function(e){if(confirm("Bạn có chắc muốn xóa loại quy chế này?"))try{await g(e),d("Xóa thành công","success"),await r()}catch(t){d("Xóa thất bại","error"),console.error(t)}};window.editCategoryRule=function(e){loadModal("category_rule_edit",{id:e})};document.addEventListener("DOMContentLoaded",()=>{r(),document.getElementById("search-name").addEventListener("input",()=>{const e=document.getElementById("search-name").value,t=document.getElementById("search-description").value;c(e,t)}),document.getElementById("search-description").addEventListener("input",()=>{const e=document.getElementById("search-name").value,t=document.getElementById("search-description").value;c(e,t)}),window.addEventListener("category_rule_created",()=>{r()}),window.addEventListener("category_rule_updated",()=>{r()})});
