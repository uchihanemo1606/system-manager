import{g as b}from"./software-DnIRmO8P.js";import{s as h}from"./toast-DwbAm--J.js";import"./api_config-DJf1M6P2.js";let s=[];async function o(){const e=document.getElementById("software-list-container");e.innerHTML="";try{const t=await b();if(t.status!=="success"||!Array.isArray(t.data))throw new Error("Dữ liệu không hợp lệ");if(s=t.data||[],document.getElementById("filter-delete").value)r();else{const a=s.filter(l=>!l.is_delete);p(a)}}catch(t){console.error(t),h({message:(t==null?void 0:t.message)||"Tải danh sách phần mềm thất bại!",type:"error",timeout:2e3})}}function p(e){const t=document.getElementById("software-list-container");if(t.innerHTML="",e.length===0){t.innerHTML='<div class="col-12 text-center text-muted">Không tìm thấy phần mềm nào.</div>';return}e.forEach(i=>{t.innerHTML+=y(i)})}function r(){const e=document.getElementById("filter-name").value.toLowerCase(),t=document.getElementById("filter-language").value.toLowerCase(),i=document.getElementById("filter-version").value.toLowerCase(),a=document.getElementById("filter-delete").value,l=document.getElementById("filter-createdby").value.toLowerCase(),d=document.getElementById("filter-createdat").value,v=s.filter(n=>{var c,m,u,f,g;return(!e||((c=n.softwareName)==null?void 0:c.toLowerCase().includes(e)))&&(!t||((m=n.language)==null?void 0:m.toLowerCase().includes(t)))&&(!i||((u=n.version)==null?void 0:u.toLowerCase().includes(i)))&&(!a||String(n.is_delete)===a)&&(!l||((f=n.user_createby)==null?void 0:f.toLowerCase().includes(l)))&&(!d||((g=n.created_at)==null?void 0:g.startsWith(d)))});p(v)}function y(e){return`
    <div class="col-12 col-sm-6 col-lg-3 mb-2">
        <div class="card position-relative m-0 ${e.is_delete?"border-danger":""}">
            ${e.is_delete?`
                <div style="
                    position: absolute;
                    top: 0;
                    left: 0;
                    background: red;
                    color: white;
                    padding: 2px 6px;
                    font-size: 12px;
                    font-weight: bold;
                    border-bottom-right-radius: 4px;
                    z-index: 1;
                ">
                    ĐÃ XÓA
                </div>`:""}

            <div style="
                position: absolute;
                top: 0;
                right: 0;
                background: #007bff;
                color: white;
                padding: 2px 6px;
                font-size: 12px;
                font-weight: bold;
                border-bottom-left-radius: 4px;
                z-index: 1;
            ">
                ${e.version||"N/A"}
            </div>

            <div class="card-body">
                <div class="media">
                    <div class="media-body overflow-hidden">
                        <h5 class="font-size-15 mb-2 text-truncate">
                            <span class="font-weight-normal text-muted">Tên:</span>
                            <a href="software_detail?id=${e.id}" class="text-dark font-weight-bold">
                                ${e.softwareName}
                            </a>
                        </h5> 
                        <div class="d-flex flex-wrap mb-2">
                            <div class="mr-3 mb-1">
                                <span class="text-muted">Ngôn ngữ:</span>
                                <span class="badge badge-primary">${e.language}</span>
                            </div>
                            <div class="mb-1">
                                <span class="text-muted">Tạo bởi:</span>
                                <span class="text-success font-weight-bold">${e.user_createby}</span>
                            </div>
                        </div>
                        <p class="text-muted limit-3-lines mb-0">
                            ${e.description||"Không có mô tả"}
                        </p>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 border-top d-flex justify-content-between">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item" data-toggle="tooltip" title="Ngày tạo">
                        <i class="bx bx-calendar mr-1"></i> ${x(e.created_at)}
                    </li>
                </ul>
                <ul class="list-inline mb-0"> 
                    <li class="list-inline-item">
                        <a href="/software_detail?id=${e.id}" title="Chi tiết" class="text-muted d-inline-flex align-items-center">
                            <i class="bx bx-link-external mr-1"></i> Chi tiết
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>`}function x(e){return new Date(e).toLocaleDateString("vi-VN")}window.loadSoftware=o;window.applyFilter=r;window.addEventListener("softwareCreated",o);document.addEventListener("DOMContentLoaded",()=>{o(),document.querySelectorAll("#filter-name, #filter-language, #filter-version, #filter-delete, #filter-createdby, #filter-createdat").forEach(t=>{const i=t.tagName.toLowerCase()==="select"||t.type==="date"?"change":"input";t.addEventListener(i,r)})});
