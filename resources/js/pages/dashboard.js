import { get_hardware_analytics } from "../api/hardware";
import { get_software_analytics } from "../api/software";

document.addEventListener("DOMContentLoaded", () => {
    const fromInput = document.getElementById("filter-start-date");
    const toInput = document.getElementById("filter-end-date");
    const loadBtn = document.getElementById("loadAnalytics");
    const resetBtn = document.getElementById("btn-reset-time");
    const fromInputOverview = document.getElementById("overview-filter-start-date");
    const toInputOverview = document.getElementById("overview-filter-end-date");
    const loadBtnOverview = document.getElementById("overviewLoadAnalytics");
    const resetBtnOverview = document.getElementById("overview-reset-time");
    // Mặc định 1 tháng gần nhất
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

    const pad = n => n.toString().padStart(2, "0");

    // format yyyy-MM-dd
    const formatDate = d => {
        return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
    };

    // format yyyy-MM-ddTHH:mm
    const formatDateTime = d => {
        return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
    };

    fromInput.value = formatDate(firstDayOfMonth);
    toInput.value = formatDateTime(today);


    // Biến lưu instance chart
    const chartInstances = {};
    const parseSize = str => {
        if (!str) return 0;
        const units = { B: 1, KB: 1024, MB: 1024 ** 2, GB: 1024 ** 3, TB: 1024 ** 4 };
        const m = str.toUpperCase().match(/([\d.]+)\s*(B|KB|MB|GB|TB)/);
        return m ? parseFloat(m[1]) * (units[m[2]] || 1) : 0;
    };

    const formatSize = bytes => {
        if (bytes < 1024) return `${bytes.toFixed(0)} B`;
        const units = ['KB', 'MB', 'GB', 'TB'];
        let i = -1;
        do { bytes /= 1024; i++; } while (bytes >= 1024 && i < units.length - 1);
        return `${bytes.toFixed(2)} ${units[i]}`;
    };
    const getUnitAndScale = (physical, virtual) => {
        let size = 0;
        if (physical == "0 B") {

            size = parseSize(virtual);
        } else if (virtual == "0 B") {
            size = parseSize(physical);
        } else {
            size = Math.min(parseSize(physical), parseSize(virtual));
        }
        if (size < 1024) {
            return { unit: "B", scale: 1 };
        }
        if (size < 1024 ** 2) return { unit: "KB", scale: 1 / 1024 };
        if (size < 1024 ** 3) return { unit: "MB", scale: 1 / 1024 ** 2 };
        return { unit: "GB", scale: 1 / 1024 ** 3 };
    };
    const renderBarChart = (elementId, label, dataSets, unit = '') => {
        const ctx = document.getElementById(elementId).getContext("2d");

        if (chartInstances[elementId]) {
            chartInstances[elementId].data.datasets = dataSets;
            chartInstances[elementId].update();
        } else {
            chartInstances[elementId] = new Chart(ctx, {
                type: "bar",
                data: { labels: [label], datasets: dataSets },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: "top" },
                        tooltip: {
                            callbacks: {
                                label: ctx => `${ctx.dataset.label}: ${ctx.raw}${unit}`
                            }
                        },
                        datalabels: {
                            anchor: 'start',
                            align: 'end',
                            formatter: value => `${value}${unit}`, // hiển thị số đo
                            color: '#000',
                            font: { weight: 'bold' }
                        }
                    },
                    scales: { y: { beginAtZero: true } }
                },
                plugins: [ChartDataLabels]
            });
        }
    };

    const displayHardware = data => {
        // Object.entries({
        //     // "hardware-created": data.totalHardware + data.deletedCount,
        //     // "hardware-deleted": data.deletedCount,
        //     // "totalHardwareAllTime": data.total_hardware_all_time,
        //     // "deletedHardwareAllTime": data.deleted_hardware_all_time,
        //     // "hardware-active": data.activeCount,
        //     "totalRam": data.totalRam,
        //     "totalRamDelete": data.totalRamDeleted
        // }).forEach(([id, val]) => document.getElementById(id).textContent = val || 0);
        Object.entries({
            // "totalHardwareOverview": data.virtualCount + data.physicalCount,
            // "totalHardwareVOverviewDetail": data.virtualCount,
            // "totalHardwarePOverviewDetail": data.physicalCount,
            // "totalHardwareDeletedOverview": data.deletedCount,
            "hardwareUpdateCount": data.updateCount,
            "hardware-created": data.virtualCreatedCount + data.physicalCreatedCount,
            "hardware-deleted": data.virtualCountDeleted + data.physicalCountDeleted,
            "totalSumHardwareDeletedDetailChart": data.virtualCountDeleted + data.physicalCountDeleted,
            "totalSumHardwareDetailChart": data.virtualCreatedCount + data.physicalCreatedCount,
            "sumHddDetailChart": data.totalActiveHddCreated,
            "sumHddDetailChartDelete": data.totalActiveHddDeleted,
            "sumRamDetailChart": data.totalRamCreated,
            "sumRamDetailChartDelete": data.totalRamDeleted,
        }).forEach(([id, val]) => document.getElementById(id).textContent = val || 0);
        const hddInfo = getUnitAndScale(data.physicalHddCreated, data.virtualHddCreated);
        const ramInfo = getUnitAndScale(data.physicalRamCreated, data.virtualRamCreated);
        const hddInfoDeleted = getUnitAndScale(data.physicalHddDeleted, data.virtualHddDeleted);
        const ramInfoDeleted = getUnitAndScale(data.physicalRamDeleted, data.virtualRamDeleted);

        renderBarChart("totalHardwareDetailChart", `máy`, [
            { label: "Máy vật lý", data: [data.physicalCreatedCount], backgroundColor: 'rgba(54,162,235,0.7)', },
            { label: "Máy ảo", data: [data.virtualCreatedCount], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], '');
        renderBarChart("totalHardwareDeletedDetailChart", `máy`, [
            { label: "Máy vật lý", data: [data.physicalCountDeleted], backgroundColor: 'rgba(54,162,235,0.7)', },
            { label: "Máy ảo", data: [data.virtualCountDeleted], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], '');
        renderBarChart("hddDetailChart", `HDD (${hddInfo.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalHddCreated) * hddInfo.scale], backgroundColor: 'rgba(54,162,235,0.7)', },
            { label: "Máy ảo", data: [parseSize(data.virtualHddCreated) * hddInfo.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], hddInfo.unit);

        renderBarChart("ramDetailChart", `RAM (${ramInfo.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalRamCreated) * ramInfo.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualRamCreated) * ramInfo.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], ramInfo.unit);
        renderBarChart("hddDeletedDetailChart", `HDD (${hddInfoDeleted.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalHddDeleted) * hddInfoDeleted.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualHddDeleted) * hddInfoDeleted.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], hddInfoDeleted.unit);

        renderBarChart("ramDeletedDetailChart", `RAM (${ramInfoDeleted.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalRamDeleted) * ramInfoDeleted.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualRamDeleted) * ramInfoDeleted.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], ramInfoDeleted.unit);
    };
    const displayHardwareOverview = data => {
        Object.entries({
            "totalHardwareOverview": data.virtualCount + data.physicalCount,
            "updateCountOverview": data.updateCount,
            "totalHardwareVOverviewDetail": data.virtualCount,
            "totalHardwarePOverviewDetail": data.physicalCount,
            "totalHardwareDeletedOverview": data.deletedCount,
            "totalHardwareDeletedOverviewChart": data.virtualCountDeleted + data.physicalCountDeleted,
            "totalHardwareOverviewChart": data.virtualCount + data.physicalCount,
            "sumHddOverviewChart": data.totalActiveHdd,
            "sumHddOverviewChartDelete": data.totalActiveHddDeleted,
            "sumRamOverviewChart": data.totalRam,
            "sumRamOverviewChartDelete": data.totalRamDeleted,
        }).forEach(([id, val]) => document.getElementById(id).textContent = val || 0);
        // Tổng: ${data.virtualCount + data.physicalCount} máy
        const hddInfo = getUnitAndScale(data.physicalHdd, data.virtualHdd);
        const ramInfo = getUnitAndScale(data.physicalRam, data.virtualRam);
        const hddInfoDeleted = getUnitAndScale(data.physicalHddDeleted, data.virtualHddDeleted);
        const ramInfoDeleted = getUnitAndScale(data.physicalRamDeleted, data.virtualRamDeleted);

        renderBarChart("totalHardwareChart", `máy`, [
            { label: "Máy vật lý", data: [data.physicalCount], backgroundColor: 'rgba(54,162,235,0.7)', },
            { label: "Máy ảo", data: [data.virtualCount], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], '');
        renderBarChart("totalHardDeletedwareChart", `máy`, [
            { label: "Máy vật lý", data: [data.physicalCountDeleted], backgroundColor: 'rgba(54,162,235,0.7)', },
            { label: "Máy ảo", data: [data.virtualCountDeleted], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], '');
        renderBarChart("hddOverviewChart", `HDD (${hddInfo.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalHdd) * hddInfo.scale], backgroundColor: 'rgba(54,162,235,0.7)', },
            { label: "Máy ảo", data: [parseSize(data.virtualHdd) * hddInfo.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], hddInfo.unit);

        renderBarChart("ramOverviewChart", `RAM (${ramInfo.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalRam) * ramInfo.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualRam) * ramInfo.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], ramInfo.unit);
        renderBarChart("hddDeletedOverviewChart", `HDD (${hddInfoDeleted.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalHddDeleted) * hddInfoDeleted.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualHddDeleted) * hddInfoDeleted.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], hddInfoDeleted.unit);

        renderBarChart("ramDeletedOverviewChart", `RAM (${ramInfoDeleted.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalRamDeleted) * ramInfoDeleted.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualRamDeleted) * ramInfoDeleted.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], ramInfoDeleted.unit);
    };
    const displaySoftwareOverview = data => {
        Object.entries({
            "totalSoftwareOverview": data.total_software,
            "deletedSoftwareOverview": data.deleted_software,
            "storageSoftwareOverview": data.storage_size_readable,
            "storageSoftwareDeletedOverview": data.deleted_storage_size_readable,
            "softwareUpdateCountOverview": data.updateCount,
            // "software-active": data.total_software + data.deleted_software,
            // "software-deleted": data.deleted_software,
            // "software-space-saved": data.storage_size_readable,
            // "software-uninstall-saved": data.deleted_storage_size_readable
        }).forEach(([id, val]) => document.getElementById(id).textContent = val || 0);
    };
    const displaySoftware = data => {
        Object.entries({
            "softwareCreated": data.total_software_created,
            "softwareDeletedDetail": data.deleted_software,
            "storageSoftwareDetail": data.created_storage_size_bytes_readable,
            "storageSoftwareDeletedDetail": data.deleted_storage_size_readable,
            "softwareUpdateCount": data.updateCount,
            // "software-active": data.total_software + data.deleted_software,
            // "software-deleted": data.deleted_software,
            // "software-space-saved": data.storage_size_readable,
            // "software-uninstall-saved": data.deleted_storage_size_readable
        }).forEach(([id, val]) => document.getElementById(id).textContent = val || 0);
    };
    const loadAnalytics = async () => {
        const from = fromInput.value;
        const to = toInput.value;

        const filters = {};
        if (from) filters.from = from;
        if (to) filters.to = to;
        try {
            const [hwRes, swRes] = await Promise.all([get_hardware_analytics(filters), get_software_analytics(filters)]);
            if (hwRes?.status === "success") displayHardware(hwRes); else console.warn("Không lấy dữ liệu phần cứng");
            if (swRes?.status === "success") displaySoftware(swRes.data); else console.warn("Không lấy dữ liệu phần mềm");
            // if (hwRes?.status === "success" && swRes?.status === "success") displayMid(hwRes, swRes.data);
        } catch (err) { console.error("Lỗi API hoặc display get element erre:", err); }
    };

    const loadAnalyticsOverview = async () => {
        const from = fromInputOverview.value;
        const to = toInputOverview.value;
        const filters = {};
        if (from) filters.from = from;
        if (to) filters.to = to;
        try {
            const [hwRes, swRes] = await Promise.all([get_hardware_analytics(filters), get_software_analytics(filters)]);
            if (hwRes?.status === "success") displayHardwareOverview(hwRes); else console.warn("Không lấy dữ liệu phần cứng");
            if (swRes?.status === "success") displaySoftwareOverview(swRes.data); else console.warn("Không lấy dữ liệu phần mềm");
            // if (hwRes?.status === "success" && swRes?.status === "success") displayMid(hwRes, swRes.data);
        } catch (err) { console.error("Lỗi API hoặc display get element erre:", err); }
    };
    loadAnalytics();
    loadAnalyticsOverview();
    loadBtn.addEventListener("click", loadAnalytics);
    loadBtnOverview.addEventListener("click", loadAnalyticsOverview); // đúng hàm cho overview
    resetBtn.addEventListener("click", () => { fromInput.value = formatDate(firstDayOfMonth); toInput.value = ff = formatDateTime(today); loadAnalytics(); });
    resetBtnOverview.addEventListener("click", () => {
        fromInputOverview.value = "";
        toInputOverview.value = "";
    });

});

