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
                    <h4 class="fw-semibold mb-8">Data Tahun Ajaran</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Data Tahun Ajaran</li>
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
                        <h4 class="card-title">Data Tahun Ajaran</h4>
                        <p class="card-subtitle">Kelola data tahun ajaran akademik</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="ti ti-plus me-2"></i>Tambah Tahun Ajaran
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered text-nowrap align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarTahunAjaran as $key => $tahunAjaran)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $tahunAjaran->tahun }}</td>
                                <td>
                                    @if($tahunAjaran->is_aktif)
                                        <span class="badge bg-success rounded-3 fw-semibold">Aktif</span>
                                    @else
                                        <span class="badge bg-danger rounded-3 fw-semibold">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $tahunAjaran->id_tahun_ajaran }}">
                                            <i class="ti ti-pencil"></i>
                                        </button>
                                        <form id="delete-form-{{ $tahunAjaran->id_tahun_ajaran }}" action="{{ route('tahun-ajaran.hapus', $tahunAjaran->id_tahun_ajaran) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus('{{ $tahunAjaran->id_tahun_ajaran }}', '{{ $tahunAjaran->tahun }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEdit{{ $tahunAjaran->id_tahun_ajaran }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Tahun Ajaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('tahun-ajaran.ubah', $tahunAjaran->id_tahun_ajaran) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tahun (contoh: 2025/2026)</label>
                                                            <input type="text" class="form-control {{ $errors->getBag('edit_' . $tahunAjaran->id_tahun_ajaran)->has('tahun') ? 'is-invalid' : '' }}" name="tahun" value="{{ old('tahun', $tahunAjaran->tahun) }}" required>
                                                            @if($errors->getBag('edit_' . $tahunAjaran->id_tahun_ajaran)->has('tahun'))
                                                                <div class="invalid-feedback">{{ $errors->getBag('edit_' . $tahunAjaran->id_tahun_ajaran)->first('tahun') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="isAktifEdit{{ $tahunAjaran->id_tahun_ajaran }}" name="is_aktif" value="1" {{ old('is_aktif', $tahunAjaran->is_aktif) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="isAktifEdit{{ $tahunAjaran->id_tahun_ajaran }}">Set sebagai Tahun Aktif</label>
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
                    <h5 class="modal-title">Tambah Tahun Ajaran Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tahun-ajaran.simpan') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tahun (contoh: 2025/2026)</label>
                            <input type="text" class="form-control {{ $errors->tambah->has('tahun') ? 'is-invalid' : '' }}" name="tahun" value="{{ old('tahun') }}" placeholder="Masukkan Tahun Ajaran" required>
                            @if($errors->tambah->has('tahun'))
                                <div class="invalid-feedback">{{ $errors->tambah->first('tahun') }}</div>
                            @endif
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="isAktifTambah" name="is_aktif" value="1" {{ old('is_aktif') ? 'checked' : '' }}>
                            <label class="form-check-label" for="isAktifTambah">Set sebagai Tahun Aktif</label>
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

        @foreach($daftarTahunAjaran as $t)
            @if($errors->hasBag('edit_' . $t->id_tahun_ajaran))
                var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit{{ $t->id_tahun_ajaran }}'));
                modalEdit.show();
            @endif
        @endforeach

        // Konfirmasi Hapus
        function konfirmasiHapus(id, tahun) {
            Swal.fire({
                title: 'Hapus Tahun Ajaran?',
                text: "Anda akan menghapus tahun ajaran '" + tahun + "'! Data yang dihapus tidak dapat dikembalikan.",
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
    </script>
@endpush
