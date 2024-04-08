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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->string('kordinat');
            $table->string('foto');
            $table->time('jam');
            $table->date('tanggal');
            $table->enum('status_presensi', ['Masuk','Pulang']);
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('data_karyawan')->onDelete('cascade');
            $table->unsignedBigInteger('pengaduan_id')->nullable();
            $table->foreign('pengaduan_id')->references('id')->on('pengaduan_presensi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
