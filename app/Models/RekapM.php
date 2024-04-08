<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapM extends Model
{
    use HasFactory;

    protected $table = 'rekap_kehadiran';
    protected $fillable = [
        // 'periode_rekap',
        'karyawan_id',
        'total_hadir',
        'total_telat',
        'total_cuti',
        'total_sakit',
    ];
    protected $casts = [
        'created_at'=> 'datetime',
        'updated_at'=> 'datetime',
    ];

    public function karyawan(){
        return $this->belongsTo(KaryawanModel::class);
    }
}
