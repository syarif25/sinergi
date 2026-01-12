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
                    <h4 class="fw-semibold mb-8">Data Pegawai</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Data Pegawai</li>
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
                        <h4 class="card-title">Data Pegawai</h4>
                        <p class="card-subtitle">Kelola data pegawai dan staff</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="ti ti-plus me-2"></i>Tambah Pegawai
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered text-nowrap align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>L/P</th>
                                <th>No. HP</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarPegawai as $key => $pegawai)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $pegawai->nip ?? '-' }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $pegawai->nama }}</span>
                                        <span class="text-muted small">{{ $pegawai->email ?? '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary rounded-3 fw-semibold">{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</span>
                                </td>
                                <td>{{ $pegawai->jenis_kelamin }}</td>
                                <td>{{ $pegawai->no_hp ?? '-' }}</td>
                                <td>
                                    @if($pegawai->status_aktif)
                                        <span class="badge bg-success rounded-3 fw-semibold">Aktif</span>
                                    @else
                                        <span class="badge bg-danger rounded-3 fw-semibold">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $pegawai->id_pegawai }}">
                                            <i class="ti ti-pencil"></i>
                                        </button>
                                        <form id="delete-form-{{ $pegawai->id_pegawai }}" action="{{ route('pegawai.hapus', $pegawai->id_pegawai) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus('{{ $pegawai->id_pegawai }}', '{{ $pegawai->nama }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEdit{{ $pegawai->id_pegawai }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Pegawai</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form id="formEdit{{ $pegawai->id_pegawai }}" action="{{ route('pegawai.ubah', $pegawai->id_pegawai) }}" method="POST" onsubmit="handleAjaxSubmit(event, '{{ $pegawai->id_pegawai }}')">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">NIP</label>
                                                                <input type="text" class="form-control" name="nip" value="{{ $pegawai->nip }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Nama Lengkap</label>
                                                                <input type="text" class="form-control" name="nama" value="{{ $pegawai->nama }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Jabatan</label>
                                                                <select class="form-select" name="id_jabatan" required>
                                                                    <option value="" disabled>Pilih Jabatan</option>
                                                                    @foreach($daftarJabatan as $jabatan)
                                                                        <option value="{{ $jabatan->id_jabatan }}" {{ $pegawai->id_jabatan == $jabatan->id_jabatan ? 'selected' : '' }}>{{ $jabatan->nama_jabatan }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Jenis Kelamin</label>
                                                                <select class="form-select" name="jenis_kelamin" required>
                                                                    <option value="L" {{ $pegawai->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                                    <option value="P" {{ $pegawai->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                                </select>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">No. HP</label>
                                                                <input type="tel" class="form-control" name="no_hp" value="{{ $pegawai->no_hp }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-8 mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input type="email" class="form-control" name="email" value="{{ $pegawai->email }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="form-label">Alamat</label>
                                                                <textarea class="form-control" name="alamat" rows="2">{{ $pegawai->alamat }}</textarea>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="statusAktifEdit{{ $pegawai->id_pegawai }}" name="status_aktif" value="1" {{ $pegawai->status_aktif ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="statusAktifEdit{{ $pegawai->id_pegawai }}">Status Aktif</label>
                                                                </div>
                                                            </div>
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pegawai Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambah" action="{{ route('pegawai.simpan') }}" method="POST" onsubmit="handleAjaxSubmit(event)">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control" name="nip" placeholder="Masukkan NIP" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Lengkap" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jabatan</label>
                                <select class="form-select" name="id_jabatan" required>
                                    <option selected disabled>Pilih Jabatan</option>
                                    @foreach($daftarJabatan as $jabatan)
                                        <option value="{{ $jabatan->id_jabatan }}">{{ $jabatan->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="jenis_kelamin" required>
                                    <option value="" disabled selected>Pilih JK</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">No. HP</label>
                                <input type="tel" class="form-control" name="no_hp" placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="contoh@email.com" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="2" placeholder="Alamat lengkap"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="statusAktifTambah" name="status_aktif" value="1" checked>
                                    <label class="form-check-label" for="statusAktifTambah">Status Aktif</label>
                                </div>
                            </div>
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
        // Notifikasi Sukses dari Session (Load awal)
        @if(session('sukses'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('sukses') }}",
                icon: 'success',
                confirmButtonColor: '#13deb9'
            });
        @endif

        // Konfirmasi Hapus
        function konfirmasiHapus(id, nama) {
            Swal.fire({
                title: 'Hapus Pegawai?',
                text: "Anda akan menghapus data pegawai '" + nama + "'! Data yang dihapus tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FA896B',
                cancelButtonColor: '#EAEFF4',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    cancelButton: 'text-dark'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        // AJAX Handle
        async function handleAjaxSubmit(event, id = null) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            // Reset Error States
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.innerText = '');

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST', // POST or PUT (spoofed via _method)
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Important for Laravel to detect AJAX
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    // Validation Error (422)
                    if (response.status === 422) {
                        Object.keys(data.errors).forEach(field => {
                            const input = form.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                                // Find sibling invalid-feedback
                                const feedback = input.nextElementSibling; 
                                if (feedback && feedback.classList.contains('invalid-feedback')) {
                                    feedback.innerText = data.errors[field][0];
                                } else {
                                    // Try finding closest parent then find feedback (for selects inside input-groups if any)
                                    // But here simple structure
                                }
                            }
                        });
                        // Optional: Toast error specific validation
                    } else {
                        // Server Error
                        Swal.fire('Error', data.message || 'Terjadi kesalahan pada server.', 'error');
                    }
                } else {
                    // Success (200)
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#13deb9'
                    }).then(() => {
                        window.location.reload();
                    });
                    
                    // Close Modal
                    const modalEl = form.closest('.modal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) modalInstance.hide();
                    
                    form.reset();
                }

            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Terjadi kesalahan jaringan atau server.', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        }
    </script>
@endpush
