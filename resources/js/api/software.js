import { defaultHeaders } from "../config/api_config";
export async function create_software(data) {
    const res = await fetch("/api/createsoftware", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi tạo phần mềm  "); 
    return result;
}
export const get_all_software = async () => {
    const res = await fetch("api/getallsoftware", {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) {
        return data.software || data;
    }
    return [];
};

export const get_software_by_id = async ({ id }) => {
    const res = await fetch(
        `/api/getsoftwarebyid?id=${encodeURIComponent(id)}`,
        {
            headers: defaultHeaders(),
        }
    );  
    const data = await res.json();
    if (res.ok) {
        return data.software || data;
    }
    return [];
};
export async function update_software(data) {
    const res = await fetch("/api/updatesoftware", {
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
        let errorMessages = result?.message || "Lỗi khi sửa phần mềm";

        if (result?.errors) {
            const detailErrors = Object.entries(result.errors)
                .map(([field, messages]) => `${field}: ${Array.isArray(messages) ? messages.join(", ") : messages}`)
                .join("\n");
            errorMessages += `\n${detailErrors}`;
        }

        throw new Error(errorMessages);
    }

    return result;
}