<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="description" content="Presensi Karyawan">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('/karyawan/assets/css/style.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" /> --}}
</head>

<body style="background-color:#e9ecef;">

    {{-- Isi Content --}}
    @yield('section-content')
    {{-- Isi Content --}}


    <!-- Bottom Menu -->
    @include('karyawan.layout.v-bottom-menu')
    <!-- * Bottom Menu -->

    @include('karyawan.layout.v-script')
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
</body>

</html>
