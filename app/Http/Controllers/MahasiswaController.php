<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;  // Tambahkan ini
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Krs;
use App\Models\Khs;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        return view('mahasiswa.dashboard', compact('mahasiswa'));
    }

    public function tambahKrs()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $tahunAkademik = '2024/2025';
        $semesterAktif = 'ganjil';
        
        // Get available kelas for current semester
        $kelas = Kelas::whereHas('mataKuliah', function($query) use ($mahasiswa) {
                $query->where('fakultas', $mahasiswa->fakultas)
                      ->where('jurusan', $mahasiswa->jurusan)
                      ->where('semester', '<=', $mahasiswa->semester)
                      ->where('status', 'aktif');
            })
            ->where('tahun_akademik', $tahunAkademik)
            ->where('semester_aktif', $semesterAktif)
            ->where('status', 'aktif')
            ->whereNotIn('mata_kuliah_id', function($query) use ($mahasiswa, $tahunAkademik, $semesterAktif) {
                $query->select('mata_kuliah_id')
                    ->from('krs')
                    ->where('mahasiswa_id', $mahasiswa->id)
                    ->where('tahun_akademik', $tahunAkademik)
                    ->where('semester_aktif', $semesterAktif);
            })
            ->with(['mataKuliah.dosen', 'jadwal'])
            ->get();

        return view('mahasiswa.tambah-krs', compact('mahasiswa', 'kelas', 'tahunAkademik', 'semesterAktif'));
    }

    public function storeKrs(Request $request)
    {
        try {
            $mahasiswa = Auth::user()->mahasiswa; // Gunakan relationship yang sudah ada
            
            if (!$mahasiswa) {
                return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
            }

            $request->validate([
                'kelas_ids' => 'required|array',
                'kelas_ids.*' => 'exists:kelas,id'
            ]);

            $kelasIds = $request->kelas_ids;
            $totalSks = 0;
            $errors = [];

            // Validasi SKS dan kapasitas
            foreach ($kelasIds as $kelasId) {
                $kelas = Kelas::with('mataKuliah')->find($kelasId);
                
                if (!$kelas) {
                    $errors[] = "Kelas tidak ditemukan";
                    continue;
                }

                // Cek apakah sudah diambil
                $existingKrs = Krs::where('mahasiswa_id', $mahasiswa->id)
                                 ->where('kelas_id', $kelasId)
                                 ->first();
                
                if ($existingKrs) {
                    $errors[] = "Mata kuliah {$kelas->mataKuliah->nama_mk} sudah diambil";
                    continue;
                }

                // Cek kapasitas kelas
                if ($kelas->jumlah_mahasiswa >= $kelas->kapasitas) {
                    $errors[] = "Kelas {$kelas->mataKuliah->nama_mk} - {$kelas->nama_kelas} sudah penuh";
                    continue;
                }

                $totalSks += $kelas->mataKuliah->sks;
            }

            // Cek total SKS
            if ($totalSks > 24) {
                $errors[] = "Total SKS melebihi batas maksimal (24 SKS)";
            }

            if (!empty($errors)) {
                return redirect()->back()->with('error', implode('<br>', $errors));
            }

            // Simpan KRS
            foreach ($kelasIds as $kelasId) {
                $kelas = Kelas::find($kelasId);
                
                Krs::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'kelas_id' => $kelasId,
                    'mata_kuliah_id' => $kelas->mata_kuliah_id,
                    'semester' => $mahasiswa->semester,
                    'tahun_akademik' => '2024/2025' // Sesuaikan dengan tahun akademik yang aktif
                ]);

                // Update jumlah mahasiswa di kelas
                $kelas->increment('jumlah_mahasiswa');
            }

            return redirect()->route('mahasiswa.krs')->with('success', 'KRS berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function krs()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $tahunAkademik = '2024/2025';
        $semesterAktif = 'ganjil';
        
        $krs = Krs::where('mahasiswa_id', $mahasiswa->id)
            ->where('tahun_akademik', $tahunAkademik)
            ->where('semester_aktif', $semesterAktif)
            ->with(['mataKuliah.dosen', 'kelas.jadwal'])
            ->get();

        $totalSks = $krs->sum(function($item) {
            return $item->mataKuliah->sks;
        });

        return view('mahasiswa.krs', compact('mahasiswa', 'krs', 'totalSks', 'tahunAkademik', 'semesterAktif'));
    }

    public function deleteKrs($id)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $krs = Krs::where('id', $id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->first();

        if ($krs) {
            // Kurangi jumlah mahasiswa di kelas
            $kelas = Kelas::find($krs->kelas_id);
            if ($kelas) {
                $kelas->decrement('jumlah_mahasiswa');
            }
            
            $krs->delete();
            return redirect()->route('mahasiswa.krs')->with('success', 'Mata kuliah berhasil dihapus dari KRS!');
        }

        return redirect()->route('mahasiswa.krs')->with('error', 'Mata kuliah tidak ditemukan!');
    }

    public function khs()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $khs = Khs::where('mahasiswa_id', $mahasiswa->id)
            ->with(['mataKuliah.dosen'])
            ->orderBy('tahun_akademik', 'desc')
            ->orderBy('semester_aktif', 'desc')
            ->get();

        // Group by semester
        $khsBySemester = $khs->groupBy(function($item) {
            return $item->tahun_akademik . ' - ' . ucfirst($item->semester_aktif);
        });

        return view('mahasiswa.khs', compact('mahasiswa', 'khsBySemester'));
    }
}
