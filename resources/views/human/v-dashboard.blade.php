@extends('layout.v-home', ['title' => 'Dashboard - HR'])

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="text-center">
                <h3 class="text-dark font-weight-bold fw-bold">Hi, Welcome Back! {{ $hr->nama_lengkap }}
                </h3>
            </div>
        </div>
        @if ($hr->alamat_lengkap == null || $hr->nama_lengkap == null || $hr->foto_diri == null || $hr->nomor_wa == null)
            <div class="card text-center mb-3 mt-4">
                <div class="card-body bg-danger">
                    <h2 class="text-white font-weight-bold fw-bold">Lengkapi Profil</h2>
                    <p class="text-white">Segera melengkapi profil kamu, isi biodata yang dibutuhkan.</p>
                </div>
            </div>
        @endif
        <div class="row mt-4">
            <div class="col-lg-2 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="text-success font-weight-bold">{{ $jumlah_user }}</h2>
                            <i class="mdi mdi-account mdi-36px text-dark"></i>
                        </div>
                    </div>
                    <div class="line-chart-row-title">AKUN PENGGUNA</div>
                </div>
            </div>
            <div class="col-lg-2 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="text-danger font-weight-bold">{{ $jumlah_karyawan }}</h2>
                            <i class="mdi mdi-human-male-female mdi-36px text-dark"></i>
                        </div>
                    </div>
                    <div class="line-chart-row-title">DATA KARYAWAN</div>
                </div>
            </div>
            <div class="col-lg-2 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="text-info font-weight-bold">{{ $jumlah_divisi }}</h2>
                            <i class="mdi mdi-briefcase-check mdi-36px text-dark"></i>
                        </div>
                    </div>
                    <div class="line-chart-row-title">DIVISI</div>
                </div>
            </div>
            <div class="col-lg-2 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="text-warning font-weight-bold">{{ $jumlah_agenda }}</h2>
                            <i class="mdi mdi-calendar-text mdi-36px text-dark"></i>
                        </div>
                    </div>
                    <canvas id="projects"></canvas>
                    <div class="line-chart-row-title">AGENDA</div>
                </div>
            </div>
            <div class="col-lg-2 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="text-secondary font-weight-bold">{{ $jumlah_jam }}</h2>
                            <i class="mdi mdi-clock mdi-36px text-dark"></i>
                        </div>
                    </div>
                    <div class="line-chart-row-title">JAM PRESENSI</div>
                </div>
            </div>
            <div class="col-lg-2 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="text-dark font-weight-bold">{{ $jumlah_dinas }}</h2>
                            <i class="mdi mdi-clipboard-alert text-dark mdi-36px"></i>
                        </div>
                    </div>
                    <canvas id="transactions"></canvas>
                    <div class="line-chart-row-title">LAPORAN DINAS</div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <h4 class="card-title">Izin Cuti</h4>
                                <canvas id="cutiChart"></canvas>
                                <p class="mt-3 mb-4 mb-lg-0">Lorem ipsum dolor sit amet,
                                    consectetur adipisicing elit.
                                </p>
                            </div>
                            <div class="col-lg-4">
                                <h4 class="card-title">Izin Sakit</h4>
                                <canvas id="sakitChart"></canvas>
                                <p class="mt-3 mb-4 mb-lg-0">Lorem ipsum dolor sit amet,
                                    consectetur adipisicing elit.
                                </p>
                            </div>
                            <div class="col-lg-4">
                                <h4 class="card-title">Rekap Kehadiran /Bulan</h4>
                                <div class="row">
                                    <div class="col-sm-8 grid-margin">
                                        <canvas id="rekapChart"></canvas>
                                    </div>
                                </div>
                                <p class="mt-3 mb-4 mb-lg-0">Lorem ipsum dolor sit amet,
                                    consectetur adipisicing elit.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
            // CUTI
            var cutiChartData = {
                labels: [],
                datasets: [{
                    label: "Izin Cuti",
                    data: [],
                    backgroundColor: [
                        "#ff0000",
                        "#ff6347",
                        "#dc143c",
                        "#ff4500",
                        "#ff8c00",
                    ],
                    borderColor: [
                        "#ff0000",
                        "#ff6347",
                        "#dc143c",
                        "#ff4500",
                        "#ff8c00",
                    ],
                    borderWidth: 1,
                    fill: true,
                }]
            };
            var namaBulan = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            @foreach ($jumlah_cuti as $data)
                var bulanTahun = "{{ $data->tahun }}-{{ $data->bulan }}-01";
                var namaBulanTahun = new Date(bulanTahun).toLocaleString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });
                cutiChartData.labels.push(namaBulanTahun);
                cutiChartData.datasets[0].data.push({{ $data->jumlah_data }});
            @endforeach
            var cutiChartOptions = {
                scales: {
                    xAxes: [{
                        position: "top",
                        display: false,
                        gridLines: {
                            display: false,
                            drawBorder: true,
                        },
                        ticks: {
                            display: false,
                            beginAtZero: true,
                        },
                    }, ],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            drawBorder: true,
                            display: false,
                        },
                        ticks: {
                            beginAtZero: true,
                        },
                    }, ],
                },
                legend: {
                    display: false,
                },
                tooltips: {
                    show: false,
                    backgroundColor: "rgba(31, 59, 179, 1)",
                },
                plugins: {
                    datalabels: {
                        display: true,
                        align: "start",
                        color: "white",
                    },
                },
            };
            var cutiChartCanvas = $("#cutiChart").get(0).getContext("2d");
            var cutiChart = new Chart(cutiChartCanvas, {
                type: "horizontalBar",
                data: cutiChartData,
                options: cutiChartOptions,
            });
            // CUTI


            // SAKIT
            var sakitChartData = {
                labels: [],
                datasets: [{
                    label: "Izin Sakit",
                    data: [],
                    backgroundColor: [
                        "#007bff",
                        "#1e90ff",
                        "#6495ed",
                        "#4169e1",
                        "#4682b4",
                    ],
                    borderColor: [
                        "#007bff",
                        "#1e90ff",
                        "#6495ed",
                        "#4169e1",
                        "#4682b4",
                    ],
                    borderWidth: 2,
                    fill: false,
                }],
            };
            var namaBulan = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            @foreach ($jumlah_sakit as $data)
                var bulanTahun = "{{ $data->tahun }}-{{ str_pad($data->bulan, 2, '0', STR_PAD_LEFT) }}-01";
                var namaBulanTahun = new Date(bulanTahun).toLocaleString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });
                sakitChartData.labels.push(namaBulanTahun);
                sakitChartData.datasets[0].data.push({{ $data->jumlah_data }});
            @endforeach
            var sakitChartOptions = {
                scales: {
                    xAxes: [{
                        position: "top",
                        display: false,
                        gridLines: {
                            display: false,
                            drawBorder: true,
                        },
                        ticks: {
                            display: false,
                            beginAtZero: true,
                        },
                    }, ],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            drawBorder: true,
                            display: false,
                        },
                        ticks: {
                            beginAtZero: true,
                        },
                    }, ],
                },
                legend: {
                    display: false,
                },
                tooltips: {
                    show: false,
                    backgroundColor: "rgba(31, 59, 179, 1)",
                },
                plugins: {
                    datalabels: {
                        display: true,
                        align: "start",
                        color: "white",
                    },
                },
            };
            var sakitChartCanvas = $("#sakitChart").get(0).getContext("2d");
            var sakitChart = new Chart(sakitChartCanvas, {
                type: "horizontalBar",
                data: sakitChartData,
                options: sakitChartOptions,
            });
            // SAKIT


            // REKAP
            var rekapData = {!! $rekap !!};
            var jumlahDataPerBulan = {};
            var namaBulan = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            rekapData.forEach(function(item) {
                var tahun = item.tahun;
                var bulan = item.bulan;
                var jumlahData = item.jumlah_data;
                var labelBulan = namaBulan[bulan - 1] + ' ' + tahun;
                if (!jumlahDataPerBulan[labelBulan]) {
                    jumlahDataPerBulan[labelBulan] = jumlahData;
                } else {
                    jumlahDataPerBulan[labelBulan] += jumlahData;
                }
            });
            var labels = Object.keys(jumlahDataPerBulan);
            var data = Object.values(jumlahDataPerBulan);
            var rekapChartData = {
                datasets: [{
                    data: data,
                    backgroundColor: [
                        "#ee5b5b",
                        "#fcd53b",
                        "#0bdbb8",
                        "#464dee",
                        "#0ad7f7",
                    ],
                    borderColor: [
                        "#ee5b5b",
                        "#fcd53b",
                        "#0bdbb8",
                        "#464dee",
                        "#0ad7f7",
                    ],
                }],
                labels: labels,
            };
            var rekapChartOptions = {
                responsive: true,
                cutoutPercentage: 80,
                legend: {
                    display: false,
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                },
                plugins: {
                    datalabels: {
                        display: false,
                        align: "center",
                        anchor: "center",
                    },
                },
            };
            if ($("#rekapChart").length) {
                var pieChartCanvas = $("#rekapChart").get(0).getContext("2d");
                var pieChart = new Chart(pieChartCanvas, {
                    type: "doughnut",
                    data: rekapChartData,
                    options: rekapChartOptions,
                });
            }
            // REKAP
        </script>
    @endsection
