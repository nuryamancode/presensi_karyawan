@extends('karyawan.layout.v-home', ['title' => 'Informasi Pribadi'])

@section('section-content')
    <style>
        .img {
            border-radius: 20px;
            border: 1px solid #000000;
            overflow: hidden;
            width: 200px;
            height: 200px;
            margin: 0 auto;
            object-fit: cover;
        }

        .img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    @include('karyawan.layout.v-loader')
    <div class="appHeader text-light" style="background-color: #092c9f">
        <div class="left">
            <a href="{{ route('employee.profil') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Informasi Pribadi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employee.edit.profil') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="img">
                            @if ($karyawan === null || $karyawan->foto_diri === null)
                                <img id="previewImage" src="{{ asset('image/avatar-2.jpg') }}" alt="">
                            @else
                                <img id="previewImage" src="{{ asset($karyawan->foto_diri) }}" alt="">
                            @endif
                        </div>
                        <div class="d-flex justify-content-center mt-1">
                            <div class="btn btn-primary btn-rounded">
                                <label class="form-label text-white m-0" for="customFile1"><ion-icon name="camera" class="ml-1 mt-1 mb-1" style="color: #fff"></ion-icon></label>
                                <input type="file" class="form-control d-none" id="customFile1" name="foto_diri"
                                    onchange="previewFile()">
                            </div>
                        </div>
                        <div class="text-center">
                            <h4 class="fw-bold mt-2">{{ $karyawan->user->email }}</h4>
                            <h4 class="fw-bold">{{ $karyawan->divisi->nama_divisi ?? 'Belum ditambahkan' }}</h4>
                        </div>
                        <div class="form-user mt-5">
                            <h4 class="fw-bold">Informasi Pribadi</h4>
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="name" class="form-control" id="nama_lengkap" aria-describedby="name"
                                    name="nama_lengkap" value="{{ $karyawan->nama_lengkap }}">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal" aria-describedby="tanggal"
                                    name="tanggal_lahir" value="{{ $karyawan->tanggal_lahir }}">
                            </div>
                            <div class="mb-3">
                                <label for="no_wa" class="form-label">Nomor Wa</label>
                                <input type="text" class="form-control" id="no_wa" aria-describedby="no_wa"
                                    name="no_wa" value="{{ $karyawan->nomor_wa ?? 'Belum diatur' }}" pattern="[0-9]+" title="Masukkan hanya nomor" inputmode="numeric">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <input type="text" class="form-control" id="alamat" aria-describedby="alamat"
                                    name="alamat" value="{{ $karyawan->alamat_lengkap ?? 'Belum diatur' }}">
                            </div>
                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary"><ion-icon name="create-outline"></ion-icon>Ubah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
