<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Kelas;

class KrsSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa = Mahasiswa::first();
        
        // Ambil 3 mata kuliah pertama
        $mataKuliahIds = MataKuliah::take(3)->pluck('id');
        
        foreach ($mataKuliahIds as $mataKuliahId) {
            // Ambil kelas pertama dari mata kuliah ini
            $kelas = Kelas::where('mata_kuliah_id', $mataKuliahId)->first();
            
            if ($kelas) {
                // Cek apakah sudah ada KRS untuk mahasiswa ini di mata kuliah ini
                $existingKrs = Krs::where('mahasiswa_id', $mahasiswa->id)
                    ->where('mata_kuliah_id', $mataKuliahId)
                    ->where('tahun_akademik', '2024/2025')
                    ->where('semester_aktif', 'ganjil')
                    ->first();

                if (!$existingKrs) {
                    Krs::create([
                        'mahasiswa_id' => $mahasiswa->id,
                        'mata_kuliah_id' => $mataKuliahId,
                        'kelas_id' => $kelas->id,
                        'tahun_akademik' => '2024/2025',
                        'semester_aktif' => 'ganjil',
                        'status' => 'diambil',
                    ]);
                }
            }
        }
    }
}
