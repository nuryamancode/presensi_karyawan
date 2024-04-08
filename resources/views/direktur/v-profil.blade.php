@extends('layout.v-home', ['title' => 'Profil - Direktur'])

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <a href="{{ route('direktur.dashboard') }}" style="text-decoration: none; color: #000;">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-chevron-left mdi-24px"></i>
                            <span class="mx-2">Kembali</span>
                        </div>
                    </a>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h4 class="card-title">Profil</h4>
                <form action="{{ route('direktur.edit.profil') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-2">
                            @if ($direktur->foto_diri == null)
                                <img src="{{ asset('image/avatar-2.jpg') }}" class="border rounded border-dark p-2"
                                    alt="Profil Picture" width="200" id="previewImage">
                            @else
                                <img src="{{ asset($direktur->foto_diri) }}" class="border rounded border-dark p-3"
                                    alt="Profil Picture" width="200" id="previewImage">
                            @endif
                            <div class="mt-1" style="margin-left: 70px">
                                <div class="btn btn-primary btn-rounded">
                                    <label class="form-label text-white m-0" for="customFile1">
                                        <i class="mdi mdi-camera mdi-24px"></i>
                                    </label>
                                    <input type="file" class="form-control d-none" id="customFile1" name="foto_diri"
                                        onchange="previewFile()">
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <h6 class="fw-bold mt-3">{{ $direktur->user->email }}</h6>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Jabatan</label>
                                <h6 class="fw-bold mt-3">{{ $direktur->user->level }}</h6>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                        <input type="name" name="nama_lengkap" class="form-control rounded border-dark"
                                            value="{{ $direktur->nama_lengkap }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Nomor Whatsapp</label>
                                        <input type="text" name="nomor_wa" class="form-control rounded border-dark"
                                            value="{{ $direktur->nomor_wa ?? '' }}" pattern="[0-9]+" title="Masukkan hanya nomor">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Alamat Lengkap</label>
                                    <div class="form-floating">
                                        <textarea class="form-control rounded border-dark" placeholder="Leave a comment here" name="alamat"
                                            id="floatingTextarea2" style="height: 100px">{{ $direktur->alamat_lengkap ?? '' }}</textarea>
                                        <label for="floatingTextarea2">Masukkan alamat disini</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function previewFile() {
            var input = document.getElementById('customFile1');
            var preview = document.getElementById('previewImage');

            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
