<?php

namespace App\Http\Controllers\Human;

use App\Http\Controllers\Controller;
use App\Models\AgendaM;
use App\Models\CutiM;
use App\Models\DivisiModel;
use App\Models\HumanResourcesM;
use App\Models\JamPresensiM;
use App\Models\KaryawanModel;
use App\Models\NotifikasiM;
use App\Models\RekapM;
use App\Models\SakitM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HumanC extends Controller
{
    public function index()
    {
        $user = auth()->id();
        $hr = HumanResourcesM::where('user_id', $user)->first();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $jumlah_cuti = CutiM::select(
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as jumlah_data')
        )
            ->where('status_pengajuan', 'Disetujui')
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get();
        $jumlah_sakit = SakitM::select(
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as jumlah_data')
        )
            ->where('status_pengajuan', 'Disetujui')
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get();
        $rekap = RekapM::select(DB::raw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, COUNT(*) as jumlah_data'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();
        $manajemenuser = User::all();
        $jumlah_user = $manajemenuser->count();
        $datakaryawan = KaryawanModel::all();
        $jumlah_karyawan = $datakaryawan->count();
        $divisi = DivisiModel::all();
        $jumlah_divisi = $divisi->count();
        $agenda = AgendaM::all();
        $jumlah_agenda = $agenda->count();
        $jam = JamPresensiM::all();
        $jumlah_jam = $jam->count();
        $dinas = AgendaM::whereNotNull('foto_kunjungan')->get();
        $jumlah_dinas = $dinas->count();
        $data = [
            'hr' => $hr,
            'notifikasi' => $notifikasi,
            'jumlah_notif' => $jumlah_notif,
            'jumlah_cuti' => $jumlah_cuti,
            'jumlah_sakit' => $jumlah_sakit,
            'jumlah_dinas' => $jumlah_dinas,
            'jumlah_jam' => $jumlah_jam,
            'jumlah_agenda' => $jumlah_agenda,
            'jumlah_divisi' => $jumlah_divisi,
            'jumlah_karyawan' => $jumlah_karyawan,
            'jumlah_user' => $jumlah_user,
            'rekap' => $rekap,
        ];
        return view('human.v-dashboard', $data);
    }

    public function profil()
    {
        $user = auth()->id();
        $hr = HumanResourcesM::where('user_id', $user)->first();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $data = [
            'hr' => $hr,
            'notifikasi' => $notifikasi,
            'jumlah_notif' => $jumlah_notif,
        ];
        return view('human.v-profil', $data);
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
        $hr = HumanResourcesM::where('user_id', $user)->first();
        $hr->nama_lengkap = $request->input('nama_lengkap');
        $hr->nomor_wa = $request->input('nomor_wa');
        $hr->alamat_lengkap = $request->input('alamat');
        if ($request->hasFile('foto_diri')) {
            $file = $request->file('foto_diri');

            if ($file->isValid()) {
                $fotoName = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'image/foto_diri/' . $fotoName;
                $success = file_put_contents($path, file_get_contents($file->getRealPath()));
                if ($success !== false) {
                    $hr->foto_diri = $path;
                } else {
                    alert()->toast('Gagal menyimpan file', 'error');
                    return redirect()->back();
                }
            } else {
                alert()->toast('File tidak valid', 'error');
                return redirect()->back();
            }
        }
        if ($hr->save()) {
            alert()->toast('Profil berhasil dirubah', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Profil tidak berhasil dirubah', 'error');
            return redirect()->back();
        }
    }

    public function baca_notif($id)
    {
        $notif = NotifikasiM::findOrFail($id);
        $notif->dibaca = true;
        $notif->update();
        if ($notif->status == 'Pengajuan Cuti') {
            return redirect()->route('hr.cuti');
        } elseif ($notif->status == 'Pengajuan Sakit') {
            return redirect()->route('hr.sakit');
        } elseif ($notif->status == 'Bukti Kunjungan') {
            return redirect()->route('hr.agenda');
        } else {
            return redirect()->back();
        }
    }

    public function hapus_semua()
    {
        $user_id = auth()->id();
        $hr = HumanResourcesM::where('user_id', $user_id)->first();
        NotifikasiM::where('hr_id', $hr->id)->delete();
        alert()->toast('Notifikasi berhasil dihapus', 'success');
        return redirect()->back();
    }

    public function notifikasi_semua()
    {
        $user = auth()->id();
        $hr = HumanResourcesM::where('user_id', $user)->first();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $data = [
            'notifikasi' => $notifikasi,
            'hr' => $hr,
            'jumlah_notif' => $jumlah_notif,
        ];
        return view('human.v-notifikasi', $data);
    }
}
