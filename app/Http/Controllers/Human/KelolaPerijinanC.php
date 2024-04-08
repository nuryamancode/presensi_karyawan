<?php

namespace App\Http\Controllers\Human;

use App\Http\Controllers\Controller;
use App\Models\CutiM;
use App\Models\HumanResourcesM;
use App\Models\NotifikasiM;
use App\Models\SakitM;
use Illuminate\Http\Request;

class KelolaPerijinanC extends Controller
{
    public function cuti()
    {
        $user_id = auth()->id();
        $hr = HumanResourcesM::where('user_id', $user_id)->first();
        $cuti = CutiM::orderBy('created_at', 'desc')->get();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $data = [
            'hr' => $hr,
            'cuti' => $cuti,
            'notifikasi' => $notifikasi,
            'jumlah_notif' => $jumlah_notif,
        ];
        return view('human.v-ijin-cuti', $data);
    }

    public function cuti_disetujui($id)
    {
        $cuti = CutiM::findOrFail($id);
        $cuti->status_pengajuan = 'Disetujui';
        if ($cuti->update()) {
            $notifikasi_sistem = new NotifikasiM([
                'judul' => 'HR menyetujui pengajuan cuti',
                'keterangan' => 'HR menyetujui kamu dalam mengajukan cuti.',
                'status' => 'Pengajuan Cuti Disetujui',
                'karyawan_id'=>$cuti->karyawan->id
            ]);
            $notifikasi_sistem->save();
            $token = 'Srywn8zTBvwwsZJ8WzA#';
            $message = "Halo Karyawan *{$cuti->karyawan->nama_lengkap}*,\npengajuan cuti kamu sudah *disetujui* oleh HR.\n\n\n\n\nSalam Hormat:\nCV Mareca Yasa Media\nhttps://marecayasa.com/";
            $formattedMessage = str_replace('{$cuti->karyawan->nama_lengkap}', $cuti->karyawan->nama_lengkap, $message);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $cuti->karyawan->nomor_wa,
                    'message' => $formattedMessage,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            alert()->toast('Perijinan Cuti berhasil disetujui', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Perijinan Cuti bermasalah', 'error');
            return redirect()->back();
        }
    }
    public function cuti_tidak_disetujui(Request $request, $id)
    {
        $cuti = CutiM::findOrFail($id);
        $cuti->status_pengajuan = 'Ditolak';
        $cuti->keterangan_penolakan = $request->input('keterangan_penolakan');
        if ($cuti->update()) {
            $notifikasi_sistem = new NotifikasiM([
                'judul' => 'HR tidak menyetujui pengajuan cuti',
                'keterangan' => 'HR tidak menyetujui kamu dalam mengajukan cuti.',
                'status' => 'Pengajuan Cuti Ditolak',
                'karyawan_id'=>$cuti->karyawan->id
            ]);
            $notifikasi_sistem->save();
            $token = 'Srywn8zTBvwwsZJ8WzA#';
            $message = "Halo Karyawan *{$cuti->karyawan->nama_lengkap}*,\npengajuan cuti kamu *tidak disetujui* oleh HR, karena alasannya {$cuti->keterangan_penolakan}.\n\n\n\n\nSalam Hormat:\nCV Mareca Yasa Media\nhttps://marecayasa.com/";
            $formattedMessage = str_replace('{$cuti->karyawan->nama_lengkap}', $cuti->karyawan->nama_lengkap, $message);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $cuti->karyawan->nomor_wa,
                    'message' => $formattedMessage,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            alert()->toast('Perijinan Cuti tidak disetujui', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Perijinan Cuti bermasalah', 'error');
            return redirect()->back();
        }
    }

    public function delete_cuti($id)
    {
        $cuti = CutiM::findOrFail($id);
        $cuti->delete();
        alert()->toast('Perijinan Cuti berhasil dihapus', 'success');
        return redirect()->back();
    }


    public function sakit()
    {
        $user_id = auth()->id();
        $hr = HumanResourcesM::where('user_id', $user_id)->first();
        $sakit = SakitM::orderBy('created_at', 'desc')->get();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $data = [
            'hr' => $hr,
            'sakit' => $sakit,
            'notifikasi' => $notifikasi,
            'jumlah_notif' => $jumlah_notif,
        ];
        return view('human.v-ijin-sakit', $data);
    }

    public function download_file_sakit($file)
    {
        return response()->download(public_path('image/file_surat_sakit/' . $file));
    }

    public function sakit_disetujui($id)
    {
        $sakit = SakitM::findOrFail($id);
        $sakit->status_pengajuan = 'Disetujui';
        if ($sakit->update()) {
            $notifikasi_sistem = new NotifikasiM([
                'judul' => 'HR menyetujui pengajuan sakit',
                'keterangan' => 'HR menyetujui kamu dalam mengajukan sakit.',
                'status' => 'Pengajuan Sakit Disetujui',
                'karyawan_id'=>$sakit->karyawan->id
            ]);
            $notifikasi_sistem->save();
            $token = 'Srywn8zTBvwwsZJ8WzA#';
            $message = "Halo Karyawan *{$sakit->karyawan->nama_lengkap}*,\npengajuan sakit kamu sudah *disetujui* oleh HR, semoga cepat sembuh.\n\n\n\n\nSalam Hormat:\nCV Mareca Yasa Media\nhttps://marecayasa.com/";
            $formattedMessage = str_replace('{$sakit->karyawan->nama_lengkap}', $sakit->karyawan->nama_lengkap, $message);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $sakit->karyawan->nomor_wa,
                    'message' => $formattedMessage,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            alert()->toast('Perijinan Sakit berhasil disetujui', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Perijinan Sakit bermasalah', 'error');
            return redirect()->back();
        }
    }

    public function sakit_tidak_disetujui(Request $request, $id)
    {
        $sakit = SakitM::findOrFail($id);
        $sakit->status_pengajuan = 'Ditolak';
        $sakit->keterangan_penolakan = $request->input('keterangan_penolakan');
        if ($sakit->update()) {
            $notifikasi_sistem = new NotifikasiM([
                'judul' => 'HR tidak menyetujui pengajuan sakit',
                'keterangan' => 'HR tidak menyetujui kamu dalam mengajukan sakit.',
                'status' => 'Pengajuan Sakit Ditolak',
                'karyawan_id'=>$sakit->karyawan->id
            ]);
            $notifikasi_sistem->save();
            $token = 'Srywn8zTBvwwsZJ8WzA#';
            $message = "Halo Karyawan *{$sakit->karyawan->nama_lengkap}*,\npengajuan sakit kamu *tidak disetujui* oleh HR, karena alasannya {$sakit->keterangan_penolakan}.\n\n\n\n\nSalam Hormat:\nCV Mareca Yasa Media\nhttps://marecayasa.com/";
            $formattedMessage = str_replace('{$sakit->karyawan->nama_lengkap}', $sakit->karyawan->nama_lengkap, $message);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $sakit->karyawan->nomor_wa,
                    'message' => $formattedMessage,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            alert()->toast('Perijinan Sakit tidak disetujui', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Perijinan Sakit bermasalah', 'error');
            return redirect()->back();
        }
    }

    public function delete_sakit($id)
    {
        $sakit = SakitM::findOrFail($id);
        $imagePath = public_path('image/file_surat_sakit/') . $sakit->file_surat_sakit;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $sakit->delete();
        alert()->toast('Perijinan Sakit berhasil dihapus', 'success');
        return redirect()->back();
    }
}
