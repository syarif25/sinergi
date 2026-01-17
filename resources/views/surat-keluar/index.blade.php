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
                    <h4 class="fw-semibold mb-8">Surat Keluar</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Surat Keluar</li>
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
            <form action="{{ route('surat-keluar.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jenis Surat</label>
                        <select class="form-select" name="id_jenis_surat">
                            <option value="">Semua Jenis</option>
                            @foreach($daftarJenis as $jenis)
                                <option value="{{ $jenis->id_jenis_surat }}" {{ request('id_jenis_surat') == $jenis->id_jenis_surat ? 'selected' : '' }}>
                                    {{ $jenis->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-filter me-1"></i>Tampilkan
                        </button>
                        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">
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
                        <h4 class="card-title">Data Surat Keluar</h4>
                        <p class="card-subtitle">Kelola arsip surat keluar</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="ti ti-plus me-2"></i>Tambah Surat
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="table-surat-keluar" class="table table-striped table-bordered text-nowrap align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th>Tanggal</th>
                                <th>Tujuan / Perihal</th>
                                <th>Jenis</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarSurat as $key => $surat)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $surat->nomor_surat }}</td>
                                <td>{{ date('d/m/Y', strtotime($surat->tanggal_surat)) }}</td>
                                <td>
                                    <strong>{{ $surat->tujuan }}</strong><br>
                                    <small>{{ Str::limit($surat->perihal, 30) }}</small>
                                </td>
                                <td><span class="badge bg-secondary rounded-3 fw-semibold">{{ $surat->jenisSurat->nama_jenis ?? '-' }}</span></td>
                                <td>
                                    @if($surat->file_surat)
                                        <a href="{{ Storage::url($surat->file_surat) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="ti ti-file-download"></i> Lihat
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $surat->id_surat_keluar }}">
                                            <i class="ti ti-pencil"></i>
                                        </button>
                                        <form id="delete-form-{{ $surat->id_surat_keluar }}" action="{{ route('surat-keluar.hapus', $surat->id_surat_keluar) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus('{{ $surat->id_surat_keluar }}', '{{ $surat->nomor_surat }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEdit{{ $surat->id_surat_keluar }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Surat Keluar</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form id="formEdit{{ $surat->id_surat_keluar }}" action="{{ route('surat-keluar.ubah', $surat->id_surat_keluar) }}" method="POST" enctype="multipart/form-data" onsubmit="handleAjaxSubmit(event)">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Nomor Surat</label>
                                                                <input type="text" class="form-control" name="nomor_surat" value="{{ $surat->nomor_surat }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Jenis Surat</label>
                                                                <select class="form-select" name="id_jenis_surat" required>
                                                                    <option value="" disabled>Pilih Jenis</option>
                                                                    @foreach($daftarJenis as $jenis)
                                                                        <option value="{{ $jenis->id_jenis_surat }}" {{ $surat->id_jenis_surat == $jenis->id_jenis_surat ? 'selected' : '' }}>{{ $jenis->nama_jenis }} ({{ $jenis->kode_surat }})</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Tanggal Surat</label>
                                                                <input type="date" class="form-control" name="tanggal_surat" value="{{ $surat->tanggal_surat }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Tujuan</label>
                                                                <input type="text" class="form-control" name="tujuan" value="{{ $surat->tujuan }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Perihal</label>
                                                            <input type="text" class="form-control" name="perihal" value="{{ $surat->perihal }}" required>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">File Surat (Biarkan kosong jika tidak diubah)</label>
                                                            <input type="file" class="form-control" name="file_surat" accept=".pdf,.jpg,.jpeg,.png">
                                                            <div class="form-text">Format: PDF, JPG, PNG. Max 2MB.</div>
                                                            <div class="invalid-feedback"></div>
                                                            @if($surat->file_surat)
                                                                <div class="mt-2">File saat ini: <a href="{{ Storage::url($surat->file_surat) }}" target="_blank">Lihat</a></div>
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Surat Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambah" action="{{ route('surat-keluar.simpan') }}" method="POST" enctype="multipart/form-data" onsubmit="handleAjaxSubmit(event)">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Surat</label>
                                <input type="text" class="form-control" name="nomor_surat" placeholder="No. Surat..." required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Surat</label>
                                <select class="form-select" name="id_jenis_surat" required>
                                    <option selected disabled>Pilih Jenis</option>
                                    @foreach($daftarJenis as $jenis)
                                        <option value="{{ $jenis->id_jenis_surat }}">{{ $jenis->nama_jenis }} ({{ $jenis->kode_surat }})</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Surat</label>
                                <input type="date" class="form-control" name="tanggal_surat" value="{{ date('Y-m-d') }}" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tujuan</label>
                                <input type="text" class="form-control" name="tujuan" placeholder="Kepada Yth..." required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Perihal</label>
                            <input type="text" class="form-control" name="perihal" placeholder="Perihal surat..." required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Surat</label>
                            <input type="file" class="form-control" name="file_surat" accept=".pdf,.jpg,.jpeg,.png" required>
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
        $(document).ready(function() {
            $('#table-surat-keluar').DataTable({
                scrollX: true,
                "order": []
            });
        });
    </script>

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
                title: 'Hapus Surat?',
                text: "Anda akan menghapus surat nomor '" + nama + "'. File surat juga akan dihapus.",
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
