<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanModel extends Model
{
    use HasFactory;

    protected $table = 'data_karyawan';
    protected $fillable = [
        'nama_lengkap',
        'tanggal_lahir',
        'nomor_wa',
        'foto_diri',
        'alamat_lengkap',
        'user_id',
        'divisi_id',
    ];
    protected $casts = [
        'created_at'=> 'datetime',
        'updated_at'=> 'datetime',
    ];

    public function user (){
        return $this->belongsTo(User::class);
    }
    public function divisi (){
        return $this->belongsTo(DivisiModel::class);
    }
    public function presensi (){
        return $this->hasOne(PresensiModel::class);
    }
}
