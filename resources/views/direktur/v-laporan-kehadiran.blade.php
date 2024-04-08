@extends('layout.v-home', ['title' => 'Laporan Kehadiran - Direktur'])

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Laporan Kehadiran</h4>
                <form action="{{ route('direktur.filter.laporan.kehadiran') }}" method="GET">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="bulan" class="form-label">Bulan</label>
                                <select class="form-select rounded border-dark" id="bulan" name="bulan">
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control rounded border-dark" id="tahun" name="tahun" min="2000"
                                    max="2099" value="{{ date('Y') }}">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mb-4" type="submit" style="color: #fff">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-filter mdi-18px"></i>
                            <span class="mx-2">Filter</span>
                        </div>
                    </button>
                </form>
                <div class="text-end">
                    @if (isset($bulan) && isset($tahun))
                        <a class="btn btn-primary mb-4"
                            href="{{ route('direktur.print.laporan.kehadiran.filter', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                            style="color: #fff">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-printer mdi-18px"></i>
                                <span class="mx-2">Print</span>
                            </div>
                        </a>
                        @else
                        <a class="btn btn-primary mb-4"
                            href="{{ route('direktur.print.laporan.kehadiran') }}"
                            style="color: #fff">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-book-open-page-variant mdi-18px"></i>
                                <span class="mx-2">Print</span>
                            </div>
                        </a>

                    @endif


                </div>
                <table id="laporankehadiran" class="table table-responsive table-striped table-borderless cell-border"
                    style="width:100%">
                    <thead class="table-success cell-border border-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Karyawan</th>
                            <th class="text-center">Tanggal Rekap</th>
                            <th class="text-center">Total Kehadiran</th>
                            <th class="text-center">Total Telat</th>
                            <th class="text-center">Total Cuti</th>
                            <th class="text-center">Total Sakit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($rekap->isEmpty())
                            {{ null }}
                        @else
                            @foreach ($rekap as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->karyawan->nama_lengkap }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td>{{ $item->total_hadir }}</td>
                                    <td>{{ $item->total_telat }}</td>
                                    <td>{{ $item->total_cuti }}</td>
                                    <td>{{ $item->total_sakit }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        new DataTable('#laporankehadiran');
    </script>
@endsection
