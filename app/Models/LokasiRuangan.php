<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiRuangan extends Model
{
    use HasFactory;

    protected $table = 'lokasi_ruangan';
    protected $primaryKey = 'id_lokasi';
    protected $fillable = ['nama_lokasi', 'keterangan'];
}
