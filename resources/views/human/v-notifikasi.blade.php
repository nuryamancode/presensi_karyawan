@extends('layout.v-home', ['title' => 'Notifikasi - HR'])

@section('content')
    <style>
        a {
            text-decoration: none;
            color: #000;
        }

        a.disabled {
            pointer-events: none;
            opacity: 0.6;
        }

        a:hover {
            color: #000;
        }
    </style>
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <a href="{{ route('hr.dashboard') }}">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-chevron-left mdi-24px"></i>
                            <span class="mx-2">Kembali</span>
                        </div>
                    </a>
                </div>
                <div class="row">
                    <div class="col">
                        <h4 class="card-title">Notifikasi</h4>
                    </div>
                    <div class="col text-end">
                        @if (!$notifikasi->isEmpty())
                            <a href="" class="pl-4" style="color: #f80000"
                                onclick="hapusData('{{ route('hr.hapus.notifikasi') }}')">
                                <i class="mdi mdi-delete-sweep mx-0 mdi-36px"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="item">
                    @if ($notifikasi->isEmpty())
                        <div class="text-center">
                            <h6 class="fw-bold">Belum ada notifikasi</h6>
                        </div>
                    @else
                        @foreach ($notifikasi as $item)
                            @if ($item->status == 'Pengajuan Sakit')
                                <a href="{{ route('hr.baca.notifikasi', $item->id) }}"
                                    class="notifikasi-link {{ $item->dibaca ? 'disabled' : '' }}">
                                    <div class="card mb-3 bg-warning">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="mdi mdi-medical-bag mx-2"></i>
                                                    <h6 class="fw-bold">{{ $item->judul }}</h6>
                                                </div>
                                                <span class="bg-{{ $item->dibaca ? 'success' : 'danger' }} p-1"
                                                    style="color: #fff">{{ $item->dibaca ? 'Sudah Dilihat' : 'Belum Dilihat' }}</span>
                                            </div>
                                            <p class="mx-3">{{ $item->keterangan }}</p>
                                        </div>
                                    </div>
                                </a>
                            @elseif($item->status == 'Pengajuan Cuti')
                                <a href="{{ route('hr.baca.notifikasi', $item->id) }}"
                                    class="notifikasi-link {{ $item->dibaca ? 'disabled' : '' }}">
                                    <div class="card mb-3 bg-warning">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="mdi mdi-car mx-2"></i>
                                                    <h6 class="fw-bold">{{ $item->judul }}</h6>
                                                </div>
                                                <span class="bg-{{ $item->dibaca ? 'success' : 'danger' }} p-1"
                                                    style="color: #fff">{{ $item->dibaca ? 'Sudah Dilihat' : 'Belum Dilihat' }}</span>
                                            </div>
                                            <p class="mx-3">{{ $item->keterangan }}</p>
                                        </div>
                                    </div>
                                </a>
                            @elseif($item->status == 'Bukti Kunjungan')
                                <a href="{{ route('hr.baca.notifikasi', $item->id) }}"
                                    class="notifikasi-link {{ $item->dibaca ? 'disabled' : '' }}">
                                    <div class="card mb-3 bg-warning">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="mdi mdi-calendar-multiple mx-2"></i>
                                                    <h6 class="fw-bold">{{ $item->judul }}</h6>
                                                </div>
                                                <span class="bg-{{ $item->dibaca ? 'success' : 'danger' }} p-1"
                                                    style="color: #fff">{{ $item->dibaca ? 'Sudah Dilihat' : 'Belum Dilihat' }}</span>
                                            </div>
                                            <p class="mx-3">{{ $item->keterangan }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
