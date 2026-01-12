<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;

class JenisSuratController extends Controller
{
    public function index()
    {
        $daftarJenisSurat = JenisSurat::all();
        return view('jenis-surat.index', compact('daftarJenisSurat'));
    }

    public function simpan(Request $permintaan)
    {
        $validasi = $permintaan->validate([
            'nama_jenis' => 'required|string|max:255',
            'kode_surat' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ], [
            'nama_jenis.required' => 'Nama jenis surat wajib diisi.',
            'kode_surat.required' => 'Kode surat wajib diisi.',
        ]);

        JenisSurat::create($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Jenis surat berhasil ditambahkan.']);
        }
        return redirect()->route('jenis-surat.index')->with('sukses', 'Jenis surat berhasil ditambahkan.');
    }

    public function ubah(Request $permintaan, $id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        $validasi = $permintaan->validate([
            'nama_jenis' => 'required|string|max:255',
            'kode_surat' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ], [
            'nama_jenis.required' => 'Nama jenis surat wajib diisi.',
            'kode_surat.required' => 'Kode surat wajib diisi.',
        ]);

        $jenisSurat->update($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Jenis surat berhasil diperbarui.']);
        }
        return redirect()->route('jenis-surat.index')->with('sukses', 'Jenis surat berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->delete();

        return redirect()->route('jenis-surat.index')->with('sukses', 'Jenis surat berhasil dihapus.');
    }
}
