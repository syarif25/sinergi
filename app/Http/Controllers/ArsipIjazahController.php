<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArsipIjazah;
use Illuminate\Support\Facades\Storage;

class ArsipIjazahController extends Controller
{
    public function index(Request $permintaan)
    {
        $query = ArsipIjazah::query();

        if ($permintaan->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $permintaan->tahun_lulus);
        }

        $daftarArsip = $query->latest()->get();
        return view('arsip-ijazah.index', compact('daftarArsip'));
    }

    public function simpan(Request $permintaan)
    {
        $validasi = $permintaan->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nis_nip' => 'required|string|max:50',
            'tahun_lulus' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'lokasi_fisik' => 'nullable|string',
            'file_ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'file_ijazah.required' => 'File ijazah wajib diupload.',
            'file_ijazah.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
            'file_ijazah.max' => 'Ukuran file maksimal 2MB.',
        ]);

        if ($permintaan->hasFile('file_ijazah')) {
            $path = $permintaan->file('file_ijazah')->store('arsip-ijazah', 'public');
            $validasi['file_ijazah'] = $path;
        }

        ArsipIjazah::create($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Arsip ijazah berhasil ditambahkan.']);
        }
        return redirect()->route('arsip-ijazah.index')->with('sukses', 'Arsip ijazah berhasil ditambahkan.');
    }

    public function ubah(Request $permintaan, $id)
    {
        $arsip = ArsipIjazah::findOrFail($id);

        $validasi = $permintaan->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nis_nip' => 'required|string|max:50',
            'tahun_lulus' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'lokasi_fisik' => 'nullable|string',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($permintaan->hasFile('file_ijazah')) {
            // Hapus file lama jika ada
            if ($arsip->file_ijazah && Storage::disk('public')->exists($arsip->file_ijazah)) {
                Storage::disk('public')->delete($arsip->file_ijazah);
            }
            $path = $permintaan->file('file_ijazah')->store('arsip-ijazah', 'public');
            $validasi['file_ijazah'] = $path;
        }

        $arsip->update($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Arsip ijazah berhasil diperbarui.']);
        }
        return redirect()->route('arsip-ijazah.index')->with('sukses', 'Arsip ijazah berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $arsip = ArsipIjazah::findOrFail($id);
        
        if ($arsip->file_ijazah && Storage::disk('public')->exists($arsip->file_ijazah)) {
            Storage::disk('public')->delete($arsip->file_ijazah);
        }

        $arsip->delete();

        return redirect()->route('arsip-ijazah.index')->with('sukses', 'Arsip ijazah berhasil dihapus.');
    }
}
