<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $daftarTahunAjaran = TahunAjaran::all();
        return view('tahun-ajaran.index', compact('daftarTahunAjaran'));
    }

    public function simpan(Request $permintaan)
    {
        $validasi = $permintaan->validateWithBag('tambah', [
            'tahun' => 'required|string|max:255',
            'is_aktif' => 'nullable|boolean',
        ], [
            'tahun.required' => 'Tahun ajaran wajib diisi.',
        ]);

        $is_aktif = $permintaan->has('is_aktif');

        if ($is_aktif) {
            TahunAjaran::query()->update(['is_aktif' => false]);
        }

        TahunAjaran::create([
            'tahun' => $validasi['tahun'],
            'is_aktif' => $is_aktif,
        ]);

        return redirect()->route('tahun-ajaran.index')->with('sukses', 'Data tahun ajaran berhasil ditambahkan.');
    }

    public function ubah(Request $permintaan, $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        $validasi = $permintaan->validateWithBag('edit_' . $id, [
            'tahun' => 'required|string|max:255',
            'is_aktif' => 'nullable|boolean',
        ], [
            'tahun.required' => 'Tahun ajaran wajib diisi.',
        ]);

        $is_aktif = $permintaan->has('is_aktif');
        
        // Jika status diubah menjadi aktif, nonaktifkan yang lain
        if ($is_aktif && !$tahunAjaran->is_aktif) {
            TahunAjaran::query()->update(['is_aktif' => false]);
        }
        // Pastikan minimal ada satu yang aktif, jika user mencoba menonaktifkan satu-satunya yang aktif, tetap aktifkan atau biarkan (depend on requirement, usually we allow unsetting but let's assume one must be active logic: if we unset active, no auto logic needed unless we require one ALWAYS active. For now let's just allow toggling off).
        // Correction: User requirement didn't specify "always one active", but "activate logic".
        
        $tahunAjaran->update([
            'tahun' => $validasi['tahun'],
            'is_aktif' => $is_aktif,
        ]);

        return redirect()->route('tahun-ajaran.index')->with('sukses', 'Data tahun ajaran berhasil mesa diperbarui.');
    }

    public function hapus($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->delete();

        return redirect()->route('tahun-ajaran.index')->with('sukses', 'Data tahun ajaran berhasil dihapus.');
    }
}
