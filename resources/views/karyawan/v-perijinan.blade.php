@extends('karyawan.layout.v-home', ['title' => 'Perijinan Karyawan'])

@section('section-content')
    @include('karyawan.layout.v-loader')
    <div class="appHeader text-light" style="background-color: #092c9f">
        <div class="left">
        </div>
        <div class="pageTitle">Perijinan Karyawan</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-5">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <ion-icon name="briefcase-outline" class="me-4"></ion-icon>Ijin Cuti
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form action="{{ route('employee.perijinan.cuti') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="dataCuti" class="form-label">Tanggal Mulai Cuti<span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="dataCuti"
                                                aria-describedby="dateHelp" name="tanggal_mulai_cuti">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dataCuti" class="form-label">Tanggal Selesai Cuti<span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="dataCuti"
                                                aria-describedby="dateHelp" name="tanggal_selesai_cuti">
                                        </div>
                                        <div class="mb-3">
                                            <label for="reason" class="form-label">Pilih Keterangan<span
                                                    class="text-danger">*</span></label>
                                            <select name="keterangan" id="reason" class="form-select">
                                                <option value="Keperluan Keluarga">Keperluan Keluarga</option>
                                                <option value="Keperluan Mendadak">Keperluan Mendadak</option>
                                                <option value="lainnya">Keperluan Lainnya</option>
                                            </select>
                                        </div>
                                        <div id="otherReasonForm" style="display: none;">
                                            <div class="mb-3">
                                                <input type="text" name="keterangan_lainnya"
                                                    placeholder="Masukkan Keperluan Lainnya" id="otherReason"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><ion-icon
                                                name="document-text-outline" class="me-2"></ion-icon>Ajukan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <ion-icon name="medkit-outline" class="me-4"></ion-icon>Ijin Sakit
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form action="{{ route('employee.perijinan.sakit') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="dataSakit" class="form-label">Tanggal Mulai Sakit<span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="dataSakit"
                                                aria-describedby="dateHelp" name="tanggal_mulai_sakit">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dataSakit" class="form-label">Tanggal Selesai Sakit<span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="dataSakit"
                                                aria-describedby="dateHelp" name="tanggal_selesai_sakit">
                                        </div>
                                        <div class="mb-3">
                                            <label for="file_sakit" class="form-label">Tambahkan Surat Sakit<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="file_surat_sakit" id="file_sakit"
                                                class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary"><ion-icon
                                                name="document-text-outline" class="me-2"></ion-icon>Ajukan</button>
                                    </form>
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
                        <a class="nav-link active position-relative disabled" data-toggle="tab" role="tab">
                            Riwayat Ajuan Perijinan
                        </a>
                    </li>
                    <li class="nav-item">
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @if ($cuti->isEmpty() || $cuti->isEmpty())
                            <li>
                                <div class="text-center">
                                    <h3 class="fw-bold mt-1">Belum ada riwayat presensi</h3>
                                </div>
                            </li>
                        @else
                            @foreach ($cuti as $item)
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-warning">
                                            <ion-icon name="briefcase-outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>
                                                <h3 class="fw-bold">Ijin Cuti</h3>
                                                <span class="">
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_mulai_cuti)->translatedFormat('D, d F Y') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_selesai_cuti)->translatedFormat('D, d F Y') }}
                                                </span>
                                                <p>Keterangan : {{ ucwords($item->keterangan) }}</p>
                                                @if ($item->status_pengajuan === 'Ditolak')
                                                <p>Keterangan Penolakan : {{ $item->keterangan_penolakan ?? 'Tidak ada Keterangan' }}</p>
                                                @endif
                                            </div>
                                            @if ($item->status_pengajuan === 'Disetujui')
                                                <span class="btn btn-success">Disetujui</span>
                                            @elseif($item->status_pengajuan === 'Ditolak')
                                                <span class="btn btn-danger">Ditolak</span>
                                            @else
                                                <span class="btn btn-primary">Belum ada status</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            @foreach ($sakit as $item)
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-dark">
                                            <ion-icon name="medkit-outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>
                                                <h3 class="fw-bold">Ijin Sakit</h3>
                                                <span class="">
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_mulai_sakit)->translatedFormat('D, d F Y') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_selesai_sakit)->translatedFormat('D, d F Y') }}
                                                </span>
                                                @if ($item->status_pengajuan == 'Ditolak')
                                                    <p>Keterangan Penolakan : {{ $item->keterangan_penolakan ?? 'Tidak ada Keterangan' }}</p>
                                                @endif
                                            </div>
                                            @if ($item->status_pengajuan == 'Disetujui')
                                                <span class="btn btn-success">Disetujui</span>
                                            @elseif($item->status_pengajuan == 'Ditolak')
                                                <span class="btn btn-danger">Ditolak</span>
                                            @else
                                                <span class="btn btn-primary">Belum ada status</span>
                                            @endif
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
    <script>
        document.getElementById('reason').addEventListener('change', function() {
            var selectedReason = this.value;
            var otherReasonForm = document.getElementById('otherReasonForm');

            if (selectedReason === 'lainnya') {
                otherReasonForm.style.display =
                    'block'; // Menampilkan form tambahan jika opsi "Keperluan Lainnya" dipilih
            } else {
                otherReasonForm.style.display = 'none'; // Menyembunyikan form tambahan untuk opsi lainnya
            }
        });
    </script>
@endsection
