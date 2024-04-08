@extends('layout.v-home', ['title' => 'Kelola Manajemen User - HR'])

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kelola Manajemen User</h4>
                <div class="mb-4">
                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-account-plus mdi-18px"></i>
                            <span class="mx-2">Tambah</span>
                        </div>
                    </a>
                </div>
                <table id="kelolauser" class="table table-responsive table-striped table-borderless cell-border"
                    style="width:100%">
                    <thead class="table-dark cell-border border-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Lengkap</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Level</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->level == 'Karyawan')
                                        {{ $item->karyawan->nama_lengkap ?? '' }}
                                    @elseif($item->level == 'Human Resource')
                                        {{ $item->hr->nama_lengkap }}
                                    @elseif($item->level == 'Direktur')
                                        {{ $item->direktur->nama_lengkap }}
                                    @endif
                                </td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->level }}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $item->id }}">
                                        <i class="mdi mdi-table-edit mdi-24px mx-0"></i>
                                    </a>
                                    <a class="btn btn-danger" style="color: #fff"
                                        onclick="hapusData('{{ route('hr.delete.manajeman.user', $item->id) }}')">
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
                            <i class="mdi mdi-account-plus mdi-18px"></i>
                            <span class="mx-2">Tambah User</span>
                        </div>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('hr.post.manajeman.user') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_lengkap-name" class="col-form-label">Nama Lengkap</label>
                            <input type="name" class="form-control rounded border-dark" id="nama_lengkap-name" name="nama_lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="email-text" class="col-form-label">Email</label>
                            <input type="email" class="form-control rounded border-dark" id="email-name" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password-text" class="col-form-label">Password</label>
                            <input type="password" class="form-control rounded border-dark" id="password-name" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="pilih-text" class="col-form-label">Pilih Level</label>
                            <select class="form-select level-select rounded border-dark" aria-label="Default select example" name="level">
                                <option value="Direktur">Direktur</option>
                                <option value="Karyawan">Karyawan</option>
                            </select>
                        </div>

                        <div class="mb-3 divisi-select" style="display: none;">
                            <label for="pilih-text" class="col-form-label">Pilih Divisi</label>
                            <select class="form-select rounded border-dark" aria-label="Default select example" name="divisi">
                                @foreach ($divisi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_divisi }}</option>
                                @endforeach
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

    @foreach ($user as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-account-edit mdi-18px"></i>
                                <span class="mx-2">Edit User</span>
                            </div>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('hr.edit.manajeman.user', $item->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_lengkap-name" class="col-form-label">Nama Lengkap</label>
                                <input type="name" class="form-control rounded border-dark" id="nama_lengkap-name" name="nama_lengkap"
                                    value="{{ $item->level == 'Karyawan' && $item->karyawan ? $item->karyawan->nama_lengkap : '' }}
                                {{ $item->level == 'Direktur' && $item->direktur ? $item->direktur->nama_lengkap : '' }}
                                {{ $item->level == 'Human Resource' && $item->hr ? $item->hr->nama_lengkap : '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="email-text" class="col-form-label">Email</label>
                                <input type="email" class="form-control rounded border-dark" id="email-name" name="email"
                                    value="{{ $item->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="password-text" class="col-form-label">Password</label>
                                <input type="password" class="form-control rounded border-dark" id="password-name" name="password"
                                    value="{{ $item->password }}">
                            </div>
                            <div class="mb-3">
                                <label for="pilih-text" class="col-form-label">Pilih Level</label>
                                <select class="form-select level-select rounded border-dark" aria-label="Default select example"
                                    name="level">
                                    <option value="{{ $item->level }}" selected>{{ $item->level }}</option>
                                    <option value="Direktur">Direktur</option>
                                    <option value="Karyawan">Karyawan</option>
                                </select>
                            </div>

                            @if ($item->level === 'Karyawan')
                                <div class="mb-3 divisi-select">
                                    <label for="pilih-text" class="col-form-label">Pilih Divisi</label>
                                    <select class="form-select rounded border-dark" aria-label="Default select example" name="divisi">
                                        @foreach ($divisi as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_divisi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="mb-3 divisi-select" style="display: none;">
                                    <label for="pilih-text" class="col-form-label">Pilih Divisi</label>
                                    <select class="form-select rounded border-dark" aria-label="Default select example" name="divisi">
                                        @foreach ($divisi as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_divisi }}</option>
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
    <script>
        new DataTable('#kelolauser');
        document.querySelectorAll('.level-select').forEach(function(element) {
            element.addEventListener('change', function() {
                var selectLevel = this.value;
                var selectDivisi = this.closest('.modal').querySelector('.divisi-select');

                if (selectLevel === 'Karyawan') {
                    selectDivisi.style.display = 'block';
                } else {
                    selectDivisi.style.display = 'none';
                }
            });
        });
    </script>
@endsection
