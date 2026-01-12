@extends('layouts.app')

@section('content')
                    <div class="row">
                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100 bg-primary-subtle overflow-hidden shadow-none">
                                <div class="card-body position-relative">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="d-flex align-items-center mb-7">
                                                <div class="rounded-circle overflow-hidden me-6">
                                                    <img src="/assets/images/profile/user-1.jpg"
                                                        alt="modernize-img" width="40" height="40" />
                                                </div>
                                                <h5 class="fw-semibold mb-0 fs-5">Selamat Datang Kembali Admin!</h5>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="border-end pe-4 border-muted border-opacity-10">
                                                    <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                                                        12/01/2026
                                                    </h3>
                                                    <p class="mb-0 text-dark">Tanggal Hari Ini</p>
                                                </div>
                                                <div class="ps-4">
                                                    <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                                                        Active
                                                    </h3>
                                                    <p class="mb-0 text-dark">Status Sistem</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="welcome-bg-img mb-n7 text-end">
                                                <img src="/assets/images/backgrounds/welcome-bg.svg"
                                                    alt="modernize-img" class="img-fluid" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ------------------------------------------------------------------------- -->
                        <!-- Summary Cards (4 Columns) -->
                        <!-- ------------------------------------------------------------------------- -->
                        <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <h4 class="fw-semibold">15</h4>
                                    <p class="mb-2 fs-3">Surat Masuk</p>
                                    <div id="spark-surat-masuk"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <h4 class="fw-semibold">12</h4>
                                    <p class="mb-2 fs-3">Surat Keluar</p>
                                    <div id="spark-surat-keluar"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Pegawai -->
                        <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="fw-semibold">124</h4>
                                            <p class="mb-0 fs-3">Total Pegawai</p>
                                        </div>
                                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 45px;">
                                            <i class="ti ti-users fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Aset -->
                        <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="fw-semibold">1,280</h4>
                                            <p class="mb-0 fs-3">Total Aset</p>
                                        </div>
                                        <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 45px;">
                                            <i class="ti ti-box fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------- -->
                        <!-- Charts Section -->
                        <!-- ------------------------------------------------------------------------- -->
                        <div class="col-lg-8 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body">
                                    <h5 class="card-title fw-semibold">Statistik Persuratan</h5>
                                    <p class="card-subtitle mb-0">Perbandingan Surat Masuk & Keluar (6 Bulan Terakhir)
                                    </p>
                                    <div id="chart-persuratan" class="mb-3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body">
                                    <h5 class="card-title fw-semibold">Kondisi Aset</h5>
                                    <p class="card-subtitle mb-0">Ringkasan Status Inventaris</p>
                                    <div id="chart-aset" class="mt-4"></div>
                                </div>
                            </div>
                        </div>

                        <!-- ------------------------------------------------------------------------- -->
                        <!-- Recent Activity Table -->
                        <!-- ------------------------------------------------------------------------- -->

                    </div>
@endsection
