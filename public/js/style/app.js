 function updateMainContentMargin() {
  const navbar = document.getElementById("main_navbar");
  const mainContent = document.getElementById("layout-main-content");
  if (navbar && mainContent) {
    mainContent.style.marginTop = `${navbar.offsetHeight}px`;
  }
} 
window.addEventListener("DOMContentLoaded", updateMainContentMargin);
window.addEventListener("resize", updateMainContentMargin);


