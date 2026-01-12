<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index(Request $permintaan)
    {
        $query = SuratMasuk::with(['jenisSurat', 'user']);

        // Filter Tanggal Surat (Range)
        if ($permintaan->filled('tanggal_awal') && $permintaan->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_surat', [$permintaan->tanggal_awal, $permintaan->tanggal_akhir]);
        }

        // Filter Jenis Surat
        if ($permintaan->filled('id_jenis_surat')) {
            $query->where('id_jenis_surat', $permintaan->id_jenis_surat);
        }

        $daftarSurat = $query->latest()->get();
        $daftarJenis = JenisSurat::all();
        
        return view('surat-masuk.index', compact('daftarSurat', 'daftarJenis'));
    }

    public function simpan(Request $permintaan)
    {
        $validasi = $permintaan->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'id_jenis_surat' => 'required|exists:jenis_surat,id_jenis_surat',
            'file_surat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
        ], [
            'file_surat.required' => 'File surat wajib diupload.',
            'file_surat.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
            'file_surat.max' => 'Ukuran file maksimal 2MB.',
        ]);

        if ($permintaan->hasFile('file_surat')) {
            $path = $permintaan->file('file_surat')->store('surat-masuk', 'public');
            $validasi['file_surat'] = $path;
        }

        $validasi['id_user_input'] = Auth::id();

        SuratMasuk::create($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Surat masuk berhasil ditambahkan.']);
        }
        return redirect()->route('surat-masuk.index')->with('sukses', 'Surat masuk berhasil ditambahkan.');
    }

    public function ubah(Request $permintaan, $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $validasi = $permintaan->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'id_jenis_surat' => 'required|exists:jenis_surat,id_jenis_surat',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($permintaan->hasFile('file_surat')) {
            // Delete old file
            if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                Storage::disk('public')->delete($surat->file_surat);
            }
            $path = $permintaan->file('file_surat')->store('surat-masuk', 'public');
            $validasi['file_surat'] = $path;
        }

        $surat->update($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Surat masuk berhasil diperbarui.']);
        }
        return redirect()->route('surat-masuk.index')->with('sukses', 'Surat masuk berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        
        if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
            Storage::disk('public')->delete($surat->file_surat);
        }
        
        $surat->delete();

        return redirect()->route('surat-masuk.index')->with('sukses', 'Surat masuk berhasil dihapus.');
    }
}
