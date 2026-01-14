<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OtentikasiController;

Route::get('/', [OtentikasiController::class, 'tampilHalamanLogin'])->name('home');
Route::get('/login', [OtentikasiController::class, 'tampilHalamanLogin'])->name('login');
Route::post('/login', [OtentikasiController::class, 'prosesLogin'])->name('login.proses');
Route::post('/logout', [OtentikasiController::class, 'prosesLogout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/master-data', function () {
        return view('master-data.index');
    })->name('master-data.index');

    // Route Master Pengguna
    Route::get('/pengguna', [App\Http\Controllers\PenggunaController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna', [App\Http\Controllers\PenggunaController::class, 'simpan'])->name('pengguna.simpan');
    Route::put('/pengguna/{id}', [App\Http\Controllers\PenggunaController::class, 'ubah'])->name('pengguna.ubah');
    Route::delete('/pengguna/{id}', [App\Http\Controllers\PenggunaController::class, 'hapus'])->name('pengguna.hapus');

    // Route Tahun Ajaran
    Route::get('/tahun-ajaran', [App\Http\Controllers\TahunAjaranController::class, 'index'])->name('tahun-ajaran.index');
    Route::post('/tahun-ajaran', [App\Http\Controllers\TahunAjaranController::class, 'simpan'])->name('tahun-ajaran.simpan');
    Route::put('/tahun-ajaran/{id}', [App\Http\Controllers\TahunAjaranController::class, 'ubah'])->name('tahun-ajaran.ubah');
    Route::delete('/tahun-ajaran/{id}', [App\Http\Controllers\TahunAjaranController::class, 'hapus'])->name('tahun-ajaran.hapus');

    // Route Pegawai
    Route::get('/pegawai', [App\Http\Controllers\PegawaiController::class, 'index'])->name('pegawai.index');
    Route::post('/pegawai', [App\Http\Controllers\PegawaiController::class, 'simpan'])->name('pegawai.simpan');
    Route::put('/pegawai/{id}', [App\Http\Controllers\PegawaiController::class, 'ubah'])->name('pegawai.ubah');
    Route::delete('/pegawai/{id}', [App\Http\Controllers\PegawaiController::class, 'hapus'])->name('pegawai.hapus');

    // Route Jabatan
    Route::get('/jabatan', [App\Http\Controllers\JabatanController::class, 'index'])->name('jabatan.index');
    Route::post('/jabatan', [App\Http\Controllers\JabatanController::class, 'simpan'])->name('jabatan.simpan');
    Route::put('/jabatan/{id}', [App\Http\Controllers\JabatanController::class, 'ubah'])->name('jabatan.ubah');
    Route::delete('/jabatan/{id}', [App\Http\Controllers\JabatanController::class, 'hapus'])->name('jabatan.hapus');

    // Route Jenis Surat
    Route::get('/jenis-surat', [App\Http\Controllers\JenisSuratController::class, 'index'])->name('jenis-surat.index');
    Route::post('/jenis-surat', [App\Http\Controllers\JenisSuratController::class, 'simpan'])->name('jenis-surat.simpan');
    Route::put('/jenis-surat/{id}', [App\Http\Controllers\JenisSuratController::class, 'ubah'])->name('jenis-surat.ubah');
    Route::delete('/jenis-surat/{id}', [App\Http\Controllers\JenisSuratController::class, 'hapus'])->name('jenis-surat.hapus');

    // Route Kategori Barang
    Route::get('/kategori-barang', [App\Http\Controllers\KategoriBarangController::class, 'index'])->name('kategori-barang.index');
    Route::post('/kategori-barang', [App\Http\Controllers\KategoriBarangController::class, 'simpan'])->name('kategori-barang.simpan');
    Route::put('/kategori-barang/{id}', [App\Http\Controllers\KategoriBarangController::class, 'ubah'])->name('kategori-barang.ubah');
    Route::delete('/kategori-barang/{id}', [App\Http\Controllers\KategoriBarangController::class, 'hapus'])->name('kategori-barang.hapus');

    // Route Lokasi Ruangan
    Route::get('/lokasi-ruangan', [App\Http\Controllers\LokasiRuanganController::class, 'index'])->name('lokasi-ruangan.index');
    Route::post('/lokasi-ruangan', [App\Http\Controllers\LokasiRuanganController::class, 'simpan'])->name('lokasi-ruangan.simpan');
    Route::put('/lokasi-ruangan/{id}', [App\Http\Controllers\LokasiRuanganController::class, 'ubah'])->name('lokasi-ruangan.ubah');
    Route::delete('/lokasi-ruangan/{id}', [App\Http\Controllers\LokasiRuanganController::class, 'hapus'])->name('lokasi-ruangan.hapus');

    // Route Surat Masuk
    Route::get('/surat-masuk', [App\Http\Controllers\SuratMasukController::class, 'index'])->name('surat-masuk.index');
    Route::post('/surat-masuk', [App\Http\Controllers\SuratMasukController::class, 'simpan'])->name('surat-masuk.simpan');
    Route::put('/surat-masuk/{id}', [App\Http\Controllers\SuratMasukController::class, 'ubah'])->name('surat-masuk.ubah');
    Route::delete('/surat-masuk/{id}', [App\Http\Controllers\SuratMasukController::class, 'hapus'])->name('surat-masuk.hapus');

    // Route Surat Keluar
    Route::get('/surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'index'])->name('surat-keluar.index');
    Route::post('/surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'simpan'])->name('surat-keluar.simpan');
    Route::put('/surat-keluar/{id}', [App\Http\Controllers\SuratKeluarController::class, 'ubah'])->name('surat-keluar.ubah');
    Route::delete('/surat-keluar/{id}', [App\Http\Controllers\SuratKeluarController::class, 'hapus'])->name('surat-keluar.hapus');

    // Route Inventaris Aset
    Route::get('/inventaris', [App\Http\Controllers\InventarisAsetController::class, 'index'])->name('inventaris.index');
    Route::post('/inventaris', [App\Http\Controllers\InventarisAsetController::class, 'simpan'])->name('inventaris.simpan');
    Route::put('/inventaris/{id}', [App\Http\Controllers\InventarisAsetController::class, 'ubah'])->name('inventaris.ubah');
    Route::delete('/inventaris/{id}', [App\Http\Controllers\InventarisAsetController::class, 'hapus'])->name('inventaris.hapus');

    // Route Arsip Ijazah
    Route::get('/arsip-ijazah', [App\Http\Controllers\ArsipIjazahController::class, 'index'])->name('arsip-ijazah.index');
    Route::post('/arsip-ijazah', [App\Http\Controllers\ArsipIjazahController::class, 'simpan'])->name('arsip-ijazah.simpan');
    Route::put('/arsip-ijazah/{id}', [App\Http\Controllers\ArsipIjazahController::class, 'ubah'])->name('arsip-ijazah.ubah');
    Route::delete('/arsip-ijazah/{id}', [App\Http\Controllers\ArsipIjazahController::class, 'hapus'])->name('arsip-ijazah.hapus');

    // Route Arsip Kepegawaian
    Route::get('/arsip-kepegawaian', [App\Http\Controllers\ArsipKepegawaianController::class, 'index'])->name('arsip-kepegawaian.index');
    Route::post('/arsip-kepegawaian', [App\Http\Controllers\ArsipKepegawaianController::class, 'simpan'])->name('arsip-kepegawaian.simpan');
    Route::put('/arsip-kepegawaian/{id}', [App\Http\Controllers\ArsipKepegawaianController::class, 'ubah'])->name('arsip-kepegawaian.ubah');
    Route::delete('/arsip-kepegawaian/{id}', [App\Http\Controllers\ArsipKepegawaianController::class, 'hapus'])->name('arsip-kepegawaian.hapus');
});

