<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $daftarPengguna = User::all();
        return view('pengguna.index', compact('daftarPengguna'));
    }

    public function simpan(Request $permintaan)
    {
        $validasi = $permintaan->validateWithBag('tambah', [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,tu,pimpinan',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Role wajib dipilih.',
        ]);

        User::create([
            'nama' => $validasi['nama'],
            'username' => $validasi['username'],
            'email' => $validasi['email'],
            'password_hash' => Hash::make($validasi['password']),
            'role' => $validasi['role'],
            'is_active' => true,
        ]);

        return redirect()->route('pengguna.index')->with('sukses', 'Data pengguna berhasil ditambahkan.');
    }

    public function ubah(Request $permintaan, $id)
    {
        $pengguna = User::findOrFail($id);

        $validasi = $permintaan->validateWithBag('edit_' . $id, [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id . ',id_user',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id . ',id_user',
            'role' => 'required|in:admin,tu,pimpinan',
            'password' => 'nullable|string|min:6',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'role.required' => 'Role wajib dipilih.',
        ]);

        $dataUpdate = [
            'nama' => $validasi['nama'],
            'username' => $validasi['username'],
            'email' => $validasi['email'],
            'role' => $validasi['role'],
        ];

        if ($permintaan->filled('password')) {
            $dataUpdate['password_hash'] = Hash::make($validasi['password']);
        }

        $pengguna->update($dataUpdate);

        return redirect()->route('pengguna.index')->with('sukses', 'Data pengguna berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $pengguna = User::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('sukses', 'Data pengguna berhasil dihapus.');
    }
}
