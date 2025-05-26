<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\Krs;
use App\Models\Khs;
use App\Models\Mahasiswa;

class DosenController extends Controller
{
    public function dashboard()
    {
        $dosen = Auth::user()->dosen;
        return view('dosen.dashboard', compact('dosen'));
    }

    public function jadwal()
    {
        $dosen = Auth::user()->dosen;
        
        $kelas = Kelas::whereHas('mataKuliah', function($query) use ($dosen) {
                $query->where('dosen_id', $dosen->id);
            })
            ->where('tahun_akademik', '2024/2025')
            ->where('semester_aktif', 'ganjil')
            ->where('status', 'aktif')
            ->with(['mataKuliah', 'jadwal'])
            ->get();

        return view('dosen.jadwal', compact('dosen', 'kelas'));
    }

    public function mahasiswa(Request $request)
    {
        $dosen = Auth::user()->dosen;
        $kelasId = $request->get('kelas');
        
        if ($kelasId) {
            $kelas = Kelas::where('id', $kelasId)
                ->whereHas('mataKuliah', function($query) use ($dosen) {
                    $query->where('dosen_id', $dosen->id);
                })
                ->with(['mataKuliah', 'jadwal'])
                ->first();
                
            if ($kelas) {
                $mahasiswaList = Krs::where('kelas_id', $kelasId)
                    ->where('tahun_akademik', '2024/2025')
                    ->where('semester_aktif', 'ganjil')
                    ->with(['mahasiswa'])
                    ->get();
                    
                return view('dosen.mahasiswa', compact('dosen', 'kelas', 'mahasiswaList'));
            }
        }
        
        // Jika tidak ada kelas dipilih, tampilkan daftar kelas
        $kelasList = Kelas::whereHas('mataKuliah', function($query) use ($dosen) {
                $query->where('dosen_id', $dosen->id);
            })
            ->where('tahun_akademik', '2024/2025')
            ->where('semester_aktif', 'ganjil')
            ->where('status', 'aktif')
            ->with(['mataKuliah'])
            ->get();

        return view('dosen.mahasiswa', compact('dosen', 'kelasList'));
    }

    public function inputNilai(Request $request)
    {
        $dosen = Auth::user()->dosen;
        $kelasId = $request->get('kelas');
        
        $kelas = Kelas::where('id', $kelasId)
            ->whereHas('mataKuliah', function($query) use ($dosen) {
                $query->where('dosen_id', $dosen->id);
            })
            ->with(['mataKuliah', 'jadwal'])
            ->first();
            
        if (!$kelas) {
            return redirect()->route('dosen.mahasiswa')->with('error', 'Kelas tidak ditemukan!');
        }
        
        $mahasiswaList = Krs::where('kelas_id', $kelasId)
            ->where('tahun_akademik', '2024/2025')
            ->where('semester_aktif', 'ganjil')
            ->with(['mahasiswa'])
            ->get();
            
        // Get existing KHS data
        $existingKhs = Khs::where('mata_kuliah_id', $kelas->mata_kuliah_id)
            ->where('tahun_akademik', '2024/2025')
            ->where('semester_aktif', 'ganjil')
            ->get()
            ->keyBy('mahasiswa_id');

        return view('dosen.input-nilai', compact('dosen', 'kelas', 'mahasiswaList', 'existingKhs'));
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nilai' => 'required|array',
            'nilai.*.mahasiswa_id' => 'required|exists:mahasiswa,id',
            'nilai.*.nilai_angka' => 'required|numeric|min:0|max:100',
        ]);

        $dosen = Auth::user()->dosen;
        $kelas = Kelas::where('id', $request->kelas_id)
            ->whereHas('mataKuliah', function($query) use ($dosen) {
                $query->where('dosen_id', $dosen->id);
            })
            ->first();

        if (!$kelas) {
            return redirect()->route('dosen.mahasiswa')->with('error', 'Unauthorized access!');
        }

        foreach ($request->nilai as $nilaiData) {
            $nilaiAngka = $nilaiData['nilai_angka'];
            
            // Convert to letter grade and grade point
            if ($nilaiAngka >= 85) {
                $nilaiHuruf = 'A';
                $nilaiMutu = 4.0;
            } elseif ($nilaiAngka >= 70) {
                $nilaiHuruf = 'B';
                $nilaiMutu = 3.0;
            } elseif ($nilaiAngka >= 55) {
                $nilaiHuruf = 'C';
                $nilaiMutu = 2.0;
            } elseif ($nilaiAngka >= 40) {
                $nilaiHuruf = 'D';
                $nilaiMutu = 1.0;
            } else {
                $nilaiHuruf = 'E';
                $nilaiMutu = 0.0;
            }

            Khs::updateOrCreate(
                [
                    'mahasiswa_id' => $nilaiData['mahasiswa_id'],
                    'mata_kuliah_id' => $kelas->mata_kuliah_id,
                    'tahun_akademik' => '2024/2025',
                    'semester_aktif' => 'ganjil',
                ],
                [
                    'nilai_angka' => $nilaiAngka,
                    'nilai_huruf' => $nilaiHuruf,
                    'nilai_mutu' => $nilaiMutu,
                    'sks' => $kelas->mataKuliah->sks,
                ]
            );
        }

        return redirect()->route('dosen.input-nilai', ['kelas' => $kelas->id])
            ->with('success', 'Nilai berhasil disimpan!');
    }

    public function absensi()
    {
        $dosen = Auth::user()->dosen;
        return view('dosen.absensi', compact('dosen'));
    }
}
