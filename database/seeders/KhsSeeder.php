<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Khs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;

class KhsSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa = Mahasiswa::first();
        $mataKuliah = MataKuliah::take(2)->get(); // Ambil 2 mata kuliah untuk semester sebelumnya

        $nilaiData = [
            ['angka' => 85, 'huruf' => 'A', 'mutu' => 4.0],
            ['angka' => 78, 'huruf' => 'B', 'mutu' => 3.0],
        ];

        foreach ($mataKuliah as $index => $mk) {
            Khs::create([
                'mahasiswa_id' => $mahasiswa->id,
                'mata_kuliah_id' => $mk->id,
                'tahun_akademik' => '2023/2024',
                'semester_aktif' => 'genap',
                'nilai_angka' => $nilaiData[$index]['angka'],
                'nilai_huruf' => $nilaiData[$index]['huruf'],
                'nilai_mutu' => $nilaiData[$index]['mutu'],
                'sks' => $mk->sks,
            ]);
        }
    }
}
