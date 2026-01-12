@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
@endpush

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Data Pengguna</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Data Pengguna</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="/assets/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="datatables">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title">Data Pengguna</h4>
                        <p class="card-subtitle">Kelola data pengguna aplikasi</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="ti ti-plus me-2"></i>Tambah Pengguna
                    </button>
                </div>

                {{-- Alert Sukses diganti SweetAlert --}}
                {{-- Alert Sukses diganti SweetAlert, Alert Error pindah ke inline modal --}}

                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered text-nowrap align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarPengguna as $key => $pengguna)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $pengguna->nama }}</td>
                                <td>{{ $pengguna->username }}</td>
                                <td>{{ $pengguna->email ?? '-' }}</td>
                                <td>
                                    @if($pengguna->role == 'admin')
                                        <span class="badge bg-primary rounded-3 fw-semibold">Admin</span>
                                    @elseif($pengguna->role == 'tu')
                                        <span class="badge bg-warning rounded-3 fw-semibold">Tata Usaha</span>
                                    @else
                                        <span class="badge bg-info rounded-3 fw-semibold">Pimpinan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pengguna->is_active)
                                        <span class="badge bg-success rounded-3 fw-semibold">Aktif</span>
                                    @else
                                        <span class="badge bg-danger rounded-3 fw-semibold">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $pengguna->id_user }}">
                                            <i class="ti ti-pencil"></i>
                                        </button>
                                        <form id="delete-form-{{ $pengguna->id_user }}" action="{{ route('pengguna.hapus', $pengguna->id_user) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus('{{ $pengguna->id_user }}', '{{ $pengguna->nama }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEdit{{ $pengguna->id_user }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Pengguna</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('pengguna.ubah', $pengguna->id_user) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama</label>
                                                            <input type="text" class="form-control {{ $errors->getBag('edit_' . $pengguna->id_user)->has('nama') ? 'is-invalid' : '' }}" name="nama" value="{{ old('nama', $pengguna->nama) }}" required>
                                                            @if($errors->getBag('edit_' . $pengguna->id_user)->has('nama'))
                                                                <div class="invalid-feedback">{{ $errors->getBag('edit_' . $pengguna->id_user)->first('nama') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Username</label>
                                                            <input type="text" class="form-control {{ $errors->getBag('edit_' . $pengguna->id_user)->has('username') ? 'is-invalid' : '' }}" name="username" value="{{ old('username', $pengguna->username) }}" required>
                                                            @if($errors->getBag('edit_' . $pengguna->id_user)->has('username'))
                                                                <div class="invalid-feedback">{{ $errors->getBag('edit_' . $pengguna->id_user)->first('username') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control {{ $errors->getBag('edit_' . $pengguna->id_user)->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email', $pengguna->email) }}">
                                                            @if($errors->getBag('edit_' . $pengguna->id_user)->has('email'))
                                                                <div class="invalid-feedback">{{ $errors->getBag('edit_' . $pengguna->id_user)->first('email') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                                                            <input type="password" class="form-control {{ $errors->getBag('edit_' . $pengguna->id_user)->has('password') ? 'is-invalid' : '' }}" name="password">
                                                            @if($errors->getBag('edit_' . $pengguna->id_user)->has('password'))
                                                                <div class="invalid-feedback">{{ $errors->getBag('edit_' . $pengguna->id_user)->first('password') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Role</label>
                                                            <select class="form-select {{ $errors->getBag('edit_' . $pengguna->id_user)->has('role') ? 'is-invalid' : '' }}" name="role" required>
                                                                <option value="admin" {{ old('role', $pengguna->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                <option value="tu" {{ old('role', $pengguna->role) == 'tu' ? 'selected' : '' }}>Tata Usaha</option>
                                                                <option value="pimpinan" {{ old('role', $pengguna->role) == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                                                            </select>
                                                            @if($errors->getBag('edit_' . $pengguna->id_user)->has('role'))
                                                                <div class="invalid-feedback">{{ $errors->getBag('edit_' . $pengguna->id_user)->first('role') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pengguna.simpan') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control {{ $errors->tambah->has('nama') ? 'is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama" required>
                            @if($errors->tambah->has('nama'))
                                <div class="invalid-feedback">{{ $errors->tambah->first('nama') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control {{ $errors->tambah->has('username') ? 'is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Masukkan Username" required>
                            @if($errors->tambah->has('username'))
                                <div class="invalid-feedback">{{ $errors->tambah->first('username') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control {{ $errors->tambah->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Masukkan Email">
                            @if($errors->tambah->has('email'))
                                <div class="invalid-feedback">{{ $errors->tambah->first('email') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control {{ $errors->tambah->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="Masukkan Password" required>
                            @if($errors->tambah->has('password'))
                                <div class="invalid-feedback">{{ $errors->tambah->first('password') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select {{ $errors->tambah->has('role') ? 'is-invalid' : '' }}" name="role" required>
                                <option selected disabled>Pilih Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="tu" {{ old('role') == 'tu' ? 'selected' : '' }}>Tata Usaha</option>
                                <option value="pimpinan" {{ old('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                            </select>
                            @if($errors->tambah->has('role'))
                                <div class="invalid-feedback">{{ $errors->tambah->first('role') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-basic.init.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    <script>
        // Notifikasi Sukses
        @if(session('sukses'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('sukses') }}",
                icon: 'success',
                confirmButtonColor: '#13deb9'
            });
        @endif

        // Auto Open Modal jika ada error validasi
        @if($errors->hasBag('tambah'))
            var modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
            modalTambah.show();
        @endif

        @foreach($daftarPengguna as $p)
            @if($errors->hasBag('edit_' . $p->id_user))
                var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit{{ $p->id_user }}'));
                modalEdit.show();
            @endif
        @endforeach

        // Konfirmasi Hapus
        function konfirmasiHapus(id, nama) {
            Swal.fire({
                title: 'Hapus Pengguna?',
                text: "Anda akan menghapus data pengguna '" + nama + "'! Data yang dihapus tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FA896B',
                cancelButtonColor: '#EAEFF4',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    cancelButton: 'text-dark' // Agar teks Batal terlihat karena background terang
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endpush
