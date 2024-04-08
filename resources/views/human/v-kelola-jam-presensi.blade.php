@extends('layout.v-home', ['title' => 'Kelola Jam Presensi - HR'])

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kelola Jam Presensi</h4>
                <div class="mb-4">
                    @if ($jumlahData < 2)
                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-alarm-plus mdi-18px"></i>
                            <span class="mx-2">Tambah</span>
                        </div>
                    </a>
                @endif
                </div>
                <table id="jampresensi" class="table table-responsive table-striped table-borderless cell-border"
                    style="width:100%">
                    <thead class="table-dark cell-border border-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jam Buka</th>
                            <th class="text-center">Jam Tutup</th>
                            <th class="text-center">Jam Telat</th>
                            <th class="text-center">Status Presensi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jam as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->waktu_buka }}</td>
                                <td>{{ $item->waktu_tutup }}</td>
                                <td>{{ $item->waktu_telat }}</td>
                                <td>Presensi {{ $item->status_jam }}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $item->id }}">
                                        <i class="mdi mdi-table-edit mdi-24px mx-0"></i>
                                    </a>
                                    <a class="btn btn-danger" style="color: #fff"
                                        onclick="hapusData('{{ route('hr.delete.jam.presensi', $item->id) }}')">
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

    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahModalLabel">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-alarm-plus mdi-18px"></i>
                            <span class="mx-2">Tambah Jam Presensi</span>
                        </div>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('hr.post.jam.presensi') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="waktu_buka-name" class="col-form-label">Jam Buka</label>
                            <input type="time" class="form-control rounded border-dark" id="waktu_buka-name"
                                name="waktu_buka">
                        </div>
                        <div class="mb-3">
                            <label for="waktu_tutup-name" class="col-form-label">Jam Tutup</label>
                            <input type="time" class="form-control rounded border-dark" id="waktu_tutup-name"
                                name="waktu_tutup">
                        </div>
                        <div class="mb-3">
                            <label for="waktu_telat-name" class="col-form-label">Jam Telat</label>
                            <input type="time" class="form-control rounded border-dark" id="waktu_telat-name"
                                name="waktu_telat">
                        </div>
                        <div class="mb-3">
                            <label for="status_jam-name" class="col-form-label">Pilih Presensi</label>
                            <select name="status_jam" id="status_jam-name" class="form-select rounded border-dark">
                                <option value="Masuk">Masuk</option>
                                <option value="Pulang">Pulang</option>
                            </select>
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

    @foreach ($jam as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-table-edit mdi-18px"></i>
                                <span class="mx-2">Edit Jam Presensi</span>
                            </div>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('hr.edit.jam.presensi', $item->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="waktu_buka-name" class="col-form-label">Jam Buka</label>
                                <input type="time" class="form-control rounded border-dark" id="waktu_buka-name"
                                    name="waktu_buka" value="{{ $item->waktu_buka }}">
                            </div>
                            <div class="mb-3">
                                <label for="waktu_tutup-name" class="col-form-label">Jam Tutup</label>
                                <input type="time" class="form-control rounded border-dark" id="waktu_tutup-name"
                                    name="waktu_tutup" value="{{ $item->waktu_tutup }}">
                            </div>
                            <div class="mb-3">
                                <label for="waktu_telat-name" class="col-form-label">Jam Telat</label>
                                <input type="time" class="form-control rounded border-dark" id="waktu_telat-name"
                                    name="waktu_telat" value="{{ $item->waktu_telat }}">
                            </div>
                            <div class="mb-3">
                                <label for="status_jam-name" class="col-form-label">Pilih Presensi</label>
                                <select name="status_jam" id="status_jam-name" class="form-select rounded border-dark">
                                    <option value="Masuk">Masuk</option>
                                    <option value="Pulang">Pulang</option>
                                </select>
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
        new DataTable('#jampresensi');
    </script>
@endsection
