// import { get_all_software_file_by_id } from "../../api/software";
// import { getCookie } from "../storage/Cookie";
// document.addEventListener("DOMContentLoaded", function () {
//     // Lấy id từ URL
//     const urlParams = new URLSearchParams(window.location.search);
//     const softwareId = urlParams.get("id");
//     const token = getCookie("auth_token");
//     if (!softwareId) return;

//     // Render nút Thêm tập tin
//     const li = document.createElement("li");
//     li.className = "list-inline-item px-2";
//     li.innerHTML = `
//         <a href="#" title="Tạo tập tin mới"
//             onclick="loadModal('software_file_create', { id: '${softwareId}', type: 'software_file' })">
//             <i class="bx bx-plus"></i> Thêm tập tin
//         </a>
//     `;
//     const target = document.getElementById("create_software_file");
//     if (target) target.appendChild(li);

//     // Hàm fetch & render lại danh sách file
//     async function fetchAndRenderFiles() {
//         try {
//             const res = await get_all_software_file_by_id(softwareId);
//             const list = res.data || [];

//             const tbody = document.getElementById("software-file-list");
//             if (!tbody) return;

//             if (list.length === 0) {
//                 tbody.innerHTML = `<tr><td colspan="3" class="text-muted text-center">Chưa có tập tin nào.</td></tr>`;
//                 return;
//             }

//             tbody.innerHTML = list.map(file => `
//                 <tr>
//                     <td style="width: 45px;">
//                         <div class="avatar-sm">
//                             <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-24">
//                                 <i class="bx bxs-file-doc"></i>
//                             </span>
//                         </div>
//                     </td>
//                     <td>
//                         <h5 class="font-size-14 mb-1">
//                             <a href="api/${file.file_path}/${file.software_id}?token=${token}" class="text-dark" target="_blank">${file.file_name}</a>
//                         </h5>
//                         <small>Người tạo: ${file.username} | Mô tả: ${file.description || "Không có"}</small>
//                     </td>
//                     <td>
//                         <div class="text-center">
//                             <a href="#" class="edit-file-link" data-file='${JSON.stringify(file)}'>sửa</a>
//                         </div>
//                     </td>
//                 </tr>
//             `).join("");
//         } catch (err) {
//             console.error("Lỗi khi lấy danh sách file phần mềm:", err);
//         }
//     }

//     // Gọi lần đầu
//     fetchAndRenderFiles();

//     // Nghe sự kiện cập nhật / tạo mới để refetch lại
//     window.addEventListener("softwareFileUpdated", fetchAndRenderFiles);
//     window.addEventListener("softwareFileCreated", fetchAndRenderFiles);

//     // Xử lý nút sửa (dùng delegation)
//     document.addEventListener("click", function (e) {
//         if (e.target.matches(".edit-file-link")) {
//             e.preventDefault();
//             const fileData = JSON.parse(e.target.dataset.file);
//             loadModal("software_file_edit", { filedata: fileData });
//         }
//     });
// });
import { get_all_software_file_by_id } from "../../api/software";
import { getCookie } from "../storage/Cookie";
import { get_my_software_permission_by_software } from "../../api/software";

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const softwareId = urlParams.get("id");
    const token = getCookie("auth_token");

    if (!softwareId) return;

    let editer = false;

    // Bọc toàn bộ trong async IIFE để dùng await được
    (async function () {
        try {
            const permissions = await get_my_software_permission_by_software(softwareId);
            console.log("User permissions for this software:", permissions);

            // Rút gọn danh sách quyền thành mảng string
            const permissionNames = permissions.data.map(p => p.permissions_name);
            const editer = permissionNames.includes("sửa phần mềm");  
            // Nếu có quyền, hiển thị nút Thêm tập tin
            if (editer) {
                const li = document.createElement("li");
                li.className = "list-inline-item px-2";
                li.innerHTML = `
                    <a href="#" title="Tạo tập tin mới"
                        onclick="loadModal('software_file_create', { id: '${softwareId}', type: 'software_file' })">
                        <i class="bx bx-plus"></i> Thêm tập tin
                    </a>
                `;
                const target = document.getElementById("create_software_file");
                if (target) target.appendChild(li);
            }

            // Sau khi biết quyền => mới fetch danh sách
            await fetchAndRenderFiles(editer);
        } catch (err) {
            console.error("Lỗi khi kiểm tra quyền hoặc tải file:", err);
        }

        // Nghe sự kiện cập nhật để refetch lại
        window.addEventListener("softwareFileUpdated", () => fetchAndRenderFiles(editer));
        window.addEventListener("softwareFileCreated", () => fetchAndRenderFiles(editer));
    })();

    // Hàm fetch & render
    async function fetchAndRenderFiles(editer) {
        try {
            const res = await get_all_software_file_by_id(softwareId);
            const list = res.data || [];

            const tbody = document.getElementById("software-file-list");
            if (!tbody) return;

            if (list.length === 0) {
                tbody.innerHTML = `<tr><td colspan="3" class="text-muted text-center">Chưa có tập tin nào.</td></tr>`;
                return;
            }

            tbody.innerHTML = list.map(file => `
                <tr>
                    <td style="width: 45px;">
                        <div class="avatar-sm">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-24">
                                <i class="bx bxs-file-doc"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <h5 class="font-size-14 mb-1">
                            <a href="api/${file.file_path}/${file.software_id}?token=${token}" class="text-dark" target="_blank">${file.file_name}</a>
                        </h5>
                        <small>Người tạo: ${file.username} | Mô tả: ${file.description || "Không có"}</small>
                    </td>
                    ${editer ? `
                    <td>
                        <div class="text-center">
                            <a href="#" class="edit-file-link" data-file='${JSON.stringify(file)}'>sửa</a>
                        </div>
                    </td>` : ""}
                </tr>
            `).join("");
        } catch (err) {
            console.error("Lỗi khi lấy danh sách file phần mềm:", err);
        }
    }

    // Xử lý click sửa file (delegation)
    document.addEventListener("click", function (e) {
        if (e.target.matches(".edit-file-link")) {
            e.preventDefault();
            const fileData = JSON.parse(e.target.dataset.file);
            loadModal("software_file_edit", { filedata: fileData });
        }
    });
});
