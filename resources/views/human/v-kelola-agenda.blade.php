@extends('layout.v-home', ['title' => 'Kelola Agenda - HR'])

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kelola Agenda</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-4">
                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-calendar-plus mdi-18px"></i>
                            <span class="mx-2">Tambah</span>
                        </div>
                    </a>
                </div>
                <table id="kelolaagenda" class="table table-responsive table-striped table-borderless cell-border"
                    style="width:100%">
                    <thead class="table-dark cell-border border-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Agenda</th>
                            <th class="text-center">Nama Karyawan</th>
                            <th class="text-center">Alamat Lokasi</th>
                            <th class="text-center">Tanggal Mulai</th>
                            <th class="text-center">Tanggal Selesi</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Foto Kunjungan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agenda as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_event }}</td>
                                <td>{{ $item->karyawan->nama_lengkap }}</td>
                                <td>{{ $item->alamat_lokasi }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                </td>
                                </td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    @if ($item->foto_kunjungan != null)
                                        <a href="{{ asset($item->foto_kunjungan) }}" class="popup-gallery">
                                            <img src="{{ asset($item->foto_kunjungan) }}" alt="">
                                        </a>
                                    @else
                                        Karyawan belum menambahkan bukti
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $item->id }}">
                                        <i class="mdi mdi-table-edit mdi-24px mx-0"></i>
                                    </a>
                                    <a class="btn btn-danger" style="color: #fff"
                                        onclick="hapusData('{{ route('hr.delete.agenda', $item->id) }}')">
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
                            <i class="mdi mdi-calendar-plus mdi-18px"></i>
                            <span class="mx-2">Tambah Agenda</span>
                        </div>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('hr.post.agenda') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_event-name" class="col-form-label">Nama Agenda</label>
                            <input type="name" class="form-control rounded border-dark" id="nama_event-name"
                                name="nama_event">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai-name" class="col-form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control rounded border-dark" id="tanggal_mulai-name"
                                name="tanggal_mulai">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai-name" class="col-form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control rounded border-dark" id="tanggal_selesai-name"
                                name="tanggal_selesai">
                        </div>
                        <div class="mb-3">
                            <label for="karyawan-name" class="col-form-label">Pilih Karyawan</label>
                            <select name="karyawan_id" id="karyawan-name" class="form-select rounded border-dark">
                                @foreach ($karyawan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_lokasi-name" class="col-form-label">Alamat Lokasi</label>
                            <div class="form-floating">
                                <textarea class="form-control rounded border-dark" placeholder="Leave a comment here" id="floatingTextarea2"
                                    style="height: 100px" name="alamat_lokasi"></textarea>
                                <label for="floatingTextarea2">Masukkan alamat disini</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nama_divisi-name" class="col-form-label">Keterangan</label>
                            <div class="form-floating">
                                <textarea class="form-control rounded border-dark" placeholder="Leave a comment here" id="floatingTextarea2"
                                    style="height: 100px" name="keterangan"></textarea>
                                <label for="floatingTextarea2">Masukkan keterangan disini</label>
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

    @foreach ($agenda as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-table-edit mdi-18px"></i>
                                <span class="mx-2">Edit Agenda</span>
                            </div>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('hr.edit.agenda', $item->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_event-name" class="col-form-label">Nama Agenda</label>
                                <input type="name" class="form-control rounded border-dark" id="nama_event-name"
                                    name="nama_event" value="{{ $item->nama_event }}">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_mulai-name" class="col-form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control rounded border-dark" id="tanggal_mulai-name"
                                    name="tanggal_mulai"
                                    value="{{ !empty($item->tanggal_mulai) ? date('Y-m-d', strtotime($item->tanggal_mulai)) : '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_selesai-name" class="col-form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control rounded border-dark" id="tanggal_selesai-name"
                                    name="tanggal_selesai"
                                    value="{{ !empty($item->tanggal_mulai) ? date('Y-m-d', strtotime($item->tanggal_selesai)) : '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="alamat_lokasi-name" class="col-form-label">Alamat Lokasi</label>
                                <div class="form-floating">
                                    <textarea class="form-control rounded border-dark" placeholder="Leave a comment here" id="alamat_lokasi-name"
                                        style="height: 100px" name="alamat_lokasi">{{ $item->alamat_lokasi }}</textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nama_divisi-name" class="col-form-label">Keterangan</label>
                                <div class="form-floating">
                                    <textarea class="form-control rounded border-dark" placeholder="Leave a comment here" id="keterangan-name"
                                        style="height: 100px" name="keterangan">{{ $item->keterangan }}</textarea>
                                </div>
                            </div>
                            @if ($item->foto_kunjungan === null)
                                <div class="mb-3">
                                    <label for="karyawan-name" class="col-form-label">Pilih Karyawan</label>
                                    <select name="karyawan_id" id="karyawan-name"
                                        class="form-select rounded border-dark">
                                        <option value="{{ $item->karyawan->id }}">{{ $item->karyawan->nama_lengkap }}
                                        </option>
                                        @foreach ($karyawan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script>
        new DataTable('#kelolaagenda');
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
