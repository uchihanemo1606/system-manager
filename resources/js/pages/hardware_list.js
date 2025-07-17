import { get_all_hardware } from "../api/hardware";
import {
    get_all_hardware_database,
    get_versions_by_dbname,
    get_all_hardware_os,
    get_versions_by_os
} from "../api/hardware_data";

let allHardwareCache = [];

async function loadHardware() {
    const container = document.getElementById("hardware-container");
    container.innerHTML = "";
    try {
        const { data = [] } = await get_all_hardware();
        allHardwareCache = data.sort((a, b) => b.is_active - a.is_active);

        const isDelete = document.getElementById("filter-delete")?.value;
        isDelete ? applyFilter() : renderHardware(allHardwareCache.filter(hw => !hw.is_delete));
    } catch (err) {
        console.error("Lỗi tải phần cứng:", err);
        container.innerHTML = `<div class="col-12 text-center text-danger">Lỗi khi tải dữ liệu!</div>`;
    }
}

function renderHardware(list) {
    const container = document.getElementById("hardware-container");
    container.innerHTML = list.length ? "" : `<div class="col-12 text-center text-muted">Không có phần cứng nào.</div>`;
    list.forEach(hw => {
        const active = hw.is_active;
        const deleted = hw.is_delete;
        const card = `
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-3">
            <div class="shadow-sm h-100 position-relative ${!active ? "bg-light text-muted border" : "border"}">
                ${deleted ? `<div style="position:absolute;top:0;right:0;background:red;color:white;font-size:11px;padding:2px 6px;font-weight:600;border-bottom-left-radius:5px;z-index:10">ĐÃ XÓA</div>` : ""}
                <div class="position-absolute" style="top:4px;left:4px;font-size:13px;z-index:2">
                    <span class="badge ${active ? "badge-primary" : "badge-secondary"} badge-custom">IP: ${hw.ip}</span>
                </div>
                <div class="position-absolute" style="top:${deleted ? "24px" : "4px"}; right:4px; font-size:12px; z-index:2;">
                    <span class="badge badge-info badge-custom" style="opacity: ${active ? 1 : 0.6}">${hw.OSver || "N/A"}</span>
                </div>
                <div class="p-4 text-center">
                    <h5 class="font-size-15 mb-1 font-weight-bold text-dark">${hw.OS} - ${hw.dbname}</h5>
                    <div class="d-flex justify-content-center gap-2 mb-2">
                        <span class="badge badge-light badge-custom">RAM: ${hw.ram}</span>
                        <span class="badge badge-light badge-custom">HDD: ${hw.hdd}</span>
                    </div>
                    <div class="d-flex justify-content-center flex-wrap gap-2">
                        <span  class="badge badge-${hw.isVirtualServer ? "secondary" : "info"} badge-custom">${hw.isVirtualServer ? "Máy ảo" : "Máy vật lý"}</span>
                        <span class="badge badge-${active ? "success" : "secondary"} badge-custom">${active ? "Đang hoạt động" : "Không hoạt động"}</span>
                    </div>
                    <p class="text-muted one-line mb-0 medium" title="${hw.services}">
                        <i class="mdi mdi-server-network"></i> Dịch vụ: ${hw.services}
                    </p>
                </div>
                <div class="card-footer bg-white border-top ${!active ? "bg-light text-muted" : ""}">
                    <div class="d-flex justify-content-around font-size-18">
                        <a href="/hardware_detail?id=${hw.ip}&edit=true" title="Sửa" class="text-primary"><i class="bx bx-wrench"></i></a>
                        <a href="#" title="Xem log" class="text-primary"><i class="bx bx-pie-chart-alt"></i></a>
                        <a href="/hardware_detail?id=${hw.ip}" title="Chi tiết" class="text-primary"><i class="bx bx-user-circle"></i></a>
                    </div>
                </div>
            </div>
        </div>`;
        container.insertAdjacentHTML("beforeend", card);
    });
}

async function initHardwareFilterSelects() {
    const [dbSelect, dbverSelect, osSelect, osverSelect] = [
        "filter-dbname", "filter-dbversion", "filter-os", "filter-osver"
    ].map(id => document.getElementById(id));

    const setupSelect = (el, list) => {
        el.innerHTML = `<option></option>` + list.map(val => `<option value="${val}">${val}</option>`).join('');
    };

    const dbNames = [...new Set((await get_all_hardware_database()).data.map(d => d.dbname))];
    const osNames = [...new Set((await get_all_hardware_os()).data.map(o => o.OS))];

    setupSelect(dbSelect, dbNames);
    setupSelect(osSelect, osNames);
    [dbverSelect, osverSelect].forEach(el => el.disabled = true);

    [dbSelect, dbverSelect, osSelect, osverSelect].forEach(el =>
        $(el).select2({ placeholder: "Chọn hoặc tìm...", allowClear: true, width: "100%", dropdownParent: $('#hardware-container').parent() })
    );

    $(dbSelect).on("change", async function () {
        dbverSelect.innerHTML = `<option></option>`;
        $(dbverSelect).val(null).trigger("change");
        dbverSelect.disabled = true;
        applyFilter();

        if (!this.value) return;
        const res = await get_versions_by_dbname(this.value);
        setupSelect(dbverSelect, res.data);
        dbverSelect.disabled = false;
    });

    $(osSelect).on("change", async function () {
        osverSelect.innerHTML = `<option></option>`;
        $(osverSelect).val(null).trigger("change");
        osverSelect.disabled = true;
        applyFilter();

        if (!this.value) return;
        const res = await get_versions_by_os(this.value);
        setupSelect(osverSelect, res.data);
        osverSelect.disabled = false;
    });
}
function parseCompareValue(str) {
    if (!str) return null;
    const match = str.match(/^([<>]=?|=)?\s*(\d+)(gb|mb|tb)?$/i);
    if (!match) return null;
    const [, operator = "=", valueStr, unit = "GB"] = match;
    const multiplier = { mb: 1, gb: 1024, tb: 1024 * 1024 };
    const value = parseInt(valueStr, 10) * (multiplier[unit.toLowerCase()] || 1024);
    return { operator, value };
}

function compareValue(hwValueStr, compare) {
    const match = hwValueStr?.match(/^(\d+)(gb|mb|tb)?$/i);
    if (!match) return false;
    const [, valueStr, unit = "GB"] = match;
    const multiplier = { mb: 1, gb: 1024, tb: 1024 * 1024 };
    const hwVal = parseInt(valueStr, 10) * (multiplier[unit.toLowerCase()] || 1024);
    switch (compare.operator) {
        case ">": return hwVal > compare.value;
        case ">=": return hwVal >= compare.value;
        case "<": return hwVal < compare.value;
        case "<=": return hwVal <= compare.value;
        case "=": return hwVal === compare.value;
        default: return false;
    }
}

function applyFilter() {
    const getVal = id => document.getElementById(id).value?.toLowerCase() || "";
    const getRaw = id => document.getElementById(id).value || "";

    const f = {
        ip: getVal("filter-ip"),
        dbname: getRaw("filter-dbname"),
        dbversion: getRaw("filter-dbversion"),
        os: getRaw("filter-os"),
        osver: getRaw("filter-osver"),
        virtual: getRaw("filter-virtual"),
        hdd: getVal("filter-hdd"),
        ram: getVal("filter-ram"),
        is_delete: getRaw("filter-delete"),
        services: getVal("filter-services"),
        created_by: getVal("filter-createdby"),
        created_at: getRaw("filter-createdat"),
        updated_at: getRaw("filter-updatedat")
    };

    const filtered = allHardwareCache.filter(hw => {
        return (!f.ip || hw.ip?.toLowerCase().includes(f.ip)) &&
            (!f.dbname || hw.dbname === f.dbname) &&
            (!f.dbversion || hw.dbversion === f.dbversion) &&
            (!f.os || hw.OS === f.os) &&
            (!f.osver || hw.OSver === f.osver) &&
            (!f.virtual || String(hw.isVirtualServer) === f.virtual) &&
            (!f.ram || (ramCompare && compareValue(hw.ram, ramCompare))) &&
            (!f.hdd || (hddCompare && compareValue(hw.hdd, hddCompare))) &&
            (!f.is_delete || String(hw.is_delete) === f.is_delete) &&
            (!f.services || hw.services?.toLowerCase().includes(f.services)) &&
            (!f.created_by || hw.created_by?.toLowerCase().includes(f.created_by)) &&
            (!f.created_at || hw.created_at?.startsWith(f.created_at)) &&
            (!f.updated_at || hw.updated_at?.startsWith(f.updated_at));
    });

    renderHardware(filtered);
}

window.loadHardware = loadHardware;
window.applyFilter = applyFilter;
window.addEventListener("hardwareCreated", loadHardware);

document.addEventListener("DOMContentLoaded", async () => {
    await initHardwareFilterSelects();
    // document.querySelectorAll("#filter-ip, #filter-dbname, #filter-dbversion, #filter-virtual, #filter-os, #filter-osver, #filter-hdd, #filter-ram, #filter-delete, #filter-services, #filter-createdby, #filter-createdat, #filter-updatedat")
    //     .forEach(el => el.addEventListener("change", applyFilter));
    loadHardware();
});
