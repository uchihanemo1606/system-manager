// import { getCookie } from "../component/storage/Cookie";

// const token = getCookie("auth_token"); 
// export const defaultHeaders = () => ({
//     "Content-Type": "application/json",
//     Authorization: `Bearer ${token}`,
//     Accept: "application/json",
// });
import { getCookie, setCookie } from "../component/storage/Cookie";

// Hàm lấy headers mặc định (luôn lấy token mới nhất từ cookie)
export const defaultHeaders = () => {
    const token = getCookie("auth_token");
    return {
        "Content-Type": "application/json",
        Authorization: token ? `Bearer ${token}` : "",
        Accept: "application/json",
    };
};

// Hàm gọi refresh token
const refreshToken = async () => {
    const refresh_token = getCookie("refresh_token");
    if (!refresh_token) throw new Error("No refresh token");

    const res = await fetch("/api/refresh", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ refresh_token }),
    });

    if (!res.ok) throw new Error("Refresh token failed");
    const data = await res.json();

    if (data.token) {
        setCookie("auth_token", data.token, 1); // lưu token mới
        return data.token;
    }

    throw new Error("Invalid refresh response");
};

// Wrapper fetch dùng trong toàn bộ project
export const apiFetch = async (url, options = {}) => {
    let headers = { ...defaultHeaders(), ...(options.headers || {}) };

    let response = await fetch(url, { ...options, headers });

    // Nếu token hết hạn → refresh và gọi lại
    if (response.status === 401) {
        try {
            const newToken = await refreshToken();
            headers = {
                ...defaultHeaders(),
                ...(options.headers || {}),
                Authorization: `Bearer ${newToken}`,
            };

            response = await fetch(url, { ...options, headers });
        } catch (err) {
            console.error("Refresh token error:", err);
            throw err;
        }
    }

    return response;
};
