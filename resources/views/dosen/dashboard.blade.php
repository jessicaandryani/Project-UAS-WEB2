@extends('layouts.dashboard')

@section('title', 'Dashboard Dosen - SIAKAD UNTAD')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="card-title mb-2">
                                <i class="fas fa-chalkboard-teacher me-2"></i>
                                Selamat Datang, {{ $dosen->nama }}!
                            </h2>
                            <p class="card-text mb-0 opacity-90">
                                <strong>NIP:</strong> {{ $dosen->nip }} | 
                                <strong>Fakultas:</strong> {{ $dosen->fakultas }} | 
                                <strong>Jurusan:</strong> {{ $dosen->jurusan }}
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="bg-white bg-opacity-20 rounded p-3">
                                <h5 class="mb-1">Status</h5>
                                <h3 class="mb-0 fw-bold">Aktif</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-calendar-alt text-primary fs-4"></i>
                    </div>
                    <h5 class="card-title">Jadwal Mengajar</h5>
                    <p class="card-text text-muted">Lihat jadwal mata kuliah yang diampu</p>
                    <a href="{{ route('dosen.jadwal') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-1"></i> Akses
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-users text-success fs-4"></i>
                    </div>
                    <h5 class="card-title">Daftar Mahasiswa</h5>
                    <p class="card-text text-muted">Lihat daftar mahasiswa yang mengambil mata kuliah</p>
                    <a href="{{ route('dosen.mahasiswa') }}" class="btn btn-success">
                        <i class="fas fa-arrow-right me-1"></i> Akses
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-edit text-warning fs-4"></i>
                    </div>
                    <h5 class="card-title">Input Nilai</h5>
                    <p class="card-text text-muted">Input dan kelola nilai mahasiswa</p>
                    <a href="{{ route('dosen.input-nilai') }}" class="btn btn-warning">
                        <i class="fas fa-arrow-right me-1"></i> Akses
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-clipboard-check text-info fs-4"></i>
                    </div>
                    <h5 class="card-title">Kelola Absensi</h5>
                    <p class="card-text text-muted">Kelola dan pantau absensi mahasiswa</p>
                    <a href="{{ route('dosen.absensi') }}" class="btn btn-info">
                        <i class="fas fa-arrow-right me-1"></i> Akses
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Summary -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>
                        Informasi Dosen
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>:</td>
                            <td>{{ $dosen->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>NIP</strong></td>
                            <td>:</td>
                            <td>{{ $dosen->nip }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jurusan</strong></td>
                            <td>:</td>
                            <td>{{ $dosen->jurusan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fakultas</strong></td>
                            <td>:</td>
                            <td>{{ $dosen->fakultas }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calendar-check me-2"></i>
                        Status Akademik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-check text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Status: Aktif</h6>
                            <small class="text-muted">Tahun Akademik 2024/2025 - Semester Ganjil</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}
</style>
@endsection
