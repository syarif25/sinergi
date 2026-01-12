<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipIjazah extends Model
{
    use HasFactory;

    protected $table = 'arsip_ijazah';
    protected $primaryKey = 'id_arsip_ijazah';
    protected $fillable = [
        'nama_pemilik',
        'nis_nip',
        'tahun_lulus',
        'file_ijazah',
        'lokasi_fisik'
    ];
}
