<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    public function index()
    {
        $daftarJabatan = Jabatan::all();
        return view('jabatan.index', compact('daftarJabatan'));
    }

    public function simpan(Request $permintaan)
    {
        $validasi = $permintaan->validate([
            'nama_jabatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama_jabatan.required' => 'Nama jabatan wajib diisi.',
        ]);

        Jabatan::create($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data jabatan berhasil ditambahkan.']);
        }
        return redirect()->route('jabatan.index')->with('sukses', 'Data jabatan berhasil ditambahkan.');
    }

    public function ubah(Request $permintaan, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $validasi = $permintaan->validate([
            'nama_jabatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama_jabatan.required' => 'Nama jabatan wajib diisi.',
        ]);

        $jabatan->update($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data jabatan berhasil diperbarui.']);
        }
        return redirect()->route('jabatan.index')->with('sukses', 'Data jabatan berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('sukses', 'Data jabatan berhasil dihapus.');
    }
}
