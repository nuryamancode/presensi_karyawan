<?php

namespace App\Http\Controllers\Human;

use App\Http\Controllers\Controller;
use App\Models\AgendaM;
use App\Models\HumanResourcesM;
use App\Models\KaryawanModel;
use App\Models\NotifikasiM;
use App\Models\RekapM;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use TCPDF;

class KelolaLaporanC extends Controller
{
    public function laporan_dinas()
    {
        $user_id = auth()->id();
        $hr = HumanResourcesM::where("user_id", $user_id)->first();
        $laporan_dinas = AgendaM::whereNotNull('foto_kunjungan')->get();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $data = [
            'hr' => $hr,
            'laporan_dinas' => $laporan_dinas,
            'notifikasi' => $notifikasi,
            'jumlah_notif' => $jumlah_notif,
        ];

        return view('human.v-laporan-dinas', $data);
    }


    public function laporan_dinas_pdf()
    {
        $laporan_dinas = AgendaM::whereNotNull('foto_kunjungan')->get();
        $html = View::make('layout.PDF.v-laporan-dinas-pdf', compact('laporan_dinas'))->render();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Laporan Dinas Karyawan');
        $pdf->SetSubject('Laporan Dinas Karyawan');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Laporan Dinas Karyawan', PDF_HEADER_STRING);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('laporan_dinas.pdf', 'I');
        exit;
    }

    public function rekap_kehadiran()
    {
        $user_id = auth()->id();
        $hr = HumanResourcesM::where("user_id", $user_id)->first();
        $oneMonthAgo = Carbon::now()->subMonth();
        $laporan_rekap = RekapM::whereDate('created_at', '>=', $oneMonthAgo)->orderByDesc('created_at')->get();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $rekap = KaryawanModel::leftJoin('presensi', 'data_karyawan.id', '=', 'presensi.karyawan_id')
            ->leftJoin('cuti', function ($join) {
                $join->on('data_karyawan.id', '=', 'cuti.karyawan_id');
            })
            ->leftJoin('sakit', function ($join) {
                $join->on('data_karyawan.id', '=', 'sakit.karyawan_id');
            })
            ->select(
                'data_karyawan.id',
                'data_karyawan.nama_lengkap',
                DB::raw('SUM(CASE WHEN presensi.status_presensi = "Masuk" THEN 1 ELSE 0 END) AS total_kehadiran'),
                DB::raw('SUM(CASE WHEN presensi.status_presensi = "Masuk" AND presensi.jam >= "23:00:00" THEN 1 ELSE 0 END) AS total_telat'),
                DB::raw('COUNT(DISTINCT cuti.id) AS total_cuti'),
                DB::raw('COUNT(DISTINCT sakit.id) AS total_sakit')
            )
            ->groupBy('data_karyawan.id', 'data_karyawan.nama_lengkap')
            ->get();
        $data = [
            'rekap' => $rekap,
            'laporan_rekap' => $laporan_rekap,
            'hr' => $hr,
            'notifikasi' => $notifikasi,
            'jumlah_notif' => $jumlah_notif,
        ];
        return view('human.v-laporan-rekap-kehadiran', $data);
    }

    public function post_rekap(Request $request)
    {
        $lastRekapDate = RekapM::max('created_at');
        $lastRekapDate = $lastRekapDate ? Carbon::parse($lastRekapDate) : null;
        if (!$lastRekapDate || !$lastRekapDate->isCurrentMonth()) {
            $karyawan_ids = $request->input('karyawan_id');
            $total_hadirs = $request->input('total_hadir');
            $total_cutis = $request->input('total_cuti');
            $total_telats = $request->input('total_telat');
            $total_sakits = $request->input('total_sakit');
            $success = true;
            foreach ($karyawan_ids as $key => $karyawan_id) {
                $rekap = new RekapM([
                    'karyawan_id' => $karyawan_id,
                    'total_hadir' => $total_hadirs[$key],
                    'total_cuti' => $total_cutis[$key],
                    'total_telat' => $total_telats[$key],
                    'total_sakit' => $total_sakits[$key],
                ]);
                if (!$rekap->save()) {
                    $success = false;
                    break;
                }
            }
            if ($success) {
                alert()->toast('Kehadiran berhasil direkap', 'success');
            } else {
                alert()->toast('Kehadiran tidak berhasil direkap', 'error');
            }
        } else {
            alert()->toast('Rekap untuk bulan ini sudah dilakukan', 'warning');
        }
        return redirect()->back();
    }
}
