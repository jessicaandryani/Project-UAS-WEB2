@extends('layouts.dashboard')

@section('title', 'Tambah KRS - SIAKAD UNTAD')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Tambah KRS
                </h5>
            </div>
            <div class="card-body">
                <!-- Info Semester -->
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Tahun Akademik:</strong> {{ $tahunAkademik }}<br>
                            <strong>Semester:</strong> {{ ucfirst($semesterAktif) }}
                        </div>
                        <div class="col-md-6">
                            <strong>Mahasiswa:</strong> {{ $mahasiswa->nama }}<br>
                            <strong>NIM:</strong> {{ $mahasiswa->nim }}
                        </div>
                    </div>
                </div>

                @if($kelas->count() > 0)
                    <form method="POST" action="{{ route('mahasiswa.store-krs') }}" id="krsForm">
                        @csrf
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th>Kode MK</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>Kelas</th>
                                        <th>SKS</th>
                                        <th>Jadwal</th>
                                        <th>Ruangan</th>
                                        <th>Dosen</th>
                                        <th>Kapasitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kelas as $kelasItem)
                                    <tr>
                                        <td>
                                            <input type="checkbox" 
                                                   name="kelas_ids[]" 
                                                   value="{{ $kelasItem->id }}" 
                                                   class="form-check-input kelas-checkbox"
                                                   data-sks="{{ $kelasItem->mataKuliah->sks }}"
                                                   {{ $kelasItem->jumlah_mahasiswa >= $kelasItem->kapasitas ? 'disabled' : '' }}>
                                        </td>
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
                                            @if($kelasItem->jadwal->count() > 0)
                                                @foreach($kelasItem->jadwal as $jadwal)
                                                    <small class="d-block">{{ $jadwal->ruangan }}</small>
                                                @endforeach
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                        <td>{{ $kelasItem->mataKuliah->dosen->nama }}</td>
                                        <td>
                                            <small>
                                                {{ $kelasItem->jumlah_mahasiswa }}/{{ $kelasItem->kapasitas }}
                                                @if($kelasItem->jumlah_mahasiswa >= $kelasItem->kapasitas)
                                                    <span class="badge bg-danger">Penuh</span>
                                                @elseif($kelasItem->jumlah_mahasiswa >= $kelasItem->kapasitas * 0.8)
                                                    <span class="badge bg-warning">Hampir Penuh</span>
                                                @else
                                                    <span class="badge bg-success">Tersedia</span>
                                                @endif
                                            </small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- SKS Counter -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="alert alert-warning" id="sksAlert">
                                    <strong>Total SKS Dipilih: <span id="totalSks">0</span> SKS</strong><br>
                                    <small class="text-muted">Maksimal 24 SKS per semester</small>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('mahasiswa.krs') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-secondary" id="submitBtn" disabled>
                                    <i class="fas fa-save me-1"></i>Simpan KRS
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5>Tidak Ada Kelas Tersedia</h5>
                        <p>Semua kelas untuk semester ini sudah diambil atau belum ada kelas yang tersedia.</p>
                        <a href="{{ route('mahasiswa.krs') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali ke KRS
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript loaded'); // Debug
    
    const selectAllCheckbox = document.getElementById('selectAll');
    const kelasCheckboxes = document.querySelectorAll('.kelas-checkbox');
    const totalSksSpan = document.getElementById('totalSks');
    const submitBtn = document.getElementById('submitBtn');
    const sksAlert = document.getElementById('sksAlert');

    console.log('Found checkboxes:', kelasCheckboxes.length); // Debug

    // Select All functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            kelasCheckboxes.forEach(checkbox => {
                if (!checkbox.disabled) {
                    checkbox.checked = this.checked;
                }
            });
            updateTotalSks();
        });
    }

    // Individual checkbox change
    kelasCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            console.log('Checkbox changed:', this.value, this.checked); // Debug
            updateSelectAllState();
            updateTotalSks();
        });
    });

    function updateSelectAllState() {
        if (selectAllCheckbox) {
            const enabledCheckboxes = document.querySelectorAll('.kelas-checkbox:not(:disabled)');
            const checkedCount = document.querySelectorAll('.kelas-checkbox:checked').length;
            const totalCount = enabledCheckboxes.length;
            
            selectAllCheckbox.checked = checkedCount === totalCount && totalCount > 0;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
        }
    }

    function updateTotalSks() {
        let totalSks = 0;
        const checkedCheckboxes = document.querySelectorAll('.kelas-checkbox:checked');
        
        checkedCheckboxes.forEach(checkbox => {
            const sks = parseInt(checkbox.getAttribute('data-sks')) || 0;
            totalSks += sks;
            console.log('Adding SKS:', sks, 'Total now:', totalSks); // Debug
        });

        console.log('Final total SKS:', totalSks); // Debug

        if (totalSksSpan) {
            totalSksSpan.textContent = totalSks;
        }
        
        // Enable/disable submit button
        if (submitBtn) {
            if (totalSks > 0 && totalSks <= 24) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-secondary');
                submitBtn.classList.add('btn-primary');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-secondary');
            }
        }

        // Warning for exceeding SKS limit
        if (sksAlert) {
            if (totalSks > 24) {
                sksAlert.classList.remove('alert-warning');
                sksAlert.classList.add('alert-danger');
            } else {
                sksAlert.classList.remove('alert-danger');
                sksAlert.classList.add('alert-warning');
            }
        }
    }

    // Initial calculation
    updateTotalSks();
});
</script>
@endpush
