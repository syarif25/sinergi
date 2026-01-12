<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatan = [
            ['nama_jabatan' => 'Kepala Sekolah'],
            ['nama_jabatan' => 'Wakil Kepala Sekolah'],
            ['nama_jabatan' => 'Guru'],
            ['nama_jabatan' => 'Tata Usaha'],
            ['nama_jabatan' => 'Keamanan'],
            ['nama_jabatan' => 'Kebersihan'],
        ];

        foreach ($jabatan as $j) {
            \App\Models\Jabatan::create($j);
        }
    }
}
