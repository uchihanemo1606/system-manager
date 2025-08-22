import{b as m}from"./log-BD_i-c5K.js";import{f as g,a as v,t as h,r as f,g as u,b as c}from"./log_utils-DGHGoPDW.js";import"./api_config-C1dH2VF8.js";let r=4,n=[],d=[],l=1;o();async function o(){const e=new URLSearchParams(window.location.search).get("id");if(!e)return console.error("Không tìm thấy ID trên URL");try{n=await m(e),n.sort((t,i)=>new Date(i.created_at)-new Date(t.created_at)),a(n,1)}catch(t){console.error("Lỗi khi gọi API:",t)}}window.fetchSoftwareLogs=o;document.getElementById("items-per-page").addEventListener("change",e=>{r=parseInt(e.target.value),a(d,1)});document.getElementById("btn-filter").addEventListener("click",()=>{const e=n.filter(t=>g(t));a(e,1)});document.getElementById("btn-reset").addEventListener("click",()=>{v(),a(n,1)});document.getElementById("toggle-filter").addEventListener("click",h);function a(e=[],t=1){d=e,l=t;const i=document.getElementById("log-timeline");i.innerHTML=e.length?e.slice((t-1)*r,t*r).map(y).join(""):'<li class="event-list"><div>Không có lịch sử thay đổi</div></li>',f(e.length,r,l,s=>a(d,s))}function y(e){const t=u(e.message),i=c(e.created_at),s=c(e.updated_at);return`
        <li class="event-list" onclick="loadModal('log_detail', { id: '${e.id}' })" >
            <div class="event-timeline-dot">
                <i class="bx bx-right-arrow-circle"></i>
            </div>
            <div class="media">
                <div class="mr-3">
                    <i class="bx ${t} h4 text-primary"></i>
                </div>
                <div class="media-body">
                    <h5 class="font-size-15">
                        <a href="#" class="text-dark">${e.message||"Không rõ nội dung"}</a>
                    </h5>
                    <div class="small text-muted">Ngày tạo: <b>${i}</b></div>
                    <div class="small text-muted">Ngày cập nhật: <b>${s}</b></div>
                                    <td class="text-center"> 
                </td>
                </div>
            </div>
        </li>`}
