const token = localStorage.getItem("jwt_token");
if (token) {
    const originalFetch = window.fetch;
    window.fetch = function (url, options = {}) {
        options.headers = options.headers || {};
        options.headers["Authorization"] = "Bearer " + token;
        return originalFetch(url, options);
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

