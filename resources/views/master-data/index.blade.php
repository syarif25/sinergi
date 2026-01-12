@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
@endpush

@section('content')
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Datatable Basic</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none"
                                                    href="../../main/index.html">Home</a>
                                            </li>
                                            <li class="breadcrumb-item" aria-current="page">Datatable Basic</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="col-3">
                                    <div class="text-center mb-n5">
                                        <img src="/assets/images/breadcrumb/ChatBc.png" alt="modernize-img"
                                            class="img-fluid mb-n4" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="datatables">
                        <!-- start Zero Configuration -->
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h4 class="card-title">Master Data</h4>
                                        <p class="card-subtitle">Manage your master data records</p>
                                    </div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addDataModal">
                                        <i class="ti ti-plus me-2"></i>Tambah Data
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table id="zero_config"
                                        class="table table-striped table-bordered text-nowrap align-middle">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Tiger Nixon</td>
                                                <td>tiger@example.com</td>
                                                <td>tigernixon</td>
                                                <td><span class="badge bg-primary rounded-3 fw-semibold">Admin</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button class="btn btn-sm btn-warning"><i
                                                                class="ti ti-pencil"></i></button>
                                                        <button class="btn btn-sm btn-danger"><i
                                                                class="ti ti-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Garrett Winters</td>
                                                <td>garrett@example.com</td>
                                                <td>garrettw</td>
                                                <td><span class="badge bg-secondary rounded-3 fw-semibold">User</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button class="btn btn-sm btn-warning"><i
                                                                class="ti ti-pencil"></i></button>
                                                        <button class="btn btn-sm btn-danger"><i
                                                                class="ti ti-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Ashton Cox</td>
                                                <td>ashton@example.com</td>
                                                <td>ashtonc</td>
                                                <td><span class="badge bg-info rounded-3 fw-semibold">Editor</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button class="btn btn-sm btn-warning"><i
                                                                class="ti ti-pencil"></i></button>
                                                        <button class="btn btn-sm btn-danger"><i
                                                                class="ti ti-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end Zero Configuration -->
                    </div>
                </div>
            </div>
        </div>
    <div class="modal fade" id="addDataModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="inputNama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="inputNama" placeholder="Masukkan Nama">
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmail" placeholder="Masukkan Email">
                        </div>
                        <div class="mb-3">
                            <label for="inputUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="inputUsername" placeholder="Masukkan Username">
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="inputPassword"
                                placeholder="Masukkan Password">
                        </div>
                        <div class="mb-3">
                            <label for="inputRole" class="form-label">Role</label>
                            <select class="form-select" id="inputRole">
                                <option selected disabled>Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-basic.init.js') }}"></script>
@endpush
