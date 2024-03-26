<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\KaryawanModel;
use App\Models\PengaduanPresensiModel;
use App\Models\PresensiModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresensiC extends Controller
{
    public function masuk()
    {
        return view("karyawan.v-presensi-masuk");
    }
    public function pulang()
    {
        return view("karyawan.v-presensi-pulang");
    }

    public function post_presensi_masuk(Request $request)
    {
        $user = auth()->user();
        $karyawan = KaryawanModel::where("user_id", $user->id)->first();
        $base64Image = $request->foto;
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $fotoExtension = 'jpg';
        $fotoName = uniqid() . '.' . $fotoExtension;
        $path = 'image/foto_presensi/' . $fotoName;
        $success = file_put_contents(public_path($path), $image);
        if ($success !== false) {
            $post = new PresensiModel([
                'kordinat' => $request->input('kordinat'),
                'foto' => $path,
                'jam' => $request->input('jam'),
                'status_presensi' => 'Masuk',
                'tanggal' => $request->input('tanggal'),
                'karyawan_id' => $karyawan->id,
            ]);
            if ($post->save()) {
                alert()->success('Presensi Berhasil.');
                return redirect()->route('employee.dashboard');
            } else {
                alert()->error('Presensi Bermasalah.');
                return redirect()->back();
            }
        } else {
            alert()->error('Gagal menyimpan foto.');
            return redirect()->back();
        }
    }
    public function post_presensi_pulang(Request $request)
    {
        $user = auth()->user();
        $karyawan = KaryawanModel::where("user_id", $user->id)->first();
        $base64Image = $request->foto;
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $fotoExtension = 'jpg';
        $fotoName = uniqid() . '.' . $fotoExtension;
        $path = 'image/foto_presensi/' . $fotoName;
        $success = file_put_contents(public_path($path), $image);
        if ($success !== false) {
            $post = new PresensiModel([
                'kordinat' => $request->input('kordinat'),
                'foto' => $path,
                'jam' => $request->input('jam'),
                'status_presensi' => 'Pulang',
                'tanggal' => $request->input('tanggal'),
                'karyawan_id' => $karyawan->id,
            ]);
            if ($post->save()) {
                alert()->success('Presensi Berhasil.');
                return redirect()->route('employee.dashboard');
            } else {
                alert()->error('Presensi Bermasalah.');
                return redirect()->back();
            }
        } else {
            alert()->error('Gagal menyimpan foto.');
            return redirect()->back();
        }
    }

}
