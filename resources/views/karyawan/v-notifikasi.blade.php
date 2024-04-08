@extends('karyawan.layout.v-home', ['title' => 'Notifikasi'])

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
            <a href="{{ route('employee.dashboard') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Notifikasi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-5">
            <div class="card">
                <div class="card-body">
                    <ul class="listview image-listview">
                        <li class="p-3">
                            <div class="row">
                                <div class="col"><a href="#"
                                        onclick="hapusData('{{ route('employee.hapus.notif') }}')" class="p-3">Hapus
                                        Semua</a></div>
                            </div>
                        </li>
                        @if ($notifikasi->count() > 0)
                            @foreach ($notifikasi as $item)
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="alert-circle-outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>
                                                <h3 class="fw-bold">{{ $item->judul }}</h3>
                                                <span>{{ Str::limit($item->keterangan, 50) }}</span>
                                            </div>
                                            @if ($item->dibaca == false)
                                                <a class="btn btn-danger"
                                                    href="{{ route('employee.baca.notif', $item->id) }}">
                                                    Baca Notifikasi
                                                </a>
                                            @else
                                                <a class="btn btn-success disabled">
                                                    Sudah Dibaca
                                                </a>
                                            @endif
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script></script>
@endsection
