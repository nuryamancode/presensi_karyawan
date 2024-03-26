@extends('karyawan.layout.v-home', ['title' => 'Ganti Password'])

@section('section-content')
    @include('karyawan.layout.v-loader')
    <div class="appHeader text-light" style="background-color: #092c9f">
        <div class="left">
            <a href="{{ route('employee.profil') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Ganti Password</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-5">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('employee.post.ganti.password') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-user mt-5">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" aria-describedby="password"
                                    name="password">
                            </div>
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password-confirm"
                                    aria-describedby="password-confirm" name="password_confirmation">
                            </div>
                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary">Ganti</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
