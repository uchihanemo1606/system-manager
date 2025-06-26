import { get_hardware_by_ip } from "../api/hardware";
import { showToast } from "../component/toast";

const urlParams = new URLSearchParams(window.location.search);
const ip = urlParams.get("id");
const detailBlock = document.getElementById("hardware-detail");
detailBlock.style.display = "none"; // Đảm bảo ẩn ban đầu
if (ip) {
    get_hardware_by_ip({ ip })
        .then((hardware) => {
            console.log("Thông tin phần cứng:", hardware);
            if (!hardware) {
                showToast({
                    message: "Không tìm thấy thông tin phần cứng cho IP này.",
                    type: "error",
                    timeout: 3000,
                });
                return;
            }

            setTextOrCreate("hardware-ip", hardware.ip || "N/A");
            setTextOrCreate("hardware-os", hardware.OS || "N/A");
            setTextOrCreate("hardware-osver", hardware.OSver || "N/A");
            setTextOrCreate(
                "hardware-updated",
                formatDate(hardware.updated_at)
            );
            setTextOrCreate("hardware-createdby", hardware.created_by || "N/A");
            setTextOrCreate(
                "hardware-created",
                formatDate(hardware.created_at)
            );
            setTextOrCreate("hardware-domain", hardware.domain || "N/A");
            setTextOrCreate("hardware-hdd", hardware.hdd || "N/A");
            setTextOrCreate("hardware-ram", hardware.ram || "N/A");
            setTextOrCreate("hardware-db", hardware.dbname || "N/A");
            setTextOrCreate("hardware-dbver", hardware.dbversion || "N/A");
            setTextOrCreate("hardware-services", hardware.services || "N/A");
            setTextOrCreate(
                "hardware-is-active",
                hardware.is_active ? "Hoạt động" : "Dừng hoạt động",
                hardware.is_active ? "text-success" : "text-danger"
            );

            detailBlock.style.display = "block";
        })
        .catch((err) => {
            console.error("Lỗi lấy dữ liệu phần cứng:", err);
            showToast({
                message:
                    "Lỗi khi lấy thông tin phần cứng. Vui lòng thử lại sau.",
                type: "error",
                timeout: 3000,
            });
        });
}

/**
 * Hàm hỗ trợ: Nếu phần tử có sẵn thì cập nhật text, nếu chưa có thì tự tạo trong body
 */
function setTextOrCreate(id, text, colorClass = "") {
    let el = document.getElementById(id);
    if (el) {
        el.textContent = text;
        el.classList.remove("text-success", "text-danger"); // Xóa class cũ
        if (colorClass) el.classList.add(colorClass); // Thêm class mới nếu có
    } else {
        console.warn(`Phần tử với id ${id} không tồn tại.`);
    }
}
function formatDate(dateString) {
    if (!dateString) return "N/A";
    const date = new Date(dateString);
    return date.toLocaleDateString("vi-VN");
}
