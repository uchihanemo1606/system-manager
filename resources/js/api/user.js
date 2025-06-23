import { defaultHeaders } from "../config/api_config";
export const get_all_user = async () => {
    const res = await fetch("api/getallusers", {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (data.status === "success" && Array.isArray(data.users)) {
        return data.users;
    }
    return [];
};

export async function create_user(data) {
    const res = await fetch("/api/createUser", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi tạo người dùng");
    return result;
}
export const get_profile = async () => {
    const res = await fetch("api/getuser", {
        headers: defaultHeaders(),
    });
    const data = await res.json();

    if (res.ok && data.user) {
        return data.user;
    }
    return [];
};
// export async function update_profile(data) {
//     alert("chức năng đang bảo trì");
//     return;
//     const res = await fetch("/api/updateuser", {
//         method: "POST",
//         headers: defaultHeaders(),
//         body: JSON.stringify(data),
//     });
//     const result = await res.json();
//     if (!res.ok) throw new Error(result.message || "Lỗi tạo người dùng");
//     return result;
// }
export async function update_profile(data) {
    const res = await fetch("/api/updateuser", {
        method: "PATCH",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });

    const result = await res.json();

    if (!res.ok) {
        let errorMessages = result.message || "Lỗi cập nhật người dùng";

        if (result?.errors) {
            const detailErrors = Object.entries(result.errors)
                .map(([field, messages]) => `${field}: ${messages.join(", ")}`)
                .join("\n");
            errorMessages += `\n${detailErrors}`;
        }

        throw new Error(errorMessages);
    }

    return result;
}
