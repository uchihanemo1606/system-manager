import { showToast } from "../toast";

const requiredFields = [
    { key: "ip", message: "Vui lòng nhập địa chỉ IP!" },
    { key: "dbname", message: "Vui lòng nhập tên cơ sở dữ liệu!" },
    { key: "dbversion", message: "Vui lòng nhập phiên bản cơ sở dữ liệu!" },
    { key: "isVirtualServer", message: "Vui lòng chọn máy ảo hay không!" },
    { key: "OS", message: "Vui lòng nhập hệ điều hành!" },
    { key: "OSver", message: "Vui lòng nhập phiên bản hệ điều hành!" },
    { key: "hdd", message: "Vui lòng nhập thông tin ổ cứng!" },
    { key: "ram", message: "Vui lòng nhập dung lượng RAM!" },
    { key: "services", message: "Vui lòng nhập thông tin dịch vụ!" },
];

export function validateHardwareData(data) {
    // Kiểm tra IP hợp lệ (IPv4 cơ bản)
    const ipRegex =
        /^(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}$/;
    if (!data.ip || typeof data.ip !== "string" || !ipRegex.test(data.ip.trim())) {
        showToast({
            message: "Vui lòng nhập đúng định dạng địa chỉ IP.",
            type: "error",
            timeout: 3000,
        });
        return false;
    }

    for (const field of requiredFields) {
        const value = data[field.key];

        if (value === undefined || value === null) {
            showToast({
                message: field.message,
                type: "error",
                timeout: 2000,
            });
            return false;
        }

        if (typeof value === "string" && value.trim() === "") {
            showToast({
                message: field.message,
                type: "error",
                timeout: 2000,
            });
            return false;
        }
    }

    return true;
}

export function validateHardwareDataUpdate(data) {
    // Kiểm tra IP hợp lệ (IPv4 cơ bản)
    const ipRegex =
        /^(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}$/;
    if (!data.ip || !ipRegex.test(data.ip)) {
        showToast({
            message: "Vui lòng nhập đúng định dạng địa chỉ IP.",
            type: "error",
            timeout: 3000,
        });
        return false;
    }

    if (!data.OS || data.OS.length > 100) {
        showToast({
            message: "Hệ điều hành không được để trống và tối đa 100 ký tự.",
            type: "error",
        });
        return false;
    }

    if (!data.OSver || data.OSver.length > 100) {
        showToast({
            message: "Phiên bản hệ điều hành không được để trống và tối đa 100 ký tự.",
            type: "error",
        });
        return false;
    }

    if (data.domain && data.domain.length > 255) {
        showToast({
            message: "Tên miền không được vượt quá 255 ký tự.",
            type: "error",
        });
        return false;
    }

    if (!data.hdd || data.hdd.length > 20) {
        showToast({
            message: "Thông tin ổ cứng không được để trống và tối đa 20 ký tự.",
            type: "error",
        });
        return false;
    }

    if (!data.ram || data.ram.length > 20) {
        showToast({
            message: "Thông tin RAM không được để trống và tối đa 20 ký tự.",
            type: "error",
        });
        return false;
    }

    if (!data.dbname || data.dbname.length > 100) {
        showToast({
            message: "Tên cơ sở dữ liệu không được để trống và tối đa 100 ký tự.",
            type: "error",
        });
        return false;
    }

    if (!data.dbversion || data.dbversion.length > 100) {
        showToast({
            message: "Phiên bản cơ sở dữ liệu không được để trống và tối đa 100 ký tự.",
            type: "error",
        });
        return false;
    }

    if (!data.services || data.services.length > 1000) {
        showToast({
            message: "Thông tin dịch vụ không được để trống và tối đa 1000 ký tự.",
            type: "error",
        });
        return false;
    }

    return true;
}
