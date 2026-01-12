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
        Schema::create('inventaris_aset', function (Blueprint $table) {
            $table->id('id_aset');
            $table->string('kode_aset')->unique();
            $table->string('nama_aset');
            $table->foreignId('id_kategori')->constrained('kategori_barang', 'id_kategori')->onDelete('cascade');
            $table->foreignId('id_lokasi')->constrained('lokasi_ruangan', 'id_lokasi')->onDelete('cascade');
            $table->enum('kondisi', ['Baik', 'Rusak', 'Hilang']);
            $table->date('tanggal_perolehan');
            $table->decimal('nilai_perolehan', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_aset');
    }
};
