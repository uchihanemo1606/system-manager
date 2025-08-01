<head>
    <link flex href="css/layouts/nav.css" rel="stylesheet" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <nav class="sidebar locked">
        <div class="logo_items flex w-full position-relative">
            <a style="scale: 2" href="/login" class="nav_image">
                <img src="images/logo.png" alt="logo_img" />
            </a>
            <span class="logo_name" id="name_system">...</span>
              <i ></i>
            <i class="bx bx-lock-alt" style="position: absolute;right: 0;" id="lock-icon" title="Unlock Sidebar"></i>
            <i class="bx bx-x" id="sidebar-close"></i>
        </div>
        <div class="menu_container text-nowrap">
            <div class="menu_items">
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">BẢNG ĐIỀU KHIỂN</span>
                        <span class="line"></span>
                    </div>
                    <li class="item">
                        <a data-key="overview" class="link flex">
                            <i class="mdi 	mdi-counter"></i>
                            <span>Thống Kê</span>
                        </a>
                    </li>
                    @hasPermission('user.list')
                    <li class="item">
                        <a data-key="users" class="link flex">
                            <i class="bx bx-group"></i>
                            <span>Danh Sách Người Dùng</span>
                        </a>
                    </li>
                    @endhasPermission
                    @hasPermission('role.list')
                    <li class="item">
                        <a data-key="roles" class="link flex">
                            <i class="mdi mdi-account-key"></i>
                            <span>Quản Lý Vai Trò</span>
                        </a>
                    </li>
                    @endhasPermission
                </ul>
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Quản lý</span>
                        <span class="line"></span>
                    </div>
                    @hasPermission('hardware.list')
                    <li class="item">
                        <a data-key="hardware" class="link flex">
                            <i class="mdi mdi-chip"></i>
                            <span>Danh Sách Phần Cứng</span>
                        </a>
                    </li>
                    @endhasPermission

                    @hasPermission('software.list')
                    <li class="item">
                        <a data-key="software" class="link flex">
                            <i class="mdi mdi-application"></i>
                            <span>Danh Sách Phần Mềm</span>
                        </a>
                    </li>
                    @endhasPermission
                </ul>
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Khác</span>
                        <span class="line"></span>
                    </div>
                    @hasPermission('legal.list')
                    <li class="item">
                        <a data-key="rule" class="link flex">
                            <i class="mdi mdi-gavel"></i>
                            <span>Loại pháp lý</span>
                        </a>
                    </li>
                    @endhasPermission
                    @hasPermission('system.get')
                    <li class="item">
                        <a data-key="log" class="link flex">
                            <i class="mdi mdi-history"></i>
                            <span>Bản ghi hệ thống</span>
                        </a>
                    </li>
                    @endhasPermission
                    @hasPermission('system.get')
                    <li class="item">
                        <a data-key="setting" class="link flex">
                            <i class="bx bx-cog"></i>
                            <span>Cài Đặt</span>
                        </a>
                    </li>
                    @endhasPermission
                </ul>
            </div>

        </div>
    </nav>
    <nav class="navbar flex flex-row " id="main_navbar">
        <i class="bx bx-menu" id="sidebar-open"></i>
        <form class="app-search d-none d-lg-block  " style="padding: 0;">
            <div class="position-relative">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="bx bx-search-alt"></span>
            </div>
        </form>
        <div class="dropdown">
            <div type="button" class="" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="images/profile.jpg" alt="Header Avatar">
                <span class="d-none d-xl-inline-block ml-1">{{ $user->username }}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </div>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#" onclick="loadModal('profile')"><i
                        class="mdi mdi-account font-size-16 align-middle mr-1"></i> Hồ Sơ</a>
                <a class="dropdown-item" href="#" onclick="loadModal('chane_password')"><i
                        class="mdi mdi-lock text-info font-size-16 align-middle mr-1"></i>Đổi mật khẩu</a>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item text-danger coru" id="logout"><i
                        class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i>Đăng Xuất</button>
            </div>
        </div>
    </nav>

</body>
<script src="{{ asset('js/style/bar.js') }}"></script>
<script src="{{ asset('js/bar.js') }}"></script>