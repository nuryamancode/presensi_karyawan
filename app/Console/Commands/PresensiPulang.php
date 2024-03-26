<?php

namespace App\Console\Commands;

use App\Models\KaryawanModel;
use Illuminate\Console\Command;

class PresensiPulang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:pulang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = 'Srywn8zTBvwwsZJ8WzA#';
        $employees = KaryawanModel::select('nama_lengkap', 'nomor_wa')->get();
        $message = "Selamat Sore *{nama_lengkap}*,\nJangan lupa untuk melakukan presensi pulang pada pukul *17:00* di aplikasi tautan tersebut.\n\nhttps://marecayasa.com/\n\n\nSalam Hormat: Direktur,\nSulaiman A.md";
        foreach ($employees as $employee) {
            $formattedMessage = str_replace('{nama_lengkap}', $employee->nama_lengkap, $message);

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
                    'target' => $employee->nomor_wa,
                    'message' => $formattedMessage,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        }

        return redirect()->back();
    }
}
