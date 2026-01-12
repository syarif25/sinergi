<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArsipKepegawaian;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Storage;

class ArsipKepegawaianController extends Controller
{
    public function index(Request $permintaan)
    {
        $query = ArsipKepegawaian::with('pegawai');

        if ($permintaan->filled('id_pegawai')) {
            $query->where('id_pegawai', $permintaan->id_pegawai);
        }

        if ($permintaan->filled('jenis_dokumen')) {
            $query->where('jenis_dokumen', 'like', '%' . $permintaan->jenis_dokumen . '%');
        }

        $daftarArsip = $query->latest()->get();
        $daftarPegawai = Pegawai::where('status_aktif', true)->get();
        return view('arsip-kepegawaian.index', compact('daftarArsip', 'daftarPegawai'));
    }

    public function simpan(Request $permintaan)
    {
        $validasi = $permintaan->validate([
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'jenis_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ], [
            'file_dokumen.required' => 'Dokumen wajib diupload.',
            'file_dokumen.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
            'file_dokumen.max' => 'Ukuran file maksimal 2MB.',
        ]);

        if ($permintaan->hasFile('file_dokumen')) {
            $path = $permintaan->file('file_dokumen')->store('arsip-kepegawaian', 'public');
            $validasi['file_dokumen'] = $path;
        }

        ArsipKepegawaian::create($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Arsip kepegawaian berhasil ditambahkan.']);
        }
        return redirect()->route('arsip-kepegawaian.index')->with('sukses', 'Arsip kepegawaian berhasil ditambahkan.');
    }

    public function ubah(Request $permintaan, $id)
    {
        $arsip = ArsipKepegawaian::findOrFail($id);

        $validasi = $permintaan->validate([
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'jenis_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        if ($permintaan->hasFile('file_dokumen')) {
            // Hapus file lama
            if ($arsip->file_dokumen && Storage::disk('public')->exists($arsip->file_dokumen)) {
                Storage::disk('public')->delete($arsip->file_dokumen);
            }
            $path = $permintaan->file('file_dokumen')->store('arsip-kepegawaian', 'public');
            $validasi['file_dokumen'] = $path;
        }

        $arsip->update($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Arsip kepegawaian berhasil diperbarui.']);
        }
        return redirect()->route('arsip-kepegawaian.index')->with('sukses', 'Arsip kepegawaian berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $arsip = ArsipKepegawaian::findOrFail($id);
        
        if ($arsip->file_dokumen && Storage::disk('public')->exists($arsip->file_dokumen)) {
            Storage::disk('public')->delete($arsip->file_dokumen);
        }

        $arsip->delete();

        return redirect()->route('arsip-kepegawaian.index')->with('sukses', 'Arsip kepegawaian berhasil dihapus.');
    }
}
