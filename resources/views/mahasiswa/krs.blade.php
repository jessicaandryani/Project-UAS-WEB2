@extends('layouts.dashboard')

@section('title', 'KRS - SIAKAD UNTAD')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list-alt me-2"></i>Kartu Rencana Studi (KRS)
                        </h5>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('mahasiswa.tambah-krs') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah Mata Kuliah
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Info Semester -->
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Tahun Akademik:</strong> {{ $tahunAkademik ?? '2024/2025' }}<br>
                            <strong>Semester:</strong> {{ ucfirst($semesterAktif ?? 'ganjil') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Mahasiswa:</strong> {{ $mahasiswa->nama }}<br>
                            <strong>NIM:</strong> {{ $mahasiswa->nim }}
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

                @if($krs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode MK</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>Kelas</th>
                                    <th>SKS</th>
                                    <th>Jadwal</th>
                                    <th>Ruangan</th>
                                    <th>Dosen</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($krs as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="badge bg-primary">{{ $item->mataKuliah->kode_mk }}</span></td>
                                    <td>{{ $item->mataKuliah->nama_mk }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $item->mataKuliah->sks }} SKS</span>
                                    </td>
                                    <td>
                                        @if($item->kelas && $item->kelas->jadwal->count() > 0)
                                            @foreach($item->kelas->jadwal as $jadwal)
                                                <small class="d-block">
                                                    <strong>{{ ucfirst($jadwal->hari) }}</strong><br>
                                                    {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                                </small>
                                            @endforeach
                                        @else
                                            <small class="text-muted">Belum dijadwalkan</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->kelas && $item->kelas->jadwal->count() > 0)
                                            @foreach($item->kelas->jadwal as $jadwal)
                                                <small class="d-block">{{ $jadwal->ruangan }}</small>
                                            @endforeach
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->mataKuliah->dosen->nama }}</td>
                                    <td>
                                        @if($item->status === 'diambil')
                                            <span class="badge bg-info">Diambil</span>
                                        @elseif($item->status === 'lulus')
                                            <span class="badge bg-success">Lulus</span>
                                        @elseif($item->status === 'tidak_lulus')
                                            <span class="badge bg-danger">Tidak Lulus</span>
                                        @else
                                            <span class="badge bg-warning">Mengulang</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status === 'diambil')
                                            <form method="POST" action="{{ route('mahasiswa.delete-krs', $item->id) }}" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini dari KRS?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="4" class="text-end">Total SKS:</th>
                                    <th>
                                        <span class="badge bg-primary fs-6">{{ $totalSks }} SKS</span>
                                    </th>
                                    <th colspan="5"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Ringkasan KRS</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Jumlah Mata Kuliah:</small><br>
                                            <strong>{{ $krs->count() }} Mata Kuliah</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Total SKS:</small><br>
                                            <strong>{{ $totalSks }} SKS</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Status Beban Studi</h6>
                                    @if($totalSks < 12)
                                        <span class="badge bg-warning">Kurang dari Minimum (12 SKS)</span>
                                    @elseif($totalSks <= 18)
                                        <span class="badge bg-success">Normal (12-18 SKS)</span>
                                    @elseif($totalSks <= 24)
                                        <span class="badge bg-info">Maksimal (19-24 SKS)</span>
                                    @else
                                        <span class="badge bg-danger">Melebihi Batas (>24 SKS)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5>Belum Ada Mata Kuliah dalam KRS</h5>
                        <p>Anda belum mengambil mata kuliah untuk semester ini. Silakan tambah mata kuliah terlebih dahulu.</p>
                        <a href="{{ route('mahasiswa.tambah-krs') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah Mata Kuliah
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
