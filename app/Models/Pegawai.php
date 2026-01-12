<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    protected $fillable = [
        'nip', 'nama', 'id_jabatan', 'jenis_kelamin', 
        'no_hp', 'email', 'alamat', 'status_aktif'
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}
