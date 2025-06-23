<head>
    <meta charset="utf-8">
    <title>404 Error Page</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/materialdesignicons.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="account-pages" style="background: url('{{ asset('images/error_img.png') }}') center/cover no-repeat; min-height: 100vh;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="display-2 font-weight-medium text-danger">
                        4<i class="bx bx-buoy bx-spin text-danger display-3"></i>4
                    </h1>
                    <h3 class="text-uppercase text-primary">ONO không có trang này</h3>
                    <div class="mt-5">
                        <a class="btn btn-primary" href="/">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
