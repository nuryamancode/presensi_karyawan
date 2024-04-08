<?php

namespace App\Http\Controllers\Human;

use App\Http\Controllers\Controller;
use App\Models\HumanResourcesM;
use App\Models\JamPresensiM;
use App\Models\NotifikasiM;
use Illuminate\Http\Request;

class JamPresensiC extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $hr = HumanResourcesM::where('user_id', $user_id)->first();
        $jam = JamPresensiM::all();
        $jumlahData = $jam->count();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $data = [
            'hr' => $hr,
            'jam' => $jam,
            'jumlahData' => $jumlahData,
            'notifikasi' => $notifikasi,
            'jumlah_notif' => $jumlah_notif,
        ];
        return view('human.v-kelola-jam-presensi', $data);
    }

    public function post(Request $request)
    {
        $request->validate([]);
        $waktu_buka = $request->input('waktu_buka');
        $waktu_tutup = $request->input('waktu_tutup');
        $waktu_telat = $request->input('waktu_telat');
        $status_jam = $request->input('status_jam');
        $existingStatus = JamPresensiM::where('status_jam', $status_jam)->exists();
        if ($existingStatus) {
            alert()->toast('Status presensi sudah ada.', 'error');
            return redirect()->back();
        }
        $jam = new JamPresensiM([
            'waktu_buka' => $waktu_buka,
            'waktu_tutup' => $waktu_tutup,
            'waktu_telat' => $waktu_telat,
            'status_jam' => $status_jam,
        ]);
        if ($jam->save()) {
            alert()->toast('Jam Presensi berhasil dibuat', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Jam Presensi tidak berhasil dibuat', 'error');
            return redirect()->back();
        }
    }

    public function edit(Request $request, string $id)
    {
        $request->validate([]);
        $jam = JamPresensiM::findOrFail($id);
        $jam->waktu_buka = $request->input('waktu_buka');
        $jam->waktu_tutup = $request->input('waktu_tutup');
        $jam->waktu_telat = $request->input('waktu_telat');
        $jam->status_jam = $request->input('status_jam');
        if ($jam->update()) {
            alert()->toast('Jam Presensi berhasil diubah', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Jam Presensi tidak berhasil diubah', 'error');
            return redirect()->back();
        }
    }

    public function delete(string $id)
    {
        $jam = JamPresensiM::findOrFail($id);
        $jam->delete();
        alert()->toast('Jam Presensi berhasil dihapus');
        return redirect()->back();
    }
}
