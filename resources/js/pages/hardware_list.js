import { get_all_hardware } from "../api/hardware";
import {
    get_all_hardware_database,
    get_versions_by_dbname,
    get_all_hardware_os,
    get_versions_by_os
} from "../api/hardware_data";
let allHardwareCache = []; // Lưu dữ liệu tạm để lọc

async function loadHardware() {
    const container = document.getElementById("hardware-container");
    container.innerHTML = ""; // Xóa cũ

    try {
        const allHardware = await get_all_hardware();
        allHardwareCache = allHardware?.data || [];

        allHardwareCache.sort((a, b) => {
            return (b.is_active === true) - (a.is_active === true);
        });

        const isDeleteFilter = document.getElementById("filter-delete")?.value;
        console.log(allHardwareCache);
        // Nếu không chọn trạng thái xóa → chỉ hiển thị phần cứng chưa xóa
        if (!isDeleteFilter) {
            const filtered = allHardwareCache.filter(hw => !hw.is_delete);
            renderHardware(filtered);
        } else {
            applyFilter(); // nếu có chọn trạng thái xóa → áp dụng toàn bộ filter
        }

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
        const cssActive = !hw.is_active && "bg-light text-muted";
        const cssbadge = !hw.is_active ? "badge-Secondary" : "badge-primary";
        const badgeStyle = hw.is_active ? "opacity: 1;" : "opacity: 0.5;";
        const OSverDeleteCss = hw.is_delete ? "top: 24px;" : "top: 4px;";
        const deleteLabel = hw.is_delete
            ? `<div style="
                    position: absolute;
                    top: 0;
                    right: 0;
                    background: red;
                    color: white;
                    font-size: 12px;
                    padding: 2px 6px;
                    font-weight: bold;
                    border-bottom-left-radius: 5px;
                ">ĐÃ XÓA</div>`
            : "";

        const card = `
        <div class="col-xl-3 col-sm-6 mb-3 ">
         <div class="card shadow-sm h-100 position-relative ${cssActive} border">
               ${deleteLabel}
            <!-- IP Góc trên trái --> 
            <div class="position-absolute" style="top: 4px; left: 4px; font-size: 13px;">
                IP: 
                <span class="badge ${cssbadge}" style="font-size: 12px; ${badgeStyle}">
                    ${hw.ip}
                </span>
            </div>
            <div class="position-absolute" style="${OSverDeleteCss} right: 4px; font-size: 13px; z-index: 5;">
                <span class="badge" style="font-size: 12px; ${badgeStyle}">
                    ${hw.OSver || "N/A"}
                </span>
            </div>
            <div class="card-body text-center">
            
                <div class="avatar-sm mx-auto mb-3 mt-1">
                    <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                        ${hw.OS?.charAt(0) || "H"}
                    </span>
                </div>
                
                <h5 class="font-size-15 mb-1">
                    <a href="#" class="text-dark font-weight-bold">${hw.OS} - ${hw.dbname
            }</a>
                </h5>

                <div class="d-flex justify-content-center mb-2">
                    <span class="badge badge-light mr-1 medium">RAM: ${hw.ram
            }</span>
                    <span class="badge badge-light medium">HDD: ${hw.hdd}</span>
                </div>

                <div class="d-flex justify-content-center flex-wrap mb-2">
                    <span class="badge badge-${hw.isVirtualServer ? "secondary" : "info"
            } m-1">
                        ${hw.isVirtualServer ? "Máy ảo" : "Máy vật lý"}
                    </span>
                    <span class="badge badge-${hw.is_active ? "success" : "secondary"
            } m-1">
                        ${hw.is_active ? "Đang hoạt động" : "Không hoạt động"}
                    </span>
                </div>

                <p class="text-muted mb-2 medium">Dịch vụ: ${hw.services}</p>
            </div>

            <div class="card-footer border-top ${cssActive}" style="background-color: white;">
                <div class="d-flex justify-content-around font-size-18">
                    <a  href="/hardware_detail?id=${hw.ip
            }&edit=true" title="Sửa"  class="text-primary">
                        <i class="bx bx-wrench"></i>
                    </a>
                    <a href="#" title="Xem log" class="text-primary">
                        <i class="bx bx-pie-chart-alt"></i>
                    </a>
                    <a href="/hardware_detail?id=${hw.ip
            }" title="Chi tiết" class="text-primary">
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
function applySort(data) {
    const sortOption = document.getElementById("sort-option").value;
    const key = sortOption.replace("-", "");
    const asc = !sortOption.startsWith("-");
    return data.sort((a, b) => {
        const valA = a[key]?.toString().toLowerCase() || "";
        const valB = b[key]?.toString().toLowerCase() || "";
        return asc ? valA.localeCompare(valB) : valB.localeCompare(valA);
    });
}
async function initHardwareFilterSelects() {
    const dbSelect = document.getElementById("filter-dbname");
    const dbverSelect = document.getElementById("filter-dbversion");
    const osSelect = document.getElementById("filter-os");
    const osverSelect = document.getElementById("filter-osver"); 

    // Tắt version ban đầu
    dbverSelect.disabled = true;
    osverSelect.disabled = true;

    // Lấy tất cả tên CSDL & OS
    const dbs = await get_all_hardware_database();
    const oss = await get_all_hardware_os();

    const uniqueDbNames = [...new Set(dbs.data.map(d => d.dbname))];
    const uniqueOSNames = [...new Set(oss.data.map(o => o.OS))];

    dbSelect.innerHTML = `<option></option>` + uniqueDbNames.map(n => `<option value="${n}">${n}</option>`).join('');
    osSelect.innerHTML = `<option></option>` + uniqueOSNames.map(n => `<option value="${n}">${n}</option>`).join('');

    // Gắn select2
    [dbSelect, dbverSelect, osSelect, osverSelect].forEach(el => {
        $(el).select2({
            placeholder: "Chọn hoặc tìm...",
            allowClear: true,
            width: "100%",
            dropdownParent: $('#hardware-container').parent()

        });
    });

    // Khi chọn dbname → load dbversion
    $(dbSelect).on("change", async function () {
        const val = this.value;
        dbverSelect.innerHTML = `<option></option>`;
        $(dbverSelect).val(null).trigger("change");
        dbverSelect.disabled = true;
        if (!val) return;

        try {
            const res = await get_versions_by_dbname(val);
            dbverSelect.innerHTML = `<option></option>` + res.data.map(v => `<option value="${v}">${v}</option>`).join('');
            dbverSelect.disabled = false;
        } catch (err) {
            console.error("Lỗi khi lấy DB version:", err);
        }
    });

    // Khi chọn OS → load OSver
    $(osSelect).on("change", async function () {
        const val = this.value;
        osverSelect.innerHTML = `<option></option>`;
        $(osverSelect).val(null).trigger("change");
        osverSelect.disabled = true;
        if (!val) return;

        try {
            const res = await get_versions_by_os(val);
            osverSelect.innerHTML = `<option></option>` + res.data.map(v => `<option value="${v}">${v}</option>`).join('');
            osverSelect.disabled = false;
        } catch (err) {
            console.error("Lỗi khi lấy OS version:", err);
        }
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
window.addEventListener("hardwareCreated", loadHardware);
loadHardware();

// Gắn sự kiện cho tất cả input/select để lọc tự động
document.addEventListener("DOMContentLoaded", async () => {

    await initHardwareFilterSelects(); // Bắt buộc gọi ở đây

    const inputs = document.querySelectorAll(
        "#filter-ip, #filter-dbname, #filter-dbversion, #filter-virtual, #filter-os, #filter-osver, #filter-hdd, #filter-ram, #filter-delete, #filter-services, #filter-createdby, #filter-createdat, #filter-updatedat"
    );

    inputs.forEach((input) => {
        input.addEventListener("change", applyFilter);
    });
});
