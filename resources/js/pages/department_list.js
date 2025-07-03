const departments = [
    { id: 1, name: "Phòng CNTT" },
    { id: 2, name: "Phòng Phần mềm" }
];

const hardwareByDepartment = {
    1: ["Máy chủ 1", "PC văn phòng"],
    2: []
};

const softwareByDepartment = {
    1: ["Phần mềm Quản lý tài sản"],
    2: ["Phần mềm Kế toán", "Phần mềm CRM"]
};

function renderDepartmentList() {
    const container = document.getElementById("department-list");
    container.innerHTML = "";

    departments.forEach(dep => {
        const item = document.createElement("button");
        item.className = "list-group-item list-group-item-action";
        item.innerHTML = `<i class="mdi mdi-domain"></i> ${dep.name}`;
        item.onclick = () => showDepartmentDetail(dep);
        container.appendChild(item);
    });
}

function showDepartmentDetail(dep) {
    document.getElementById("department-list-view").classList.add("d-none");
    document.getElementById("department-detail-view").classList.remove("d-none");

    document.getElementById("selected-department-name").innerText = dep.name;

    renderHardwareList(dep.id);
    renderSoftwareList(dep.id);
}

function renderHardwareList(depId) {
    const container = document.getElementById("hardware-list");
    const data = hardwareByDepartment[depId] || [];

    container.innerHTML = data.length
        ? data.map(item => `<li class="list-group-item">${item}</li>`).join("")
        : `<li class="list-group-item text-muted">Không có dữ liệu</li>`;
}

function renderSoftwareList(depId) {
    const container = document.getElementById("software-list");
    const data = softwareByDepartment[depId] || [];

    container.innerHTML = data.length
        ? data.map(item => `<li class="list-group-item">${item}</li>`).join("")
        : `<li class="list-group-item text-muted">Không có dữ liệu</li>`;
}

document.getElementById("btn-back-to-department").onclick = () => {
    document.getElementById("department-list-view").classList.remove("d-none");
    document.getElementById("department-detail-view").classList.add("d-none");
};

renderDepartmentList();
