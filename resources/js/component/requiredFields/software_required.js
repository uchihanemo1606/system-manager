import { showToast } from "../toast";

const REQUIRED_FIELDS = [
    { key: "softwareName", label: "Tên phần mềm" },
    { key: "language", label: "Ngôn ngữ" },
    { key: "version", label: "Phiên Bản" },
    { key: "description", label: "Mô Tả" },
    // Bạn có thể thêm các trường bắt buộc khác ở đây nếu cần
];

export function validateSoftwareData(data) {
    for (const field of REQUIRED_FIELDS) {
        if (!data[field.key] || data[field.key].trim() === "") {
            showToast({
                message: `Vui lòng nhập ${field.label.toLowerCase()}!`,
                type: "error",
                timeout: 2000,
            });
            return false;
        }
    }
    return true;
}
