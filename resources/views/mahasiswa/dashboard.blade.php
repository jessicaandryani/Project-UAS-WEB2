@extends('layouts.dashboard')

@section('title', 'Dashboard Mahasiswa - SIAKAD UNTAD')

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
                                <i class="fas fa-graduation-cap me-2"></i>
                                Selamat Datang, {{ $mahasiswa->nama }}!
                            </h2>
                            <p class="card-text mb-0 opacity-90">
                                <strong>NIM:</strong> {{ $mahasiswa->nim }} | 
                                <strong>Program Studi:</strong> {{ $mahasiswa->program_studi }} | 
                                <strong>Semester:</strong> {{ $mahasiswa->semester }}
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="bg-white bg-opacity-20 rounded p-3">
                                <h5 class="mb-1">IPK Saat Ini</h5>
                                <h3 class="mb-0 fw-bold">{{ number_format($mahasiswa->ipk, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-book text-danger fs-4"></i>
                    </div>
                    <h5 class="card-title">Kelola KRS</h5>
                    <p class="card-text text-muted">Tambah atau lihat Kartu Rencana Studi</p>
                    <a href="{{ route('mahasiswa.krs') }}" class="btn btn-danger">
                        <i class="fas fa-arrow-right me-1"></i> Akses KRS
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-file-alt text-success fs-4"></i>
                    </div>
                    <h5 class="card-title">Lihat KHS</h5>
                    <p class="card-text text-muted">Kartu Hasil Studi dan transkrip nilai</p>
                    <a href="{{ route('mahasiswa.khs') }}" class="btn btn-success">
                        <i class="fas fa-arrow-right me-1"></i> Lihat KHS
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-calendar text-info fs-4"></i>
                    </div>
                    <h5 class="card-title">Jadwal Kuliah</h5>
                    <p class="card-text text-muted">Lihat jadwal perkuliahan semester ini</p>
                    <a href="#" class="btn btn-info">
                        <i class="fas fa-arrow-right me-1"></i> Lihat Jadwal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Visi & Misi Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-secondary text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-university me-2"></i>
                        VISI & MISI UNIVERSITAS TADULAKO
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Visi -->
                    <div class="mb-4">
                        <h4 class="text-center mb-3 fw-bold text-danger">Visi</h4>
                        <div class="bg-light p-3 rounded">
                            <p class="text-center mb-0 fst-italic">
                                "Universitas Tadulako Menjadi Perguruan Tinggi Berstandar Internasional Dalam Pengembangan IPTEKS Berwawasan Lingkungan Hidup"
                            </p>
                        </div>
                    </div>

                    <!-- Misi -->
                    <div>
                        <h4 class="text-center mb-3 fw-bold text-danger">Misi</h4>
                        <div class="row">
                            <div class="col-12">
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 bg-light mb-2 rounded">
                                        Menyelenggarakan pendidikan yang bermutu, modern, dan relevan menuju pencapaian standar internasional dalam pengembangan IPTEKS berwawasan lingkungan hidup.
                                    </li>
                                    <li class="list-group-item border-0 bg-light mb-2 rounded">
                                        Menyelenggarakan penelitian yang bermutu untuk pengembangan IPTEKS berwawasan lingkungan hidup.
                                    </li>
                                    <li class="list-group-item border-0 bg-light mb-2 rounded">
                                        Menyelenggarakan pengabdian kepada masyarakat sebagai pemanfaatan hasil pendidikan dan hasil penelitian yang di butuhkan dalam pembangunan masyarakat.
                                    </li>
                                    <li class="list-group-item border-0 bg-light mb-2 rounded">
                                        Menyelenggarakan akan reformasi birokrasi dan kerjasama regional, nasional dan internasional.
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tutorial Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-warning text-dark py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-play-circle me-2"></i>
                        TUTORIAL PENGGUNAAN SIAKAD
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-dark">Mahasiswa Harus Mandiri Ber KRS</h4>
                        <p class="text-muted fst-italic">say to no for GAPTEK</p>
                    </div>

                    <!-- YouTube Video Embed -->
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="ratio ratio-16x9 rounded overflow-hidden shadow">
                                <iframe 
                                    src="https://www.youtube.com/embed/47z0v-J1uTM" 
                                    title="Tutorial SIAKAD UNTAD - Cara Reset Password User"
                                    allowfullscreen
                                    class="rounded">
                                </iframe>
                            </div>
                            <div class="text-center mt-3">
                                <p class="text-muted mb-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Cara Reset Password User
                                </p>
                                <a href="https://www.youtube.com/watch?v=47z0v-J1uTM" 
                                   target="_blank" 
                                   class="btn btn-outline-danger btn-sm">
                                    <i class="fab fa-youtube me-1"></i>
                                    Tonton di YouTube
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tutorial Tips -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="bg-danger bg-opacity-10 p-3 rounded">
                                <h6 class="fw-bold text-danger">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Tips Penggunaan SIAKAD
                                </h6>
                                <ul class="list-unstyled mb-0 small">
                                    <li><i class="fas fa-check text-success me-1"></i> Selalu logout setelah selesai</li>
                                    <li><i class="fas fa-check text-success me-1"></i> Gunakan browser terbaru</li>
                                    <li><i class="fas fa-check text-success me-1"></i> Simpan password dengan aman</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <h6 class="fw-bold text-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Perhatian
                                </h6>
                                <ul class="list-unstyled mb-0 small">
                                    <li><i class="fas fa-times text-danger me-1"></i> Jangan share akun dengan orang lain</li>
                                    <li><i class="fas fa-times text-danger me-1"></i> Jangan akses dari warnet</li>
                                    <li><i class="fas fa-times text-danger me-1"></i> Jangan lupa isi KRS tepat waktu</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Summary -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Ringkasan Akademik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-danger mb-1">{{ $mahasiswa->total_sks }}</h4>
                                <small class="text-muted">Total SKS</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">{{ $mahasiswa->semester }}</h4>
                            <small class="text-muted">Semester</small>
                        </div>
                    </div>
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
                            <small class="text-muted">Semester {{ $mahasiswa->semester }} - Tahun Akademik 2024/2025</small>
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
.bg-gradient-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}
</style>
@endsection
