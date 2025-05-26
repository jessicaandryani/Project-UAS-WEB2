<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Jadwal;

class KelasJadwalSeeder extends Seeder
{
    public function run(): void
    {
        $mataKuliah = MataKuliah::all();
        $tahunAkademik = '2024/2025';
        $semesterAktif = 'ganjil';

        $jadwalData = [
            ['hari' => 'senin', 'jam_mulai' => '08:00', 'jam_selesai' => '10:30', 'ruangan' => 'Lab Komputer 1'],
            ['hari' => 'selasa', 'jam_mulai' => '10:30', 'jam_selesai' => '13:00', 'ruangan' => 'Ruang Kelas A'],
            ['hari' => 'rabu', 'jam_mulai' => '13:00', 'jam_selesai' => '15:30', 'ruangan' => 'Lab Komputer 2'],
            ['hari' => 'kamis', 'jam_mulai' => '08:00', 'jam_selesai' => '10:30', 'ruangan' => 'Ruang Kelas B'],
            ['hari' => 'jumat', 'jam_mulai' => '10:30', 'jam_selesai' => '13:00', 'ruangan' => 'Lab Komputer 3'],
        ];

        foreach ($mataKuliah as $index => $mk) {
            // Buat 2 kelas untuk setiap mata kuliah
            $kelasNames = ['A', 'B'];
            
            foreach ($kelasNames as $kelasName) {
                $kelas = Kelas::create([
                    'mata_kuliah_id' => $mk->id,
                    'nama_kelas' => $kelasName,
                    'kapasitas' => 40,
                    'tahun_akademik' => $tahunAkademik,
                    'semester_aktif' => $semesterAktif,
                    'status' => 'aktif',
                ]);

                // Buat jadwal untuk kelas
                $jadwalIndex = ($index * 2 + array_search($kelasName, $kelasNames)) % count($jadwalData);
                Jadwal::create([
                    'kelas_id' => $kelas->id,
                    'hari' => $jadwalData[$jadwalIndex]['hari'],
                    'jam_mulai' => $jadwalData[$jadwalIndex]['jam_mulai'],
                    'jam_selesai' => $jadwalData[$jadwalIndex]['jam_selesai'],
                    'ruangan' => $jadwalData[$jadwalIndex]['ruangan'],
                ]);
            }
        }
    }
}
