import { defaultHeaders, apiFetch } from "../config/api_config";
export const get_profile = async () => {
    const res = await apiFetch("api/getuser", {
        headers: defaultHeaders(),
    });
    const data = await res.json();

    if (res.ok && data.user) {
        return data.user;
    }
    return [];
};
export const get_all_user = async () => {
    const res = await apiFetch("api/getallusers", {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (data.status === "success" && Array.isArray(data.users)) {
        return data.users;
    }
    return [];
};

export async function create_user(data) {
    const res = await apiFetch("/api/createUser", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi tạo người dùng");
    return result;
}

export const get_user_by_username = async (username) => {
    const res = await apiFetch(`api/getuserbyusername?username=${username}`, {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    console.log("get_user_by_username", data);
    if (res.ok && data.user) {
        return data.user[0];
    }
    return [];
};
// export async function update_profile(data) {
//     alert("chức năng đang bảo trì");
//     return;
//     const res = await apiFetch("/api/updateuser", {
//         method: "POST",
//         headers: defaultHeaders(),
//         body: JSON.stringify(data),
//     });
//     const result = await res.json();
//     if (!res.ok) throw new Error(result.message || "Lỗi tạo người dùng");
//     return result;
// }
export async function chane_password(data) {
    const res = await apiFetch("/api/changepassword", {
        method: "PATCH",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });

    const result = await res.json();

    if (!res.ok) {
        let errorMessages = result.message || "Lỗi đổi mật khẩu";

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
export async function updateuserbyadmin(params) {
    const res = await apiFetch("/api/updateuserbyadmin", {
        method: "PATCH",
        headers: defaultHeaders(),
        body: JSON.stringify(params),
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
export async function hideUser(username) {
    if (!username) throw new Error("Username is required to hide user");

    const res = await apiFetch("/api/hideUser", {
        method: "PATCH", // hoặc POST tùy API
        headers: defaultHeaders(),
        body: JSON.stringify({ username }),
    });

    const result = await res.json();

    if (!res.ok) {
        let errorMessages = result.message || "Lỗi ẩn người dùng";
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

export async function deleteUser(username) {
    if (!username) throw new Error("Username is required to delete user");

    const res = await apiFetch("/api/deleteUser", {
        method: "PATCH", // API của bạn dùng PATCH hoặc POST
        headers: defaultHeaders(),
        body: JSON.stringify({ username }),
    });

    const result = await res.json();

    if (!res.ok) {
        let errorMessages = result.message || "Lỗi xóa người dùng";
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


export async function update_profile(data) {
    const res = await apiFetch("/api/updateuser", {
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
