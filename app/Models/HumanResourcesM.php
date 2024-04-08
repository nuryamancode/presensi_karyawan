<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanResourcesM extends Model
{
    use HasFactory;
    protected $table = 'data_hr';
    protected $fillable = [
        'nama_lengkap',
        'nomor_wa',
        'foto_diri',
        'alamat_lengkap',
        'user_id',
    ];
    protected $casts = [
        'created_at'=> 'datetime',
        'updated_at'=> 'datetime',
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
