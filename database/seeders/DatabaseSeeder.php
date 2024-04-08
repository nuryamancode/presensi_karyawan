<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AgendaM;
use App\Models\DivisiModel;
use App\Models\HumanResourcesM;
use App\Models\KaryawanModel;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::create([
        //     'email' => 'karyawan@gmail.com',
        //     'password' => bcrypt('password')
        // ]);
        // User::create([
        //     'email' => 'human@gmail.com',
        //     'password' => bcrypt('password')
        // ]);
        // DivisiModel::create([
        //     'nama_divisi' => 'Programmer'
        // ]);
        // KaryawanModel::create([
        //     'nama_lengkap' => 'Iqbal Nuryaman',
        //     'user_id' => 1,
        //     'divisi_id' => 1
        // ]);
        HumanResourcesM::create([
            'nama_lengkap' => 'Human Maman',
            'user_id' => 2,
        ]);
    }
}
