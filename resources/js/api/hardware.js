import { defaultHeaders } from "../config/api_config";
export async function create_hardware(data) {
    const res = await fetch("/api/createhardware", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi tạo phần cứng   ");
    return result;
}
export async function delete_hardware(ip) {
    const res = await fetch(`/api/deletehardware?ip=${ip}`, {
        method: "DELETE",
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi xóa phần cứng   ");
    return result;
}
export const get_all_hardware = async () => {
    const res = await fetch("api/getallhardware", {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) {
        return data.hardware || data;
    }
    return [];
};
export const get_hardware_by_ip = async ({ ip }) => {
    const res = await fetch(
        `/api/gethardwarebyip?ip=${encodeURIComponent(ip)}`,
        {
            headers: defaultHeaders(),
        }
    );
    const data = await res.json();
    if (res.ok) {
        return data.hardware || data;
    }
    return [];
};

export async function update_hardware(data,oldIp) {
    const res = await fetch(`/api/updatehardware/${oldIp}`, {
        method: "PATCH",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    }); 
    let result;
    try {
        result = await res.json();
    } catch (e) {
        throw new Error("Lỗi không xác định từ server, không thể parse JSON.");
    }

    if (!res.ok) {
        let errorMessages = result?.message || "Lỗi khi sửa phần cứng";

        if (result?.errors) {
            const detailErrors = Object.entries(result.errors)
                .map(
                    ([field, messages]) =>
                        `${field}: ${Array.isArray(messages)
                            ? messages.join(", ")
                            : messages
                        }`
                )
                .join("\n");
            errorMessages += `\n${detailErrors}`;
        }

        throw new Error(errorMessages);
    }

    return result;
}
export const get_all_user_permission_hardware = async (hardwareIP) => {
    const res = await fetch(`/api/getalluserpermissioninhardware/${hardwareIP}`, {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) {
        return data.hardware || data;
    }
    return [];
};
export const get_all_permission_hardware_by_user = async ({ username, hardwareIp }) => {
    const res = await fetch(`/api/getdetailuserpermissioninhardware?user_name=${encodeURIComponent(username)}&hardware_ip=${encodeURIComponent(hardwareIp)}`, {
        headers: defaultHeaders(),
    });

    const data = await res.json();
    if (res.ok) {
        return data.data || data;
    }
    return [];
}
export async function remove_user_permission_in_hardware({ username, hardwareIp }) {
    const res = await fetch(`/api/removeuserpermissioninhardware?user_name=${encodeURIComponent(username)}&hardware_ip=${encodeURIComponent(hardwareIp)}`, {
        method: "DELETE",
        headers: defaultHeaders()
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi xóa quyền");
    return result;
}

export async function create_hardware_permission(data) {
    const res = await fetch("/api/createharwarepermission", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi tạo quyền");
    return result;
}
