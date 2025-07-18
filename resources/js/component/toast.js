export function showToast(toastInput) {
    let message, type = "success", timeout = 1000;

    // Nếu truyền vào là object { message, type, timeout }
    if (typeof toastInput === "object" && toastInput !== null) {
        message = toastInput.message || "";
        type = toastInput.type || "success";
        timeout = toastInput.timeout || 1000;
    }
    // Nếu truyền vào là chuỗi, kiểu showToast("msg", "success")
    else {
        message = arguments[0] || "";
        type = arguments[1] || "success";
        timeout = arguments[2] || 1000;
    }

    let bgColor = "#28a745"; // Mặc định xanh thành công

    if (type === "error") bgColor = "#dc3545";
    else if (type === "warning") bgColor = "#ffc107";
    else if (type === "info") bgColor = "#17a2b8";

    Toastify({
        text: message,
        duration: timeout,
        gravity: "top",
        position: "right",
        backgroundColor: bgColor,
        stopOnFocus: true,
        style: {
            borderRadius: "6px",
            padding: "10px 15px",
            color: "#fff",
            boxShadow: "0 0 10px rgba(0,0,0,0.2)",
        },
    }).showToast();
}
