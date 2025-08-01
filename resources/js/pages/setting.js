import { update_system_project, get_system_project, update_logo, get_logo } from "../api/setting";

window.submitSystemSetting = async function () {
    const name_company = document.getElementById("inputCompanyName").value.trim();
    const name_system = document.getElementById("inputSystemName").value.trim();
    const phone = document.getElementById("inputPhone").value.trim(); 
    const data = `"name_company": "${name_company}", "name_system": "${name_system}", "phone": "${phone}"`;  
    try {
        await update_system_project(data);
        
        alert("Cập nhật thành công!");
    } catch (e) {
        alert("Cập nhật thất bại: " + e.message);
    }
};  
window.submitLogoUpload = async function () {
    const fileInput = document.getElementById("inputLogo");
    const file = fileInput.files[0];
    if (!file) {
        alert("Vui lòng chọn một file hình ảnh.");
        return;
    } 
    try {
        await update_logo(file);
        alert("Tải logo thành công!");
        // Cập nhật lại preview
        document.getElementById("previewLogo").src = URL.createObjectURL(file);
        document.getElementById("previewLogo").style.display = "block";
    } catch (e) {
        alert("Tải logo thất bại: " + e.message);
    }
};
document.addEventListener("DOMContentLoaded", () => {
    const saveBtn = document.getElementById("saveLogoBtn");
    const inputLogo = document.getElementById("inputLogo");
    const preview = document.getElementById("previewLogo");

    if (saveBtn && inputLogo) {
        saveBtn.addEventListener("click", async () => {
            const file = inputLogo.files[0];
            if (!file) return alert("Vui lòng chọn một tệp hình ảnh");

            try {
                const result = await update_logo(file);
                alert("Cập nhật logo thành công!");

                // Cập nhật ảnh preview
                if (preview) {
                    // Thêm timestamp để tránh cache
                    preview.src = result.logo_url + "?t=" + new Date().getTime();
                    preview.style.display = "block";
                }
            } catch (e) {
                alert("Lỗi cập nhật logo: " + e.message);
            }
        });
    }
});
document.addEventListener("DOMContentLoaded", async function () {
    const btn = document.getElementById("update_system_info");
    if (btn) {
        btn.addEventListener("click", () => window.submitSystemSetting());
    }

    const logoBtn = document.getElementById("update_logo_btn");
    if (logoBtn) {
        logoBtn.addEventListener("click", () => window.submitLogoUpload());
    }

    // Load dữ liệu hệ thống hiện tại vào input
    try {
        const system = await get_system_project();
        console.log("Dữ liệu hệ thống:", system);

        // Parse footer JSON
        let footerData = system.footer;
        if (footerData) {
            if (!footerData.trim().startsWith("{")) {
                footerData = "{" + footerData + "}";
            }

            const parsedData = JSON.parse(footerData);

            document.getElementById("inputCompanyName").value = parsedData.name_company || "";
            document.getElementById("inputSystemName").value = parsedData.name_system || "";
            document.getElementById("inputPhone").value = parsedData.phone || "";
        }

        // Hiển thị logo hiện tại nếu có
        if (system.logo_url) {
            const logoImg = document.getElementById("previewLogo");
            logoImg.src = system.logo_url;
            logoImg.style.display = "block";
        }

    } catch (error) {
        console.error("Lỗi khi tải dữ liệu hệ thống:", error);
    }
});
