@extends('layout.v-home', ['title' => 'Laporan Dinas Karyawan - Direktur'])

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Laporan Dinas Karyawan</h4>
                <div class="mb-4">
                    <a class="btn btn-primary" href="{{ route('direktur.laporan.dinas.print') }}" style="color: #fff">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-printer mdi-18px"></i>
                            <span class="mx-2">Print</span>
                        </div>
                    </a>
                </div>
                <table id="laporandinas" class="table table-responsive table-striped table-borderless cell-border"
                    style="width:100%">
                    <thead class="table-success cell-border border-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Agenda</th>
                            <th class="text-center">Nama Karyawan</th>
                            <th class="text-center">Tanggal Mulai</th>
                            <th class="text-center">Tanggal Selesi</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Foto Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan_dinas as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_event }}</td>
                                <td>{{ $item->karyawan->nama_lengkap }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                </td>
                                </td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-center">
                                    <a href="{{ asset($item->foto_kunjungan) }}" class="popup-gallery">
                                        <img src="{{ asset($item->foto_kunjungan) }}" alt="">
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script>
        new DataTable('#laporandinas');
        $(document).ready(function() {
            $('.popup-gallery').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: false
                },
                image: {
                    verticalFit: true,
                    maxWidth: '100%'
                }
            });
        });
    </script>
@endsection
