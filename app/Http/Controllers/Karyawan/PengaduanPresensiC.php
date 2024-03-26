<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\KaryawanModel;
use App\Models\PengaduanPresensiModel;
use App\Models\PresensiModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengaduanPresensiC extends Controller
{
    public function pengaduan_presensi_masuk($id)
    {
        $alasan = PengaduanPresensiModel::findOrFail($id);
        $data = [
            'alasan' => $alasan
        ];
        return view('karyawan.pengaduan_presensi.v-presensi_masuk_alasan', $data);
    }
    public function pengaduan_presensi_pulang($id)
    {
        $alasan = PengaduanPresensiModel::findOrFail($id);
        $data = [
            'alasan' => $alasan
        ];
        return view('karyawan.pengaduan_presensi.v-presensi_pulang_alasan', $data);
    }

    public function post_pengaduan_presensi_masuk(Request $request)
    {
        $user = auth()->user();
        $karyawan = KaryawanModel::where('user_id', $user->id)->first();
        $pengaduan = new PengaduanPresensiModel([
            'alasan_telat' => $request->input('alasan'),
            'karyawan_id' => $karyawan->id,
        ]);
        if ($pengaduan->save()) {
            return redirect()->route('employee.pengaduan.presensi.masuk', ['id' => $pengaduan->id]);
        } else {
            alert()->success('Alasan bermasalah');
            return redirect()->back();
        }
    }
    public function post_pengaduan_presensi_pulang(Request $request)
    {
        $user = auth()->user();
        $karyawan = KaryawanModel::where('user_id', $user->id)->first();
        $pengaduan = new PengaduanPresensiModel([
            'alasan_telat' => $request->input('alasan'),
            'karyawan_id' => $karyawan->id,
        ]);
        if ($pengaduan->save()) {
            return redirect()->route('employee.pengaduan.presensi.pulang', ['id' => $pengaduan->id]);
        } else {
            alert()->success('Alasan bermasalah');
            return redirect()->back();
        }
    }


    public function post_presensi_masuk_pengaduan(Request $request)
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
                'pengaduan_id' => $request->input('alasan'),
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
    public function post_presensi_pulang_pengaduan(Request $request)
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
                'pengaduan_id' => $request->input('alasan'),
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
