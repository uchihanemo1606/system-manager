import { defaultHeaders, apiFetch } from "../config/api_config"; 
// ----------- OS Data -----------

export async function get_all_hardware_os() {
    const res = await apiFetch("/api/getallos", { headers: defaultHeaders() });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Không thể lấy danh sách OS.");
    return result;
}

export async function get_versions_by_os(osName) {
    const res = await apiFetch(`/api/getallversionofos/${osName}`, {
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Không thể lấy phiên bản OS.");
    return result;
}

export async function create_hardware_os(data) {
    const res = await apiFetch("/api/createos", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi thêm OS.");
    return result;
}
export async function create_hardware_os_version(data) {
    const res = await apiFetch("/api/createosversion", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi thêm OS version.");
    return result;
}


export async function update_hardware_os_data(id, data) {
    const res = await apiFetch(`/api/hardwareOsData/${id}`, {
        method: "PUT",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi cập nhật OS.");
    return result;
}

export async function delete_hardware_os_data(id) {
    const res = await apiFetch(`/api/hardwareOsData/${id}`, {
        method: "DELETE",
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi xóa OS.");
    return result;
}

// ----------- Database Data -----------

export async function get_all_hardware_database() {
    const res = await apiFetch("/api/getalldatabases", { headers: defaultHeaders() });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Không thể lấy danh sách Database.");
    return result;
}
export async function get_all_hardware_database_version() {
    const res = await apiFetch("/api/getalldatabaseversions", { headers: defaultHeaders() });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Không thể lấy danh sách Database version.");
    return result;
}

export async function get_versions_by_dbname(dbname) {
    const res = await apiFetch(`/api/getdatabaseversionbyname/${encodeURIComponent(dbname)}`, {
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Không thể lấy phiên bản Database.");
    return result;
}

export async function create_hardware_database(data) {
    const res = await apiFetch("/api/createdatabase", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi thêm database.");
    return result;
}
export async function create_hardware_database_version(data) {
    const res = await apiFetch("/api/createdatabaseversion", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi thêm database version.");
    return result;
}

export async function update_hardware_database(id, data) {
    const res = await apiFetch(`/api/hardwareDatabase/${id}`, {
        method: "PUT",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi cập nhật database.");
    return result;
}

export async function delete_hardware_database(id) {
    const res = await apiFetch(`/api/hardwareDatabase/${id}`, {
        method: "DELETE",
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi khi xóa database.");
    return result;
}
