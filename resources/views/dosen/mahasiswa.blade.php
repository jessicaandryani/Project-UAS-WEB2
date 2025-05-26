@extends('layouts.dashboard')

@section('title', 'Daftar Mahasiswa - SIAKAD UNTAD')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>Daftar Mahasiswa
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

                @if(isset($kelas) && isset($mahasiswaList))
                    <!-- Info Kelas -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0">
                                        {{ $kelas->mataKuliah->nama_mk }} - Kelas {{ $kelas->nama_kelas }}
                                    </h6>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('dosen.input-nilai', ['kelas' => $kelas->id]) }}" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-edit me-1"></i>Input Nilai
                                    </a>
                                </div>
                            </div>
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
                                    <strong>Kapasitas:</strong> {{ $mahasiswaList->count() }}/{{ $kelas->kapasitas }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Jadwal:</strong>
                                    @if($kelas->jadwal->count() > 0)
                                        @foreach($kelas->jadwal as $jadwal)
                                            <small class="d-block">
                                                {{ ucfirst($jadwal->hari) }}, 
                                                {{ date('H:i', strtotime($jadwal->jam_mulai)) }}-{{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                            </small>
                                        @endforeach
                                    @else
                                        <small class="text-muted">Belum dijadwalkan</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($mahasiswaList->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Semester</th>
                                        <th>Status KRS</th>
                                        <th>Tanggal Daftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mahasiswaList as $index => $krs)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $krs->mahasiswa->nim }}</span>
                                        </td>
                                        <td>{{ $krs->mahasiswa->nama }}</td>
                                        <td>{{ $krs->mahasiswa->semester }}</td>
                                        <td>
                                            @if($krs->status === 'diambil')
                                                <span class="badge bg-info">Aktif</span>
                                            @elseif($krs->status === 'lulus')
                                                <span class="badge bg-success">Lulus</span>
                                            @elseif($krs->status === 'tidak_lulus')
                                                <span class="badge bg-danger">Tidak Lulus</span>
                                            @else
                                                <span class="badge bg-warning">Mengulang</span>
                                            @endif
                                        </td>
                                        <td>{{ $krs->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-primary">{{ $mahasiswaList->count() }}</h5>
                                        <small class="text-muted">Total Mahasiswa</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-success">{{ $mahasiswaList->where('status', 'diambil')->count() }}</h5>
                                        <small class="text-muted">Mahasiswa Aktif</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-info">{{ number_format(($mahasiswaList->count() / $kelas->kapasitas) * 100, 1) }}%</h5>
                                        <small class="text-muted">Tingkat Hunian</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <h5>Belum Ada Mahasiswa</h5>
                            <p>Belum ada mahasiswa yang mengambil kelas ini.</p>
                        </div>
                    @endif

                @elseif(isset($kelasList))
                    <!-- Pilih Kelas -->
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Pilih kelas untuk melihat daftar mahasiswa</strong>
                    </div>

                    <div class="row">
                        @foreach($kelasList as $kelasItem)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">{{ $kelasItem->mataKuliah->kode_mk }} - {{ $kelasItem->nama_kelas }}</h6>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">{{ $kelasItem->mataKuliah->nama_mk }}</h6>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            <i class="fas fa-graduation-cap me-1"></i>{{ $kelasItem->mataKuliah->sks }} SKS<br>
                                            <i class="fas fa-users me-1"></i>{{ $kelasItem->jumlah_mahasiswa }}/{{ $kelasItem->kapasitas }} Mahasiswa
                                        </small>
                                    </p>
                                    @if($kelasItem->jadwal->count() > 0)
                                        @foreach($kelasItem->jadwal as $jadwal)
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ ucfirst($jadwal->hari) }}, 
                                                    {{ date('H:i', strtotime($jadwal->jam_mulai)) }}-{{ date('H:i', strtotime($jadwal->jam_selesai)) }}<br>
                                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $jadwal->ruangan }}
                                                </small>
                                            </p>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('dosen.mahasiswa', ['kelas' => $kelasItem->id]) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-users me-1"></i>Lihat Mahasiswa
                                        </a>
                                        <a href="{{ route('dosen.input-nilai', ['kelas' => $kelasItem->id]) }}" 
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-edit me-1"></i>Input Nilai
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5>Belum Ada Kelas</h5>
                        <p>Anda belum memiliki kelas yang diampu untuk semester ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
