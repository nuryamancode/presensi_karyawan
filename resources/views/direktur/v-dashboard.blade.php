@extends('layout.v-home', ['title' => 'Dashboard - Direktur'])

@section('content')
    <style>
        .product-order-wrap {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 60%;
        }
    </style>
    <div class="content-wrapper">
        <div class="row">
            <div class="text-center">
                <h3 class="text-dark font-weight-bold fw-bold">Hi, Welcome Back! {{ $direktur->nama_lengkap }}
                </h3>
            </div>
        </div>
        @if (
            $direktur->alamat_lengkap == null ||
                $direktur->nama_lengkap == null ||
                $direktur->foto_diri == null ||
                $direktur->nomor_wa == null)
            <div class="card text-center mb-3 mt-4">
                <div class="card-body bg-danger">
                    <h2 class="text-white font-weight-bold fw-bold">Lengkapi Profil</h2>
                    <p class="text-white">Segera melengkapi profil kamu, isi biodata yang dibutuhkan.</p>
                </div>
            </div>
        @endif
        <div class="row mb-4 mt-4">
            <div class="col-sm-6 grid-margin grid-margin-md-0 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">Laporan Kehadiran Karyawan</h4>
                            <h4 class="text-success font-weight-bold">Data<span
                                    class="text-dark ms-3">{{ $jumlah_data }}</span></h4>
                        </div>
                        <div id="support-tracker-legend" class="support-tracker-legend"></div>
                        <canvas id="kehadiranChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 grid-margin grid-margin-md-0 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-lg-flex align-items-center justify-content-between mb-4">
                            <h4 class="card-title">Laporan Dinas Karyawan</h4>
                            <p class="text-dark">Jumlah Data Dinas</p>
                        </div>
                        <div class="product-order-wrap padding-reduced text-center data-center">
                            <h1 style="font-size: 100px;" class="text-primary fw-bold">{{ $jumlah_data_dinas }}</h1>
                            <h1 class="fw-bold text-primary">DATA</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var kehadiranChartData = {
            labels: [],
            datasets: [{
                label: 'Jumlah Data Kehadiran Perbulan',
                data: [],
                backgroundColor: '#0D6EFD',
                borderColor: '#0D6EFD',
                borderWidth: 1,
                fill: false
            }]
        };
        @foreach ($rekap as $data)
            @php
                $namaBulanTahun = date('M Y', mktime(0, 0, 0, $data->bulan, 1)) . '';
            @endphp
            kehadiranChartData.labels.push('{{ $namaBulanTahun }}');
            kehadiranChartData.datasets[0].data.push({{ $data->jumlah_data }});
        @endforeach
        var kehadiranChartOptions = {
            scales: {
                yAxes: [{
                    display: false
                }]
            },
        };
        var barChartCanvas = $("#kehadiranChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: kehadiranChartData,
            options: kehadiranChartOptions
        });
        document.getElementById('support-tracker-legend').innerHTML = barChart.generateLegend();
    </script>
@endsection
