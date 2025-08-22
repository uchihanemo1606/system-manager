import{remove_user_permission_in_hardware as f,create_hardware_permission as g,get_all_permission_hardware_by_user as y}from"./hardware-BVsb7eyA.js";import{s as d}from"./toast-DwbAm--J.js";import{p}from"./type_permission_create-BOYBh87e.js";import"./api_config-C1dH2VF8.js";import"./user-DYdThU7v.js";import"./software-BinQehaT.js";let c={username:"",hardwareIp:"",permissions:[]};window.initUserHardwarePermissionEditModal=function(n){const{username:e,ip:a}=n;if(!e||!a){d({message:"Thiếu thông tin!",type:"error"});return}c={username:e,hardwareIp:a,permissions:[]},document.getElementById("savePermissionBtn").onclick=async()=>{try{let s=Array.from(document.querySelectorAll("#permissionCheckboxList input.form-check-input:checked")).map(r=>r.value);const i=new Set;s.forEach(r=>{const l=p.hardware.group.find(m=>m[r]);l?l[r].forEach(m=>i.add(m)):i.add(r)});const o=Array.from(i);await f({username:c.username,hardwareIp:c.hardwareIp}),o.length>0&&await g({hardware_ip:c.hardwareIp,users:[{user_name:c.username,permissions:o}]}),d({message:"Cập nhật quyền thành công!",type:"success"})}catch(s){d({message:"Lỗi: "+s.message,type:"error"})}},w()};async function w(){try{const n=await y({username:c.username,hardwareIp:c.hardwareIp});c.permissions=n.map(e=>e.permissions_name),k()}catch(n){d({message:"Lỗi lấy quyền: "+n.message,type:"error"})}}function k(){const n=document.getElementById("permissionCheckboxList");n.innerHTML="",p.hardware.default.forEach(e=>{const a=c.permissions.includes(e),s=e.replace(/\s+/g,"-").normalize("NFD").replace(/[\u0300-\u036f]/g,"");n.innerHTML+=`
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm-${s}" value="${e}" ${a?"checked":""}>
                <label class="form-check-label" for="perm-${s}">${e}</label>
            </div>
        `}),p.hardware.group.forEach(e=>{for(const a in e){const s=e[a],i=t=>t.trim().normalize("NFD").replace(/[\u0300-\u036f]/g,""),o=c.permissions.map(i),r=s.every(t=>o.includes(i(t))),m=s.some(t=>o.includes(i(t)))&&!r,h=a.replace(/\s+/g,"-").normalize("NFD").replace(/[\u0300-\u036f]/g,""),u=s.map(t=>`• ${t}`).join(`
`);n.innerHTML+=`
                <div class="form-check mb-2 position-relative" title="${u}">
                    <input class="form-check-input group-permission" type="checkbox"
                        id="perm-${h}"
                        value="${a}"
                        data-children='${JSON.stringify(s)}'
                        ${r?"checked":""}
                    >
                    <label class="form-check-label fw-bold text-primary" for="perm-${h}">
                        ${a}
                        ${m?'<span class="text-danger ms-1" title="Thiếu quyền con">❗</span>':""}
                    </label>
                </div>
            `}}),n.querySelectorAll(".group-permission").forEach(e=>{e.addEventListener("change",()=>{JSON.parse(e.dataset.children||"[]").forEach(s=>{const i="perm-"+s.replace(/\s+/g,"-").normalize("NFD").replace(/[\u0300-\u036f]/g,"");let o=document.getElementById(i);if(o)o.checked=e.checked;else{const r=document.createElement("input");r.type="checkbox",r.id=i,r.value=s,r.checked=e.checked,r.classList.add("hidden-child","form-check-input"),r.style.display="none",n.appendChild(r)}})})})}
