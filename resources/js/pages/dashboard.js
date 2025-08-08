import { get_hardware_analytics } from "../api/hardware";
import { get_software_analytics } from "../api/software";

document.addEventListener("DOMContentLoaded", () => {
    const fromInput = document.getElementById("filter-start-date");
    const toInput = document.getElementById("filter-end-date");
    const loadBtn = document.getElementById("loadAnalytics");

    const displayAnalyticsHardware = (data) => {
        document.getElementById("hardware-created").textContent = data.totalHardware + data.deletedCount || 0;

        document.getElementById("hardware-deleted").textContent = data.deletedCount || 0;
        document.getElementById("hardware-active").textContent = data.activeCount || 0;
        document.getElementById("hardware-average-storage").textContent = data.totalActiveHdd || "0 MB";
        document.getElementById("totalRam").textContent = data.totalRam || "0 MB";
        document.getElementById("virtualCount").textContent = data.virtualCount || 0;
        document.getElementById("physicalCount").textContent = data.physicalCount || 0;
        document.getElementById("virtualHdd").textContent = data.virtualHdd || "0 MB";
        document.getElementById("virtualRam").textContent = data.virtualRam || "0 MB";
        document.getElementById("physicalHdd").textContent = data.physicalHdd || "0 MB";
        document.getElementById("physicalRam").textContent = data.physicalRam || "0 MB";
    };

    const displayAnalyticsSoftware = (data) => {
        document.getElementById("software-active").textContent = data.total_software + data.deleted_software || 0;
        document.getElementById("software-deleted").textContent = data.deleted_software || 0;
        document.getElementById("software-space-saved").textContent = data.storage_size_readable || "0 MB";
        document.getElementById("software-uninstall-saved").textContent = data.deleted_storage_size_readable || "0 MB";
    };
    const displayAnalyticsMid = (hardware, software) => {
        const totalHddBytes = parseSize(hardware.totalActiveHdd);
        const storage_size_readable = parseSize(software.storage_size_readable);
        console.log("Total HDD Bytes:", totalHddBytes);
        console.log("Deleted Storage Bytes:", storage_size_readable);
        const savedBytes = totalHddBytes - storage_size_readable;
        document.getElementById("hardware-dark").textContent = software.storage_size_readable || "-";

        document.getElementById("hardware-storage-saved").textContent = formatSize(savedBytes);
    };

    const loadAnalytics = async () => {
        const fromDate = fromInput.value;
        const toDate = toInput.value;
        document.getElementById("software-range").textContent = fromDate && toDate
            ? `(Từ ${fromDate} đến ${toDate})`
            : "(Tất cả thời gian)";

        document.getElementById("hardware-range").textContent = fromDate && toDate
            ? `(Từ ${fromDate} đến ${toDate})`
            : "(Tất cả thời gian)";

        const filters = {};
        if (fromDate) filters.from = fromDate;
        if (toDate) filters.to = toDate;

        try {
            // Gọi song song cả hai API
            const [hardwareRes, softwareRes] = await Promise.all([
                get_hardware_analytics(filters),
                get_software_analytics(filters)
            ]);

            const hardwareOk = hardwareRes && hardwareRes.status === "success";
            const softwareOk = softwareRes && softwareRes.status === "success";

            if (hardwareOk) {
                displayAnalyticsHardware(hardwareRes);
            } else {
                console.warn("Không lấy được dữ liệu phần cứng");
            }

            if (softwareOk) {
                displayAnalyticsSoftware(softwareRes.data);
            } else {
                console.warn("Không lấy được dữ liệu phần mềm");
            }

            if (hardwareOk && softwareOk) {
                displayAnalyticsMid(hardwareRes, softwareRes.data);
            }

        } catch (err) {
            console.error("Lỗi khi gọi API thống kê:", err);
        }
    };

    // Gọi lần đầu khi load trang
    loadAnalytics();

    // Gọi lại khi nhấn nút
    loadBtn.addEventListener("click", loadAnalytics);
    const resetBtn = document.getElementById("btn-reset-time");
    resetBtn.addEventListener("click", () => {
        fromInput.value = "";
        toInput.value = "";
        loadAnalytics(); // Gọi lại mà không có bộ lọc
    });

});

function parseSize(sizeStr) {
    if (!sizeStr) return 0;
    const units = { B: 1, KB: 1024, MB: 1024 ** 2, GB: 1024 ** 3, TB: 1024 ** 4 };
    const match = sizeStr.toUpperCase().match(/([\d.]+)\s*(B|KB|MB|GB|TB)/);
    if (!match) return 0;
    const [_, num, unit] = match;
    return parseFloat(num) * (units[unit] || 1);
}

function formatSize(bytes) {
    if (bytes < 1024) return `${bytes.toFixed(0)} B`;
    const units = ['KB', 'MB', 'GB', 'TB'];
    let unitIndex = -1;
    do {
        bytes /= 1024;
        unitIndex++;
    } while (bytes >= 1024 && unitIndex < units.length - 1);
    return `${bytes.toFixed(2)} ${units[unitIndex]}`;
}