@extends('layouts.dashboard')

@section('title', 'Jadwal Mengajar - SIAKAD UNTAD')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Jadwal Mengajar
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

                @if($kelas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode MK</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>Kelas</th>
                                    <th>SKS</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Ruangan</th>
                                    <th>Mahasiswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kelas as $index => $kelasItem)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="badge bg-primary">{{ $kelasItem->mataKuliah->kode_mk }}</span></td>
                                    <td>{{ $kelasItem->mataKuliah->nama_mk }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $kelasItem->nama_kelas }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $kelasItem->mataKuliah->sks }} SKS</span>
                                    </td>
                                    <td>
                                        @if($kelasItem->jadwal->count() > 0)
                                            @foreach($kelasItem->jadwal as $jadwal)
                                                <span class="badge bg-secondary d-block mb-1">
                                                    {{ ucfirst($jadwal->hari) }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($kelasItem->jadwal->count() > 0)
                                            @foreach($kelasItem->jadwal as $jadwal)
                                                <small class="d-block">
                                                    {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                                </small>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($kelasItem->jadwal->count() > 0)
                                            @foreach($kelasItem->jadwal as $jadwal)
                                                <small class="d-block">{{ $jadwal->ruangan }}</small>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">
                                            {{ $kelasItem->jumlah_mahasiswa }}/{{ $kelasItem->kapasitas }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dosen.mahasiswa', ['kelas' => $kelasItem->id]) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <a href="{{ route('dosen.input-nilai', ['kelas' => $kelasItem->id]) }}" 
                                               class="btn btn-success btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Jadwal Mingguan -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Jadwal Mingguan</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Jam</th>
                                            <th>Senin</th>
                                            <th>Selasa</th>
                                            <th>Rabu</th>
                                            <th>Kamis</th>
                                            <th>Jumat</th>
                                            <th>Sabtu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $jamSlots = [
                                                '08:00-10:30',
                                                '10:30-13:00',
                                                '13:00-15:30',
                                                '15:30-18:00'
                                            ];
                                            $hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
                                        @endphp
                                        @foreach($jamSlots as $jamSlot)
                                        <tr>
                                            <td class="fw-bold">{{ $jamSlot }}</td>
                                            @foreach($hari as $hariItem)
                                            <td>
                                                @php
                                                    $jadwalHari = $kelas->flatMap->jadwal->where('hari', $hariItem)
                                                        ->filter(function($jadwal) use ($jamSlot) {
                                                            $jamMulai = date('H:i', strtotime($jadwal->jam_mulai));
                                                            $jamSelesai = date('H:i', strtotime($jadwal->jam_selesai));
                                                            return $jamSlot === $jamMulai . '-' . $jamSelesai;
                                                        });
                                                @endphp
                                                @if($jadwalHari->count() > 0)
                                                    @foreach($jadwalHari as $jadwal)
                                                        <div class="small bg-light p-1 mb-1 rounded">
                                                            <strong>{{ $jadwal->kelas->mataKuliah->kode_mk }}</strong><br>
                                                            {{ $jadwal->kelas->nama_kelas }}<br>
                                                            <small>{{ $jadwal->ruangan }}</small>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5>Belum Ada Jadwal Mengajar</h5>
                        <p>Anda belum memiliki jadwal mengajar untuk semester ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
