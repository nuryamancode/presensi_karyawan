<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('hr-direktur/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('hr-direktur/vendors/base/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('hr-direktur/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('image/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <style>
        .dt-length label {
            margin-left: 10px;
        }

        .dt-search label {
            margin-right: 10px;
        }

        .status-perijinan-disetujui {
            background-color: #0aff2f;
            border-radius: 10px;
            color: #fff;
            padding: 10px;
        }

        .status-perijinan-ditolak {
            background-color: #f30000;
            border-radius: 10px;
            color: #fff;
            padding: 10px;
        }
    </style>
</head>

<body>
    <!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
        @include('layout.v-topbar-first')
        @php
            $currentUrl = request()->url();
        @endphp

        @if (!Str::contains($currentUrl, ['hr/notifikasi', 'hr/profil', 'direktur/profil']))
            @include('layout.v-topbar-second')
        @endif



    </div>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            @yield('content')

            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            @include('layout.v-footer')
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <script src="{{ asset('hr-direktur/vendors/base/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('hr-direktur/js/template.js') }}"></script>
    <script src="{{ asset('hr-direktur/js/dashboard.js') }}"></script>
    <script src="{{ asset('hr-direktur/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('hr-direktur/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    @yield('js')
    <script>
        document.querySelector('label[for="dt-length-0"]').textContent = 'Entri per halaman';
        document.querySelector('label[for="dt-search-0"]').textContent = 'Cari: ';

        function translateToIndonesian(text) {
            var translations = {
                "Showing": "Menampilkan",
                "to": "hingga",
                "of": "dari",
                "entries": "entri"
            };
            return text.replace(/Showing|to|of|entries/g, function(match) {
                return translations[match];
            });
        }

        function translateInfo() {
            $('.dt-info').each(function() {
                var infoText = $(this).text();
                var indonesianText = translateToIndonesian(infoText);
                $(this).text(indonesianText);
            });
        }
        $(document).ready(function() {
            translateInfo();
        });
        $('#kelolauser').on('draw.dt', function() {
            translateInfo();
        });

        function hapusData(deleteUrl) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah kamu yakin ingin menghapus ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#435ebe',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = deleteUrl;
                }
            });
        }
    </script>
</body>

</html>
