export function showToast({ message, type = "success", timeout = 1000 }) {
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
