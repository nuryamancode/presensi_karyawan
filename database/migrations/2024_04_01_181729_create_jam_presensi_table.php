<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jam_presensi', function (Blueprint $table) {
            $table->id();
            $table->time('waktu_buka');
            $table->time('waktu_telat');
            $table->time('waktu_tutup');
            $table->enum('status_jam', ['Masuk', 'Pulang']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_presensi');
    }
};
