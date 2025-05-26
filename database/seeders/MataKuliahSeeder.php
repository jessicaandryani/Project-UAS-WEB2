<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataKuliah;
use App\Models\Dosen;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $dosen = Dosen::first();

        $mataKuliah = [
            [
                'kode_mk' => 'TIF101',
                'nama_mk' => 'Algoritma dan Pemrograman',
                'sks' => 3,
                'semester' => 1,
                'fakultas' => 'MIPA',
                'jurusan' => 'Teknik Informatika',
                'dosen_id' => $dosen->id,
            ],
            [
                'kode_mk' => 'TIF102',
                'nama_mk' => 'Matematika Diskrit',
                'sks' => 3,
                'semester' => 1,
                'fakultas' => 'MIPA',
                'jurusan' => 'Teknik Informatika',
                'dosen_id' => $dosen->id,
            ],
            [
                'kode_mk' => 'TIF201',
                'nama_mk' => 'Struktur Data',
                'sks' => 3,
                'semester' => 2,
                'fakultas' => 'MIPA',
                'jurusan' => 'Teknik Informatika',
                'dosen_id' => $dosen->id,
            ],
            [
                'kode_mk' => 'TIF202',
                'nama_mk' => 'Basis Data',
                'sks' => 3,
                'semester' => 2,
                'fakultas' => 'MIPA',
                'jurusan' => 'Teknik Informatika',
                'dosen_id' => $dosen->id,
            ],
            [
                'kode_mk' => 'TIF301',
                'nama_mk' => 'Pemrograman Web',
                'sks' => 3,
                'semester' => 3,
                'fakultas' => 'MIPA',
                'jurusan' => 'Teknik Informatika',
                'dosen_id' => $dosen->id,
            ],
            [
                'kode_mk' => 'TIF501',
                'nama_mk' => 'Rekayasa Perangkat Lunak',
                'sks' => 3,
                'semester' => 5,
                'fakultas' => 'MIPA',
                'jurusan' => 'Teknik Informatika',
                'dosen_id' => $dosen->id,
            ],
        ];

        foreach ($mataKuliah as $mk) {
            MataKuliah::create($mk);
        }
    }
}
