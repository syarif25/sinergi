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
                    <h4 class="fw-semibold mb-8">Arsip Ijazah</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Arsip Ijazah</li>
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

    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 py-3 border-bottom">
            <h5 class="card-title fw-semibold mb-0 lh-sm">Filter Data</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('arsip-ijazah.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tahun Lulus</label>
                        <select class="form-select" name="tahun_lulus">
                            <option value="">Semua Tahun</option>
                            @for($tahun = date('Y') + 1; $tahun >= 2000; $tahun--)
                                <option value="{{ $tahun }}" {{ request('tahun_lulus') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-filter me-1"></i>Tampilkan
                        </button>
                        <a href="{{ route('arsip-ijazah.index') }}" class="btn btn-secondary">
                            <i class="ti ti-refresh me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="datatables">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title">Data Arsip Ijazah</h4>
                        <p class="card-subtitle">Kelola arsip digital ijazah</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="ti ti-plus me-2"></i>Tambah Arsip
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered text-nowrap align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pemilik (NIS/NIP)</th>
                                <th>Tahun Lulus</th>
                                <th>Lokasi Fisik</th>
                                <th>File Arsip</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarArsip as $key => $arsip)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <strong>{{ $arsip->nama_pemilik }}</strong><br>
                                    <small class="text-muted">{{ $arsip->nis_nip }}</small>
                                </td>
                                <td>{{ $arsip->tahun_lulus }}</td>
                                <td>{{ $arsip->lokasi_fisik ?? '-' }}</td>
                                <td>
                                    <a href="{{ Storage::url($arsip->file_ijazah) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="ti ti-file-download me-1"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $arsip->id_arsip_ijazah }}">
                                            <i class="ti ti-pencil"></i>
                                        </button>
                                        <form id="delete-form-{{ $arsip->id_arsip_ijazah }}" action="{{ route('arsip-ijazah.hapus', $arsip->id_arsip_ijazah) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus('{{ $arsip->id_arsip_ijazah }}', '{{ $arsip->nama_pemilik }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEdit{{ $arsip->id_arsip_ijazah }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Arsip Ijazah</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form id="formEdit{{ $arsip->id_arsip_ijazah }}" action="{{ route('arsip-ijazah.ubah', $arsip->id_arsip_ijazah) }}" method="POST" enctype="multipart/form-data" onsubmit="handleAjaxSubmit(event)">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Nama Pemilik</label>
                                                                <input type="text" class="form-control" name="nama_pemilik" value="{{ $arsip->nama_pemilik }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">NIS / NIP</label>
                                                                <input type="text" class="form-control" name="nis_nip" value="{{ $arsip->nis_nip }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Tahun Lulus</label>
                                                                <input type="number" class="form-control" name="tahun_lulus" value="{{ $arsip->tahun_lulus }}" min="1900" max="{{ date('Y')+1 }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Lokasi Fisik (Rak/Lemari)</label>
                                                                <input type="text" class="form-control" name="lokasi_fisik" value="{{ $arsip->lokasi_fisik }}">
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">File Ijazah (Biarkan kosong jika tidak diubah)</label>
                                                            <input type="file" class="form-control" name="file_ijazah" accept=".pdf,.jpg,.jpeg,.png">
                                                            <div class="form-text">Format: PDF, JPG, PNG. Max 2MB.</div>
                                                            <div class="invalid-feedback"></div>
                                                            <div class="mt-2">File saat ini: <a href="{{ Storage::url($arsip->file_ijazah) }}" target="_blank">Lihat</a></div>
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
                    <h5 class="modal-title">Tambah Arsip Ijazah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambah" action="{{ route('arsip-ijazah.simpan') }}" method="POST" enctype="multipart/form-data" onsubmit="handleAjaxSubmit(event)">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Pemilik</label>
                                <input type="text" class="form-control" name="nama_pemilik" placeholder="Nama Lengkap" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIS / NIP</label>
                                <input type="text" class="form-control" name="nis_nip" placeholder="Nomor Induk" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Lulus</label>
                                <input type="number" class="form-control" name="tahun_lulus" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y')+1 }}" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Fisik (Rak/Lemari)</label>
                                <input type="text" class="form-control" name="lokasi_fisik" placeholder="Contoh: Lemari A, Rak 2">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Ijazah (Scan)</label>
                            <input type="file" class="form-control" name="file_ijazah" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">Format: PDF, JPG, PNG. Max 2MB.</div>
                            <div class="invalid-feedback"></div>
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
        @if(session('sukses'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('sukses') }}",
                icon: 'success',
                confirmButtonColor: '#13deb9'
            });
        @endif

        function konfirmasiHapus(id, nama) {
            Swal.fire({
                title: 'Hapus Arsip?',
                text: "Anda akan menghapus arsip ijazah milik '" + nama + "'. File juga akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FA896B',
                cancelButtonColor: '#EAEFF4',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: { cancelButton: 'text-dark' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        async function handleAjaxSubmit(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.innerText = '');

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    body: formData
                });
                const data = await response.json();

                if (!response.ok) {
                    if (response.status === 422) {
                        Object.keys(data.errors).forEach(field => {
                            const input = form.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                                if(input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                                    input.nextElementSibling.innerText = data.errors[field][0];
                                } else if(input.closest('.mb-3') && input.closest('.mb-3').querySelector('.invalid-feedback')) {
                                     input.closest('.mb-3').querySelector('.invalid-feedback').innerText = data.errors[field][0];
                                }
                            }
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Server Error', 'error');
                    }
                } else {
                    Swal.fire({ title: 'Berhasil!', text: data.message, icon: 'success', confirmButtonColor: '#13deb9' }).then(() => {
                        window.location.reload();
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Kesalahan jaringan.', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        }
    </script>
@endpush
