import ApexCharts from "apexcharts";

// Hàm giả lập dữ liệu thống kê
function fakeFetchStatistics(fromDate, toDate) {
    const dailyData = [];
    const start = new Date(fromDate);
    const end = new Date(toDate);

    let totalSoftware = 100;
    let totalHardware = 100;
    let totalUser = 100;
    let totalVisit = 1283830;

    let softwareManagers = 15;
    let hardwareManagers = 10;

    const roleCounts = {
        Admin: 5,
        "Quản lý": 15,
        "Người dùng thường": 80
    };

    while (start <= end) {
        const software = Math.floor(Math.random() * 10 + 5);
        const hardware = Math.floor(Math.random() * 8 + 3);
        const user = Math.floor(Math.random() * 5 + 2);
        const visit = Math.floor(Math.random() * 50 + 20);

        dailyData.push({
            date: start.toISOString().slice(0, 10),
            software,
            hardware,
            user,
            visit,
            addActions: Math.floor(Math.random() * 3),
            editActions: Math.floor(Math.random() * 3),
            deleteActions: Math.floor(Math.random() * 2)
        });

        totalSoftware += software;
        totalHardware += hardware;
        totalUser += user;
        totalVisit += visit;

        start.setDate(start.getDate() + 1);
    }

    return {
        dailyData,
        totalSoftware,
        totalHardware,
        totalUser,
        totalVisit,
        softwareManagers,
        hardwareManagers,
        roleCounts
    };
}

// Render tổng số liệu
function renderSummary(data) {
    document.getElementById("total-software").innerText = data.totalSoftware;
    document.getElementById("total-hardware").innerText = data.totalHardware;
    document.getElementById("total-user").innerText = data.totalUser;
    document.getElementById("total-visit").innerText = data.totalVisit;

    document.getElementById("software-manager-count").innerText = data.softwareManagers;
    document.getElementById("hardware-manager-count").innerText = data.hardwareManagers;
}
function renderRolePieChart(roleCounts) {
    const labels = Object.keys(roleCounts);
    const series = Object.values(roleCounts);

    const options = {
        chart: { type: "pie" },
        labels,
        series,
        colors: ["#007bff", "#28a745", "#ffc107"]
    };

    const chart = new ApexCharts(document.querySelector("#role-pie-chart"), options);
    chart.render();
}


// Render bảng chi tiết
function renderTable(dailyData) {
    const tbody = document.getElementById("detailed-statistics");
    tbody.innerHTML = "";

    dailyData.forEach((item) => {
        const row = `
            <tr>
                <td>${item.date}</td>
                <td>${item.software}</td>
                <td>${item.hardware}</td>
                <td>${item.user}</td>
                <td>${item.visit}</td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

// Render biểu đồ Pie
function renderPieChart(data) {
    const options = {
        chart: {
            type: "pie",
        },
        labels: ["Phần mềm", "Phần cứng", "Người dùng"],
        series: [data.totalSoftware, data.totalHardware, data.totalUser],
        colors: ["#28a745", "#ffc107", "#007bff"],
    };

    const chart = new ApexCharts(
        document.querySelector("#detailed-pie-chart"),
        options
    );
    chart.render();
}

// Render biểu đồ Bar
function renderBarChart(dailyData) {
    const categories = dailyData.map((item) => item.date);
    const softwareSeries = dailyData.map((item) => item.software);
    const hardwareSeries = dailyData.map((item) => item.hardware);
    const userSeries = dailyData.map((item) => item.user);

    const options = {
        chart: {
            type: "bar",
            stacked: true,
        },
        colors: ["#28a745", "#ffc107", "#007bff"],
        plotOptions: {
            bar: {
                horizontal: false,
            },
        },
        xaxis: {
            categories,
        },
        series: [
            {
                name: "Phần mềm",
                data: softwareSeries,
            },
            {
                name: "Phần cứng",
                data: hardwareSeries,
            },
            {
                name: "Người dùng",
                data: userSeries,
            },
        ],
    };

    const chart = new ApexCharts(
        document.querySelector("#detailed-bar-chart"),
        options
    );
    chart.render();
}

// Sự kiện lọc dữ liệu
document.getElementById("btn-filter").addEventListener("click", () => {
    const fromDate = document.getElementById("filter-from").value;
    const toDate = document.getElementById("filter-to").value;

    if (!fromDate || !toDate) {
        alert("Vui lòng chọn đầy đủ ngày bắt đầu và kết thúc.");
        return;
    }

    const result = fakeFetchStatistics(fromDate, toDate);

    document.getElementById("detailed-pie-chart").innerHTML = "";
    document.getElementById("detailed-bar-chart").innerHTML = "";

    renderSummary(result);
    renderTable(result.dailyData);
    renderPieChart(result);
    renderBarChart(result.dailyData);
});


// ✅ Gọi thống kê ví dụ ngay khi trang tải lần đầu
window.addEventListener("DOMContentLoaded", () => {
    const today = new Date();
    const start = new Date();
    start.setDate(today.getDate() - 7); // Mặc định thống kê 7 ngày gần nhất

    const fromDate = start.toISOString().slice(0, 10);
    const toDate = today.toISOString().slice(0, 10);

    // Đổ giá trị mặc định vào input ngày
    document.getElementById("filter-from").value = fromDate;
    document.getElementById("filter-to").value = toDate;

    const result = fakeFetchStatistics(fromDate, toDate);
    renderSummary(result);
    renderTable(result.dailyData);
    renderPieChart(result);
    renderBarChart(result.dailyData);
});
const result = fakeFetchStatistics(fromDate, toDate);
renderSummary(result);
renderTable(result.dailyData);
renderPieChart(result);
renderBarChart(result.dailyData);
renderRolePieChart(result.roleCounts);
