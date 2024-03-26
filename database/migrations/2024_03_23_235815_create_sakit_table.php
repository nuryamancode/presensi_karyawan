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
        Schema::create('sakit', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_mulai_sakit');
            $table->date('tanggal_selesai_sakit');
            $table->string('file_surat_sakit');
            $table->string('keterangan_penolakan')->nullable();
            $table->enum('status_pengajuan', ['Disetujui', 'Ditolak'])->nullable();
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
        Schema::dropIfExists('sakit');
    }
};
