<?php

namespace App\Http\Controllers\Human;

use App\Http\Controllers\Controller;
use App\Models\AgendaM;
use App\Models\HumanResourcesM;
use App\Models\KaryawanModel;
use App\Models\NotifikasiM;
use Illuminate\Http\Request;

class AgendaC extends Controller
{

    public function index()
    {
        $user_id = auth()->id();
        $hr = HumanResourcesM::where("user_id", $user_id)->first();
        $agenda = AgendaM::orderBy('created_at','desc')->get();
        $karyawan = KaryawanModel::all();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $data = [
            'karyawan' => $karyawan,
            'agenda' => $agenda,
            'hr' => $hr,
            'notifikasi' => $notifikasi,
            'jumlah_notif' => $jumlah_notif,
        ];
        return view('human.v-kelola-agenda', $data);
    }


    public function post(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'nama_event' => 'required',
            'alamat_lokasi' => 'required',
            'keterangan' => 'required',
        ], [
            'tanggal_mulai.required' => 'Tanggal Mulai harus diisi',
            'tanggal_mulai.date' => 'Tanggal Mulai harus berupa format tanggal',
            'tanggal_mulai.after_or_equal' => 'Tanggal Mulai harus sesudah hari ini',
            'tanggal_selesai.required' => 'Tanggal Selesai harus diisi',
            'tanggal_selesai.date' => 'Tanggal Selesai harus berupa format tanggal',
            'tanggal_selesai.after_or_equal' => 'Tanggal Selesai harus sesudah tanggal mulai',
        ]);
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');
        $nama_event = $request->input('nama_event');
        $alamat_lokasi = $request->input('alamat_lokasi');
        $keterangan = $request->input('keterangan');
        $karyawanID = $request->input('karyawan_id');
        $karyawan = KaryawanModel::findOrFail($karyawanID);
        $agenda = new AgendaM([
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'nama_event' => $nama_event,
            'alamat_lokasi' => $alamat_lokasi,
            'keterangan' => $keterangan,
            'karyawan_id' => $karyawan->id,
        ]);
        if ($agenda->save()) {
            $notifikasi_sistem = new NotifikasiM([
                'judul' => 'HR menambahkan agenda',
                'keterangan' => 'HR menambahkan agenda untuk kamu',
                'status' => 'Agenda',
                'karyawan_id'=>$karyawan->id,
            ]);
            $notifikasi_sistem->save();
            $token = 'Srywn8zTBvwwsZJ8WzA#';
            $message = "Halo Karyawan *{$karyawan->nama_lengkap}*,\nHR sudah menambahkan agenda yang bernama {$nama_event} untuk kamu pada tanggal {$tanggal_mulai} sampai {$tanggal_selesai}, berlokasi pada alamat {$alamat_lokasi}.\n\nCatatan :\n{$keterangan}\n\nSalam Hormat:\nCV Mareca Yasa Media\nhttps://marecayasa.com/";
            $formattedMessage = str_replace('{$karyawan->nama_lengkap}', $karyawan->nama_lengkap, $message);
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
                    'target' => $karyawan->nomor_wa,
                    'message' => $formattedMessage,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            alert()->toast('Agenda berhasil dibuat', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Agenda tidak berhasil dibuat', 'error');
            return redirect()->back();
        }
    }

    public function edit(Request $request, string $id)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'tanggal_mulai.required' => 'Tanggal Mulai harus diisi',
            'tanggal_mulai.date' => 'Tanggal Mulai harus berupa format tanggal',
            'tanggal_mulai.after_or_equal' => 'Tanggal Mulai harus sesudah hari ini',
            'tanggal_selesai.required' => 'Tanggal Selesai harus diisi',
            'tanggal_selesai.date' => 'Tanggal Selesai harus berupa format tanggal',
            'tanggal_selesai.after_or_equal' => 'Tanggal Selesai harus sesudah tanggal mulai',
        ]);
        $agenda = AgendaM::findOrFail($id);
        $agenda->tanggal_mulai = $request->input('tanggal_mulai');
        $agenda->tanggal_selesai = $request->input('tanggal_selesai');
        $agenda->nama_event = $request->input('nama_event');
        $agenda->alamat_lokasi = $request->input('alamat_lokasi');
        $agenda->keterangan = $request->input('keterangan');
        $agenda->karyawan_id = $request->input('karyawan_id');
        if ($agenda->update()) {
            alert()->toast('Agenda berhasil diubah', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Agenda tidak berhasil diubah', 'error');
            return redirect()->back();
        }
    }

    public function delete(string $id)
    {
        $agenda = AgendaM::findOrFail($id);
        $agenda->delete();
        alert()->toast('Agenda berhasil dihapus','success');
        return redirect()->back();
    }
}
