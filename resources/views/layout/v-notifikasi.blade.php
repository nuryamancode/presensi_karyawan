@if (Auth::user()->level == 'Human Resource')
    <div style="margin-left: 30px">
        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
            id="notificationDropdown" href="#" data-bs-toggle="dropdown">
            <i class="mdi mdi-bell mdi-spin mx-0"></i>
            @if ($jumlah_notif == 0)
                {{ null }}
            @else
                <span class="count bg-success">{{ $jumlah_notif }}</span>
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown"
            style="margin-left: 20px">
            <div class="row">
                <div class="col">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifikasi</p>
                </div>
                <div class="col">
                    <div class="text-end" style="margin-right: 20px; margin-top: 5px">
                        @if (!$notifikasi->isEmpty())
                            <a href="" class="pl-4" style="color: #f80000"
                                onclick="hapusData('{{ route('hr.hapus.notifikasi') }}')">
                                <i class="mdi mdi-delete-sweep mx-0 mdi-18px"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="item" style="margin-left: 10px">
                @if ($notifikasi->isEmpty())
                    <div class="text-center">
                        <h6 class="fw-bold">Notifikasi belum ada</h6>
                    </div>
                @else
                    @foreach ($notifikasi as $item)
                        @if ($item->status == 'Pengajuan Sakit')
                            <a class="dropdown-item preview-item {{ $item->dibaca == false ? '' : 'disabled' }}"
                                href="{{ route('hr.baca.notifikasi', $item->id) }}">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-danger">
                                        <i class="mdi mdi-medical-bag mdi-light mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-bold fw-bold">
                                        {{ $item->judul }}
                                        @if ($item->dibaca == false)
                                            <span class="bg-danger p-1" style="color: #fff">Belum Dilihat</span>
                                        @else
                                            <span class="bg-success p-1" style="color: #fff">Sudah Dilihat</span>
                                        @endif
                                    </h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        {{ Str::limit($item->keterangan, 50) }}
                                    </p>
                                </div>
                            </a>
                        @elseif($item->status == 'Pengajuan Cuti')
                            <a class="dropdown-item preview-item {{ $item->dibaca == false ? '' : 'disabled' }}"
                                href="{{ route('hr.baca.notifikasi', $item->id) }}">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-primary">
                                        <i class="mdi mdi-car mdi-light mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-bold fw-bold">
                                        {{ $item->judul }}
                                        @if ($item->dibaca == false)
                                            <span class="bg-danger p-1" style="color: #fff">Belum Dilihat</span>
                                        @else
                                            <span class="bg-success p-1" style="color: #fff">Sudah Dilihat</span>
                                        @endif
                                    </h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        {{ Str::limit($item->keterangan, 50) }}
                                    </p>
                                </div>
                            </a>
                        @elseif($item->status == 'Bukti Kunjungan')
                            <a class="dropdown-item preview-item {{ $item->dibaca == false ? '' : 'disabled' }}"
                                href="{{ route('hr.baca.notifikasi', $item->id) }}">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-warning">
                                        <i class="mdi mdi-calendar-multiple mdi-light mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-bold fw-bold">
                                        {{ $item->judul }}
                                        @if ($item->dibaca == false)
                                            <span class="bg-danger p-1" style="color: #fff">Belum Dilihat</span>
                                        @else
                                            <span class="bg-success p-1" style="color: #fff">Sudah Dilihat</span>
                                        @endif
                                    </h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        {{ Str::limit($item->keterangan, 50) }}
                                    </p>
                                </div>
                            </a>
                        @endif
                    @endforeach
                @endif
                @if (!$notifikasi->isEmpty())
                    <a class="dropdown-item preview-item" href="{{ route('hr.notifikasi') }}">
                        <div class="preview-item-content text-center">
                            <h6 class="preview-subject font-weight-bold fw-bold">Lihat Semua</h6>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
