<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\KaryawanModel;
use App\Models\PresensiModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanC extends Controller
{
    public function index()
    {
        $user = auth()->id();
        $karyawan = KaryawanModel::where('user_id', $user)->first();
        $today = Carbon::today();
        $presensi_masuk_today = PresensiModel::where('karyawan_id', $karyawan->id)->where('status_presensi', 'Masuk')->whereDate('tanggal', $today)->first();
        $presensi_pulang_today = PresensiModel::where('karyawan_id', $karyawan->id)->where('status_presensi', 'Pulang')->whereDate('tanggal', $today)->first();
        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now()->endOfMonth();
        if ($endDate->isPast()) {
            $lastAvailableMonth = PresensiModel::max('tanggal')->format('Y-m');
            $endDate = Carbon::parse($lastAvailableMonth)->endOfMonth();
        }
        $presensi = PresensiModel::where('karyawan_id', $karyawan->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
        $telat = PresensiModel::where('status_presensi', 'Masuk')
            ->where('jam', '>', '09:30:00')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
        $hadir = PresensiModel::where('status_presensi', 'Masuk')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
        $total_telat = $telat->count();
        $total_hadir = $hadir->count();
        $data = [
            'karyawan' => $karyawan,
            'presensi' => $presensi,
            'total_hadir' => $total_hadir,
            'total_telat' => $total_telat,
            'presensi_masuk_today' => $presensi_masuk_today,
            'presensi_pulang_today' => $presensi_pulang_today,
        ];
        return view("karyawan.v-presensi", $data);
    }

    public function notifikasi()
    {
        $user = auth()->id();
        $karyawan = KaryawanModel::where('user_id', $user)->first();
        $today = Carbon::today();
        $presensi_masuk_today = PresensiModel::where('karyawan_id', $karyawan->id)->where('status_presensi', 'Masuk')->whereDate('tanggal', $today)->first();
        $presensi_pulang_today = PresensiModel::where('karyawan_id', $karyawan->id)->where('status_presensi', 'Pulang')->whereDate('tanggal', $today)->first();
        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now()->endOfMonth();
        if ($endDate->isPast()) {
            $lastAvailableMonth = PresensiModel::max('tanggal')->format('Y-m');
            $endDate = Carbon::parse($lastAvailableMonth)->endOfMonth();
        }
        $presensi = PresensiModel::where('karyawan_id', $karyawan->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
        $telat = PresensiModel::where('status_presensi', 'Masuk')
            ->where('jam', '>', '09:30:00')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
        $hadir = PresensiModel::where('status_presensi', 'Masuk')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
        $total_telat = $telat->count();
        $total_hadir = $hadir->count();
        $data = [
            'karyawan' => $karyawan,
            'presensi' => $presensi,
            'total_hadir' => $total_hadir,
            'total_telat' => $total_telat,
            'presensi_masuk_today' => $presensi_masuk_today,
            'presensi_pulang_today' => $presensi_pulang_today,
        ];
        return view("karyawan.v-presensi-notifikasi", $data);
    }

    public function profil()
    {
        $user = auth()->id();
        $karyawan = KaryawanModel::where('user_id', $user)->first();
        $data = [
            'karyawan' => $karyawan
        ];
        return view("karyawan.v-profil", $data);
    }

    public function ganti_password()
    {
        $user = auth()->user();
        $data = [
            'user' => $user
        ];
        return view("karyawan.v-ganti-password", $data);
    }

    public function post_password(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if (!$user) {
            abort(404);
        }
        $request->validate([
            "password" => "required|min:8|confirmed",
        ], [
            "password.required" => "Password harus diisi",
            "password.min" => "Password minimal 8 karakter",
            "password.confirmed" => "Password harus sama",
        ]);
        $user->password = Hash::make($request->input('password'));
        if ($user->save()) {
            alert()->success('Password berhasil dirubah');
            return redirect()->route('employee.profil');
        } else {
            alert()->error('Password tidak berhasil dirubah');
            return redirect()->back();
        }
    }
    public function informasi_pribadi()
    {
        $user = auth()->id();
        $karyawan = KaryawanModel::where('user_id', $user)->first();
        $data = [
            'karyawan' => $karyawan
        ];
        return view("karyawan.v-informasi-pribadi", $data);
    }
    public function edit_profil(Request $request)
    {
        $user = auth()->id();
        $request->validate([
            'foto_diri' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'foto_diri.image' => 'File harus berupa gambar',
            'foto_diri.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg',
            'foto_diri.max' => 'Ukuran gambar tidak boleh lebih dari 2MB',
        ]);
        $karyawan = KaryawanModel::where('user_id', $user)->first();
        $karyawan->nama_lengkap = $request->input('nama_lengkap');
        $karyawan->tanggal_lahir = $request->input('tanggal_lahir');
        $karyawan->nomor_wa = $request->input('no_wa');
        $karyawan->alamat_lengkap = $request->input('alamat');
        if ($request->hasFile('foto_diri')) {
            $file = $request->file('foto_diri');

            if ($file->isValid()) {
                $fotoName = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'image/foto_diri/' . $fotoName;
                $success = file_put_contents($path, file_get_contents($file->getRealPath()));
                if ($success !== false) {
                    $karyawan->foto_diri = $path;
                } else {
                    alert()->error('Gagal menyimpan file');
                    return redirect()->back();
                }
            } else {
                alert()->error('File tidak valid');
                return redirect()->back();
            }
        }
        if ($karyawan->save()) {
            alert()->success('Profil berhasil dirubah');
            return redirect()->back();
        } else {
            alert()->error('Profil tidak berhasil dirubah');
            return redirect()->back();
        }
    }
}
