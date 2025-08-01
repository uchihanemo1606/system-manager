const token = localStorage.getItem("jwt_token");

async function get_system_project() {
    const res = await fetch("/api/getfootersystem", {
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
        },
    });

    const result = await res.json();
    if (!res.ok) throw new Error(result.message || "Lỗi lấy thông tin hệ thống");
    return result;
}

get_system_project()
    .then(response => {
        console.log("Response from get_system_project:", response);

        // Chuỗi JSON: parse lần nữa
        const footerData = JSON.parse(`{${response.footer}}`);

        // Gán vào HTML
        document.getElementById("name_company").textContent = footerData.name_company || "Tên công ty";
        document.getElementById("name_system").textContent = footerData.name_system || "Tên hệ thống";
        document.getElementById("phone").textContent = " : " + (footerData.phone || "SĐT");

    })
    .catch(error => {
        console.error("Lỗi khi gọi API:", error);
    });


if (token) {
    const originalFetch = window.fetch;

    window.fetch = async function (url, options = {}) {
        options.headers = options.headers || {};
        options.headers["Authorization"] = "Bearer " + localStorage.getItem("jwt_token");
        options.credentials = "include"; // quan trọng khi dùng cookie refresh

        let response = await originalFetch(url, options);

        // Nếu token hết hạn, thử refresh
        if (response.status === 401) {
            const refreshRes = await originalFetch("/api/refresh", {
                method: "POST",
                credentials: "include", // gửi cookie token cũ (nếu backend lưu)
                headers: {
                    "Accept": "application/json",
                }
            });

            if (refreshRes.ok) {
                const refreshData = await refreshRes.json();

                if (refreshData.token) {
                    // ✅ Cập nhật token mới
                    localStorage.setItem("jwt_token", refreshData.token);
                    const isSecure = location.protocol === "https:";
                    document.cookie = `token=${refreshData.token}; path=/; SameSite=Lax${isSecure ? "; Secure" : ""
                        }`;

                    // Gắn token mới và gọi lại request cũ
                    options.headers["Authorization"] = "Bearer " + refreshData.token;
                    response = await originalFetch(url, options);
                }
            } else {
                console.warn("Không thể refresh token");
            }
        }

        return response;
    };
}

function loadModal(modalName, data = null, modalSize = 'lg') {
    console.log("Loading modal:", modalName, "with data:", data);
    fetch("/modal/" + modalName)
        .then(res => res.text())
        .then(html => {
            document.getElementById("modalContent").innerHTML = html;

            const modalDialog = document.querySelector("#modalContainer .modal-dialog");
            modalDialog.classList.remove("modal-sm", "modal-lg", "modal-xl", "modal-xxl");
            if (["sm", "lg", "xl", "xxl"].includes(modalSize)) {
                modalDialog.classList.add("modal-" + modalSize);
            }
            const modal = new bootstrap.Modal(document.getElementById("modalContainer"));
            modal.show();

            loadScript(modalName, function () {
                const initFuncName = 'init' + toPascalCase(modalName) + 'Modal';

                if (typeof window[initFuncName] === "function") {
                    // ✅ Gọi hàm init kèm data
                    window[initFuncName](data);
                }
            });
        });
}
function closeModal() {
    const modalElement = document.getElementById("modalContainer");
    const modal = bootstrap.Modal.getInstance(modalElement);
    if (modal) {
        modal.hide();
    }
}


function loadScript(modalName, callback) {
    const src = window.viteAssets?.[modalName];
    if (!src) {
        console.error("Không tìm thấy file Vite asset cho modal:", modalName);
        return;
    }

    // Nếu đã load rồi thì thôi
    if (document.querySelector(`script[src="${src}"]`)) {
        callback();
        return;
    }

    const script = document.createElement("script");
    script.type = "module";
    script.src = src;
    script.onload = callback;
    script.onerror = () => console.error("Lỗi khi load file:", src);
    document.head.appendChild(script);
}

function toPascalCase(str) {
    return str.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join('');
}

