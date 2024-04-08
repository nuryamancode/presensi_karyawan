<nav class="navbar top-navbar col-lg-12 col-12 p-0">
    <div class="container-fluid">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
            @include('layout.v-notifikasi')
            <div class="text-center navbar-brand-wrapper ms-4 d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo"><img src="{{ asset('image/logo.png') }}"
                        alt="logo"/>
                        <span class="fw-bold">MARECA</span>
                </a>
                <a class="navbar-brand brand-logo-mini"><img src="{{ asset('image/logo.png') }}"
                        alt="logo" /></a>
            </div>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown d-lg-flex d-none">
                </li>
                <li class="nav-item dropdown d-lg-flex d-none">
                </li>
                <li class="nav-item dropdown d-lg-flex d-none">
                </li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                        @if (Auth::user()->level == 'Human Resource')
                            <span class="nav-profile-name">{{ $hr->nama_lengkap }}</span>
                            @if ($hr == null || $hr->foto_diri == null)
                                <img src="{{ asset('image/avatar-2.jpg') }}" alt="profile" />
                            @else
                                <img src="{{ asset($hr->foto_diri) }}" alt="profile" />
                            @endif
                        @elseif(Auth::user()->level == 'Direktur')
                            <span class="nav-profile-name">{{ $direktur->nama_lengkap }}</span>
                            @if ($direktur == null || $direktur->foto_diri == null)
                                <img src="{{ asset('image/avatar-2.jpg') }}" alt="profile" />
                            @else
                                <img src="{{ asset($direktur->foto_diri) }}" alt="profile" />
                            @endif
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        @if (Auth::user()->level == 'Human Resource')
                            @php
                                $isActive = Str::startsWith(request()->path(), 'hr/profil');
                            @endphp
                            <a class="dropdown-item {{ $isActive ? 'active' : '' }}" href="{{ route('hr.profil') }}">
                                <i
                                    class="mdi {{ $isActive ? 'mdi-account-box mdi-light' : 'mdi-account-box text-primary' }}"></i>
                                Profil
                            </a>
                        @elseif(Auth::user()->level == 'Direktur')
                            @php
                                $isActive = Str::startsWith(request()->path(), 'direktur/profil');
                            @endphp
                            <a class="dropdown-item {{ $isActive ? 'active' : '' }}"
                                href="{{ route('direktur.profil') }}">
                                <i
                                    class="mdi {{ $isActive ? 'mdi-account-box mdi-light' : 'mdi-account-box text-primary' }}"></i>
                                Profil
                            </a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="mdi mdi-logout text-primary"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
