<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo.png') }}">
    <title>{{ $title ?? config('app.name') }} Presensi MARECA</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-icons/font/bootstrap-icons.css') }}">
    <style>
        body {
            overflow-x: hidden;
        }

        .container-wrapper {
            max-width: 400px;
            margin: 0 auto;
            padding: 0 15px;
        }
        .container-wrapper {
            max-width: 400px;
            margin: 0 auto;
            padding: 0 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

    </style>
</head>

<body>
    <div class="container-wrapper mt-3">
        <div class="card border-0">
            <div class="text-center mb-3">
                <img src="{{ asset('image/char1.png') }}" alt="" width="100%" srcset="" class="imaged"/>
            </div>
        </div>
        <div class="card border-0">
            @yield('content')
            @include('layout.login.footer-login')
        </div>
    </div>

    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
