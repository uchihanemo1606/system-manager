import { get_all_software } from "../api/software";
import { showToast } from "../component/toast";

let allSoftwareCache = []; // Lưu dữ liệu tạm để lọc

async function loadSoftware() {
    const container = document.getElementById("software-list-container");
    container.innerHTML = ""; // Xóa cũ

    try {
        const res = await get_all_software();
        if (res.status !== "success" || !Array.isArray(res.data)) {
            throw new Error("Dữ liệu không hợp lệ");
        }

        allSoftwareCache = res.data || [];

        // Nếu người dùng chưa chọn bộ lọc trạng thái xóa, thì mặc định chỉ lấy phần mềm chưa xóa
        const isDeleteFilter = document.getElementById("filter-delete").value; 
        if (!isDeleteFilter) {
            const filtered = allSoftwareCache.filter(sw => !sw.is_delete);
            renderSoftware(filtered);
        } else {    
            applyFilter(); // Nếu có bộ lọc đang được chọn thì apply toàn bộ
        }

    } catch (err) {
        console.error(err);
        showToast({
            message: err?.message || "Tải danh sách phần mềm thất bại!",
            type: "error",
            timeout: 2000,
        });
    }
}

function renderSoftware(data) {
    const container = document.getElementById("software-list-container");
    container.innerHTML = "";

    if (data.length === 0) {
        container.innerHTML = `<div class="col-12 text-center text-muted">Không tìm thấy phần mềm nào.</div>`;
        return;
    }

    data.forEach((software) => {
        container.innerHTML += renderSoftwareCard(software);
    });
}

function applyFilter() {
    const name = document.getElementById("filter-name").value.toLowerCase();
    const language = document
        .getElementById("filter-language")
        .value.toLowerCase();
    const version = document
        .getElementById("filter-version")
        .value.toLowerCase();
    const is_delete = document.getElementById("filter-delete").value;
    const created_by = document
        .getElementById("filter-createdby")
        .value.toLowerCase();
    const created_at = document.getElementById("filter-createdat").value;

    const filtered = allSoftwareCache.filter((sw) => {
        return (
            (!name || sw.softwareName?.toLowerCase().includes(name)) &&
            (!language || sw.language?.toLowerCase().includes(language)) &&
            (!version || sw.version?.toLowerCase().includes(version)) &&
            (!is_delete || String(sw.is_delete) === is_delete) &&
            (!created_by ||
                sw.user_createby?.toLowerCase().includes(created_by)) &&
            (!created_at || sw.created_at?.startsWith(created_at))
        );
    });

    renderSoftware(filtered);
}

function renderSoftwareCard(software) {
    return `
    <div class="col-12 col-sm-6 col-lg-3 mb-2">
        <div class="card position-relative m-0 ${software.is_delete ? 'border-danger' : ''}">
            ${software.is_delete ? `
                <div style="
                    position: absolute;
                    top: 0;
                    left: 0;
                    background: red;
                    color: white;
                    padding: 2px 6px;
                    font-size: 12px;
                    font-weight: bold;
                    border-bottom-right-radius: 4px;
                    z-index: 1;
                ">
                    ĐÃ XÓA
                </div>` : ""
            }

            <div style="
                position: absolute;
                top: 0;
                right: 0;
                background: #007bff;
                color: white;
                padding: 2px 6px;
                font-size: 12px;
                font-weight: bold;
                border-bottom-left-radius: 4px;
                z-index: 1;
            ">
                ${software.version || "N/A"}
            </div>

            <div class="card-body">
                <div class="media">
                    <div class="media-body overflow-hidden">
                        <h5 class="font-size-15 mb-2 text-truncate">
                            <span class="font-weight-normal text-muted">Tên:</span>
                            <a href="software_detail?id=${software.id}" class="text-dark font-weight-bold">
                                ${software.softwareName}
                            </a>
                        </h5> 
                        <div class="d-flex flex-wrap mb-2">
                            <div class="mr-3 mb-1">
                                <span class="text-muted">Ngôn ngữ:</span>
                                <span class="badge badge-primary">${software.language}</span>
                            </div>
                            <div class="mb-1">
                                <span class="text-muted">Tạo bởi:</span>
                                <span class="text-success font-weight-bold">${software.user_createby}</span>
                            </div>
                        </div>
                        <p class="text-muted limit-3-lines mb-0">
                            ${software.description || "Không có mô tả"}
                        </p>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 border-top d-flex justify-content-between">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item" data-toggle="tooltip" title="Ngày tạo">
                        <i class="bx bx-calendar mr-1"></i> ${formatDate(software.created_at)}
                    </li>
                </ul>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item mr-3">
                        <a href="/software_detail?id=${software.id}&edit=true" title="Sửa" class="text-primary d-inline-flex align-items-center">
                            <i class="bx bx-wrench mr-1"></i> Sửa
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="/software_detail?id=${software.id}" title="Chi tiết" class="text-muted d-inline-flex align-items-center">
                            <i class="bx bx-link-external mr-1"></i> Chi tiết
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>`;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("vi-VN");
}

window.loadSoftware = loadSoftware;
window.applyFilter = applyFilter;
window.addEventListener("softwareCreated", loadSoftware);
document.addEventListener("DOMContentLoaded", () => {
    loadSoftware();

    const inputs = document.querySelectorAll(
        "#filter-name, #filter-language, #filter-version, #filter-delete, #filter-createdby, #filter-createdat"
    );

    inputs.forEach((input) => {
        const eventType =
            input.tagName.toLowerCase() === "select" || input.type === "date"
                ? "change"
                : "input";
        input.addEventListener(eventType, applyFilter);
    });
});
