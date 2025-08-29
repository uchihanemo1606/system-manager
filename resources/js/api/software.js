import { defaultHeaders, apiFetch } from "../config/api_config"; 
export async function create_software(data) {
    const res = await apiFetch("/api/createsoftware", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi tạo phần mềm  ");
    return result;
}
export const get_all_software = async () => {
    const res = await apiFetch("api/getallsoftware", {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) {
        return data.software || data;
    }
    return [];
};
// export const update_software_file_by_id = async (id, data) => {
//     try {
//         const res = await apiFetch(`/api/updatesoftwarefile/${id}`, {
//             method: "PATCH",
//             headers: defaultHeaders(),
//             body: JSON.stringify(data),
//         });

//         if (!res.ok) {
//             const error = await res.json();
//             throw new Error(error.message || "Lỗi không xác định");
//         }

//         const result = await res.json();
//         return result;
//     } catch (err) {
//         console.error("Lỗi khi cập nhật tập tin phần mềm:", err);
//         throw err;
//     }
// };
export async function update_software_file_by_id(id, { software_id, file_name, file, description }) {
    const formData = new FormData();
    formData.append("software_id", software_id);
    formData.append("file_name", file_name);
    if (file) formData.append("file", file); // Chỉ gửi nếu có file mới
    if (description) formData.append("description", description);

    const res = await apiFetch(`/api/updatesoftwarefile/${id}`, {
        method: "POST", // Laravel không hỗ trợ PATCH với multipart/form-data trực tiếp
        headers: {
            Authorization: defaultHeaders().Authorization, // hoặc bỏ nếu Laravel không cần
        },
        body: (() => {
            formData.append("_method", "PATCH"); // Laravel sẽ hiểu là PATCH nhờ dòng này
            return formData;
        })(),
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi cập nhật tệp phần mềm.");
    return result;
}



export async function delete_software_file_by_id(id) {
    const res = await apiFetch(`/api/deletesoftwarefile/${id}`, {
        method: "DELETE",
        headers: defaultHeaders(), // đảm bảo có Authorization + Content-Type: application/json
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi xóa tài liệu thành công");
    return result;
}

export const get_all_software_file_by_id = async (id) => {
    const res = await apiFetch(
        `/api/getallsoftwarefilebysoftwareid/${encodeURIComponent(id)}`,
        {
            headers: defaultHeaders(),
        }
    );
    const data = await res.json();
    if (res.ok) {
        return data;
    }
    return [];
};

export const get_software_by_id = async ({ id }) => {
    const res = await apiFetch(`/api/getsoftwarebyid?id=${encodeURIComponent(id)}`, {
        headers: defaultHeaders(),
    });

    const data = await res.json();

    if (res.ok) {
        // backend trả về {status: "success", data: software}
        return data.software || data;  
    } else {
        // Tạo object lỗi có status để bên catch kiểm tra
        const error = new Error(data.message || "Lỗi lấy dữ liệu phần mềm");
        error.status = res.status;
        throw error;
    }
};

export async function delete_software({ id }) {
    const res = await apiFetch(`/api/deleteSoftware?id=${id}`, {
        method: "DELETE",
        headers: defaultHeaders(), // đảm bảo có Authorization + Content-Type: application/json
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi xóa phần mềm");
    return result;
}

export async function update_software({ id, ...data }) {
    const res = await apiFetch(`/api/updatesoftware/${id}?id=${id}`, {
        method: "PATCH",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });

    const result = await res.json().catch(() => {
        throw new Error("Lỗi không xác định từ server, không thể parse JSON.");
    });

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
export const get_all_user_permission_software = async (softwareID) => {
    try {
        const res = await apiFetch(`/api/getalluserinsoftware/${softwareID}`, {
            headers: defaultHeaders(),
        });
        const data = await res.json();
        if (res.ok) {
            return data.hardware || data;
        }
        return [];
    } catch (error) {
        console.error("Error fetching user permissions for software:", error);
        throw new Error("Lỗi khi lấy quyền người dùng trong phần mềm");
    }
};
export async function create_software_permission({ software_id, user_name, permissions }) {
    if (!Array.isArray(permissions) || permissions.length === 0) {
        throw new Error("Danh sách quyền không hợp lệ.");
    }

    for (const perm of permissions) {
        const res = await apiFetch("/api/createsoftwarepermission", {
            method: "POST",
            headers: defaultHeaders(),
            body: JSON.stringify({
                software_id,
                user_name,
                permissions_name: perm,
            }),
        });

        const result = await res.json();
        if (!res.ok) {
            throw new Error(result.message || `Lỗi khi tạo quyền: ${perm}`);
        }
    }
}
export async function remove_user_permission_in_software({ username, softwareId }) {
    const res = await apiFetch(`/api/deletesoftwarepermission?user_name=${encodeURIComponent(username)}&software_id=${encodeURIComponent(softwareId)}`, {
        method: "DELETE",
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi xóa quyền người dùng phần mềm.");
    return result;
}
export async function get_all_permission_software_by_user({ username, softwareId }) {
    const res = await apiFetch(`/api/getdetailuserpermissioninsoftware?user_name=${encodeURIComponent(username)}&software_id=${encodeURIComponent(softwareId)}`, {
        headers: defaultHeaders(),
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi lấy quyền.");
    return result.data || [];
}
export async function create_software_file({ software_id, file_name, file, description }) {
    const formData = new FormData();
    formData.append("software_id", software_id);
    formData.append("file_name", file_name);
    formData.append("file", file); // Truyền file thực
    if (description) formData.append("description", description);

    const res = await apiFetch("/api/createsoftwarefile", {
        method: "POST",
        headers: {
            Authorization: defaultHeaders().Authorization,
        },
        body: formData,
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi tạo tệp phần mềm.");
    return result;
}
export const get_software_analytics = async (filters = {}) => {
    const query = new URLSearchParams(filters).toString();

    const res = await apiFetch(`api/getsoftwareanalytics?${query}`, {
        headers: defaultHeaders(),
    });

    if (!res.ok) throw new Error("Failed to fetch hardware analytics");
    return await res.json();
};
export const get_my_software_permission_by_software = async (softwareId) => {
    const res = await apiFetch(`/api/getMySoftwarePermissionBySoftware/${encodeURIComponent(softwareId)}`, {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    if (res.ok) {
        return data || [];
    }
    return [];
}