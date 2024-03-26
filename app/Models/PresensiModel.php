<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiModel extends Model
{
    use HasFactory;
    protected $table = 'presensi';
    protected $fillable = [
        'kordinat',
        'jam',
        'tanggal',
        'foto',
        'status_presensi',
        'karyawan_id',
        'pengaduan_id',
    ];
    protected $casts = [
        'created_at'=> 'datetime',
        'updated_at'=> 'datetime',
    ];

    public function karyawan(){
        return $this->belongsTo(KaryawanModel::class);
    }
    public function pengaduan(){
        return $this->belongsTo(PengaduanPresensiModel::class);
    }


}
