<?php

use App\Http\Controllers\Auth\AuthC;
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
            return redirect('/hr');
        } elseif (Auth::user()->level == 'Direktur') {
            return redirect('/direktur');
        } elseif (Auth::user()->level == 'Karyawan') {
            return redirect()->route('employee.dashboard');
        } else {
            Auth::logout();
            return redirect('/');
        }
    }
})->middleware('web');

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthC::class, 'index'])->name('login');
    Route::get('/login', [AuthC::class, 'index'])->name('login');
    Route::post('/login', [AuthC::class, 'login'])->name('login');
    Route::get('/senreminder', [PresensiC::class, 'sendReminder'])->name('send.reminder');
});

Route::middleware('auth')->group(function (){
    Route::get('/logout', [AuthC::class, 'logout'])->name('logout');

    // Karyawan
    Route::middleware('akses:Karyawan')->prefix('/employee')->name('employee')->group(function (){
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

Route::middleware(['auth', 'akses:Direktur'])->group(function () {
    Route::get('/homedirektur', function () {
        return view('direktur.home');
    });
});

Route::middleware(['auth', 'akses:Human Resource'])->group(function () {
    Route::get('/homehuman', function () {
        return view('human.home');
    });
});
