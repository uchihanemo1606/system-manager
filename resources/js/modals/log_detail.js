import { get_log_by_id } from "../api/log";

function initLogDetailModal(data) {
    const id = data.id || data;

    get_log_by_id(id).then(res => {
        if (res) {
            const log = res;

            const detailContainer = document.getElementById("log-detail-body");
            if (!detailContainer) return;
            detailContainer.innerHTML = ""; // Xóa nội dung cũ

            const fields = [
                { label: "Người thực hiện", value: log.user?.fullName || log.username },
                { label: "Tên đăng nhập", value: log.user?.username },
                { label: "Email", value: log.user?.email },
                { label: "Số điện thoại", value: log.user?.phone_number },
                { label: "Thời gian", value: formatDate(log.created_at) },
                { label: "Thông điệp", value: log.message },
                { label: "IP", value: log.ip },
                { label: "Tên phần mềm", value: log.software?.name },
                { label: "Tên hệ điều hành", value: log.os_name },
                { label: "Tên cơ sở dữ liệu", value: log.database_name },
                { label: "Quyền phần mềm", value: log.software_permission?.name },
                { label: "Quyền phần cứng", value: log.hardware_permission?.name },
                { label: "Vai trò", value: log.role?.name },
                { label: "Quyền", value: log.permission?.name },
                { label: "Quy chế", value: log.rule?.name },
                { label: "Phòng ban", value: log.department?.name },
                { label: "Tên miền", value: log.domain?.name },
                { label: "Tên phần cứng", value: log.hardware?.name },
                { label: "File phần mềm", value: log.software_file?.file_url },
                { label: "Danh mục quy chế", value: log.category_rule?.name },
            ];

            for (const field of fields) {
                if (field.value != null && field.value !== "") {
                    const div = document.createElement("div");
                    div.innerHTML = `<strong>${field.label}:</strong> <span>${field.value}</span>`;
                    detailContainer.appendChild(div);
                }
            }

            $('#logDetailModal').modal('show');
        } else {
            alert("Không thể tải chi tiết bản ghi.");
        }
    }).catch(err => {
        console.error(err);
        alert("Lỗi khi lấy dữ liệu log.");
    });
}

function formatDate(isoString) {
    const date = new Date(isoString);
    return date.toLocaleString("vi-VN", {
        hour12: false,
        timeZone: "Asia/Ho_Chi_Minh"
    });
}

window.initLogDetailModal = initLogDetailModal;
