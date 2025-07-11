import { defaultHeaders } from "../config/api_config";

// Lấy tất cả log
export const get_all_logs = async () => {
    const res = await fetch(`api/getAllLog`, {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) return data || [];
    return [];
};

// Lấy log theo IP phần cứng
export const get_log_by_hardware = async (ip) => {
    const res = await fetch(`api/getloginhardware/${ip}`, {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) return data || [];
    return [];
};

// Lấy log theo ID phần mềm
export const get_log_by_software = async (id) => {
    const res = await fetch(`api/getloginsoftware/${id}`, {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) return data || [];
    return [];
};

// Lấy log theo username
export const get_log_by_user = async (username) => {
    const res = await fetch(`api/getlogcreatebyuser/${username}`, {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) return data || [];
    return [];
};

// Lấy log theo khoảng thời gian
export const get_log_by_time = async (from, to) => {
    const url = new URL(`api/getlogintime`, window.location.origin);
    if (from) url.searchParams.append("from", from);
    if (to) url.searchParams.append("to", to);

    const res = await fetch(url, {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok && data.status === "success") return data.logs || [];
    return [];
};

// Lấy chi tiết log theo ID
export const get_log_by_id = async (id) => {
    const res = await fetch(`api/getLogById/${id}`, {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) return data;
    return null;
};
