import { get_hardware_analytics } from "../api/hardware";
import { get_software_analytics } from "../api/software";

document.addEventListener("DOMContentLoaded", () => {
    const fromInput = document.getElementById("filter-start-date");
    const toInput = document.getElementById("filter-end-date");
    const loadBtn = document.getElementById("loadAnalytics");
    const resetBtn = document.getElementById("btn-reset-time");

    // Mặc định 1 tháng gần nhất
    const today = new Date();
    const lastMonth = new Date();
    lastMonth.setMonth(lastMonth.getMonth() - 1);
    const formatDate = d => d.toISOString().split("T")[0];
    fromInput.value = formatDate(lastMonth);
    toInput.value = formatDate(today);

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

    const renderPieChart = (elementId, labels, values, colors) => {
        const ctx = document.getElementById(elementId).getContext("2d");
        if (chartInstances[elementId]) {
            chartInstances[elementId].data.datasets[0].data = values;
            chartInstances[elementId].update();
        } else {
            chartInstances[elementId] = new Chart(ctx, {
                type: "pie",
                data: { labels, datasets: [{ data: values, backgroundColor: colors }] },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: "bottom" },
                        datalabels: { color: '#fff', formatter: v => v, font: { weight: 'bold', size: 12 } }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    };

    const renderBarChart = (elementId, label, dataSets) => {
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
                            callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.raw.toFixed(2)}` }
                        }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }
    };

    const displayHardware = data => {
        Object.entries({
            "hardware-created": data.totalHardware + data.deletedCount,
            "hardware-deleted": data.deletedCount,
            "totalHardwareAllTime": data.total_hardware_all_time,
            "deletedHardwareAllTime": data.deleted_hardware_all_time,
            "hardware-active": data.activeCount,
            "totalRam": data.totalRam,
            "totalRamDelete": data.totalRamDeleted
        }).forEach(([id, val]) => document.getElementById(id).textContent = val || 0);

        renderPieChart("vmPieChart", ["Vật lý", "Ảo"], [data.physicalCount, data.virtualCount], ["#36A2EB", "#FF6384"]);
        renderPieChart("vmPieChartDeleted", ["Vật lý", "Ảo"], [data.physicalCountDeleted, data.virtualCountDeleted], ["#36A2EB", "#FF6384"]);

        const hddUnit = (parseSize(data.physicalHdd) < 1 && parseSize(data.virtualHdd) < 1) ? "MB" : "GB";
        const ramUnit = (parseSize(data.physicalRam) < 1 && parseSize(data.virtualRam) < 1) ? "MB" : "GB";

        const scale = unit => unit === "MB" ? 1024 : 1;
        renderBarChart("hddChart", `HDD (${hddUnit})`, [
            { label: "Vật lý", data: [parseSize(data.physicalHdd) * scale(hddUnit)], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Ảo", data: [parseSize(data.virtualHdd) * scale(hddUnit)], backgroundColor: 'rgba(255,99,132,0.7)' }
        ]);
        renderBarChart("hddChart-delete", `HDD (${hddUnit})`, [
            { label: "Vật lý", data: [parseSize(data.physicalHddDeleted) * scale(hddUnit)], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Ảo", data: [parseSize(data.virtualHddDeleted) * scale(hddUnit)], backgroundColor: 'rgba(255,99,132,0.7)' }
        ]);
        renderBarChart("ramChart", `RAM (${ramUnit})`, [
            { label: "Vật lý", data: [parseSize(data.physicalRam) * scale(ramUnit)], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Ảo", data: [parseSize(data.virtualRam) * scale(ramUnit)], backgroundColor: 'rgba(255,99,132,0.7)' }
        ]);
        renderBarChart("ramChart-delete", `RAM (${ramUnit})`, [
            { label: "Vật lý", data: [parseSize(data.physicalRamDeleted) * scale(ramUnit)], backgroundColor: 'rgba(54,162,235,0.7)' },
            { label: "Ảo", data: [parseSize(data.virtualRamDeleted) * scale(ramUnit)], backgroundColor: 'rgba(255,99,132,0.7)' }
        ]);
    };

    const displaySoftware = data => {
        Object.entries({
            "totalSoftwareAllTime": data.total_software_all_time,
            "deletedSoftwareAllTime": data.deleted_software_all_time,
            "software-active": data.total_software + data.deleted_software,
            "software-deleted": data.deleted_software,
            "software-space-saved": data.storage_size_readable,
            "software-uninstall-saved": data.deleted_storage_size_readable
        }).forEach(([id, val]) => document.getElementById(id).textContent = val || 0);
    };

    const displayMid = (hw, sw) => {
        const total = parseSize(hw.totalActiveHdd);
        const used = parseSize(sw.storage_size_readable);
        const free = total - used;
        const usedPercent = total ? (used / total) * 100 : 0;
        const minPercent = Math.max(usedPercent, 22);

        document.getElementById("hardware-average-storage").textContent = hw.totalActiveHdd || "0 MB";
        document.getElementById("hardware-average-storage-delete").textContent = hw.totalActiveHddDeleted || "0 MB";
        document.getElementById("hardware-storage-saved").textContent = formatSize(used);

        const usedBar = document.getElementById("hdd-used-bar");
        const usedText = document.getElementById("hdd-used-text");
        // const freeText = document.getElementById("hdd-free-text");
        usedBar.style.width = minPercent + "%";
        usedText.textContent = `${formatSize(used)} (${usedPercent.toFixed(1)}%)`;
        // freeText.textContent = `${formatSize(free)} (${(100 - usedPercent).toFixed(1)}%)`;
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
            if (hwRes?.status === "success" && swRes?.status === "success") displayMid(hwRes, swRes.data);
        } catch (err) { console.error("Lỗi API hoặc display get element erre:", err); }
    };

    loadAnalytics();
    loadBtn.addEventListener("click", loadAnalytics);
    resetBtn.addEventListener("click", () => { fromInput.value = formatDate(lastMonth); toInput.value = formatDate(today); loadAnalytics(); });
});
 

// import { get_hardware_analytics } from "../api/hardware";
// import { get_software_analytics } from "../api/software";

// document.addEventListener("DOMContentLoaded", () => {
//     const fromInput = document.getElementById("filter-start-date");
//     const toInput = document.getElementById("filter-end-date");
//     const loadBtn = document.getElementById("loadAnalytics");

//     // MẶC ĐỊNH: set khoảng thời gian = 1 tháng gần nhất
//     const today = new Date();
//     const lastMonth = new Date();
//     lastMonth.setMonth(lastMonth.getMonth() - 1);

//     // Định dạng yyyy-mm-dd
//     const formatDate = (d) => d.toISOString().split("T")[0];
//     fromInput.value = formatDate(lastMonth);
//     toInput.value = formatDate(today);
//     function parseSizeToGB(str) {
//         if (!str) return 0;
//         const units = { "B": 1 / 1024 / 1024 / 1024, "KB": 1 / 1024 / 1024, "MB": 1 / 1024, "GB": 1, "TB": 1024 };
//         const m = str.match(/([\d\.]+)\s*(B|KB|MB|GB|TB)/i);
//         if (!m) return 0;
//         return parseFloat(m[1]) * units[m[2].toUpperCase()];
//     }

//     const displayAnalyticsHardware = (data) => {
//         // Cập nhật số liệu
//         document.getElementById("hardware-created").textContent =
//             (data.totalHardware + data.deletedCount) || 0;
//         document.getElementById("hardware-deleted").textContent = data.deletedCount || 0;
//         document.getElementById("totalHardwareAllTime").textContent = data.total_hardware_all_time || 0;
//         document.getElementById("deletedHardwareAllTime").textContent = data.deleted_hardware_all_time || 0;
//         document.getElementById("hardware-active").textContent = data.activeCount || 0;
//         document.getElementById("totalRam").textContent = data.totalRam || "0 MB";
//         document.getElementById("totalRamDelete").textContent = data.totalRamDeleted || "0 MB";
//         // document.getElementById("virtualCount").textContent = data.virtualCount || 0;
//         // document.getElementById("physicalCount").textContent = data.physicalCount || 0;
//         let vmPieChartInstances = {}; // lưu nhiều chart theo element id

//         const displayVmPieChart = (physicalCount, virtualCount, element = "vmPieChart") => {
//             const ctx = document.getElementById(element).getContext("2d");
//             const data = {
//                 labels: ["Máy vật lý", "Máy ảo"],
//                 datasets: [{
//                     data: [physicalCount || 0, virtualCount || 0],
//                     backgroundColor: ["#36A2EB", "#FF6384"]
//                 }]
//             };

//             const options = {
//                 responsive: true,
//                 plugins: {
//                     legend: {
//                         position: "bottom",
//                         labels: {
//                             generateLabels: function (chart) {
//                                 return chart.data.labels.map((label, i) => {
//                                     const value = chart.data.datasets[0].data[i];
//                                     return {
//                                         text: `${label}: ${value}`,
//                                         fillStyle: chart.data.datasets[0].backgroundColor[i],
//                                         strokeStyle: chart.data.datasets[0].backgroundColor[i],
//                                         lineWidth: 1,
//                                         hidden: false,
//                                         index: i
//                                     };
//                                 });
//                             }
//                         }
//                     },
//                     datalabels: {
//                         color: '#fff',
//                         formatter: (value, ctx) => {
//                             return `${value}`;
//                         },
//                         font: { weight: 'bold', size: 12 }
//                     }
//                 }
//             };

//             if (vmPieChartInstances[element]) {
//                 // update chart nếu đã tồn tại
//                 vmPieChartInstances[element].data.datasets[0].data = [physicalCount || 0, virtualCount || 0];
//                 vmPieChartInstances[element].update();
//             } else {
//                 // tạo chart mới
//                 vmPieChartInstances[element] = new Chart(ctx, {
//                     type: "pie",
//                     data: data,
//                     options: options,
//                     plugins: [ChartDataLabels]
//                 });
//             }
//         };

//         // Hiển thị active
//         displayVmPieChart(data.physicalCount, data.virtualCount, "vmPieChart");
//         // Hiển thị deleted
//         displayVmPieChart(data.physicalCountDeleted, data.virtualCountDeleted, "vmPieChartDeleted");


//         // Chuẩn bị dữ liệu cho chart
//         const physicalHdd = parseSizeToGB(data.physicalHdd);
//         const virtualHdd = parseSizeToGB(data.virtualHdd);
//         const physicalRam = parseSizeToGB(data.physicalRam);
//         const virtualRam = parseSizeToGB(data.virtualRam);

//         const physicalHddDeleted = parseSizeToGB(data.physicalHddDeleted);
//         const virtualHddDeleted = parseSizeToGB(data.virtualHddDeleted);
//         const physicalRamDeleted = parseSizeToGB(data.physicalRamDeleted);
//         const virtualRamDeleted = parseSizeToGB(data.virtualRamDeleted);

//         const hddUnit = physicalHdd < 1 && virtualHdd < 1 ? "MB" : "GB";
//         const ramUnit = physicalRam < 1 && virtualRam < 1 ? "MB" : "GB";

//         const hddUnitDeleted = physicalHddDeleted < 1 && virtualHddDeleted < 1 ? "MB" : "GB";
//         const ramUnitDeleted = physicalRamDeleted < 1 && virtualRamDeleted < 1 ? "MB" : "GB";

//         const physicalHddVal = hddUnit === "MB" ? physicalHdd * 1024 : physicalHdd;
//         const virtualHddVal = hddUnit === "MB" ? virtualHdd * 1024 : virtualHdd;
//         const physicalRamVal = ramUnit === "MB" ? physicalRam * 1024 : physicalRam;
//         const virtualRamVal = ramUnit === "MB" ? virtualRam * 1024 : virtualRam;

//         // HDD Chart
//         new Chart(document.getElementById("hddChart").getContext("2d"), {
//             type: "bar",
//             data: {
//                 labels: [`HDD (${hddUnit})`],
//                 datasets: [
//                     { label: "Vật lý", data: [physicalHddVal], backgroundColor: 'rgba(54, 162, 235, 0.7)' },
//                     { label: "Ảo", data: [virtualHddVal], backgroundColor: 'rgba(255, 99, 132, 0.7)' }
//                 ]
//             },
//             options: {
//                 responsive: true,
//                 plugins: {
//                     legend: { position: "top" },
//                     tooltip: {
//                         callbacks: {
//                             label: function (context) {
//                                 return `${context.dataset.label}: ${context.raw.toFixed(2)} ${hddUnit}`;
//                             }
//                         }
//                     }
//                 },
//                 scales: { y: { beginAtZero: true } }
//             }
//         });
//         // HDD Chart
//         new Chart(document.getElementById("hddChart-delete").getContext("2d"), {
//             type: "bar",
//             data: {
//                 labels: [`HDD (${hddUnitDeleted})`],
//                 datasets: [
//                     { label: "Vật lý", data: [hddUnitDeleted === "MB" ? physicalHddDeleted * 1024 : physicalHddDeleted], backgroundColor: 'rgba(54, 162, 235, 0.7)' },
//                     { label: "Ảo", data: [hddUnitDeleted === "MB" ? virtualHddDeleted * 1024 : virtualHddDeleted], backgroundColor: 'rgba(255, 99, 132, 0.7)' }
//                 ]
//             },
//             options: {
//                 responsive: true,
//                 plugins: {
//                     legend: { position: "top" },
//                     tooltip: {
//                         callbacks: {
//                             label: function (context) {
//                                 return `${context.dataset.label}: ${context.raw.toFixed(2)} ${hddUnitDeleted}`;
//                             }
//                         }
//                     }
//                 },
//                 scales: { y: { beginAtZero: true } }
//             }
//         });

//         // RAM Chart
//         new Chart(document.getElementById("ramChart").getContext("2d"), {
//             type: "bar",
//             data: {
//                 labels: [`RAM (${ramUnit})`],
//                 datasets: [
//                     { label: "Vật lý", data: [physicalRamVal], backgroundColor: 'rgba(54, 162, 235, 0.7)' },
//                     { label: "Ảo", data: [virtualRamVal], backgroundColor: 'rgba(255, 99, 132, 0.7)' }
//                 ]
//             },
//             options: {
//                 responsive: true,
//                 plugins: {
//                     legend: { position: "top" },
//                     tooltip: {
//                         callbacks: {
//                             label: function (context) {
//                                 return `${context.dataset.label}: ${context.raw.toFixed(2)} ${ramUnit}`;
//                             }
//                         }
//                     }
//                 },
//                 scales: { y: { beginAtZero: true } }
//             }
//         });
//         // RAM Chart
//         new Chart(document.getElementById("ramChart-delete").getContext("2d"), {
//             type: "bar",
//             data: {
//                 labels: [`RAM (${ramUnitDeleted})`],
//                 datasets: [
//                     { label: "Vật lý", data: [ramUnitDeleted === "MB" ? physicalRamDeleted * 1024 : physicalRamDeleted], backgroundColor: 'rgba(54, 162, 235, 0.7)' },
//                     { label: "Ảo", data: [ramUnitDeleted === "MB" ? virtualRamDeleted * 1024 : virtualRamDeleted], backgroundColor: 'rgba(255, 99, 132, 0.7)' }
//                 ]
//             },
//             options: {
//                 responsive: true,
//                 plugins: {
//                     legend: { position: "top" },
//                     tooltip: {
//                         callbacks: {
//                             label: function (context) {
//                                 return `${context.dataset.label}: ${context.raw.toFixed(2)} ${ramUnitDeleted}`;
//                             }
//                         }
//                     }
//                 },
//                 scales: { y: { beginAtZero: true } }
//             }
//         });
//     };

//     const displayAnalyticsSoftware = (data) => {
//         document.getElementById("totalSoftwareAllTime").textContent = data.total_software_all_time || 0;
//         document.getElementById("deletedSoftwareAllTime").textContent = data.deleted_software_all_time || 0;
//         document.getElementById("software-active").textContent =
//             (data.total_software + data.deleted_software) || 0;
//         document.getElementById("software-deleted").textContent = data.deleted_software || 0;
//         document.getElementById("software-space-saved").textContent = data.storage_size_readable || "0 MB";
//         document.getElementById("software-uninstall-saved").textContent = data.deleted_storage_size_readable || "0 MB";
//     };

//     const displayAnalyticsMid = (hardware, software) => {
//         const totalHddBytes = parseSize(hardware.totalActiveHdd);
//         const usedHddBytes = parseSize(software.storage_size_readable);
//         const freeHddBytes = totalHddBytes - usedHddBytes;
//         console.log("Total HDD Bytes:", totalHddBytes);
//         console.log("Used HDD Bytes:", usedHddBytes);
//         console.log("Free HDD Bytes:", freeHddBytes);
//         const usedPercent = totalHddBytes > 0 ? (usedHddBytes / totalHddBytes) * 100 : 0;
//         const freePercent = 100 - usedPercent;

//         // Cập nhật text tổng và đã dùng
//         document.getElementById("hardware-average-storage").textContent = hardware.totalActiveHdd || "0 MB";
//         document.getElementById("hardware-average-storage-delete").textContent = hardware.totalActiveHddDeleted || "0 MB";
//         document.getElementById("hardware-storage-saved").textContent = formatSize(usedHddBytes);

//         // Cập nhật thanh màu + text
//         const hddUsedBar = document.getElementById("hdd-used-bar");
//         // const hddFreeBar = document.getElementById("hdd-free-bar");
//         const hddUsedText = document.getElementById("hdd-used-text");
//         const hddFreeText = document.getElementById("hdd-free-text");

//         // hddUsedBar.style.width = usedPercent + "%";
//         let displayPercent = Math.max(usedPercent, 22); // tối thiểu 30%
//         hddUsedBar.style.width = displayPercent + "%";
//         // hddFreeBar.style.width = freePercent + "%";

//         hddUsedText.textContent = `${formatSize(usedHddBytes)} (${usedPercent.toFixed(1)}%)`;
//         hddFreeText.textContent = `${formatSize(freeHddBytes)} (${freePercent.toFixed(1)}%)`;
//     };



//     const loadAnalytics = async () => {
//         const fromDate = fromInput.value;
//         const toDate = toInput.value;

//         document.getElementById("software-range").textContent = fromDate && toDate
//             ? `(Từ ${fromDate} đến ${toDate})`
//             : "(Tất cả thời gian)";

//         document.getElementById("hardware-range").textContent = fromDate && toDate
//             ? `(Từ ${fromDate} đến ${toDate})`
//             : "(Tất cả thời gian)";

//         const filters = {};
//         if (fromDate) filters.from = fromDate;
//         if (toDate) filters.to = toDate;

//         try {
//             const [hardwareRes, softwareRes] = await Promise.all([
//                 get_hardware_analytics(filters),
//                 get_software_analytics(filters)
//             ]);

//             const hardwareOk = hardwareRes && hardwareRes.status === "success";
//             const softwareOk = softwareRes && softwareRes.status === "success";

//             if (hardwareOk) displayAnalyticsHardware(hardwareRes);
//             else console.warn("Không lấy được dữ liệu phần cứng");

//             if (softwareOk) displayAnalyticsSoftware(softwareRes.data);
//             else console.warn("Không lấy được dữ liệu phần mềm");

//             if (hardwareOk && softwareOk) displayAnalyticsMid(hardwareRes, softwareRes.data);

//         } catch (err) {
//             console.error("Lỗi khi gọi API thống kê:", err);
//         }
//     };

//     // Gọi lần đầu khi load trang (với 1 tháng gần nhất)
//     loadAnalytics();

//     // Khi nhấn nút tải
//     loadBtn.addEventListener("click", loadAnalytics);

//     // Khi reset thời gian
//     const resetBtn = document.getElementById("btn-reset-time");
//     resetBtn.addEventListener("click", () => {
//         fromInput.value = "";
//         toInput.value = "";
//         loadAnalytics();
//     });
// });

// function parseSize(sizeStr) {
//     if (!sizeStr) return 0;
//     const units = { B: 1, KB: 1024, MB: 1024 ** 2, GB: 1024 ** 3, TB: 1024 ** 4 };
//     const match = sizeStr.toUpperCase().match(/([\d.]+)\s*(B|KB|MB|GB|TB)/);
//     if (!match) return 0;
//     const [_, num, unit] = match;
//     return parseFloat(num) * (units[unit] || 1);
// }

// function formatSize(bytes) {
//     if (bytes < 1024) return `${bytes.toFixed(0)} B`;
//     const units = ['KB', 'MB', 'GB', 'TB'];
//     let unitIndex = -1;
//     do {
//         bytes /= 1024;
//         unitIndex++;
//     } while (bytes >= 1024 && unitIndex < units.length - 1);
//     return `${bytes.toFixed(2)} ${units[unitIndex]}`;
// }