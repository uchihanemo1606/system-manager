const API_HEADERS = () => ({
    Authorization: `Bearer ${window.appConfig?.apiToken}`,
    Accept: "application/json",
});

export async function fetchUsers(apiUrl) {
    const res = await fetch(apiUrl, { headers: API_HEADERS() });
    const data = await res.json();
    if (data.status === "success" && Array.isArray(data.users)) {
        return data.users;
    }
    return [];
}

export async function fetchRoles() {
    const res = await fetch("/api/getAllRoles", { headers: API_HEADERS() });
    const data = await res.json();
    return data.data || [];
}
