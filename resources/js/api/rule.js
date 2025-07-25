import { defaultHeaders } from "../config/api_config";

// Tạo loại quy chế
export async function create_category_rule(data) {
    const res = await fetch("api/createcategoryrule", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi tạo loại quy chế");
    return result;
}

// Cập nhật loại quy chế
export async function update_category_rule(data) {
    const res = await fetch("api/updatecategoryrule", {
        method: "PATCH",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi cập nhật loại quy chế");
    return result;
}   

// Xóa loại quy chế
export async function delete_category_rule(id) {
    const res = await fetch(`api/deletecategoryrule?id=${id}`, {
        method: "DELETE",
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi xóa loại quy chế");
    return result;
}

// Lấy tất cả loại quy chế
export async function get_all_category_rule() {
    const res = await fetch("api/getallcategoryrule", {
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi lấy danh sách loại quy chế");
    return result;
}
export async function get_category_by_id(id) {
    const res = await fetch(`api/getcategoryrulebyid?id=${id}`, {
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi lấy thông tin loại quy chế");
    return result;
}
// rule software
export async function create_rule(formData) {
    const res = await fetch("api/createrule", {
        method: "POST",
        headers: {
            Authorization: defaultHeaders().Authorization // chỉ giữ Authorization
        },
        body: formData,
    });

    const result = await res.json();
    if (!res.ok) throw result; // giữ nguyên lỗi để hiển thị errors từ server
    return result;
}
export async function create_software_rule(payload) {
    const res = await fetch("api/createsoftwarerule", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(payload), // Không dùng FormData
    });

    const result = await res.json();
    if (!res.ok) throw result;
    return result;
}
export async function get_all_software_rule(software_id) {
    const res = await fetch(`api/get_software_rules?software_id=${software_id}`, {
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi lấy danh sách loại quy chế");
    return result;
}
export async function delete_software_rule_by_id(id) {
    const res = await fetch(`/api/deletesoftwarerule?id=${id}`, {
        method: "DELETE",
        headers: defaultHeaders(),
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi xóa quy chế thành công");
    return result;
}
export async function update_software_rule_by_id(payload) {
    const res = await fetch("api/updatesoftwarerule", {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
            Authorization: defaultHeaders().Authorization
        },
        body: JSON.stringify(payload)
    });

    const result = await res.json();
    if (!res.ok) throw result;
    return result;
}
