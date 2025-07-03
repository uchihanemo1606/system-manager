import { defaultHeaders } from "../config/api_config";
// export async function create_hardware(data) {
//     const res = await fetch("/api/createhardware", {
//         method: "POST",
//         headers: defaultHeaders(),
//         body: JSON.stringify(data),
//     });
//     const result = await res.json();
//     if (!res.ok) throw new Error(result.message || "Lỗi tạo phần cứng   ");
//     return result;
// }
export const get_log_by_hardware = async (ip) => {
    const res = await fetch(`api/getloginhardware/${ip}`, {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) {
        return data || [];
    }
    return [];
};
export const get_log_by_software = async (id) => {
    const res = await fetch(`api/getloginsoftware/${id}`, {
        headers: defaultHeaders(),
    })
    const data = await res.json()
    if (res.ok) {
        return data || [];
    }
    return [];
}

