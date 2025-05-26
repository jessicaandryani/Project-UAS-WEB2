@extends('layouts.dashboard')

@section('title', 'Input Nilai - SIAKAD UNTAD')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-edit me-2"></i>Input Nilai Akhir
                        </h5>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('dosen.mahasiswa', ['kelas' => $kelas->id]) }}" 
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
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

                <!-- Info Kelas -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">
                            {{ $kelas->mataKuliah->nama_mk }} - Kelas {{ $kelas->nama_kelas }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Kode MK:</strong> {{ $kelas->mataKuliah->kode_mk }}
                            </div>
                            <div class="col-md-3">
                                <strong>SKS:</strong> {{ $kelas->mataKuliah->sks }}
                            </div>
                            <div class="col-md-3">
                                <strong>Semester:</strong> {{ $kelas->mataKuliah->semester }}
                            </div>
                            <div class="col-md-3">
                                <strong>Tahun Akademik:</strong> {{ $kelas->tahun_akademik }}
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($mahasiswaList->count() > 0)
                    <!-- Panduan Penilaian -->
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-info-circle me-2"></i>Panduan Penilaian:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small>
                                    <strong>A:</strong> 85-100 (Sangat Baik)<br>
                                    <strong>B:</strong> 70-84 (Baik)<br>
                                    <strong>C:</strong> 55-69 (Cukup)
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small>
                                    <strong>D:</strong> 40-54 (Kurang)<br>
                                    <strong>E:</strong> 0-39 (Sangat Kurang)
                                </small>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('dosen.store-nilai') }}">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Nilai Angka (0-100)</th>
                                        <th>Nilai Huruf</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mahasiswaList as $index => $krs)
                                    @php
                                        $existingNilai = $existingKhs->get($krs->mahasiswa_id);
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $krs->mahasiswa->nim }}</span>
                                        </td>
                                        <td>{{ $krs->mahasiswa->nama }}</td>
                                        <td>
                                            <input type="hidden" name="nilai[{{ $index }}][mahasiswa_id]" value="{{ $krs->mahasiswa_id }}">
                                            <input type="number" 
                                                   name="nilai[{{ $index }}][nilai_angka]" 
                                                   class="form-control nilai-input" 
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   value="{{ $existingNilai ? $existingNilai->nilai_angka : '' }}"
                                                   data-index="{{ $index }}"
                                                   placeholder="0-100">
                                        </td>
                                        <td>
                                            <span class="badge nilai-huruf" id="huruf-{{ $index }}">
                                                {{ $existingNilai ? $existingNilai->nilai_huruf : '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($existingNilai)
                                                <span class="badge bg-success">Sudah Dinilai</span>
                                            @else
                                                <span class="badge bg-warning">Belum Dinilai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <strong>Total Mahasiswa: {{ $mahasiswaList->count() }}</strong><br>
                                    <small class="text-muted">
                                        Sudah Dinilai: {{ $existingKhs->count() }} | 
                                        Belum Dinilai: {{ $mahasiswaList->count() - $existingKhs->count() }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i>Simpan Nilai
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5>Belum Ada Mahasiswa</h5>
                        <p>Belum ada mahasiswa yang mengambil kelas ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nilaiInputs = document.querySelectorAll('.nilai-input');
    
    nilaiInputs.forEach(input => {
        input.addEventListener('input', function() {
            const index = this.dataset.index;
            const nilai = parseFloat(this.value);
            const hurufSpan = document.getElementById(`huruf-${index}`);
            
            if (!isNaN(nilai)) {
                let huruf, badgeClass;
                
                if (nilai >= 85) {
                    huruf = 'A';
                    badgeClass = 'bg-success';
                } else if (nilai >= 70) {
                    huruf = 'B';
                    badgeClass = 'bg-info';
                } else if (nilai >= 55) {
                    huruf = 'C';
                    badgeClass = 'bg-warning';
                } else if (nilai >= 40) {
                    huruf = 'D';
                    badgeClass = 'bg-danger';
                } else {
                    huruf = 'E';
                    badgeClass = 'bg-dark';
                }
                
                hurufSpan.textContent = huruf;
                hurufSpan.className = `badge ${badgeClass}`;
            } else {
                hurufSpan.textContent = '-';
                hurufSpan.className = 'badge bg-secondary';
            }
        });
        
        // Trigger change event for existing values
        if (input.value) {
            input.dispatchEvent(new Event('input'));
        }
    });
});
</script>
@endpush
@endsection
