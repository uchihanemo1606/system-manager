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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="assets\css\bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <link href="assets\css\app.min.css" id="app-style" rel="stylesheet" type="text/css">
    <link href="assets\css\icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets\css\boxicons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/materialdesignicons.min.css" rel="stylesheet"> 
    <!-- role detail -->
    <link href="assets\libs\summernote\summernote-bs4.min.css" rel="stylesheet" type="text/css">


    @if($cssPath && file_exists(public_path($cssPath)))
    <link href="{{ asset($cssPath) }}" rel="stylesheet" />
    @endif
</head>

<body>
    <!-- content -->
    @include('layouts.navbar')
    <main class="main-content" id="layout-main-content">
        @include('layouts.main_modal')
        @yield('content')
    </main>
</body>
<!-- script modal -->
<script>
    // console.log("menu:", @json($permissionsRoute));
    // console.log("code:", @json($userPermissionCodes));
    // console.log("so:", @json($permissions));
    window.permissionsRoute = @json($permissionsRoute);
    window.userPermissionCodes = @json($userPermissionCodes);
    // end test 
    window.viteAssets = {
        @foreach($modalAssets as $name => $path)
        '{{ $name }}': '{{ Vite::asset($path) }}',
        @endforeach
    };
</script>
<!-- scripts java file -->
@if($scriptPath && file_exists(public_path($scriptPath)))
<script src="{{ asset($scriptPath) }}"></script>
@endif
<script src="/js/app.js"></script>
<script src="js\style\app.js"></script>
@yield('scripts')

<script src="assets\libs\jquery\jquery.min.js"></script>
<script src="assets\libs\bootstrap\js\bootstrap.bundle.min.js"></script>
<script src="assets\libs\metismenu\metisMenu.min.js"></script>

<!-- role_detail -->
<script src="assets\libs\summernote\summernote-bs4.min.js"></script>
<script src="assets\libs\summernote\email-summernote.init.js"></script>

</html>