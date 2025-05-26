@extends('layouts.dashboard')

@section('title', 'Absensi - SIAKAD UNTAD')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clipboard-check me-2"></i>Kelola Absensi
                </h5>
            </div>
            <div class="card-body">
                <!-- Info Dosen -->
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Dosen:</strong> {{ $dosen->nama }}<br>
                            <strong>NIP:</strong> {{ $dosen->nip }}
                        </div>
                        <div class="col-md-6">
                            <strong>Fakultas:</strong> {{ $dosen->fakultas }}<br>
                            <strong>Jurusan:</strong> {{ $dosen->jurusan }}
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning text-center">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h5>Fitur Dalam Pengembangan</h5>
                    <p>Fitur kelola absensi sedang dalam tahap pengembangan. Akan memungkinkan Anda untuk mengelola absensi mahasiswa dalam mata kuliah yang diampu.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
