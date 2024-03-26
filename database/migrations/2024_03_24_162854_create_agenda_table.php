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
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->datetime('tanggal_mulai');
            $table->datetime('tanggal_selesai');
            $table->string('nama_event');
            $table->string('alamat_lokasi');
            $table->string('keterangan')->nullable();
            $table->string('foto_kunjungan')->nullable();
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('data_karyawan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda');
    }
};
