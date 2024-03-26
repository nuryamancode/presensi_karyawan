<div class="section" id="user-section">
    <div id="user-detail">
        <div class="avatar">
            @if ($karyawan === null || $karyawan->foto_diri === null)
                <img src="{{ asset('image/avatar-2.jpg') }}" alt="avatar" class="imaged w64 rounded">
            @else
                <img src="{{ asset($karyawan->foto_diri) }}" alt="avatar" class="imaged w64 rounded">
            @endif
        </div>
        <div id="user-info">
            <h2 id="user-name">{{ $karyawan->nama_lengkap ?? 'No Name' }}</h2>
            <span id="user-role">{{ $karyawan->divisi->nama_divisi ?? 'Belum ditambahkan' }}</span>
        </div>
    </div>
</div>
