<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SakitM extends Model
{
    use HasFactory;
    protected $table = 'sakit';
    protected $fillable = [
        'tanggal_mulai_sakit',
        'tanggal_selesai_sakit',
        'file_surat_sakit',
        'keterangan_penolakan',
        'status_pengajuan',
        'karyawan_id',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class);
    }
}
