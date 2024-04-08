<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiM extends Model
{
    use HasFactory;
    protected $table = 'notifikasi';
    protected $fillable = [
        'karyawan_id',
        'hr_id',
        'judul',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function karyawan(){
        return $this->belongsTo(KaryawanModel::class);
    }

    public function hr(){
        return $this->belongsTo(HumanResourcesM::class);
    }
}
