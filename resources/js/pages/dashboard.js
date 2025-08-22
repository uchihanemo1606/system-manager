import { get_hardware_analytics } from "../api/hardware";
import { get_software_analytics } from "../api/software";

document.addEventListener("DOMContentLoaded", () => {
    // DOM elements
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
    const formatDate = d => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
    const formatDateTime = d => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;

    fromInput.value = formatDate(firstDayOfMonth);
    toInput.value = formatDateTime(today);
    if(fromInput){
        
    }
    // Chart instances
    const chartInstances = {};

    // parseSize với cache
    const parsedSizes = {};
    const parseSize = str => {
        if (!str) return 0;
        if (parsedSizes[str] !== undefined) return parsedSizes[str];
        const units = { B: 1, KB: 1024, MB: 1024 ** 2, GB: 1024 ** 3, TB: 1024 ** 4 };
        const m = str.toUpperCase().match(/([\d.]+)\s*(B|KB|MB|GB|TB)/);
        const val = m ? parseFloat(m[1]) * (units[m[2]] || 1) : 0;
        parsedSizes[str] = val;
        return val;
    };

    const getUnitAndScale = (physical, virtual) => {
        let size = 0;
        if (physical === "0 B") size = parseSize(virtual);
        else if (virtual === "0 B") size = parseSize(physical);
        else size = Math.min(parseSize(physical), parseSize(virtual));

        if (size < 1024) return { unit: "B", scale: 1 };
        if (size < 1024 ** 2) return { unit: "KB", scale: 1 / 1024 };
        if (size < 1024 ** 3) return { unit: "MB", scale: 1 / 1024 ** 2 };
        return { unit: "GB", scale: 1 / 1024 ** 3 };
    };

    // Tạo chart một lần
    const createChart = (elementId, label, unit = '') => {
        const ctx = document.getElementById(elementId).getContext("2d");
        chartInstances[elementId] = new Chart(ctx, {
            type: "bar",
            data: { labels: [label], datasets: [] },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: "top" },
                    tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.raw}${unit}` } },
                    datalabels: {
                        anchor: 'start', align: 'end',
                        formatter: value => `${value}${unit}`,
                        color: '#000',
                        font: { weight: 'bold' }
                    }
                },
                scales: { y: { beginAtZero: true } }
            },
            plugins: [ChartDataLabels]
        });
    };

    // Cập nhật chart
    const updateChart = (elementId, label, dataSets, unit = '') => {
        const chart = chartInstances[elementId];
        if (chart) {
            chart.data.labels = [label];
            chart.data.datasets = dataSets;
            chart.update();
        }
    };

    // Tạo tất cả chart trước
    ["totalHardwareDetailChart", "totalHardwareDeletedDetailChart", "hddDetailChart", "ramDetailChart",
        "hddDeletedDetailChart", "ramDeletedDetailChart", "totalHardwareChart", "totalHardDeletedwareChart",
        "hddOverviewChart", "ramOverviewChart", "hddDeletedOverviewChart", "ramDeletedOverviewChart"
    ].forEach(id => createChart(id, ' ', ''));

    // Cập nhật DOM nhanh
    const updateElements = (map) => {
        const fragment = document.createDocumentFragment();
        for (const [id, val] of Object.entries(map)) {
            const el = document.getElementById(id);
            if (el) el.textContent = val || 0;
        }
    };

    // Hiển thị hardware chi tiết
    const displayHardware = data => {
        updateElements({
            "hardwareUpdateCount": data.updateCount,
            "hardware-created": data.virtualCreatedCount + data.physicalCreatedCount,
            "hardware-deleted": data.virtualCountDeleted + data.physicalCountDeleted,
            "totalSumHardwareDeletedDetailChart": data.virtualCountDeleted + data.physicalCountDeleted,
            "totalSumHardwareDetailChart": data.virtualCreatedCount + data.physicalCreatedCount,
            "sumHddDetailChart": data.totalActiveHddCreated,
            "sumHddDetailChartDelete": data.totalActiveHddDeleted,
            "sumRamDetailChart": data.totalRamCreated,
            "sumRamDetailChartDelete": data.totalRamDeleted,
        });

        const hddInfo = getUnitAndScale(data.physicalHddCreated, data.virtualHddCreated);
        const ramInfo = getUnitAndScale(data.physicalRamCreated, data.virtualRamCreated);
        const hddInfoDeleted = getUnitAndScale(data.physicalHddDeleted, data.virtualHddDeleted);
        const ramInfoDeleted = getUnitAndScale(data.physicalRamDeleted, data.virtualRamDeleted);

        updateChart("totalHardwareDetailChart", "máy", [
            { label: "Máy vật lý", data: [data.physicalCreatedCount], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [data.virtualCreatedCount], backgroundColor: 'rgba(255,99,132,0.7)' }
        ]);

        updateChart("totalHardwareDeletedDetailChart", "máy", [
            { label: "Máy vật lý", data: [data.physicalCountDeleted], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [data.virtualCountDeleted], backgroundColor: 'rgba(255,99,132,0.7)' }
        ]);

        updateChart("hddDetailChart", `HDD (${hddInfo.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalHddCreated) * hddInfo.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualHddCreated) * hddInfo.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], hddInfo.unit);

        updateChart("ramDetailChart", `RAM (${ramInfo.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalRamCreated) * ramInfo.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualRamCreated) * ramInfo.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], ramInfo.unit);

        updateChart("hddDeletedDetailChart", `HDD (${hddInfoDeleted.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalHddDeleted) * hddInfoDeleted.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualHddDeleted) * hddInfoDeleted.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], hddInfoDeleted.unit);

        updateChart("ramDeletedDetailChart", `RAM (${ramInfoDeleted.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalRamDeleted) * ramInfoDeleted.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualRamDeleted) * ramInfoDeleted.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], ramInfoDeleted.unit);
    };

    // Hiển thị hardware overview
    const displayHardwareOverview = data => {
        updateElements({
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
        });

        const hddInfo = getUnitAndScale(data.physicalHdd, data.virtualHdd);
        const ramInfo = getUnitAndScale(data.physicalRam, data.virtualRam);
        const hddInfoDeleted = getUnitAndScale(data.physicalHddDeleted, data.virtualHddDeleted);
        const ramInfoDeleted = getUnitAndScale(data.physicalRamDeleted, data.virtualRamDeleted);

        updateChart("totalHardwareChart", "máy", [
            { label: "Máy vật lý", data: [data.physicalCount], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [data.virtualCount], backgroundColor: 'rgba(255,99,132,0.7)' }
        ]);

        updateChart("totalHardDeletedwareChart", "máy", [
            { label: "Máy vật lý", data: [data.physicalCountDeleted], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [data.virtualCountDeleted], backgroundColor: 'rgba(255,99,132,0.7)' }
        ]);

        updateChart("hddOverviewChart", `HDD (${hddInfo.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalHdd) * hddInfo.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualHdd) * hddInfo.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], hddInfo.unit);

        updateChart("ramOverviewChart", `RAM (${ramInfo.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalRam) * ramInfo.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualRam) * ramInfo.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], ramInfo.unit);

        updateChart("hddDeletedOverviewChart", `HDD (${hddInfoDeleted.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalHddDeleted) * hddInfoDeleted.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualHddDeleted) * hddInfoDeleted.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], hddInfoDeleted.unit);

        updateChart("ramDeletedOverviewChart", `RAM (${ramInfoDeleted.unit})`, [
            { label: "Máy vật lý", data: [parseSize(data.physicalRamDeleted) * ramInfoDeleted.scale], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Máy ảo", data: [parseSize(data.virtualRamDeleted) * ramInfoDeleted.scale], backgroundColor: 'rgba(255,99,132,0.7)' }
        ], ramInfoDeleted.unit);
    };

    const displaySoftwareOverview = data => {
        updateElements({
            "totalSoftwareOverview": data.total_software,
            "deletedSoftwareOverview": data.deleted_software,
            "storageSoftwareOverview": data.storage_size_readable,
            "storageSoftwareDeletedOverview": data.deleted_storage_size_readable,
            "softwareUpdateCountOverview": data.updateCount
        });
    };

    const displaySoftware = data => {
        updateElements({
            "softwareCreated": data.total_software_created,
            "softwareDeletedDetail": data.deleted_software,
            "storageSoftwareDetail": data.created_storage_size_bytes_readable,
            "storageSoftwareDeletedDetail": data.deleted_storage_size_readable,
            "softwareUpdateCount": data.updateCount
        });
    };

    // Load analytics bất đồng bộ, không block UI
    const loadAnalytics = async () => {
        const from = fromInput.value;
        const to = toInput.value;
        const filters = {};
        if (from) filters.from = from;
        if (to) filters.to = to;
        get_software_analytics(filters).then(swRes => {
            if (swRes?.status === "success") displaySoftware(swRes.data);
            else console.warn("Không lấy dữ liệu phần mềm");
        }).catch(err => console.error("Lỗi phần mềm:", err));
        get_hardware_analytics(filters).then(hwRes => {
            if (hwRes?.status === "success") displayHardware(hwRes);
            else console.warn("Không lấy dữ liệu phần cứng");
        }).catch(err => console.error("Lỗi phần cứng:", err));


    };
    const loadAnalyticsOverview = async () => {
        const from = fromInputOverview.value;
        const to = toInputOverview.value;
        const filters = {};
        if (from) filters.from = from;
        if (to) filters.to = to;
        get_software_analytics(filters).then(swRes => {
            if (swRes?.status === "success") displaySoftwareOverview(swRes.data);
            else console.warn("Không lấy dữ liệu phần mềm overview");
        }).catch(err => console.error("Lỗi phần mềm overview:", err));
        get_hardware_analytics(filters).then(hwRes => {
            if (hwRes?.status === "success") displayHardwareOverview(hwRes);
            else console.warn("Không lấy dữ liệu phần cứng overview");
        }).catch(err => console.error("Lỗi phần cứng overview:", err));


    };

    // Initial load
    loadAnalyticsOverview();
    loadAnalytics();
    // Event listeners
    loadBtn.addEventListener("click", loadAnalytics);
    loadBtnOverview.addEventListener("click", loadAnalyticsOverview);

    resetBtn.addEventListener("click", () => {
        fromInput.value = formatDate(firstDayOfMonth);
        toInput.value = formatDateTime(today);
        loadAnalytics();
    });

    resetBtnOverview.addEventListener("click", () => {
        fromInputOverview.value = "";
        toInputOverview.value = "";
        loadAnalyticsOverview();
    });
});
