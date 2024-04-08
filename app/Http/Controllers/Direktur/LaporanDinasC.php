<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\AgendaM;
use App\Models\DirekturM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use TCPDF;

class LaporanDinasC extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $direktur = DirekturM::where("user_id", $user_id)->first();
        $laporan_dinas = AgendaM::whereNotNull('foto_kunjungan')->get();
        $data = [
            'direktur' => $direktur,
            'laporan_dinas' => $laporan_dinas,
        ];

        return view('direktur.v-laporan-dinas', $data);
    }


    public function laporan_dinas_print()
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
}
