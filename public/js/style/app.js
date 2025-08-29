function updateMainContentMargin() {
  const navbar = document.getElementById("main_navbar");
  const mainContent = document.getElementById("layout-main-content");
  if (navbar && mainContent) {
    mainContent.style.marginTop = `${navbar.offsetHeight}px`;
  }
}
window.addEventListener("DOMContentLoaded", updateMainContentMargin);
window.addEventListener("resize", updateMainContentMargin);


document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("input[required], select[required], textarea[required]").forEach(input => {
    const wrapper = input.closest(".form-group, .form-label, div");
    if (!wrapper) return;

    const label = wrapper.querySelector("label");
    if (label && !label.classList.contains("required")) {
      label.classList.add("required");
    }
  });
});

