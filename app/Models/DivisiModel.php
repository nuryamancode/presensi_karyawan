<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisiModel extends Model
{
    use HasFactory;
    protected $table = 'divisi';
    protected $fillable = [
        'nama_divisi'
    ];
    protected $casts = [
        'created_at'=> 'datetime',
        'updated_at'=> 'datetime',
    ];

    public function karyawan(){
        return $this->hasOne(KaryawanModel::class);
    }
}
