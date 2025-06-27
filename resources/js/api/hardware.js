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

export async function update_hardware(data) {
    const res = await fetch("/api/updatehardware", {
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
                        `${field}: ${
                            Array.isArray(messages)
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
