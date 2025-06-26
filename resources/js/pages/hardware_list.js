import { get_all_hardware } from "../api/hardware";

let allHardwareCache = []; // Lưu dữ liệu tạm để lọc

async function loadHardware() {
    const container = document.getElementById("hardware-container");
    container.innerHTML = ""; // Xóa cũ

    try {
        const allHardware = await get_all_hardware();
        console.log("Tải phần cứng thành công:", allHardware);

        allHardwareCache = allHardware?.data || []; // Lưu vào biến tạm
        renderHardware(allHardwareCache);
    } catch (err) {
        console.error("Lỗi khi tải danh sách phần cứng:", err);
        container.innerHTML = `<div class="col-12 text-center text-danger">Lỗi khi tải dữ liệu!</div>`;
    }
}

function renderHardware(data) {
    const container = document.getElementById("hardware-container");
    container.innerHTML = "";

    if (data.length === 0) {
        container.innerHTML = `<div class="col-12 text-center text-muted">Không có phần cứng nào.</div>`;
        return;
    }

    data.forEach((hw) => {
        const card = `
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card shadow-sm h-100 position-relative">
        
            <!-- IP Góc trên trái --> 
            <div class="position-absolute" style="top: 4px; left: 4px; font-size: 13px;">
                IP: <span class="badge badge-info" style="font-size: 12px;">${hw.ip}</span>
            </div>
            <div class="card-body text-center">
            
                <div class="avatar-sm mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                        ${hw.OS?.charAt(0) || "H"}
                    </span>
                </div>
                
                <h5 class="font-size-15 mb-1">
                    <a href="#" class="text-dark font-weight-bold">${hw.OS} - ${
            hw.dbname
        }</a>
                </h5>

                <div class="d-flex justify-content-center mb-2">
                    <span class="badge badge-light mr-1 medium">RAM: ${
                        hw.ram
                    }</span>
                    <span class="badge badge-light medium">HDD: ${hw.hdd}</span>
                </div>

                <div class="d-flex justify-content-center flex-wrap mb-2">
                    <span class="badge badge-${
                        hw.isVirtualServer ? "secondary" : "info"
                    } m-1">
                        ${hw.isVirtualServer ? "Máy ảo" : "Máy vật lý"}
                    </span>
                    <span class="badge badge-${
                        hw.is_active ? "success" : "secondary"
                    } m-1">
                        ${hw.is_active ? "Đang hoạt động" : "Không hoạt động"}
                    </span>
                </div>

                <p class="text-muted mb-2 medium">Dịch vụ: ${hw.services}</p>
            </div>

            <div class="card-footer bg-light border-top">
                <div class="d-flex justify-content-around font-size-18">
                    <a href="#" title="Sửa" onclick="loadModal('hardware_edit', ${
                        hw.id
                    })" class="text-primary">
                        <i class="bx bx-wrench"></i>
                    </a>
                    <a href="#" title="Xem log" class="text-warning">
                        <i class="bx bx-pie-chart-alt"></i>
                    </a>
                    <a href="/hardware_detail?id=${
                        hw.ip
                    }" title="Chi tiết" class="text-info">
                        <i class="bx bx-user-circle"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    `;
        container.insertAdjacentHTML("beforeend", card);
    });
}

function applyFilter() {
    const ip = document.getElementById("filter-ip").value.toLowerCase();
    const dbname = document.getElementById("filter-dbname").value.toLowerCase();
    const dbversion = document
        .getElementById("filter-dbversion")
        .value.toLowerCase();
    const virtual = document.getElementById("filter-virtual").value;
    const os = document.getElementById("filter-os").value.toLowerCase();
    const osver = document.getElementById("filter-osver").value.toLowerCase();
    const hdd = document.getElementById("filter-hdd").value.toLowerCase();
    const ram = document.getElementById("filter-ram").value.toLowerCase();
    const is_delete = document.getElementById("filter-delete").value;
    const services = document
        .getElementById("filter-services")
        .value.toLowerCase();
    const created_by = document
        .getElementById("filter-createdby")
        .value.toLowerCase();
    const created_at = document.getElementById("filter-createdat").value;
    const updated_at = document.getElementById("filter-updatedat").value;

    const filtered = allHardwareCache.filter((hw) => {
        return (
            (!ip || hw.ip?.toLowerCase().includes(ip)) &&
            (!dbname || hw.dbname?.toLowerCase().includes(dbname)) &&
            (!dbversion || hw.dbversion?.toLowerCase().includes(dbversion)) &&
            (!virtual || String(hw.isVirtualServer) === virtual) &&
            (!os || hw.OS?.toLowerCase().includes(os)) &&
            (!osver || hw.OSver?.toLowerCase().includes(osver)) &&
            (!hdd || hw.hdd?.toLowerCase().includes(hdd)) &&
            (!ram || hw.ram?.toLowerCase().includes(ram)) &&
            (!is_delete || String(hw.is_delete) === is_delete) &&
            (!services || hw.services?.toLowerCase().includes(services)) &&
            (!created_by ||
                hw.created_by?.toLowerCase().includes(created_by)) &&
            (!created_at || hw.created_at?.startsWith(created_at)) &&
            (!updated_at || hw.updated_at?.startsWith(updated_at))
        );
    });

    renderHardware(filtered);
}

window.loadHardware = loadHardware;
window.applyFilter = applyFilter;

loadHardware();

// Gắn sự kiện cho tất cả input/select để lọc tự động
document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll(
        "#filter-ip, #filter-dbname, #filter-dbversion, #filter-virtual, #filter-os, #filter-osver, #filter-hdd, #filter-ram, #filter-delete, #filter-services, #filter-createdby, #filter-createdat, #filter-updatedat"
    );

    inputs.forEach((input) => {
        input.addEventListener("input", applyFilter);
    });
});

// import { get_all_hardware } from "../api/hardware";

// async function loadHardware() {
//     const container = document.getElementById("hardware-container");
//     container.innerHTML = ""; // Xóa cũ

//     try {
//         const allHardware = await get_all_hardware();
//         console.log("Tải phần cứng thành công:", allHardware);

//         if (allHardware?.data?.length > 0) {
//             allHardware.data.forEach(hw => {
//                 const card = `
//                 <div class="col-xl-3 col-sm-6 mb-3">
//                     <div class="card text-center">
//                         <div class="card-body">
//                             <div class="avatar-sm mx-auto mb-4">
//                                 <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
//                                     ${hw.OS?.charAt(0) || "H"}
//                                 </span>
//                             </div>
//                             <h5 class="font-size-15">
//                                 <a href="#" class="text-dark">${hw.OS} - ${hw.dbname}</a>
//                             </h5>
//                             <p class="text-muted">IP: ${hw.ip}</p>
//                             <p class="text-muted">RAM: ${hw.ram} | HDD: ${hw.hdd}</p>
//                             <p class="text-muted">Dịch vụ: ${hw.services}</p>
//                             <div>
//                                 <span class="badge badge-${hw.isVirtualServer ? "Secondary" : "info"} font-size-11 m-1">
//                                     ${hw.isVirtualServer ? "Máy ảo" : "Máy vật lý"}
//                                 </span>
//                                 <span class="badge badge-${hw.is_active ? "success" : "secondary"} font-size-11 m-1">
//                                     ${hw.is_active ? "Đang hoạt động" : "Không hoạt động"}
//                                 </span>
//                             </div>
//                         </div>
//                         <div class="card-footer bg-transparent border-top">
//                             <div class="d-flex font-size-20 contact-links">
//                                 <div class="flex-fill">
//                                     <a href="#" data-toggle="tooltip" title="Sửa" onclick="loadModal('hardware_edit', ${hw.id})">
//                                         <i class="bx bx-wrench"></i>
//                                     </a>
//                                 </div>
//                                 <div class="flex-fill">
//                                     <a href="#" data-toggle="tooltip" title="Log">
//                                         <i class="bx bx-pie-chart-alt"></i>
//                                     </a>
//                                 </div>
//                                 <div class="flex-fill">
//                                     <a href="/hardware_detail?id=${hw.ip}" title="Chi tiết">
//                                         <i class="bx bx-user-circle"></i>
//                                     </a>
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                 </div>`;
//                 container.insertAdjacentHTML("beforeend", card);
//             });
//         } else {
//             container.innerHTML = `<div class="col-12 text-center text-muted">Không có phần cứng nào.</div>`;
//         }
//     } catch (err) {
//         console.error("Lỗi khi tải danh sách phần cứng:", err);
//         container.innerHTML = `<div class="col-12 text-center text-danger">Lỗi khi tải dữ liệu!</div>`;
//     }
// }

// window.loadHardware = loadHardware; // Để dùng trong Blade onclick
// loadHardware();
