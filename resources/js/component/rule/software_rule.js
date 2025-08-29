import {
    create_rule,
    get_all_category_rule,
    create_software_rule,
    get_all_software_rule,
    delete_software_rule_by_id,
    update_software_rule_by_id
} from "../../api/rule";
import { get_my_software_permission_by_software } from "../../api/software";
import { showToast } from "../../component/toast";

document.addEventListener("DOMContentLoaded", async function () {

    const form = document.getElementById("create-rule-form");
    const tableBody = document.getElementById("software-rule-table-body");

    const urlParams = new URLSearchParams(window.location.search);
    const softwareId = urlParams.get("id");

    if (!softwareId) {
        tableBody.innerHTML = `<tr><td colspan="5" class="text-danger text-center">Không tìm thấy ID phần mềm trên URL</td></tr>`;
        return;
    }
    let canEditRule = false; // mặc định: không có quyền

    const permissionsRes = await get_my_software_permission_by_software(softwareId);
    const permissionNames = permissionsRes.data.map(p => p.permissions_name);
    canEditRule = permissionNames.includes("sửa phần mềm") || permissionNames.includes("quản lý quy chế");
    if (!canEditRule) {
        const createBtn = document.getElementById("create-rule-button");
        if (createBtn) createBtn.style.display = "none";
    }

    async function loadSoftwareRules() {
        try {
            const { data = [] } = await get_all_software_rule(softwareId);
            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="text-center">Chưa có quy chế nào</td></tr>`;
                return;
            }
            tableBody.innerHTML = "";
            data.forEach((item, index) => {
                const ruleName = item.rule_name.length > 50
                    ? item.rule_name.slice(0, 50) + "..."
                    : item.rule_name;

                const modalId = `ruleModal${index}`;

                const row = document.createElement("tr");
                row.innerHTML = `
                                <td>
                                    <span title="${item.rule_name}">${ruleName}</span>
                                </td> 
                                <td>${item.category_rule_name || "<span class='text-muted'>Không có</span>"}</td>
                                <td class="text-right">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#${modalId}" title="Xem chi tiết">
                                            <i class="mdi mdi-eye-outline"></i>
                                        </button>
                                        ${item.file_url
                        ? `<a href="${item.file_url}" class="btn btn-outline-primary btn-sm" target="_blank" title="Tải tệp">
                                                    <i class="mdi mdi-download"></i>
                                                </a>`
                        : `<button class="btn btn-outline-secondary btn-sm" disabled title="Không có tệp">
                                                    <i class="mdi mdi-file-remove-outline"></i>
                                                </button>`
                    }
                                        ${canEditRule
                                        ? `<button class="btn btn-outline-warning btn-sm btn-edit-rule" 
                                                data-id="${item.rule_id}" 
                                                data-name="${item.rule_name}"
                                                data-description="${item.rule_description || ''}"
                                                data-category="${item.category_rule_id}"
                                                data-file="${item.file_url || ''}"
                                                title="Sửa">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </button>

                                            <button class="btn btn-outline-danger btn-sm btn-delete-rule" 
                                                data-id="${item.software_rule_id}" 
                                                title="Xóa">
                                                <i class="mdi mdi-delete-outline"></i>
                                            </button>`
                                        : ""
                                        }

                                    </div>
                                </td>
                            `;

                const modal = document.createElement("div");
                modal.innerHTML = `
                                    <div class="modal fade" id="${modalId}" tabindex="-1" role="dialog" aria-labelledby="ruleModalLabel${index}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                            <div class="modal-content shadow">
                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title fw-bold" id="ruleModalLabel${index}">
                                                        <i class="mdi mdi-file-document-outline text-primary me-1"></i> ${item.rule_name}
                                                    </h5> 
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Mô tả:</strong><br>${item.rule_description || "<span class='text-muted'>Không có</span>"}</p>
                                                    <hr>
                                                    <p><strong>Loại quy chế:</strong> ${item.category_rule_name || "<span class='text-muted'>Không có</span>"}</p>
                                                    <p><strong>Tệp:</strong> ${item.file_url
                        ? `<a href="${item.file_url}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="mdi mdi-download"></i> Tải tệp
                                                            </a>`
                        : "<span class='text-muted'>Không có</span>"
                    }</p>
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;

                document.body.appendChild(modal);

                tableBody.appendChild(row);
            });
        } catch (error) {
            tableBody.innerHTML = `<tr><td colspan="5" class="text-primary text-center">Không có quy chế nào</td></tr>`;
            console.error(error);
        }
    }

    document.addEventListener("click", async function (e) {
        const btn = e.target.closest(".btn-delete-rule");
        if (btn) {
            const softwareRuleId = btn.dataset.id;
            if (!confirm("Bạn có chắc muốn xóa quy chế này khỏi phần mềm?")) return;

            try {
                await delete_software_rule_by_id(softwareRuleId);
                showToast("Đã xóa quy chế khỏi phần mềm", "success");
                await loadSoftwareRules(); // reload bảng
            } catch (e) {
                console.error("Lỗi khi xóa:", e);
                showToast("Xóa thất bại", "error");
            }
        }
    });

    document.addEventListener("click", async function (e) {
        if (e.target.closest(".btn-edit-rule")) {
            const btn = e.target.closest(".btn-edit-rule");
            document.getElementById("edit-rule-id").value = btn.dataset.id;
            document.getElementById("edit-rule-name").value = btn.dataset.name;
            document.getElementById("edit-rule-description").value = btn.dataset.description;
            const categoryId = btn.dataset.category;
            const editSelect = document.getElementById("edit-rule-category");

            // Nếu đã có option, thì chỉ set .value
            if (editSelect.options.length > 0) {
                editSelect.value = categoryId;
            } else {
                // Nếu chưa load (hoặc bạn muốn load lại mỗi lần), bạn có thể fetch:
                const { data = [] } = await get_all_category_rule();
                editSelect.innerHTML = ""; // clear cũ
                data.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = item.name;
                    if (item.id === parseInt(categoryId)) option.selected = true;
                    editSelect.appendChild(option);
                });
            }


            $('#editRuleModal').modal('show');
        }
    });
    document.getElementById("edit-rule-form").addEventListener("submit", async function (e) {
        e.preventDefault();

        const id = document.getElementById("edit-rule-id").value;
        const name = document.getElementById("edit-rule-name").value.trim();
        const description = document.getElementById("edit-rule-description").value.trim();
        const category_rule_id = document.getElementById("edit-rule-category").value;
        const fileInput = document.getElementById("edit-rule-file");
        const file = fileInput.files.length > 0 ? fileInput.files[0] : null;
        if (!id || !name || !category_rule_id) {
            showToast("Vui lòng nhập đầy đủ thông tin", "error");
            return;
        }

        const payload = {
            id: parseInt(id), // <-- Đảm bảo là số
            name,
            description,
            category_rule_id: parseInt(category_rule_id), // <-- Đảm bảo là số
            file
        };

        try {
            await update_software_rule_by_id(payload);
            showToast("Cập nhật quy chế thành công", "success");
            $('#editRuleModal').modal('hide');
            await loadSoftwareRules();
        } catch (err) {
            console.error("Lỗi cập nhật:", err);
            showToast("Cập nhật thất bại", "error");
        }
    });

    // Load loại quy chế và danh sách ban đầu
    if (!form.dataset.initialized) {
        form.dataset.initialized = "true";

        try {
            const { data = [] } = await get_all_category_rule();

            const createSelect = document.getElementById("rule-category");
            const editSelect = document.getElementById("edit-rule-category");
            editSelect.innerHTML = ""; // clear c 
            data.forEach((item, index) => {
                const option1 = document.createElement("option");
                option1.value = item.id;
                option1.textContent = item.name;
                if (index === 0) option1.selected = true;
                createSelect.appendChild(option1);

                const option2 = document.createElement("option");
                option2.value = item.id;
                option2.textContent = item.name;
                if (index === 0) option2.selected = true;
                editSelect.appendChild(option2);
            });
        } catch (e) {
            console.error("Không tải được loại quy chế:", e);
        }


        await loadSoftwareRules();

        form.addEventListener("submit", async function (e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append("name", form.querySelector("#rule-name").value.trim());
            formData.append("description", form.querySelector("#rule-description").value.trim());
            formData.append("category_rule_id", form.querySelector("#rule-category").value);

            const fileInput = form.querySelector("#rule-file");
            if (fileInput.files.length > 0) {
                formData.append("file", fileInput.files[0]);
            }

            try {
                const { id: ruleId } = await create_rule(formData);

                await create_software_rule({
                    software_id: parseInt(softwareId),
                    rule_id: parseInt(ruleId)
                });

                showToast("Tạo và gán quy chế thành công", "success");
                $('#createRuleModal').modal('hide');
                form.reset();
                await loadSoftwareRules(); // Reload
            } catch (err) {
                console.error(err);
                showToast("Lỗi khi tạo hoặc gán quy chế", "error");
            }
        });
    } else {
        await loadSoftwareRules();
    }
});
