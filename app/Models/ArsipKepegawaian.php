<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pegawai;

class ArsipKepegawaian extends Model
{
    use HasFactory;

    protected $table = 'arsip_kepegawaian';
    protected $primaryKey = 'id_arsip_kepegawaian';
    protected $fillable = [
        'id_pegawai',
        'jenis_dokumen',
        'file_dokumen',
        'keterangan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
