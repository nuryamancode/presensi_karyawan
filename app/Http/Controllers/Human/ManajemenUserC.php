<?php

namespace App\Http\Controllers\Human;

use App\Http\Controllers\Controller;
use App\Models\DirekturM;
use App\Models\DivisiModel;
use App\Models\HumanResourcesM;
use App\Models\KaryawanModel;
use App\Models\NotifikasiM;
use App\Models\User;
use Illuminate\Http\Request;

class ManajemenUserC extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $hr = HumanResourcesM::where('user_id', $user_id)->first();
        $user = User::all();
        $divisi = DivisiModel::all();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $data = [
            'hr' => $hr,
            'divisi' => $divisi,
            'user' => $user,
            'notifikasi' => $notifikasi,
            'jumlah_notif' => $jumlah_notif,
        ];
        return view('human.v-kelola-manajemen-user', $data);
    }

    public function post(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $level = $request->input('level');
        $nama_lengkap = $request->input('nama_lengkap');
        $divisi = $request->input('divisi');
        $user_exists = User::where('email', $email)->first();
        if ($user_exists) {
            return redirect()->back();
        }

        $user = User::create([
            'email' => $email,
            'password' => bcrypt($password),
            'level' => $level,
        ]);
        if ($user) {
            if ($level == "Karyawan") {
                $karyawan = KaryawanModel::create([
                    'nama_lengkap' => $nama_lengkap,
                    'user_id' => $user->id,
                    'divisi_id' => $divisi,
                ]);
                if ($karyawan->save()) {
                    alert()->toast('User Karyawan berhasil dibuat', 'success');
                    return redirect()->back();
                } else {
                    alert()->toast('User Karyawan tidak berhasil dibuat', 'error');
                    return redirect()->back();
                }
            } elseif ($level == "Direktur") {
                $direktur = DirekturM::create([
                    'nama_lengkap' => $nama_lengkap,
                    'user_id' => $user->id,
                ]);
                if ($direktur->save()) {
                    alert()->toast('User Direktur berhasil dibuat', 'success');
                    return redirect()->back();
                } else {
                    alert()->toast('User Direktur tidak berhasil dibuat', 'error');
                    return redirect()->back();
                }
            } else {
                alert()->toast('Level Tidak ada', 'error');
                return redirect()->back();
            }
        } else {
            alert()->toast('User Tidak ada', 'error');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::findOrFail($id);

        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->level = $request->input('level');

        if ($user->save()) {
            if ($request->input('level') == "Karyawan") {
                $karyawan = KaryawanModel::updateOrCreate(
                    ['user_id' => $id],
                    ['nama_lengkap' => $request->input('nama_lengkap'), 'divisi_id' => $request->input('divisi')]
                );
                $message = $karyawan ? 'User Karyawan berhasil diubah' : 'User Karyawan tidak berhasil diubah';
            } elseif ($request->input('level') == "Direktur") {
                $direktur = DirekturM::updateOrCreate(
                    ['user_id' => $id],
                    ['nama_lengkap' => $request->input('nama_lengkap')]
                );
                $message = $direktur ? 'User Direktur berhasil diubah' : 'User Direktur tidak berhasil diubah';
            } else {
                $message = 'Level tidak valid';
            }

            alert()->toast($message, $message ? 'success' : 'error');
        } else {
            alert()->toast('User tidak ditemukan', 'error');
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        alert()->toast('User berhasil dihapus', 'success');
        return redirect()->back();
    }
}
