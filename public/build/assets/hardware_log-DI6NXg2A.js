import{c as m}from"./log-BD_i-c5K.js";import{f as g,a as h,t as v,r as u,g as f,b as c}from"./log_utils-DGHGoPDW.js";import"./api_config-C1dH2VF8.js";let r=4,a=[],d=[],l=1;o();async function o(){const e=new URLSearchParams(window.location.search).get("id");if(!e)return console.error("Không tìm thấy ID trên URL");try{a=await m(e),a.sort((t,i)=>new Date(i.created_at)-new Date(t.created_at)),n(a,1)}catch(t){console.error("Lỗi khi gọi API:",t)}}window.fetchHardwareLogs=o;document.getElementById("items-per-page").addEventListener("change",e=>{r=parseInt(e.target.value),n(d,1)});document.getElementById("btn-filter").addEventListener("click",()=>{const e=a.filter(t=>g(t));n(e,1)});document.getElementById("btn-reset").addEventListener("click",()=>{h(),n(a,1)});document.getElementById("toggle-filter").addEventListener("click",v);function n(e=[],t=1){d=e,l=t;const i=document.getElementById("log-timeline");i.innerHTML=e.length?e.slice((t-1)*r,t*r).map(y).join(""):'<li class="event-list"><div>Không có lịch sử thay đổi</div></li>',u(e.length,r,l,s=>n(d,s))}function y(e){const t=f(e.message),i=c(e.created_at),s=c(e.updated_at);return`
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
                </div>
            </div>
        </li>`}
