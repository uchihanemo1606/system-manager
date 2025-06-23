import { getCookie } from "../component/storage/Cookie";

const token = getCookie("auth_token");

export const defaultHeaders = () => ({
    "Content-Type": "application/json",
    Authorization: `Bearer ${token}`,
    Accept: "application/json",
});
