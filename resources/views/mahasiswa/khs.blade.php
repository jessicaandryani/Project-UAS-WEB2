@extends('layouts.dashboard')

@section('title', 'KHS - SIAKAD UNTAD')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-alt me-2"></i>Kartu Hasil Studi (KHS)
                        </h5>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success" onclick="window.print()">
                            <i class="fas fa-print me-1"></i>Cetak KHS
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Info Mahasiswa -->
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Nama:</strong> {{ $mahasiswa->nama }}<br>
                            <strong>NIM:</strong> {{ $mahasiswa->nim }}
                        </div>
                        <div class="col-md-6">
                            <strong>Jurusan:</strong> {{ $mahasiswa->jurusan }}<br>
                            <strong>Fakultas:</strong> {{ $mahasiswa->fakultas }}
                        </div>
                    </div>
                </div>

                @if($khsBySemester->count() > 0)
                    @foreach($khsBySemester as $semester => $khsItems)
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">{{ $semester }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode MK</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th>SKS</th>
                                            <th>Nilai Angka</th>
                                            <th>Nilai Huruf</th>
                                            <th>Nilai Mutu</th>
                                            <th>SKS x Mutu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalSks = 0;
                                            $totalMutu = 0;
                                        @endphp
                                        @foreach($khsItems as $index => $khs)
                                        @php
                                            $totalSks += $khs->sks;
                                            $sksXMutu = $khs->sks * $khs->nilai_mutu;
                                            $totalMutu += $sksXMutu;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><span class="badge bg-primary">{{ $khs->mataKuliah->kode_mk }}</span></td>
                                            <td>{{ $khs->mataKuliah->nama_mk }}</td>
                                            <td>{{ $khs->sks }}</td>
                                            <td>{{ $khs->nilai_angka ?? '-' }}</td>
                                            <td>
                                                @if($khs->nilai_huruf)
                                                    <span class="badge 
                                                        @if($khs->nilai_huruf === 'A') bg-success
                                                        @elseif($khs->nilai_huruf === 'B') bg-info
                                                        @elseif($khs->nilai_huruf === 'C') bg-warning
                                                        @elseif($khs->nilai_huruf === 'D') bg-danger
                                                        @else bg-dark
                                                        @endif">
                                                        {{ $khs->nilai_huruf }}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $khs->nilai_mutu ?? '-' }}</td>
                                            <td>{{ number_format($sksXMutu, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="3" class="text-end">Total:</th>
                                            <th>{{ $totalSks }}</th>
                                            <th colspan="3" class="text-end">IPS:</th>
                                            <th>
                                                <span class="badge bg-primary">
                                                    {{ $totalSks > 0 ? number_format($totalMutu / $totalSks, 2) : '0.00' }}
                                                </span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- IPK Summary -->
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <h5 class="text-primary">{{ $khsBySemester->count() }}</h5>
                                    <small class="text-muted">Semester Selesai</small>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="text-success">
                                        {{ $khsBySemester->flatten()->sum('sks') }}
                                    </h5>
                                    <small class="text-muted">Total SKS</small>
                                </div>
                                <div class="col-md-3">
                                    @php
                                        $totalSksAll = $khsBySemester->flatten()->sum('sks');
                                        $totalMutuAll = $khsBySemester->flatten()->sum(function($item) {
                                            return $item->sks * $item->nilai_mutu;
                                        });
                                        $ipk = $totalSksAll > 0 ? $totalMutuAll / $totalSksAll : 0;
                                    @endphp
                                    <h5 class="text-warning">{{ number_format($ipk, 2) }}</h5>
                                    <small class="text-muted">IPK</small>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="text-info">
                                        @if($ipk >= 3.5) Cum Laude
                                        @elseif($ipk >= 3.0) Sangat Baik
                                        @elseif($ipk >= 2.5) Baik
                                        @else Cukup
                                        @endif
                                    </h5>
                                    <small class="text-muted">Predikat</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5>Belum Ada Data KHS</h5>
                        <p>Anda belum memiliki data Kartu Hasil Studi. Data KHS akan muncul setelah nilai diinput oleh dosen.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .btn, .card-header .col-auto {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .alert {
        border: 1px solid #ddd !important;
        background: white !important;
        color: black !important;
    }
}
</style>
@endpush
@endsection
