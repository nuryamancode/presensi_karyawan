<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation">
            @if (Auth::user()->level == 'Human Resource')
                <li class="nav-item {{ 'hr' == request()->path() ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('hr.dashboard') }}">
                        <i class="mdi mdi-view-dashboard menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item {{ Str::startsWith(request()->path(), 'hr/manajemen-user') ? 'active' : '' }}">
                    <a href="{{ route('hr.manajeman.user') }}" class="nav-link">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">Manajemen User</span>
                        <i class="menu-arrow"></i>
                    </a>
                </li>
                <li class="nav-item {{ Str::startsWith(request()->path(), 'hr/data-karyawan') ? 'active' : '' }}">
                    <a href="{{ route('hr.data.karyawan') }}" class="nav-link">
                        <i class="mdi mdi-human-male-female menu-icon"></i>
                        <span class="menu-title">Data Karyawan</span>
                        <i class="menu-arrow"></i>
                    </a>
                </li>
                <li class="nav-item {{ Str::startsWith(request()->path(), 'hr/divisi') ? 'active' : '' }}">
                    <a href="{{ route('hr.divisi') }}" class="nav-link">
                        <i class="mdi mdi-briefcase-check menu-icon"></i>
                        <span class="menu-title">Divisi</span>
                        <i class="menu-arrow"></i>
                    </a>
                </li>
                <li class="nav-item {{ Str::startsWith(request()->path(), 'hr/agenda') ? 'active' : '' }}">
                    <a href="{{ route('hr.agenda') }}" class="nav-link">
                        <i class="mdi mdi-calendar-text menu-icon"></i>
                        <span class="menu-title">Agenda</span>
                        <i class="menu-arrow"></i>
                    </a>
                </li>
                <li class="nav-item {{ Str::startsWith(request()->path(), 'hr/jam-presensi') ? 'active' : '' }}">
                    <a href="{{ route('hr.jam.presensi') }}" class="nav-link">
                        <i class="mdi mdi-clock menu-icon"></i>
                        <span class="menu-title">Jam Presensi</span>
                        <i class="menu-arrow"></i>
                    </a>
                </li>
                <li
                    class="nav-item {{ Str::startsWith(request()->path(), 'hr/laporan-dinas') ? 'active' : '' }} {{ Str::startsWith(request()->path(), 'hr/laporan-rekap') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title">Laporan</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul>
                            <li
                                class="nav-item {{ Str::startsWith(request()->path(), 'hr/laporan-rekap') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('hr.laporan.rekap') }}">Laporan Rekap
                                    Kehadiran</a>
                            </li>
                            <li
                                class="nav-item {{ Str::startsWith(request()->path(), 'hr/laporan-dinas') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('hr.laporan.dinas') }}">Laporan Dinas
                                    Karyawan</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li
                    class="nav-item {{ Str::startsWith(request()->path(), 'hr/cuti') ? 'active' : '' }} {{ Str::startsWith(request()->path(), 'hr/sakit') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="mdi mdi-clipboard-alert menu-icon"></i>
                        <span class="menu-title">Perizinan</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul>
                            <li class="nav-item {{ Str::startsWith(request()->path(), 'hr/cuti') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('hr.cuti') }}">Izin Cuti</a>
                            </li>
                            <li class="nav-item {{ Str::startsWith(request()->path(), 'hr/sakit') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('hr.sakit') }}">Izin Sakit</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @elseif(Auth::user()->level == 'Direktur')
                <li class="nav-item {{ 'direktur' == request()->path() ? 'active' : '' }}">
                    <a href="{{ route('direktur.dashboard') }}" class="nav-link">
                        <i class="mdi mdi-chart-areaspline menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                        <i class="menu-arrow"></i>
                    </a>
                </li>
                <li class="nav-item {{ Str::startsWith(request()->path(), 'direktur/laporan-kehadiran') ? 'active' : '' }}">
                    <a href="{{ route('direktur.laporan.kehadiran') }}" class="nav-link">
                        <i class="mdi mdi-chart-areaspline menu-icon"></i>
                        <span class="menu-title">Laporan Kehadiran</span>
                        <i class="menu-arrow"></i>
                    </a>
                </li>
                <li class="nav-item {{ Str::startsWith(request()->path(), 'direktur/laporan-dinas') ? 'active' : '' }}">
                    <a href="{{ route('direktur.laporan.dinas') }}" class="nav-link">
                        <i class="mdi mdi-chart-areaspline menu-icon"></i>
                        <span class="menu-title">Laporan Dinas Karyawan</span>
                        <i class="menu-arrow"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
