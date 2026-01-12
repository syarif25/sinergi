<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $daftarPegawai = Pegawai::with('jabatan')->get();
        $daftarJabatan = Jabatan::all();
        return view('pegawai.index', compact('daftarPegawai', 'daftarJabatan'));
    }

    public function simpan(Request $permintaan)
    {
        $validasi = $permintaan->validate([
            'nip' => 'required|string|max:20|unique:pegawai,nip',
            'nama' => 'required|string|max:255',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|max:255|unique:pegawai,email',
            'alamat' => 'nullable|string',
            'status_aktif' => 'nullable|boolean',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'id_jabatan.required' => 'Jabatan wajib dipilih.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'no_hp.numeric' => 'No. HP harus berupa angka.',
            'no_hp.digits_between' => 'No. HP harus 10-15 digit.',
            'email.required' => 'Email wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $status_aktif = $permintaan->has('status_aktif');

        Pegawai::create([
            'nip' => $validasi['nip'],
            'nama' => $validasi['nama'],
            'id_jabatan' => $validasi['id_jabatan'],
            'jenis_kelamin' => $validasi['jenis_kelamin'],
            'no_hp' => $validasi['no_hp'],
            'email' => $validasi['email'],
            'alamat' => $validasi['alamat'],
            'status_aktif' => $status_aktif,
        ]);

        return response()->json(['success' => true, 'message' => 'Data pegawai berhasil ditambahkan.']);
    }

    public function ubah(Request $permintaan, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validasi = $permintaan->validate([
            'nip' => 'required|string|max:20|unique:pegawai,nip,' . $id . ',id_pegawai',
            'nama' => 'required|string|max:255',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|max:255|unique:pegawai,email,' . $id . ',id_pegawai',
            'alamat' => 'nullable|string',
            'status_aktif' => 'nullable|boolean',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'id_jabatan.required' => 'Jabatan wajib dipilih.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'no_hp.numeric' => 'No. HP harus berupa angka.',
            'no_hp.digits_between' => 'No. HP harus 10-15 digit.',
            'email.required' => 'Email wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $status_aktif = $permintaan->has('status_aktif');

        $pegawai->update([
            'nip' => $validasi['nip'],
            'nama' => $validasi['nama'],
            'id_jabatan' => $validasi['id_jabatan'],
            'jenis_kelamin' => $validasi['jenis_kelamin'],
            'no_hp' => $validasi['no_hp'],
            'email' => $validasi['email'],
            'alamat' => $validasi['alamat'],
            'status_aktif' => $status_aktif,
        ]);

        return response()->json(['success' => true, 'message' => 'Data pegawai berhasil diperbarui.']);
    }

    public function hapus($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('sukses', 'Data pegawai berhasil dihapus.');
    }
}
