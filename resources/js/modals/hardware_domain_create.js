import {
    create_domain_hardware,
    get_domain_by_hardware,
    remove_hardware_in_domain,
} from "../api/domain";
import { showToast } from "../component/toast";
import { get_all_hardware_connect_domain } from "../api/hardware";
// getallhardwareconnectdomain
async function initHardwareDomainCreateModal(data) {
    console.log(data)
    const selectedIPs = new Set(); // user chọn
    const linkedIPs = new Set();   // đã liên kết

    const table = document.querySelector("#hardware-select-table tbody");
    const selectAllCheckbox = document.querySelector("#select-all-hw");
    const linkButton = document.querySelector("#link-selected-hardware");

    const filterDeleted = document.querySelector("#filter-deleted");
    const filterIP = document.querySelector("#filter-ip");
    const filterOS = document.querySelector("#filter-os");
    const filterDB = document.querySelector("#filter-db");

    if (!table) return;

    table.innerHTML = `
        <tr>
            <td colspan="5" class="text-center text-muted">
                <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                Đang tải danh sách phần cứng...
            </td>
        </tr>
    `;

    try {
        const resAll = await get_all_hardware_connect_domain();
        const hardwareList = resAll.data || [];

        table.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-muted">
                    <div class="spinner-border spinner-border-sm text-info me-2"></div>
                    Đang kiểm tra domain đã liên kết trong phần cứng...
                </td>
            </tr>
        `;

        await Promise.all(
            hardwareList.map(hw =>
                get_domain_by_hardware({ ip: hw.ip }).then(res => {
                    const domains = Array.isArray(res) ? res : [];

                    if (domains.some(d => d.id == data.id)) {
                        linkedIPs.add(hw.ip);
                        selectedIPs.add(hw.ip); // Mặc định các IP đã liên kết cũng được chọn
                    }
                }).catch(err => {
                    console.error("Lỗi khi gọi get_domain_by_hardware:", err);
                })
            )
        );

        function renderTable(filteredList) {
            table.innerHTML = filteredList.length
                ? filteredList.map(hw => {
                    const isChecked = selectedIPs.has(hw.ip);
                    const checkedAttr = isChecked ? 'checked' : '';

                    const isDeleted = hw.is_delete;
                    const rowClass = isDeleted ? "bg-light text-muted" : "";
                    const disabled = isDeleted ? "disabled" : "";

                    return `
                        <tr class="hardware-row ${rowClass}" data-ip="${hw.ip}">
                            <td><input type="checkbox" class="hw-checkbox" data-ip="${hw.ip}" ${checkedAttr} ${disabled}></td>
                            <td>${hw.ip}</td>
                            <td>${hw.OS || "?"}</td>
                            <td>${hw.dbname || "?"} - ${hw.dbversion || ""}</td>
                            <td><a href="/hardware_detail?id=${encodeURIComponent(hw.ip)}" target="_blank" class="btn btn-sm btn-link">Xem</a></td>
                        </tr>`;
                }).join("")
                : `<tr><td colspan="5" class="text-center text-muted">Không có phần cứng nào.</td></tr>`;

            // Cập nhật sự kiện click cho row và checkbox
            table.querySelectorAll(".hardware-row").forEach(row => {
                const cb = row.querySelector(".hw-checkbox");
                const ip = row.dataset.ip;

                // Row click để toggle checkbox
                row.addEventListener("click", e => {
                    if (e.target.tagName === "INPUT" || e.target.tagName === "A") return;
                    if (cb && !cb.disabled) {
                        cb.checked = !cb.checked;
                        if (cb.checked) selectedIPs.add(ip);
                        else selectedIPs.delete(ip);
                    }
                });

                // Khi người dùng click trực tiếp vào checkbox
                cb?.addEventListener("change", () => {
                    if (cb.checked) selectedIPs.add(ip);
                    else selectedIPs.delete(ip);
                });
            });
        }

        function applyFilter() {
            const ipVal = filterIP.value.toLowerCase();
            const osVal = filterOS.value.toLowerCase();
            const dbVal = filterDB.value.toLowerCase();
            const deletedVal = filterDeleted.value;

            const filtered = hardwareList.filter(hw =>
                (!ipVal || hw.ip.toLowerCase().includes(ipVal)) &&
                (!osVal || (hw.OS || "").toLowerCase().includes(osVal)) &&
                (!dbVal || `${hw.dbname || ""} ${hw.dbversion || ""}`.toLowerCase().includes(dbVal)) &&
                (
                    deletedVal === "all" ||
                    (deletedVal === "true" && hw.is_delete === true) ||
                    (deletedVal === "false" && hw.is_delete === false)
                )
            );

            renderTable(filtered);
        }

        // Gán sự kiện lọc
        [filterIP, filterOS, filterDB, filterDeleted].forEach(input => {
            input.addEventListener("input", applyFilter);
            input.addEventListener("change", applyFilter);
        });

        // Chọn tất cả
        selectAllCheckbox.onclick = () => {
            document.querySelectorAll(".hw-checkbox:not(:disabled)").forEach(cb => {
                const ip = cb.dataset.ip;
                cb.checked = selectAllCheckbox.checked;
                if (cb.checked) selectedIPs.add(ip);
                else selectedIPs.delete(ip);
            });
        };

        // Render ban đầu
        applyFilter();

        // Xử lý khi click liên kết
        linkButton.onclick = async () => {
            if (!hardwareList.length) {
                return showToast({ message: "Không có phần cứng nào để xử lý.", type: "warning" });
            }

            let successCreate = 0, failCreate = 0;
            let successRemove = 0, failRemove = 0;

            for (const hw of hardwareList) {
                const ip = hw.ip;
                const shouldBeLinked = selectedIPs.has(ip);
                const isLinked = linkedIPs.has(ip);

                if (shouldBeLinked && !isLinked) {
                    try {
                        await create_domain_hardware({ hardware_ip: ip, domain_id: data.id });
                        successCreate++;
                    } catch (err) {
                        console.error(`Lỗi tạo domain cho ${ip}`, err);
                        failCreate++;
                    }
                }

                if (!shouldBeLinked && isLinked) {
                    try {
                        await remove_hardware_in_domain(ip, data.id);
                        successRemove++;
                    } catch (err) {
                        console.error(`Lỗi gỡ domain khỏi ${ip}`, err);
                        failRemove++;
                    }
                }
            }

            showToast({
                message:"cập nhật thành công",
                // message: `bạn vừa liên kết: ${successCreate}, Gỡ bỏ: ${successRemove}`,
                type: (failCreate || failRemove) ? "warning" : "success",
                timeout: 6000,
            });

            window.dispatchEvent(new CustomEvent("domainUpdated"));
        };
    } catch (err) {
        table.innerHTML = `<tr><td colspan="5" class="text-danger text-center">Lỗi khi tải danh sách phần cứng.</td></tr>`;
        console.error(err);
    }
}

window.initHardwareDomainCreateModal = initHardwareDomainCreateModal;
