<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanPresensiModel extends Model
{
    use HasFactory;
    protected $table = 'pengaduan_presensi';
    protected $fillable = [
        "alasan_telat",
        "karyawan_id",
    ];
    protected $casts = [
        "created_at"=> "datetime",
        "updated_at"=> "datetime",
    ];

    public function presensi(){
        return $this->hasOne(PresensiModel::class);
    }
}
