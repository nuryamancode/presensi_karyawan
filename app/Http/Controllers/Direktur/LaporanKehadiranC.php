<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\DirekturM;
use App\Models\RekapM;
use Illuminate\Http\Request;
use TCPDF;

class LaporanKehadiranC extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $direktur = DirekturM::where('user_id', $user_id)->first();
        $rekap = RekapM::all();
        $data = [
            'direktur' => $direktur,
            'rekap' => $rekap,

        ];
        return view('direktur.v-laporan-kehadiran', $data);
    }

    public function filter_laporan(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $user_id = auth()->id();
        $direktur = DirekturM::where('user_id', $user_id)->first();
        $rekap = RekapM::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->get();

        $data = [
            'direktur' => $direktur,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'rekap' => $rekap,
        ];
        return view('direktur.v-laporan-kehadiran', $data);
    }

    public function print_laporan(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $rekap = RekapM::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->get();
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Laporan Kehadiran - ' . $bulan . '/' . $tahun);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Laporan Kehadiran - ' . $bulan . '/' . $tahun, PDF_HEADER_STRING);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Laporan Kehadiran - ' . $bulan . '/' . $tahun, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
        $pdf->AddPage();
        $html = '<h1>Laporan Kehadiran - ' . $bulan . '/' . $tahun . '</h1>';
        $html .= '<table border="1" style="text-align:center; border-collapse: collapse; white-space: nowrap;">';
        $html .= '<tr style="background-color:#464DEE;">';
        $html .= '<th style="width: 50px; color: #fff;">No</th>';
        $html .= '<th style="width: 150px; color: #fff;">Nama Karyawan</th>';
        $html .= '<th style="width:110px; color: #fff;">Tanggal Rekap</th>';
        $html .= '<th style="width: 50px; color: #fff;">Hadir</th>';
        $html .= '<th style="width: 50px; color: #fff;">Telat</th>';
        $html .= '<th style="width: 50px; color: #fff;">Cuti</th>';
        $html .= '<th style="width: 50px; color: #fff;">Sakit</th>';
        $html .= '</tr>';

        foreach ($rekap as $key => $item) {
            $html .= '<tr>';
            $html .= '<td style="text-align:center; width: 50px;">' . ($key + 1) . '</td>';
            $html .= '<td style="text-align:center; width: 150px;">' . $item->karyawan->nama_lengkap . '</td>';
            $html .= '<td style="text-align:center; width: 110px;">' . \Carbon\Carbon::parse($item->created_at)->locale('id_ID')->isoFormat('D MMMM Y') . '</td>';
            $html .= '<td style="text-align:center; width: 50px;">' . $item->total_hadir . '</td>';
            $html .= '<td style="text-align:center; width: 50px;">' . $item->total_telat . '</td>';
            $html .= '<td style="text-align:center; width: 50px;">' . $item->total_cuti . '</td>';
            $html .= '<td style="text-align:center; width: 50px;">' . $item->total_sakit . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('laporan_kehadiran_' . $bulan . '_' . $tahun . '.pdf', 'I');
        exit;
    }

    public function print_laporan_tanpa_filter()
    {
        $rekap = RekapM::all();
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Laporan Kehadiran');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Laporan Kehadiran', PDF_HEADER_STRING);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Laporan Kehadiran', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
        $pdf->AddPage();
        $html = '<h1>Laporan Kehadiran</h1>';
        $html .= '<table border="1" style="text-align:center; border-collapse: collapse; white-space: nowrap;">';
        $html .= '<tr style="background-color:#464DEE;">';
        $html .= '<th style="width: 50px; color: #fff;">No</th>';
        $html .= '<th style="width: 150px; color: #fff;">Nama Karyawan</th>';
        $html .= '<th style="width:110px; color: #fff;">Tanggal Rekap</th>';
        $html .= '<th style="width: 50px; color: #fff;">Hadir</th>';
        $html .= '<th style="width: 50px; color: #fff;">Telat</th>';
        $html .= '<th style="width: 50px; color: #fff;">Cuti</th>';
        $html .= '<th style="width: 50px; color: #fff;">Sakit</th>';
        $html .= '</tr>';

        foreach ($rekap as $key => $item) {
            $html .= '<tr>';
            $html .= '<td style="text-align:center; width: 50px;">' . ($key + 1) . '</td>';
            $html .= '<td style="text-align:center; width: 150px;">' . $item->karyawan->nama_lengkap . '</td>';
            $html .= '<td style="text-align:center; width: 110px;">' . \Carbon\Carbon::parse($item->created_at)->locale('id_ID')->isoFormat('D MMMM Y') . '</td>';
            $html .= '<td style="text-align:center; width: 50px;">' . $item->total_hadir . '</td>';
            $html .= '<td style="text-align:center; width: 50px;">' . $item->total_telat . '</td>';
            $html .= '<td style="text-align:center; width: 50px;">' . $item->total_cuti . '</td>';
            $html .= '<td style="text-align:center; width: 50px;">' . $item->total_sakit . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('laporan_kehadiran.pdf', 'I');
        exit;
    }
}
