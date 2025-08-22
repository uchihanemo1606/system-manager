import{g as d}from"./role-DWAQ50LF.js";import"./toast-DwbAm--J.js";import"./api_config-C1dH2VF8.js";async function r(){if(!document.getElementById("role-table-body"))return;const t=(await d()).data;s(t)}function s(o){const e=document.getElementById("role-table-body");e&&(e.innerHTML=o.map(t=>{const a=t.created_at?new Date(t.created_at).toLocaleDateString():"-",n=JSON.stringify(t).replace(/"/g,"&quot;");return`
            <tr>
                <td>
                    <h5 class="text-truncate font-size-14"><a href="#" class="text-dark">${t.role_name}</a></h5>
                </td> 
                <td>${a}</td> 
                <td class="text-right">
                    <div class="dropdown" >
                        <button class="btn btn-link p-0 dropdown-toggle" 
                                type="button"
                                data-role="${n||"{}"}"
                                onclick="loadModal('role_detail', JSON.parse(this.dataset.role))"
                        >
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </button>
                        
                    </div>
                </td>
            </tr>
            `}).join(""))}document.addEventListener("DOMContentLoaded",async()=>{await r()});
