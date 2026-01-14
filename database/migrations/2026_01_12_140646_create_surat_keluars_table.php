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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id('id_surat_keluar');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('tujuan');
            $table->string('perihal');
            $table->foreignId('id_jenis_surat')->constrained('jenis_surat', 'id_jenis_surat')->onDelete('cascade');
            $table->string('file_surat');
            $table->foreignId('id_user_input')->constrained('users', 'id_user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
