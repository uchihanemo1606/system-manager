<head>
  <link flex href="css/layouts/nav.css" rel="stylesheet" />
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
  <nav class="sidebar locked">
    <div class="logo_items flex">
      <a
        style="scale: 2"
        href="/login" class="nav_image">
        <img src="images/logo.png" alt="logo_img" />
      </a>
      <span class="logo_name">System Manager</span>

      <i class="bx bx-lock-alt" id="lock-icon" title="Unlock Sidebar"></i>
      <i class="bx bx-x" id="sidebar-close"></i>
    </div>
    <div class="menu_container">
      <div class="menu_items">
        <ul class="menu_item">
          <div class="sidebar_profile flex">
            <span class="nav_image">
              <img src="images/profile.jpg" alt="logo_img" />
            </span>
            <div class="data_text">
              <span class="name">{{ $user->username }}</span>
            </div>
          </div>
          <div class="menu_title flex">
            <span class="title">Dashboard</span>
            <span class="line"></span>
          </div>
          <li class="item">
            <a href="#" class="link flex">
              <i class="bx bx-home-alt"></i>
              <span>Overview</span>
            </a>
          </li>
          <li class="item">
            <a data-key="users" class="link flex">
              <i class="bx bx-grid-alt"></i>
              <span>Users</span>
            </a>
          </li>
          <li class="item">
            <a data-key="roles" class="link flex">
              <i class="bx bx-grid-alt"></i>
              <span>Roles</span>
            </a>
          </li>
        </ul>
        <ul class="menu_item">
          <div class="menu_title flex">
            <span class="title">Manager</span>
            <span class="line"></span>
          </div>

          <li class="item">
            <a data-key="hardware" class="link flex">
              <i class="bx"><svg
                  style="width: 22px;height: 22px;"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                </svg></i>
              <span>hardware</span>
            </a>
          </li>
          <li class="item">
            <a data-key="software" class="link flex">
              <i class="bx bx-cloud-upload"></i>
              <span>SoftWare</span>
            </a>
          </li>
          <li class="item">
            <a data-key="software_file" class="link flex">
              <i class="bx bx-folder"></i>
              <span> SoftWare File</span>
            </a>
          </li>
          <li class="item">
            <a data-key="rule" class="link flex">
              <i class="bx bxs-magic-wand"></i>
              <span>rule</span>
            </a>
          </li>
        </ul>
        <ul class="menu_item">
          <div class="menu_title flex">
            <span class="title">Setting</span>
            <span class="line"></span>
          </div>
          <li class="item">
            <a href="hardware_detail" class="link flex">
              <i class="bx bx-flag"></i>
              <span>Notice Board</span>
            </a>
          </li>
          <li class="item">
            <a href="#" class="link flex">
              <i class="bx bx-award"></i>
              <span>Award</span>
            </a>
          </li>
          <li class="item">
            <a href="#" class="link flex">
              <i class="bx bx-cog"></i>
              <span>Setting</span>
            </a>
          </li>
        </ul>
      </div>

    </div>
  </nav>
  <nav class="navbar flex flex-row" id="main_navbar">
    <i class="bx bx-menu" id="sidebar-open"></i>
    <form class="app-search d-none d-lg-block  " style="padding: 0;">
      <div class="position-relative">
        <input type="text" class="form-control" placeholder="Search...">
        <span class="bx bx-search-alt"></span>
      </div>
    </form>
    <div class="dropdown">
      <div type="button" class="" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="rounded-circle header-profile-user" src="images/profile.jpg" alt="Header Avatar">
        <span class="d-none d-xl-inline-block ml-1">{{$user->username }}</span>
        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
      </div>
      <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="#" onclick="loadModal('profile')"><i class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>
        <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right">11</span><i class="bx bx-wrench font-size-16 align-middle mr-1"></i> Settings</a>
        <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle mr-1"></i> Lock screen</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" id="logout"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Logout</a>
      </div>
    </div>
  </nav>
</body>
<script src="{{ asset('js/style/bar.js') }}"></script>
<script src="{{ asset('js/bar.js') }}"></script>