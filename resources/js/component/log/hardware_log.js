import { get_log_by_hardware } from "../../api/log";

async function fetchLogs() {
    try {
        const logs = await get_log_by_hardware("YOUR_JWT_TOKEN_HERE");
        console.log("Logs từ API:", logs);
    } catch (error) {
        console.error("Lỗi khi gọi API:", error);
    }
}
