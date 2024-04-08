<?php

namespace App\Http\Controllers\Human;

use App\Http\Controllers\Controller;
use App\Models\HumanResourcesM;
use App\Models\KaryawanModel;
use App\Models\NotifikasiM;
use Illuminate\Http\Request;

class DataKaryawanC extends Controller
{
    public function index(){
        $user_id = auth()->id();
        $hr = HumanResourcesM::where('user_id', $user_id)->first();
        $karyawan = KaryawanModel::all();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $data = [
            'hr'=> $hr,
            'karyawan'=> $karyawan,
            'notifikasi'=> $notifikasi,
            'jumlah_notif'=> $jumlah_notif,
        ];
        return view('human.v-kelola-data-karyawan', $data);
    }

    public function edit(Request $request , $id){

        $karyawan = KaryawanModel::find($id);
        if (!$karyawan) {
            // Handle jika data karyawan tidak ditemukan
            alert()->toast('Karyawan tidak ditemukan', 'error');
            return redirect()->back();
        }

        $karyawan->nama_lengkap = $request->input('nama_lengkap');
        $karyawan->nomor_wa = $request->input('nomor_wa');
        $karyawan->tanggal_lahir = $request->input('tanggal_lahir');
        $karyawan->alamat_lengkap = $request->input('alamat_lengkap');

        if ($karyawan->save()) {
            alert()->toast('Karyawan berhasil diubah', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Karyawan tidak berhasil diubah', 'error');
            return redirect()->back();
        }
    }

}
