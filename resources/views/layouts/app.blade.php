<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    use App\Helpers\ViteModalHelper;

    $modalAssets = App\Helpers\ViteModalHelper::getModalAssets();
    $routeName = Route::currentRouteName();
    $cssPath = isset($page) ? 'css/' . $page . '.css' : null;
    $scriptPath = isset($page) ? 'js/' . $page . '.js' : null;
@endphp

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/boxicons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- role detail -->
    <link href="assets/libs/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @if ($cssPath && file_exists(public_path($cssPath)))
        <link href="{{ asset($cssPath) }}" rel="stylesheet" />
    @endif
    @yield('css')
</head>

<body>
    <!-- Toast Layer that allows interaction through it -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999; pointer-events: none">
        <div id="liveToast" class="toast" style="pointer-events: none">
            <!-- nội dung toast -->
        </div>
    </div>

    <div id="globalLoading" class="d-none">
        <div style=" 
        position: fixed;
        z-index: 1050;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    ">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    @include('layouts.navbar')
    <main class="main-content" style="min-height: 90dvh;" id="layout-main-content">
        @include('layouts.main_modal')
        @yield('content')
    </main>
    @include('layouts.footer')
</body>

<!-- script modal -->
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    window.permissionsRoute = @json($permissionsRoute);
    window.userPermissionCodes = @json($userPermissionCodes);
    window.viteAssets = {
        @foreach ($modalAssets as $name => $path)
            '{{ $name }}': '{{ Vite::asset($path) }}',
        @endforeach
    };
</script>

@if ($scriptPath && file_exists(public_path($scriptPath)))
    <script src="{{ asset($scriptPath) }}"></script>
@endif

@yield('scripts')
<script src="/js/app.js"></script>
<script src="js/style/app.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/summernote/summernote-bs4.min.js"></script>
<script src="assets/libs/summernote/email-summernote.init.js"></script>
@vite('resources/js/component/toast.js')
</html>
