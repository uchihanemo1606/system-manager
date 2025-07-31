import { defaultHeaders } from "../config/api_config";

export async function update_system_project(data) {
    const res = await fetch("/api/updatefootersystem", {
        method: "POST",
        headers: {
            ...defaultHeaders(),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ foodter: data }),
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi ");
    return result;
}
export async function get_system_project() {
    const res = await fetch("/api/getfootersystem", {
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi lấy thông tin hệ thống");
    return result;
}
export async function update_logo(file) {
    const formData = new FormData();
    formData.append("avatar", file); // ✅ Laravel yêu cầu field này là 'avatar'

    const response = await fetch("/api/updatelogo", {
        method: "POST",
        headers: {
            // KHÔNG thêm Content-Type ở đây — để trình duyệt tự set
            Authorization: defaultHeaders().Authorization, // nếu cần
        },
        body: formData,
    });

    if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || "Lỗi không xác định");
    }

    return await response.json();
}


export async function get_logo() {
    const res = await fetch("/api/getavatarsystem", {
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi lấy logo hệ thống");
    return result;
}