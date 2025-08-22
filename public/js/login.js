// document.addEventListener("DOMContentLoaded", () => {
//     initLoginForm();
// });
// function initLoginForm() {
//     const form = document.getElementById("loginForm");
//     if (!form) return;
//     const errorDiv = document.getElementById("error");
//     // Nếu có hàm getCsrfToken() thì gọi nó, nếu không có thì để token CSRF theo cách Laravel cung cấp
//     const csrfToken =
//         typeof getCsrfToken === "function"
//             ? getCsrfToken()
//             : document.querySelector('meta[name="csrf-token"]')?.content || "";

//     form.addEventListener("submit", async (e) => {
//         e.preventDefault();
//         errorDiv.textContent = "";
//         const formData = new FormData(form);
//         try {
//             const res = await fetch(
//                 "/api/login",
//                 {
//                     method: "POST",
//                     credentials: "include",
//                     headers: {
//                         "X-CSRF-TOKEN": csrfToken,
//                         Accept: "application/json",
//                     },
//                     body: formData,
//                 },
//                 { withCredentials: true }
//             );
//             const data = await res.json();

//             if (res.ok && data.token) {
//                 localStorage.setItem("jwt_token", data.token);
//                 const isSecure = location.protocol === "https:";
//                 document.cookie = `token=${data.token}; path=/; SameSite=Lax${
//                     isSecure ? "; Secure" : ""
//                 }`;
//                 window.location.href = data.redirect || "/";
//                 errorDiv.textContent =
//                     data.message || data.status || "Đăng nhập thành công!";
//             } else {
//                 errorDiv.textContent = data.message || data.status;
//             }
//         } catch {
//             errorDiv.textContent = "Lỗi server, vui lòng thử lại sau.";
//         }
//     });
// }
document.addEventListener("DOMContentLoaded", () => {
    initLoginForm();
});

function initLoginForm() {
    const form = document.getElementById("loginForm");
    if (!form) return;
    const errorDiv = document.getElementById("error");

    // Nếu có hàm getCsrfToken() thì gọi nó, nếu không có thì lấy từ meta Laravel
    const csrfToken =
        typeof getCsrfToken === "function"
            ? getCsrfToken()
            : document.querySelector('meta[name="csrf-token"]')?.content || "";

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        errorDiv.textContent = "";

        const formData = new FormData(form);

        try {
            const res = await fetch("/api/login", {
                method: "POST",
                credentials: "include",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
                body: formData,
            });

            const data = await res.json();

            if (res.ok && data.token) {
                // Lưu token vào localStorage
                localStorage.setItem("jwt_token", data.token);

                // Tính thời gian sống cookie = 60 phút
                const maxAge = 60 * 60; // 60 phút (giây)
                const isSecure = location.protocol === "https:";

                // Set cookie token
                document.cookie = `token=${data.token}; path=/; Max-Age=${maxAge}; SameSite=Lax${
                    isSecure ? "; Secure" : ""
                }`;

                // Redirect sau khi login
                window.location.href = data.redirect || "/";

                errorDiv.textContent =
                    data.message || data.status || "Đăng nhập thành công!";
            } else {
                errorDiv.textContent = data.message || data.status || "Đăng nhập thất bại!";
            }
        } catch (err) {
            console.error("Login error:", err);
            errorDiv.textContent = "Lỗi server, vui lòng thử lại sau.";
        }
    });
}
