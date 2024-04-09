<?php

use App\Http\Controllers\Auth\AuthC;
use App\Http\Controllers\Direktur\DirekturC;
use App\Http\Controllers\Direktur\LaporanDinasC;
use App\Http\Controllers\Direktur\LaporanKehadiranC;
use App\Http\Controllers\Human\AgendaC as HumanAgendaC;
use App\Http\Controllers\Human\DataKaryawanC;
use App\Http\Controllers\Human\DivisiC;
use App\Http\Controllers\Human\HumanC;
use App\Http\Controllers\Human\JamPresensiC;
use App\Http\Controllers\Human\KelolaLaporanC;
use App\Http\Controllers\Human\KelolaPerijinanC;
use App\Http\Controllers\Human\ManajemenUserC;
use App\Http\Controllers\Karyawan\AgendaC;
use App\Http\Controllers\Karyawan\KaryawanC;
use App\Http\Controllers\Karyawan\PengaduanPresensiC;
use App\Http\Controllers\Karyawan\PerijinanC;
use App\Http\Controllers\Karyawan\PresensiC;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    if (Auth::check()) {
        if (Auth::user()->level == 'Human Resource') {
            return redirect()->route('hr.dashboard');
        } elseif (Auth::user()->level == 'Direktur') {
            return redirect()->route('direktur.dashboard');
        } elseif (Auth::user()->level == 'Karyawan') {
            return redirect()->route('employee.dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
})->middleware('web');

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthC::class, 'index'])->name('login');
    Route::get('/login', [AuthC::class, 'index'])->name('login');
    Route::post('/login', [AuthC::class, 'login'])->name('login');
    Route::get('/lupa-password', [AuthC::class, 'forget_password'])->name('password.request');
    Route::post('/lupa-password', [AuthC::class, 'forget_password_send'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthC::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [AuthC::class, 'reset_password'])->name('password.update');

});

Route::middleware('auth')->group(function (){
    Route::get('/logout', [AuthC::class, 'logout'])->name('logout');

    // Karyawan
    Route::middleware('akses:Karyawan')->prefix('/employee')->name('employee')->group(function (){
        //notifikasi
        Route::get('/baca-notif/{id}', [KaryawanC::class, 'baca_notif'])->name('.baca.notif');
        Route::get('/hapus-notif', [KaryawanC::class, 'hapus_semua'])->name('.hapus.notif');
        Route::get('/notifikasi-semua', [KaryawanC::class, 'notifikasi_semua'])->name('.notifikasi.semua');

        // presensi
        Route::get('/', [KaryawanC::class, 'index'])->name('.dashboard');
        Route::get('/notifikasi', [KaryawanC::class, 'notifikasi'])->name('.notifikasi');
        Route::get('/presensi/masuk', [PresensiC::class, 'masuk'])->name('.presensi.masuk');
        Route::get('/presensi/pulang', [PresensiC::class, 'pulang'])->name('.presensi.pulang');
        Route::get('/presensi/masuk/{id}', [PengaduanPresensiC::class, 'pengaduan_presensi_masuk'])->name('.pengaduan.presensi.masuk');
        Route::get('/presensi/pulang/{id}', [PengaduanPresensiC::class, 'pengaduan_presensi_pulang'])->name('.pengaduan.presensi.pulang');
        Route::post('/presensi/masuk', [PresensiC::class, 'post_presensi_masuk'])->name('.post.presensi.masuk');
        Route::post('/presensi/pulang', [PresensiC::class, 'post_presensi_pulang'])->name('.post.presensi.pulang');
        Route::post('/presensi/masuk/alasan', [PengaduanPresensiC::class, 'post_pengaduan_presensi_masuk'])->name('.post.pengaduan.presensi.masuk');
        Route::post('/presensi/pulang/alasan', [PengaduanPresensiC::class, 'post_pengaduan_presensi_pulang'])->name('.post.pengaduan.presensi.pulang');
        Route::post('/presensi/masuk/alasan/post', [PengaduanPresensiC::class, 'post_presensi_masuk_pengaduan'])->name('.post.presensi.masuk.with.alasan');
        Route::post('/presensi/pulang/alasan/post', [PengaduanPresensiC::class, 'post_presensi_pulang_pengaduan'])->name('.post.presensi.pulang.with.alasan');

        // profil
        Route::get('/profil', [KaryawanC::class, 'profil'])->name('.profil');
        Route::get('/profil/informasi-pribadi', [KaryawanC::class, 'informasi_pribadi'])->name('.informasi.pribadi');
        Route::put('/profil/informasi-pribadi/edit', [KaryawanC::class, 'edit_profil'])->name('.edit.profil');
        Route::get('/profil/ganti-password', [KaryawanC::class, 'ganti_password'])->name('.ganti.password');
        Route::put('/profil/ganti/password', [KaryawanC::class, 'post_password'])->name('.post.ganti.password');

        // perijinan
        Route::get('/perijinan', [PerijinanC::class, 'index'])->name('.perijinan');
        Route::post('/perijinan/cuti/post', [PerijinanC::class, 'post_cuti'])->name('.perijinan.cuti');
        Route::post('/perijinan/sakit/post', [PerijinanC::class, 'post_sakit'])->name('.perijinan.sakit');

        // agenda
        Route::get('/agenda', [AgendaC::class, '__invoke'])->name('.agenda');
        Route::put('/agenda/foto_kunjungan', [AgendaC::class, 'post_kunjungan'])->name('.post.kunjungan');

    });
    // Karyawan
});

Route::middleware(['auth', 'akses:Direktur'])->prefix('/direktur')->name('direktur')->group(function () {
    // dashboard
    Route::get('/', [DirekturC::class, 'index'])->name('.dashboard');

    // profil
    Route::get('/profil', [DirekturC::class, 'profil'])->name('.profil');
    Route::put('/edit-profi;', [DirekturC::class, 'edit_profil'])->name('.edit.profil');

    // laporan dinas
    Route::get('/laporan-dinas', [LaporanDinasC::class, 'index'])->name('.laporan.dinas');
    Route::get('/laporan-dinas-print', [LaporanDinasC::class, 'laporan_dinas_print'])->name('.laporan.dinas.print');

    // laporan kehadiran
    Route::get('/laporan-kehadiran', [LaporanKehadiranC::class, 'index'])->name('.laporan.kehadiran');
    Route::get('/laporan-kehadiran-filter', [LaporanKehadiranC::class, 'filter_laporan'])->name('.filter.laporan.kehadiran');
    Route::get('/laporan-kehadiran-print', [LaporanKehadiranC::class, 'print_laporan'])->name('.print.laporan.kehadiran.filter');
    Route::get('/laporan-kehadiran-print-all', [LaporanKehadiranC::class, 'print_laporan_tanpa_filter'])->name('.print.laporan.kehadiran');

});

Route::middleware(['auth', 'akses:Human Resource'])->prefix('/hr')->name('hr')->group(function () {
    // dashboard
    Route::get('/', [HumanC::class, 'index'])->name('.dashboard');

    // notifikasi
    Route::get('/baca-notifikasi/{id}', [HumanC::class, 'baca_notif'])->name('.baca.notifikasi');
    Route::get('/hapus-notifikasi', [HumanC::class, 'hapus_semua'])->name('.hapus.notifikasi');
    Route::get('/notifikasi', [HumanC::class, 'notifikasi_semua'])->name('.notifikasi');

    // profil
    Route::get('/profil', [HumanC::class, 'profil'])->name('.profil');
    Route::put('/edit-profil', [HumanC::class, 'edit_profil'])->name('.edit.profil');

    // manajemen user
    Route::get('/manajemen-user', [ManajemenUserC::class, 'index'])->name('.manajeman.user');
    Route::get('/manajemen-user-delete/{id}', [ManajemenUserC::class, 'delete'])->name('.delete.manajeman.user');
    Route::post('/manajemen-user-post', [ManajemenUserC::class, 'post'])->name('.post.manajeman.user');
    Route::put('/manajemen-user-edit/{id}', [ManajemenUserC::class, 'edit'])->name('.edit.manajeman.user');

    // data karyawan
    Route::get('/data-karyawan', [DataKaryawanC::class, 'index'])->name('.data.karyawan');
    Route::put('/data-karyawan-edit/{id}', [DataKaryawanC::class, 'edit'])->name('.edit.data.karyawan');

    // divisi
    Route::get('/divisi', [DivisiC::class, 'index'])->name('.divisi');
    Route::get('/divisi-delete/{id}', [DivisiC::class, 'delete'])->name('.delete.divisi');
    Route::post('/divisi-post', [DivisiC::class, 'post'])->name('.post.divisi');
    Route::put('/divisi-edit/{id}', [DivisiC::class, 'edit'])->name('.edit.divisi');

    // agenda
    Route::get('/agenda', [HumanAgendaC::class, 'index'])->name('.agenda');
    Route::get('/agenda-delete/{id}', [HumanAgendaC::class, 'delete'])->name('.delete.agenda');
    Route::put('/agenda-edit/{id}', [HumanAgendaC::class, 'edit'])->name('.edit.agenda');
    Route::post('/agenda-post', [HumanAgendaC::class, 'post'])->name('.post.agenda');

    // jampresensi
    Route::get('/jam-presensi', [JamPresensiC::class, 'index'])->name('.jam.presensi');
    Route::get('/jam-presensi-delete/{id}', [JamPresensiC::class, 'delete'])->name('.delete.jam.presensi');
    Route::put('/jam-presensi-edit/{id}', [JamPresensiC::class, 'edit'])->name('.edit.jam.presensi');
    Route::post('/jam-presensi-post', [JamPresensiC::class, 'post'])->name('.post.jam.presensi');

    // ijin cuti
    Route::get('/cuti', [KelolaPerijinanC::class, 'cuti'])->name('.cuti');
    Route::get('/cuti-delete/{id}', [KelolaPerijinanC::class, 'delete_cuti'])->name('.delete.cuti');
    Route::put('/cuti-disetujui/{id}', [KelolaPerijinanC::class, 'cuti_disetujui'])->name('.setujui.cuti');
    Route::put('/cuti-tidakdisetujui/{id}', [KelolaPerijinanC::class, 'cuti_tidak_disetujui'])->name('.tolak.cuti');


    // ijin sakit
    Route::get('/sakit', [KelolaPerijinanC::class, 'sakit'])->name('.sakit');
    Route::get('/sakit-download-file/{file}', [KelolaPerijinanC::class, 'download_file_sakit'])->name('.download.file.sakit');
    Route::get('/sakit-delete/{id}', [KelolaPerijinanC::class, 'delete_sakit'])->name('.delete.sakit');
    Route::put('/sakit-disetujui/{id}', [KelolaPerijinanC::class, 'sakit_disetujui'])->name('.setujui.sakit');
    Route::put('/sakit-ditolak/{id}', [KelolaPerijinanC::class, 'sakit_tidak_disetujui'])->name('.tolak.sakit');

    // laporan dinas
    Route::get('/laporan-dinas', [KelolaLaporanC::class, 'laporan_dinas'])->name('.laporan.dinas');
    Route::get('/laporan-dinas-pdf', [KelolaLaporanC::class, 'laporan_dinas_pdf'])->name('.laporan.dinas.pdf');

    // laporan rekap
    Route::get('/laporan-rekap', [KelolaLaporanC::class, 'rekap_kehadiran'])->name('.laporan.rekap');
    Route::post('/laporan-rekap-post', [KelolaLaporanC::class, 'post_rekap'])->name('.laporan.rekap.post');

});
