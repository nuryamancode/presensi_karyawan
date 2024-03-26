@extends('karyawan.layout.v-home', ['title' => 'Profil Karyawan'])

@section('section-content')
    @include('karyawan.layout.v-loader')
    <div class="appHeader text-light" style="background-color: #092c9f">
        <div class="left">
        </div>
        <div class="pageTitle">Profil Karyawan</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-3 mt-2">
                        <a class="btn btn-primary" href="{{ route('employee.informasi.pribadi') }}"><ion-icon name="people-outline"></ion-icon> Informasi Pribadi</a>
                        <a class="btn btn-warning" href="{{ route('employee.ganti.password') }}"><ion-icon name="lock-closed-outline"></ion-icon> Ganti Password</a>
                        <a class="btn btn-danger"  href="{{ route('logout') }}"><ion-icon name="log-in-outline"></ion-icon> Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
