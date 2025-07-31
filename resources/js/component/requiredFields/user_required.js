// file: helpers/validate.js
import { showToast } from "../toast";
const requiredFieldsUserCreate = [
    { key: "fullName", message: "Vui lòng nhập họ và tên!" },
    { key: "email", message: "Vui lòng nhập email!" },
    { key: "username", message: "Vui lòng nhập tên đăng nhập!" },
    { key: "password", message: "Vui lòng nhập mật khẩu!" },
    { key: "verifyPassword", message: "Vui lòng nhập xác nhận mật khẩu!" },
];
const requiredFieldsUserEdit = [
    { key: "fullName", message: "Vui lòng nhập họ và tên!" },
    { key: "email", message: "Vui lòng nhập email!" },
    { key: "username", message: "Vui lòng nhập tên đăng nhập!" },
];
export function validateUserData(data) {
    for (const field of requiredFieldsUserCreate) {
        if (!data[field.key] || data[field.key].trim() === "") {
            showToast({
                message: field.message,
                type: "error",
                timeout: 2000,
            });
            return false;
        }
    }

    // Kiểm tra mật khẩu mạnh
    const password = data.password || "";
    if (!isStrongPassword(password)) {
        showToast({
            message: "Mật khẩu phải có ít nhất 8 ký tự, gồm chữ, số và ký tự đặc biệt!",
            type: "error",
            timeout: 2000,
        });
        return false;
    }

    return true;
}

function isStrongPassword(password) {
    return (
        password.length >= 8 &&
        /[a-zA-Z]/.test(password) &&
        /[0-9]/.test(password) &&
        /[^a-zA-Z0-9]/.test(password)
    );
}

export function validateUserDataUpdate(data) {
    for (const field of requiredFieldsUserEdit) {
        if (!data[field.key] || data[field.key].trim() === "") {
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
