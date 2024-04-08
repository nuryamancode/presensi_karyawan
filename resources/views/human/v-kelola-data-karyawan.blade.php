@extends('layout.v-home', ['title'=>'Kelola Data Karyawan - HR'])

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kelola Data Karyawan</h4>
                <table id="datakarywan" class="table table-responsive table-striped table-borderless cell-border"
                    style="width:100%">
                    <thead class="table-dark cell-border border-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Lengkap</th>
                            <th class="text-center">Tanggal Lahir</th>
                            <th class="text-center">Nomor Whatsapp</th>
                            <th class="text-center">Alamat Lengkap</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karyawan as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_lengkap ?? 'Belum ditambahkan' }}</td>
                                <td>
                                    @if(!empty($item->tanggal_lahir))
                                    {{ \Carbon\Carbon::parse($item->tangal_lahir)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                    @else
                                        Belum ditambahkan
                                    @endif
                                </td>
                                <td>{{ $item->nomor_wa ?? 'Belum ditambahkan' }}</td>
                                <td>{{ $item->alamat_lengkap ?? 'Belum ditambahkan' }}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $item->id }}">
                                        <i class="mdi mdi-table-edit mdi-24px mx-0"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($karyawan as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-table-edit mdi-18px"></i>
                                <span class="mx-2">Edit Karyawan</span>
                            </div>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('hr.edit.data.karyawan', $item->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_lengkap-name" class="col-form-label">Nama Lengkap</label>
                                <input type="name" class="form-control rounded border-dark" id="nama_lengkap-name" name="nama_lengkap"
                                    value="{{ $item->nama_lengkap }}">
                            </div>
                            <div class="mb-3">
                                <label for="nama_lengkap-name" class="col-form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control rounded border-dark" id="nama_lengkap-name" name="tanggal_lahir"
                                    value="{{ $item->tanggal_lahir ?? 'Belum ditambahkan' }}">
                            </div>
                            <div class="mb-3">
                                <label for="nama_lengkap-name" class="col-form-label">Nomor WhatsApp</label>
                                <input type="text" class="form-control rounded border-dark" id="nama_lengkap-name" name="nomor_wa"
                                    value="{{ $item->nomor_wa ?? 'Belum ditambahkan'}}">
                            </div>
                            <div class="mb-3">
                                <label for="pilih-text" class="col-form-label">Alamat Lengkap</label>
                                <div class="form-floating">
                                    <textarea class="form-control rounded border-dark" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="alamat_lengkap">{{ $item->alamat_lengkap ?? 'Belum ditambahkan' }}</textarea>
                                    <label for="floatingTextarea2">Masukkan alamat disini</label>
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
        new DataTable('#datakarywan');
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
