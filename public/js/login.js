document.addEventListener("DOMContentLoaded", () => {
    initLoginForm();
});
console.log("Login script loaded");
function initLoginForm() {
    const form = document.getElementById("loginForm");
    if (!form) return;
    const errorDiv = document.getElementById("error");
    // Nếu có hàm getCsrfToken() thì gọi nó, nếu không có thì để token CSRF theo cách Laravel cung cấp
    const csrfToken =
        typeof getCsrfToken === "function"
            ? getCsrfToken()
            : document.querySelector('meta[name="csrf-token"]')?.content || "";

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        errorDiv.textContent = "";
        const formData = new FormData(form);
        try {
            const res = await fetch(
                "/api/login",
                {
                    method: "POST",
                    credentials: "include",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        Accept: "application/json",
                    },
                    body: formData,
                },
                { withCredentials: true }
            );
            const data = await res.json();

            if (res.ok && data.token) {
                localStorage.setItem("jwt_token", data.token);
                const isSecure = location.protocol === "https:";
                document.cookie = `token=${data.token}; path=/; SameSite=Lax${
                    isSecure ? "; Secure" : ""
                }`;

                alert(data.message || "Đăng nhập thành công!");
                window.location.href = data.redirect || "/";
                errorDiv.textContent = data.message || "Đăng nhập thất bại";
            }
        } catch {
            errorDiv.textContent = "Lỗi server, vui lòng thử lại sau.";
        }
    });
}
