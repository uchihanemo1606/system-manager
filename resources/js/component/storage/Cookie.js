export const getCookie = (name) => {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(";").shift();
    return null;
};

export const setCookie = (name, value, minutes = 60, path = "/") => {
    const expires = new Date(Date.now() + minutes * 60 * 1000).toUTCString();
    const isSecure = location.protocol === "https:";
    document.cookie = `${name}=${value}; Expires=${expires}; Path=${path}; SameSite=Lax${
        isSecure ? "; Secure" : ""
    }`;
};
