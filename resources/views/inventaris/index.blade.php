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
                    <h4 class="fw-semibold mb-8">Inventaris Aset</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Inventaris Aset</li>
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
            <form action="{{ route('inventaris.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="id_kategori">
                            <option value="">Semua Kategori</option>
                            @foreach($daftarKategori as $kategori)
                                <option value="{{ $kategori->id_kategori }}" {{ request('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Lokasi</label>
                        <select class="form-select" name="id_lokasi">
                            <option value="">Semua Lokasi</option>
                            @foreach($daftarLokasi as $lokasi)
                                <option value="{{ $lokasi->id_lokasi }}" {{ request('id_lokasi') == $lokasi->id_lokasi ? 'selected' : '' }}>
                                    {{ $lokasi->nama_lokasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" name="kondisi">
                            <option value="">Semua Kondisi</option>
                            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak" {{ request('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                            <option value="Hilang" {{ request('kondisi') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                        </select>
                    </div>
                    <div class="col-md-9 mb-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-filter me-1"></i>Tampilkan
                        </button>
                        <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">
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
                        <h4 class="card-title">Data Inventaris Aset</h4>
                        <p class="card-subtitle">Kelola data aset dan inventaris</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="ti ti-plus me-2"></i>Tambah Aset
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered text-nowrap align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Aset</th>
                                <th>Kategori / Lokasi</th>
                                <th>Kondisi</th>
                                <th>Tgl Perolehan</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarAset as $key => $aset)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><span class="badge bg-light-primary text-primary fw-semibold">{{ $aset->kode_aset }}</span></td>
                                <td>
                                    <strong>{{ $aset->nama_aset }}</strong>
                                </td>
                                <td>
                                    <small class="text-muted">Kategori:</small> {{ $aset->kategori->nama_kategori ?? '-' }}<br>
                                    <small class="text-muted">Lokasi:</small> {{ $aset->lokasi->nama_lokasi ?? '-' }}
                                </td>
                                <td>
                                    @if($aset->kondisi == 'Baik')
                                        <span class="badge bg-success rounded-3 fw-semibold">Baik</span>
                                    @elseif($aset->kondisi == 'Rusak')
                                        <span class="badge bg-warning rounded-3 fw-semibold">Rusak</span>
                                    @else
                                        <span class="badge bg-danger rounded-3 fw-semibold">Hilang</span>
                                    @endif
                                </td>
                                <td>{{ date('d/m/Y', strtotime($aset->tanggal_perolehan)) }}</td>
                                <td>Rp {{ number_format($aset->nilai_perolehan, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $aset->id_aset }}">
                                            <i class="ti ti-pencil"></i>
                                        </button>
                                        <form id="delete-form-{{ $aset->id_aset }}" action="{{ route('inventaris.hapus', $aset->id_aset) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus('{{ $aset->id_aset }}', '{{ $aset->nama_aset }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEdit{{ $aset->id_aset }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Aset</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form id="formEdit{{ $aset->id_aset }}" action="{{ route('inventaris.ubah', $aset->id_aset) }}" method="POST" onsubmit="handleAjaxSubmit(event)">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Kode Aset</label>
                                                                <input type="text" class="form-control" name="kode_aset" value="{{ $aset->kode_aset }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Nama Aset</label>
                                                                <input type="text" class="form-control" name="nama_aset" value="{{ $aset->nama_aset }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Kategori</label>
                                                                <select class="form-select" name="id_kategori" required>
                                                                    <option value="" disabled>Pilih Kategori</option>
                                                                    @foreach($daftarKategori as $kategori)
                                                                        <option value="{{ $kategori->id_kategori }}" {{ $aset->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Lokasi</label>
                                                                <select class="form-select" name="id_lokasi" required>
                                                                    <option value="" disabled>Pilih Lokasi</option>
                                                                    @foreach($daftarLokasi as $lokasi)
                                                                        <option value="{{ $lokasi->id_lokasi }}" {{ $aset->id_lokasi == $lokasi->id_lokasi ? 'selected' : '' }}>{{ $lokasi->nama_lokasi }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Kondisi</label>
                                                                <select class="form-select" name="kondisi" required>
                                                                    <option value="Baik" {{ $aset->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                                    <option value="Rusak" {{ $aset->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                                                    <option value="Hilang" {{ $aset->kondisi == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                                                                </select>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Tgl Perolehan</label>
                                                                <input type="date" class="form-control" name="tanggal_perolehan" value="{{ $aset->tanggal_perolehan }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Nilai Perolehan (Rp)</label>
                                                                <input type="text" class="form-control rupiah" name="nilai_perolehan" value="{{ number_format($aset->nilai_perolehan, 0, ',', '.') }}" required>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Keterangan</label>
                                                            <textarea class="form-control" name="keterangan" rows="2">{{ $aset->keterangan }}</textarea>
                                                            <div class="invalid-feedback"></div>
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
                    <h5 class="modal-title">Tambah Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambah" action="{{ route('inventaris.simpan') }}" method="POST" onsubmit="handleAjaxSubmit(event)">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Aset</label>
                                <input type="text" class="form-control" name="kode_aset" placeholder="Contoh: INV-2024-001" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Aset</label>
                                <input type="text" class="form-control" name="nama_aset" placeholder="Nama Barang..." required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="id_kategori" required>
                                    <option selected disabled>Pilih Kategori</option>
                                    @foreach($daftarKategori as $kategori)
                                        <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi</label>
                                <select class="form-select" name="id_lokasi" required>
                                    <option selected disabled>Pilih Lokasi</option>
                                    @foreach($daftarLokasi as $lokasi)
                                        <option value="{{ $lokasi->id_lokasi }}">{{ $lokasi->nama_lokasi }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kondisi</label>
                                <select class="form-select" name="kondisi" required>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Hilang">Hilang</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tgl Perolehan</label>
                                <input type="date" class="form-control" name="tanggal_perolehan" value="{{ date('Y-m-d') }}" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nilai Perolehan (Rp)</label>
                                <input type="text" class="form-control rupiah" name="nilai_perolehan" placeholder="0" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="2" placeholder="Keterangan tambahan..."></textarea>
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
        // Format Rupiah
        const rupiahInputs = document.querySelectorAll('.rupiah');
        rupiahInputs.forEach(input => {
            input.addEventListener('keyup', function(e) {
                input.value = formatRupiah(this.value);
            });
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

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
                title: 'Hapus Aset?',
                text: "Anda akan menghapus aset '" + nama + "'.",
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
