<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo.png') }}">
    <title>Login Presensi MARECA</title>
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
            <div class="text-center">
                <h1 class="fw-bold">LOGIN</h1>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text bg-white" id="addon-wrapping"><i
                                    class="bi bi-envelope-at-fill" style="color: #304A93;"></i> </span>
                            <input type="text" name="email" class="form-control-lg form-control"
                                placeholder="Email Address" aria-label="Email Address"
                                aria-describedby="addon-wrapping">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text bg-white" id="addon-wrapping"><i class="bi bi-key-fill"
                                    style="color: #304A93;"></i> </span>
                            <input type="password" name="password" class="form-control-lg form-control"
                                placeholder="Password" aria-label="Password" aria-describedby="addon-wrapping">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-end mb-3">
                    <a href="{{ route('send.reminder') }}" class="mx-2" style="text-decoration: none">Reset Password</a>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
            <div class="footer text-center mt-5">
                <p>© 2024 Presensi. <a href="https://marecayasa.com/" style="text-decoration: none">CV Mareca Yasa
                        Media.</a></p>
            </div>
        </div>
    </div>

    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
