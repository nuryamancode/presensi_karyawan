@extends('layout.v-home', ['title' => 'Laporan Rekap Kehadiran - HR'])

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Laporan Rekap Kehadiran</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="rekapForm" action="{{ route('hr.laporan.rekap.post') }}" method="POST">
                    @csrf
                    @foreach ($rekap as $item)
                        <input type="hidden" name="karyawan_id[]" value="{{ $item->id }}">
                        <input type="hidden" name="total_hadir[]" value="{{ $item->total_kehadiran }}">
                        <input type="hidden" name="total_cuti[]" value="{{ $item->total_cuti }}">
                        <input type="hidden" name="total_telat[]" value="{{ $item->total_telat }}">
                        <input type="hidden" name="total_sakit[]" value="{{ $item->total_sakit }}">
                    @endforeach
                    <button class="btn btn-primary mb-4" type="button" style="color: #fff" onclick="confirmSubmit()">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-book-open-page-variant mdi-18px"></i>
                            <span class="mx-2">Rekap Bulan Ini</span>
                        </div>
                    </button>
                </form>
                <table id="laporanrekap" class="table table-responsive table-striped table-borderless cell-border"
                    style="width:100%">
                    <thead class="table-dark cell-border border-primary">
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
                        @if ($laporan_rekap->isEmpty())
                            {{ null }}
                        @else
                            @foreach ($laporan_rekap as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->karyawan->nama_lengkap }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id_ID')->isoFormat('D MMMM Y') }}</td>
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
        new DataTable('#laporanrekap');
        function confirmSubmit() {
            // Menampilkan pesan konfirmasi SweetAlert
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah kamu yakin ingin mengirimkan rekap bulan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#435ebe',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna menekan OK, kirimkan formulir
                    document.getElementById("rekapForm").submit();
                }
            });
        }
    </script>
@endsection
