
document.addEventListener("DOMContentLoaded", function () {
    // Lấy id từ URL
    const urlParams = new URLSearchParams(window.location.search);
    const softwareId = urlParams.get("id");

    if (!softwareId) return;

    // Tạo phần tử li mới
    const li = document.createElement("li");
    li.className = "list-inline-item px-2";

    li.innerHTML = `
      <a href="#" title="Tạo tập tin mới"
         onclick="loadModal('software_file_create', { id: '${softwareId}', type: 'software_file' })">
         <i class="bx bx-plus"></i> Thêm tập tin
      </a>
    `;

    // Gắn vào phần tử có id create_software_file
    const target = document.getElementById("create_software_file");
    if (target) {
        target.appendChild(li);
    }
}); 