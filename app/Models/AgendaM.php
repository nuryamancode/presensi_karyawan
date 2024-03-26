<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaM extends Model
{
    use HasFactory;
    protected $table = 'agenda';
    protected $fillable = [
        'id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'nama_event',
        'alamat_lokasi',
        'foto_kunjungan',
        'karyawan_id',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function karyawan(){
        return $this->belongsTo(KaryawanModel::class);
    }
}
