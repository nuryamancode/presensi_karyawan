@extends('layout.v-home', ['title'=>'Kelola Perizinan Cuti - HR'])

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kelola Perizinan Cuti</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <table id="ijincuti" class="table table-responsive table-striped table-borderless cell-border"
                    style="width:100%">
                    <thead class="table-dark cell-border border-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Karyawan</th>
                            <th class="text-center">Tanggal Mulai Cuti</th>
                            <th class="text-center">Tanggal Selesi Cuti</th>
                            <th class="text-center">Alasan Cuti</th>
                            <th class="text-center">Status Pengajuan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cuti as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->karyawan->nama_lengkap }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai_cuti)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai_cuti)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                </td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-center">
                                    @if ($item->status_pengajuan === 'Disetujui')
                                        <span class="status-perijinan-disetujui">{{ $item->status_pengajuan }}</span>
                                    @elseif($item->status_pengajuan === 'Ditolak')
                                        <span class="status-perijinan-ditolak">{{ $item->status_pengajuan }}</span>
                                    @else
                                        Belum ada status
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->status_pengajuan == null)
                                        <a class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#setujuModal{{ $item->id }}" style="color: #fff">
                                            <i class="mdi mdi-checkbox-marked-circle mdi-24px mx-0"></i>
                                        </a>
                                        <a class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#tidakSetujuModal{{ $item->id }}" style="color: #fff">
                                            <i class="mdi mdi-close-circle mdi-24px mx-0"></i>
                                        </a>
                                    @endif
                                    <a class="btn btn-dark" style="color: #fff"
                                        onclick="hapusData('{{ route('hr.delete.cuti', $item->id) }}')">
                                        <i class="mdi mdi-delete-forever mdi-24px mx-0"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($cuti as $item)
        <div class="modal fade" id="setujuModal{{ $item->id }}" tabindex="-1" aria-labelledby="setujuModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="setujuModalLabel">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-checkbox-marked-circle mdi-18px"></i>
                                <span class="mx-2">Persetujuan Cuti</span>
                            </div>
                        </h1>
                    </div>
                    <form action="{{ route('hr.setujui.cuti', $item->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <p>Apakah anda yakin ingin menyetujui perijinan cuti?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="color: #fff">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-close-circle mdi-18px"></i>
                                    Tutup
                                </div>
                            </button>
                            <button type="submit" class="btn btn-success" style="color: #fff">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-content-save mdi-18px"></i>
                                    Setujui
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($cuti as $item)
        <div class="modal fade" id="tidakSetujuModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="tidakSetujuModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tidakSetujuModalLabel">
                            <div class="d-flex align-items-center">
                                <i class="mdi  mdi-close-circle mdi-18px"></i>
                                <span class="mx-2">Persetujuan Cuti</span>
                            </div>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('hr.tolak.cuti', $item->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <p style="font-size: 14px">Apakah anda yakin ingin menolak perijinan cuti?. Jika yakin berikan
                                alasannya</p>
                            <div class="mb-3">
                                <label for="keterangan-name" class="col-form-label">Alasan Tidak Setujui</label>
                                <div class="form-floating">
                                    <textarea class="form-control rounded border-dark" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                        name="keterangan_penolakan"></textarea>
                                    <label for="floatingTextarea2">Masukkan alasan disini</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="color: #fff">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-close-circle mdi-18px"></i>
                                    Tutup
                                </div>
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-content-save mdi-18px"></i>
                                    Simpan
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('js')
    <script>
        new DataTable('#ijincuti');
    </script>
@endsection
