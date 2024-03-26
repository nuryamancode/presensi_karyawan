@extends('karyawan.layout.v-home', ['title' => 'Presensi Karyawan'])

@section('section-content')
    @php
        // Presensi Masuk
        $waktu_sekarang_m = now();
        $waktu_buka_m = now()->setHour(8)->setMinute(50)->setSecond(0);
        $waktu_telat_m = now()->setHour(9)->setMinute(30)->setSecond(0);
        $waktu_tutup_m = now()->setHour(10)->setMinute(0)->setSecond(0);

        $button_disabled_m =
            $waktu_sekarang_m < $waktu_buka_m ||
            $waktu_sekarang_m > $waktu_telat_m ||
            $waktu_sekarang_m > $waktu_tutup_m
                ? 'disabled'
                : '';
        // Presensi Masuk

        // Presensi Pulang
        $waktu_sekarang_p = now();
        $waktu_buka_p = now()->setHour(16)->setMinute(50)->setSecond(0);
        $waktu_telat_p = now()->setHour(17)->setMinute(30)->setSecond(0);
        $waktu_tutup_p = now()->setHour(18)->setMinute(0)->setSecond(0);

        $button_disabled_p = $waktu_sekarang_p < $waktu_buka_p || $waktu_sekarang_p > $waktu_telat_p || $waktu_sekarang_p > $waktu_tutup_p ? 'disabled' : '';
        // Presensi Pulang
    @endphp
    @include('karyawan.layout.v-loader')
    @include('karyawan.layout.v-user')
    <div id="appCapsule">
        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <h6 id="date"></h6>
                    <h1 id="clock"></h1>
                    <div class="todaypresence" style="margin-top: -5px">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('employee.presensi.masuk') }}" {{ $button_disabled_m }}
                                    id="presensi_masuk_link">
                                    <div class="card gradasigreen">
                                        <div class="card-body">
                                            <div class="presencecontent">
                                                <div class="iconpresence">
                                                    <ion-icon name="camera" style="color: #fff"></ion-icon>
                                                </div>
                                                <div class="presencedetail">
                                                    <h4 class="presencetitle">Masuk</h4>
                                                    <span class="text-white">09:00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('employee.presensi.pulang') }}" {{ $button_disabled_p }}
                                    id="presensi_pulang_link">
                                    <div class="card gradasired">
                                        <div class="card-body">
                                            <div class="presencecontent">
                                                <div class="iconpresence">
                                                    <ion-icon name="camera" style="color: #fff"></ion-icon>
                                                </div>
                                                <div class="presencedetail">
                                                    <h4 class="presencetitle">Pulang</h4>
                                                    <span class="text-white">17:00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section" style="margin-top: 200px" id="presence-section">
            <div class="rekappresence">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence primary">
                                        <ion-icon name="log-in"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Hadir</h4>
                                        <span class="rekappresencedetail">{{ $total_hadir }} Kali</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence green">
                                        <ion-icon name="document-text"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Cuti</h4>
                                        <span class="rekappresencedetail">0 Kali</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence primary">
                                        <ion-icon name="alarm"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Telat</h4>
                                        <span class="rekappresencedetail">{{ $total_telat }} Kali</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence danger">
                                        <ion-icon name="sad"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Sakit</h4>
                                        <span class="rekappresencedetail">0 Kali</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="{{ route('employee.dashboard') }}"
                                role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative" data-toggle="tab"
                                href="{{ route('employee.notifikasi') }}" role="tab">
                                Notifikasi
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    99+
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @if ($presensi->isEmpty())
                                <li>
                                    <div class="text-center">
                                        <h3 class="fw-bold mt-1">Belum ada riwayat presensi</h3>
                                    </div>
                                </li>
                            @else
                                @foreach ($presensi as $item)
                                    <li>
                                        <div class="item">
                                            <div
                                                class="icon-box {{ $item->status_presensi == 'Masuk' ? 'bg-primary' : 'bg-danger' }}">
                                                <ion-icon name="alarm-outline"></ion-icon>
                                            </div>
                                            <div class="in">
                                                <div>
                                                    <h3 class="fw-bold">Presensi {{ $item->status_presensi }}</h3>
                                                    <span
                                                        class="">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->translatedFormat('D, d F Y') }}</span>
                                                </div>
                                                <p>{{ \Carbon\Carbon::createFromFormat('H:i:s', $item->jam)->format('h:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- alert masuk --}}
    <div class="modal fade" id="presensiModalMasuk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="presensiModalMasukLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('employee.post.pengaduan.presensi.masuk') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="text-center mt-3">
                            <img src="{{ asset('image/icons/time.png') }}" width="100px" style="color: #f40000;"
                                alt="" srcset="">
                            <h1 class="mt-3">Kamu Terlambat Masuk!</h1>
                        </div>
                        <p>Maaf, anda sudah terlambat untuk melakukan presensi masuk, anda akan tetap bisa melakukan
                            presensi
                            namun dihitung terlambat, silahkan untuk mengisi alasan terlambat.</p>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                name="alasan"></textarea>
                            <label for="floatingTextarea2">Alasan Terlambat Masuk</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><ion-icon
                                name="close-circle-outline"></ion-icon>Tutup</button>
                        <button type="submit" class="btn btn-primary"><ion-icon name="alert-circle-outline"></ion-icon>
                            Laporkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- alert masuk --}}
    {{-- alert pulang --}}
    <div class="modal fade" id="presensiModalPulang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="presensiModalPulangLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('employee.post.pengaduan.presensi.pulang') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="text-center mt-3">
                            <img src="{{ asset('image/icons/time.png') }}" width="100px" style="color: #f40000;"
                                alt="" srcset="">
                            <h1 class="mt-3">Kamu Terlambat Pulang!</h1>
                        </div>
                        <p>Maaf, anda sudah terlambat untuk melakukan presensi pulang, anda akan tetap bisa melakukan
                            presensi
                            namun dihitung terlambat, silahkan untuk mengisi alasan terlambat dan laporkan kegiatan jika
                            ada.</p>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                name="alasan"></textarea>
                            <label for="floatingTextarea2">Alasan Terlambat Pulang</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><ion-icon
                                name="close-circle-outline"></ion-icon>Tutup</button>
                        <button type="submit" class="btn btn-primary"><ion-icon name="alert-circle-outline"></ion-icon>
                            Laporkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- alert pulang --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Presensi Masuk
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('presensi_masuk_link').addEventListener('click', function(event) {
                var waktuSekarang = new Date();
                var waktuTelat = new Date("{{ $waktu_telat_m }}");
                var waktuBuka = new Date("{{ $waktu_buka_m }}");
                var waktuTutup = new Date("{{ $waktu_tutup_m }}");
                var hariini = "{{ $presensi_masuk_today }}";

                if (hariini) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Presensi Masuk Sudah Dilakukan',
                        text: 'Maaf, Anda sudah melakukan presensi masuk hari ini.',
                        confirmButtonText: 'Baik',
                    });
                } else {
                    if (waktuSekarang <= waktuBuka) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Presensi Masuk Belum Dibuka',
                            text: 'Maaf, waktu untuk melakukan presensi masuk belum dibuka.',
                            confirmButtonText: 'Baik',
                        });
                    } else if (waktuSekarang > waktuTutup) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Presensi Masuk Sudah Ditutup',
                            text: 'Maaf, waktu untuk melakukan presensi masuk sudah ditutup.',
                            confirmButtonText: 'Baik',
                        });
                    } else {
                        if (waktuSekarang > waktuTelat) {
                            event.preventDefault();
                            $('#presensiModalMasuk').modal('show');
                        } else {
                            console.log('');
                        }
                    }
                }
            });
        });
        // Presensi Masuk

        // Presensi Pulang
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('presensi_pulang_link').addEventListener('click', function(event) {
                var waktuSekarang = new Date();
                var waktuTelat = new Date("{{ $waktu_telat_p }}");
                var waktuBuka = new Date("{{ $waktu_buka_p }}");
                var waktuTutup = new Date("{{ $waktu_tutup_p }}");
                var hariini = "{{ $presensi_pulang_today }}";
                if (hariini) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Presensi Masuk Sudah Dilakukan',
                        text: 'Maaf, Anda sudah melakukan presensi pulang hari ini.',
                        confirmButtonText: 'Baik',
                    });
                } else {
                    if (waktuSekarang <= waktuBuka) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Presensi Pulang Belum Dibuka',
                            text: 'Maaf, waktu untuk melakukan presensi pulang belum dibuka.',
                            confirmButtonText: 'Baik',
                        });
                    } else if (waktuSekarang > waktuTutup) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Presensi Pulang Sudah Ditutup',
                            text: 'Maaf, waktu untuk melakukan presensi pulang sudah ditutup.',
                            confirmButtonText: 'Baik',
                        });
                    } else {
                        if (waktuSekarang > waktuTelat) {
                            event.preventDefault();
                            $('#presensiModalPulang').modal('show');
                        } else {
                            console.log('');
                        }
                    }
                }
            });
        });
        // Presensi Pulang
    </script>
@endsection
