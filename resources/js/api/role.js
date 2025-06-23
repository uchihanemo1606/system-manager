import { defaultHeaders } from "../config/api_config"; 
export const get_all_role = async () => {
    const res = await fetch("/api/getAllRoles", {
        headers: defaultHeaders(),
    });
    const data = await res.json();
    return data || [];
};
export const get_all_role_permission = async (role_name) => {
    const res = await fetch(
        `/api/getRolePermissionByName?role_name=${role_name}`,
        {
            headers: defaultHeaders(),
        }
    );
    const data = await res.json();
    return data || [];
};
//
