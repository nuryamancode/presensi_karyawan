<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiM extends Model
{
    use HasFactory;
    protected $table = 'cuti';
    protected $fillable = [
        'tanggal_mulai_cuti',
        'tanggal_selesai_cuti',
        'keterangan',
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
