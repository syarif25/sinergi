<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriBarang;
use App\Models\LokasiRuangan;

class InventarisAset extends Model
{
    use HasFactory;

    protected $table = 'inventaris_aset';
    protected $primaryKey = 'id_aset';
    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'id_kategori',
        'id_lokasi',
        'kondisi',
        'tanggal_perolehan',
        'nilai_perolehan',
        'keterangan'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori');
    }

    public function lokasi()
    {
        return $this->belongsTo(LokasiRuangan::class, 'id_lokasi');
    }
}
