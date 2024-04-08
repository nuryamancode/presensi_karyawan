@extends('layout.v-home', ['title'=>'Kelola Divisi - HR'])

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kelola Divisi</h4>
                <div class="mb-4">
                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-plus-circle mdi-18px"></i>
                            <span class="mx-2">Tambah</span>
                        </div>
                    </a>
                </div>
                <table id="keloladivisi" class="table table-responsive table-striped table-borderless cell-border"
                    style="width:100%">
                    <thead class="table-dark cell-border border-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Divisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($divisi as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_divisi }}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $item->id }}">
                                        <i class="mdi mdi-table-edit mdi-24px mx-0"></i>
                                    </a>
                                    <a class="btn btn-danger" style="color: #fff"
                                        onclick="hapusData('{{ route('hr.delete.divisi', $item->id) }}')">
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
                            <i class="mdi mdi-plus-circle mdi-18px"></i>
                            <span class="mx-2">Tambah Divisi</span>
                        </div>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('hr.post.divisi') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_divisi-name" class="col-form-label">Nama Divisi</label>
                            <input type="name" class="form-control rounded border-dark" id="nama_divisi-name" name="nama_divisi">
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

    @foreach ($divisi as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-table-edit mdi-18px"></i>
                                <span class="mx-2">Edit Divisi</span>
                            </div>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('hr.edit.divisi', $item->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_divisi-name" class="col-form-label">Nama Divisi</label>
                                <input type="name" class="form-control rounded border-dark" id="nama_divisi-name" name="nama_divisi" value="{{ $item->nama_divisi }}">
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
        new DataTable('#keloladivisi');
    </script>
@endsection
