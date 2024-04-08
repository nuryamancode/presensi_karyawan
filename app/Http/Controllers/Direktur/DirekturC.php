<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\AgendaM;
use App\Models\DirekturM;
use App\Models\RekapM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirekturC extends Controller
{
    public function index()
    {
        $user = auth()->id();
        $direktur = DirekturM::where('user_id', $user)->first();
        $rekap = RekapM::select(DB::raw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, COUNT(*) as jumlah_data'))
        ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
        ->get();
        $semua_rekap = RekapM::all();
        $semua_dinas = AgendaM::whereNotNull('foto_kunjungan')->get();
        $jumlah_data_dinas = $semua_dinas->count();
        $jumlah_data = $semua_rekap->count();
        $data = [
            'direktur' => $direktur,
            'rekap' => $rekap,
            'jumlah_data' => $jumlah_data,
            'jumlah_data_dinas' => $jumlah_data_dinas,
        ];
        return view('direktur.v-dashboard', $data);
    }
    public function profil()
    {
        $user = auth()->id();
        $direktur = DirekturM::where('user_id', $user)->first();
        $data = [
            'direktur' => $direktur,
        ];
        return view('direktur.v-profil', $data);
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
        $direktur = DirekturM::where('user_id', $user)->first();
        $direktur->nama_lengkap = $request->input('nama_lengkap');
        $direktur->nomor_wa = $request->input('nomor_wa');
        $direktur->alamat_lengkap = $request->input('alamat');
        if ($request->hasFile('foto_diri')) {
            $file = $request->file('foto_diri');

            if ($file->isValid()) {
                $fotoName = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'image/foto_diri/' . $fotoName;
                $success = file_put_contents($path, file_get_contents($file->getRealPath()));
                if ($success !== false) {
                    $direktur->foto_diri = $path;
                } else {
                    alert()->toast('Gagal menyimpan file', 'error');
                    return redirect()->back();
                }
            } else {
                alert()->toast('File tidak valid', 'error');
                return redirect()->back();
            }
        }
        if ($direktur->save()) {
            alert()->toast('Profil berhasil dirubah', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Profil tidak berhasil dirubah', 'error');
            return redirect()->back();
        }
    }
}
