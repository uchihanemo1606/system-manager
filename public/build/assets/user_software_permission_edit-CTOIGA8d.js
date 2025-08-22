import{r as h,c as g,e as y}from"./software-BinQehaT.js";import{s as p}from"./toast-DwbAm--J.js";import{p as u}from"./type_permission_create-BOYBh87e.js";import"./api_config-C1dH2VF8.js";import"./user-DYdThU7v.js";import"./hardware-BVsb7eyA.js";let a={username:"",softwareId:"",permissions:[]};window.initUserSoftwarePermissionEditModal=function(r){console.log("Initializing user software permission edit modal with data:",r);const{username:e,targetId:o}=r;if(!e||!o){p({message:"Thiếu thông tin!",type:"error"});return}a={username:e,softwareId:o,permissions:[]};const t=document.getElementById("permissionCheckboxList");t&&(t.innerHTML=""),document.getElementById("savePermissionBtn").onclick=async()=>{try{let i=Array.from(document.querySelectorAll("#permissionCheckboxList input.form-check-input:checked")),n=new Set;i.forEach(c=>{const s=c.value,d=u.software.group.find(l=>l[s]);d?d[s].forEach(l=>n.add(l)):n.add(s)}),n=Array.from(n),await h({username:a.username,softwareId:a.softwareId}),n.length>0&&await g({software_id:a.softwareId,user_name:a.username,permissions:n}),p({message:"Cập nhật quyền thành công!",type:"success"})}catch(i){p({message:"Lỗi: "+i.message,type:"error"})}},w()};async function w(){try{const r=await y({username:a.username,softwareId:a.softwareId});a.permissions=r.map(e=>e.permissions_name),k()}catch(r){p({message:"Lỗi lấy quyền: "+r.message,type:"error"})}}function k(){const r=document.getElementById("permissionCheckboxList");r.innerHTML="",u.software.default.forEach(e=>{const o=a.permissions.includes(e),t=e.replace(/\s+/g,"-").normalize("NFD").replace(/[\u0300-\u036f]/g,"");r.innerHTML+=`
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm-${t}" value="${e}" ${o?"checked":""}>
                <label class="form-check-label" for="perm-${t}">${e}</label>
            </div>
        `}),u.software.group.forEach(e=>{for(const o in e){const t=e[o],i=m=>m.trim().normalize("NFD").replace(/[\u0300-\u036f]/g,""),n=a.permissions.map(i),c=t.every(m=>n.includes(i(m))),d=t.some(m=>n.includes(i(m)))&&!c,l=o.replace(/\s+/g,"-").normalize("NFD").replace(/[\u0300-\u036f]/g,""),f=t.map(m=>`• ${m}`).join(`
`);r.innerHTML+=`
            <div class="form-check mb-2 position-relative" title="${f}">
                <input class="form-check-input group-permission" type="checkbox"
                    id="perm-${l}"
                    value="${o}"
                    data-children='${JSON.stringify(t)}'
                    ${c?"checked":""}
                >
                <label class="form-check-label fw-bold text-primary" for="perm-${l}">
                    ${o}
                    ${d?'<span class="text-danger ms-1" title="Thiếu quyền con">❗</span>':""}
                </label>
            </div>
        `}}),r.querySelectorAll(".group-permission").forEach(e=>{e.addEventListener("change",o=>{JSON.parse(e.dataset.children||"[]").forEach(i=>{const n="perm-"+i.replace(/\s+/g,"-").normalize("NFD").replace(/[\u0300-\u036f]/g,"");let c=document.getElementById(n);if(c)c.checked=e.checked;else{const s=document.createElement("input");s.type="checkbox",s.id=n,s.value=i,s.checked=e.checked,s.classList.add("hidden-child"),s.style.display="none",s.classList.add("form-check-input"),r.appendChild(s)}})})})}
