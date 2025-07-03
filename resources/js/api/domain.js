import { showToast } from "../component/toast";
import { defaultHeaders } from "../config/api_config";
export async function get_all_domain() {
    const res = await fetch(
        `/api/getalldomain`,
        {
            headers: defaultHeaders(),
        }
    );
    const data = await res.json();
    if (res.ok) {
        return data;
    }
    return [];
}
export async function update_domain_by_name(data) {
    const res = await fetch(`/api/updatedomain`, {
        method: "PATCH",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) {
        showToast({
            message: result.message || "Lỗi cập nhật tên miền",
            type: "error",
        });
        throw new Error(result.message || "Lỗi cập nhật tên miền");
    }
    showToast({
        message: "Cập nhật tên miền thành công!",
        type: "success",
    });
    return result;
}
export async function create_domain(data) {
    const res = await fetch("/api/createdomain", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi tạo tên miền");
    return result;
}
export async function delete_domain_by_name(name) {
    const res = await fetch(`/api/deletedomain?name=${name}`, {
        method: "DELETE",
        headers: defaultHeaders(),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi xóa tên miền " + name);
    return result;
}
export const get_domain_software = async (id) => {
    const res = await fetch("/api/getalldomain", {
        headers: defaultHeaders(),
    });

    const data = await res.json();

    if (!data?.data) return [];

    // Lọc ra các domain có software_id khớp với id truyền vào
    const filteredDomains = data.data.filter(
        (domain) => domain.software_id == id
    );

    return filteredDomains;
};
export async function get_hardware_software_by_domain({ link, name }) {
    const res = await fetch(
        `/api/gethardwaresoftwareindomain?link=${link}&name=${name}`,
        {
            headers: defaultHeaders(),
        }
    );
    const data = await res.json();
    if (res.ok) {
        return data;
    }
    return [];
}
export async function get_domain_by_hardware({ ip }) {
    const res = await fetch(
        `/api/getdomainsbyhardware?ip=${ip}`,
        {
            headers: defaultHeaders(),
        }
    );
    const data = await res.json();
    if (res.ok && data?.data?.hardware_ip == ip) {
        return data;
    }
    return [];
}
export async function create_domain_hardware(data) {
    const res = await fetch("/api/createhardwaredomain", {
        method: "POST",
        headers: defaultHeaders(),
        body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi thêm tên miền cho phần cứng");
    return result;
}