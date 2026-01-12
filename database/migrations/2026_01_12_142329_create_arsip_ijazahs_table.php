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
        Schema::create('arsip_ijazah', function (Blueprint $table) {
            $table->id('id_arsip_ijazah');
            $table->string('nama_pemilik');
            $table->string('nis_nip');
            $table->string('tahun_lulus', 4);
            $table->string('file_ijazah');
            $table->text('lokasi_fisik')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_ijazah');
    }
};
