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
export async function delete_software({ id }) {
    const res = await fetch(`/api/deleteSoftware?id=${id}`, {
        method: "DELETE",
        headers: defaultHeaders(), // đảm bảo có Authorization + Content-Type: application/json
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi xóa phần mềm");
    return result;
}

export async function update_software({ id, ...data }) {
    const res = await fetch(`/api/updatesoftware/${id}`, {
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
        const res = await fetch(`/api/getalluserinsoftware/${softwareID}`, {
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
        const res = await fetch("/api/createsoftwarepermission", {
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
    const res = await fetch(`/api/deletesoftwarepermission?user_name=${encodeURIComponent(username)}&software_id=${encodeURIComponent(softwareId)}`, {
        method: "DELETE",
        headers: defaultHeaders(),
    }); 
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi xóa quyền người dùng phần mềm.");
    return result;
}
export async function get_all_permission_software_by_user({ username, softwareId }) {
    const res = await fetch(`/api/getdetailuserpermissioninsoftware?user_name=${encodeURIComponent(username)}&software_id=${encodeURIComponent(softwareId)}`, {
        headers: defaultHeaders(),
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi lấy quyền.");
    return result.data || [];
}
export async function create_software_file({ software_id, file_name, file_path, description }) {
    const res = await fetch("/api/createsoftwarefile", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify({
            software_id,
            file_name,
            file_path,
            description, // thêm nếu cần
        }),
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi tạo tệp phần mềm.");
    return result;
}
