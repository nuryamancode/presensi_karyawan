<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\AgendaM;
use Illuminate\Http\Request;

class AgendaC extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $events = [];
        $agenda = AgendaM::with('karyawan')->get();
        foreach ($agenda as $agendaItem) {
            $events[] = [
                'title' => $agendaItem->nama_event . ' (' . $agendaItem->karyawan->nama_lengkap . ')',
                'description' => $agendaItem->keterangan,
                'alamat' => $agendaItem->alamat_lokasi,
                'id_agenda' => $agendaItem->id,
                'start' => $agendaItem->tanggal_mulai,
                'end' => $agendaItem->tanggal_selesai,
            ];
        }
        $data = [
            'events' => $events,
        ];
        return view('karyawan.v-agenda', $data);
    }

    public function post_kunjungan(Request $request)
    {
        $request->validate([
            'foto_kunjungan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'foto_kunjungan.required' => 'Foto Kunjungan wajib diisi.',
            'foto_kunjungan.image' => 'File yang diunggah harus berupa gambar.',
            'foto_kunjungan.mimes' => 'Format Foto Kunjungan harus berupa jpeg, png, atau jpg.',
            'foto_kunjungan.max' => 'Ukuran Foto Kunjungan maksimal 2MB.',
        ]);

        if ($request->hasFile('foto_kunjungan')) {
            $file = $request->file('foto_kunjungan');

            if ($file->isValid()) {
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'image/foto_kunjungan/' . $fileName;
                $success = $file->move(public_path('image/foto_kunjungan'), $fileName);

                if ($success) {
                    $agenda = AgendaM::find($request->input('id_agenda'));
                    $agenda->foto_kunjungan = $path;

                    if ($agenda->save()) {
                        alert()->success('Foto Kunjungan berhasil diunggah.');
                        return redirect()->back();
                    } else {
                        alert()->error('Gagal menyimpan data.');
                        return redirect()->back();
                    }
                } else {
                    alert()->error('Gagal menyimpan file.');
                    return redirect()->back();
                }
            } else {
                alert()->error('File tidak valid.');
                return redirect()->back();
            }
        } else {
            alert()->error('Foto Kunjungan tidak ditemukan.');
            return redirect()->back();
        }
    }
}
