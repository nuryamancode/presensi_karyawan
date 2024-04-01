<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamPresensiM extends Model
{
    use HasFactory;
    protected $table = 'jam_presensi';
    protected $fillable = [
        'waktu_buka',
        'waktu_tutup',
        'waktu_telat',
        'status_jam',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
