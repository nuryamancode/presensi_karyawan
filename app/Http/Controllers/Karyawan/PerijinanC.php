<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\CutiM;
use App\Models\KaryawanModel;
use App\Models\SakitM;
use Illuminate\Http\Request;

class PerijinanC extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $karyawan = KaryawanModel::where('user_id', $user->id)->first();
        $cuti = CutiM::where('karyawan_id', $karyawan->id)->latest()->get();
        $sakit = SakitM::where('karyawan_id', $karyawan->id)->latest()->get();
        $data = [
            'cuti' => $cuti,
            'sakit' => $sakit
        ];
        return view('karyawan.v-perijinan', $data);
    }

    public function post_cuti(Request $request)
    {
        $user = auth()->user();
        $karyawan = KaryawanModel::where('user_id', $user->id)->first();
        $request->validate([
            'keterangan' => 'required',
            'tanggal_mulai_cuti' => 'required|date|after_or_equal:today',
            'tanggal_selesai_cuti' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $start = strtotime($request->tanggal_mulai_cuti);
                    $end = strtotime($request->tanggal_selesai_cuti);
                    $difference = ceil(abs($end - $start) / 86400); // Hitung selisih dalam hari

                    if ($difference > 3) {
                        $fail('Tanggal selesai cuti tidak boleh melebihi 3 hari dari tanggal mulai cuti.');
                    }
                },
            ],
            'keterangan_lainnya' => 'nullable|string',
        ], [
            'keterangan.required' => 'Keterangan harus diisi.',
            'tanggal_mulai_cuti.required' => 'Tanggal harus diisi.',
            'tanggal_selesai_cuti.required' => 'Tanggal selesai cuti harus diisi.',
            'keterangan_lainnya.string' => 'Keterangan lainnya harus berupa teks.',
            'tanggal_mulai_cuti.after_or_equal' => 'Tanggal cuti tidak boleh lebih awal dari hari ini.',

        ]);
        $cuti_berlansung = CutiM::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal_selesai_cuti', '>=', now()->format('Y-m-d'))
            ->exists();
        $status_ditolak = CutiM::where('karyawan_id', $karyawan->id)
            ->where('status_pengajuan', 'Ditolak')
            ->exists();
        if ($cuti_berlansung && !$status_ditolak) {
            alert()->error('Anda masih dalam masa cuti. Anda tidak dapat mengajukan ijin cuti lagi.');
            return redirect()->back();
        }
        $keterangan = $request->input('keterangan');
        $keterangan_lainnya = $request->input('keterangan_lainnya');
        $keterangangabungan = $keterangan;
        if ($keterangan === 'lainnya' && !empty($keterangan_lainnya)) {
            $keterangangabungan = $keterangan_lainnya;
        }
        $cuti = new CutiM([
            'tanggal_mulai_cuti' => $request->input('tanggal_mulai_cuti'),
            'tanggal_selesai_cuti' => $request->input('tanggal_selesai_cuti'),
            'keterangan' => $keterangangabungan,
            'karyawan_id' => $karyawan->id,
        ]);
        if ($cuti->save()) {
            alert()->success('Ijin Cuti berhasil diajukan');
            return redirect()->back();
        } else {
            alert()->error('ijin Cuti tidak berhasil diajukan');
            return redirect()->back();
        }
    }
    public function post_sakit(Request $request)
    {
        $user = auth()->user();
        $karyawan = KaryawanModel::where('user_id', $user->id)->first();
        $request->validate([
            'file_surat_sakit' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
            'tanggal_mulai_sakit' => 'required|date|date_equals:' . now()->format('Y-m-d'), // Tanggal mulai harus hari ini
            'tanggal_selesai_cuti' => 'date|after_or_equal:tanggal_mulai_sakit',
        ], [
            'file_surat_sakit.required' => 'File surat sakit harus diunggah.',
            'file_surat_sakit.mimes' => 'Format file yang diperbolehkan: jpeg, png, jpg, pdf',
            'file_surat_sakit.max' => 'Ukuran file tidak boleh lebih dari 2MB',
            'tanggal_mulai_sakit.required' => 'Tanggal sakit harus diisi dengan berapa hari di surat sakit.',
            'tanggal_mulai_sakit.date_equals' => 'Tanggal mulai sakit harus sama dengan hari ini.', // Pesan jika tidak sesuai
            'tanggal_selesai_sakit.before_or_equal' => 'Tanggal selesai sakit tidak boleh melebihi tanggal mulai sakit.',
        ]);

        $sakit_berlangsung = SakitM::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal_selesai_sakit', '>=', now()->format('Y-m-d'))
            ->exists();
        $status_ditolak = SakitM::where('karyawan_id', $karyawan->id)
            ->where('status_pengajuan', 'Ditolak')
            ->exists();
        if ($sakit_berlangsung && !$status_ditolak) {
            alert()->error('Anda masih dalam masa sakit. Anda tidak dapat mengajukan ijin sakit lagi.');
            return redirect()->back();
        }
        if ($request->hasFile('file_surat_sakit')) {
            $file = $request->file('file_surat_sakit');

            if ($file->isValid()) {
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'image/file_surat_sakit/' . $fileName;
                $success = $file->move(public_path('image/file_surat_sakit'), $fileName);

                if ($success) {
                    $sakit = new SakitM([
                        'file_surat_sakit' => $path,
                        'tanggal_mulai_sakit' => $request->input('tanggal_mulai_sakit'),
                        'tanggal_selesai_sakit' => $request->input('tanggal_selesai_sakit'),
                        'karyawan_id' => $karyawan->id
                    ]);
                    if ($sakit->save()) {
                        alert()->success('Ijin Sakit berhasil diajukan');
                        return redirect()->back();
                    } else {
                        alert()->error('Ijin Sakit tidak berhasil diajukan');
                        return redirect()->back();
                    }
                } else {
                    alert()->error('Gagal menyimpan file');
                    return redirect()->back();
                }
            } else {
                alert()->error('File tidak valid');
                return redirect()->back();
            }
        }
    }
}
