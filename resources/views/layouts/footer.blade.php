<div class="w-100 d-flex justify-content-end">
    <footer id="dynamic-footer" class="bg-white border-top border-4 py-4 mt-5 shadow-sm">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <!-- Logo & Copyright -->
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <a href="{{ url('/') }}"
                        class="d-inline-flex align-items-center mb-2 text-decoration-none text-dark">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" height="32" class="me-2">
                        <strong id="name_system_footer">Hệ thống quản lý</strong>
                    </a> 
                </div>
                <!-- Liên kết -->
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <div class="medium text-muted mt-1">
                            &copy; {{ date('Y') }} Công ty : <strong id="name_company"></strong>
                        </div>
                        <li class="list-inline-item">
                            <span href="#" class="text-muted text-decoration-none">Hỗ trợ<span
                                    id="phone"></span></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
<script>
    function syncFooterWidth() {
        const navbar = document.getElementById("main_navbar");
        const footer = document.getElementById("dynamic-footer");
        if (navbar && footer) {
            const width = navbar.offsetWidth;
            footer.style.width = width + "px";
        }
    }

    // Gọi lần đầu khi trang tải xong
    window.addEventListener("load", syncFooterWidth);
    window.addEventListener("resize", syncFooterWidth); // khi thay đổi kích thước cửa sổ

    // Nếu main_navbar có thể thay đổi kích thước động (JS resize, collapse, v.v.)
    const navbarEl = document.getElementById("main_navbar");
    if (navbarEl) {
        const resizeObserver = new ResizeObserver(() => {
            syncFooterWidth();
        });
        resizeObserver.observe(navbarEl);
    }
</script>