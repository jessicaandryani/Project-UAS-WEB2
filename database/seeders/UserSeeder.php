<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Mahasiswa
        $mahasiswaUser = User::create([
            'username' => 'mahasiswa1',
            'email' => 'mahasiswa1@untad.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $mahasiswaUser->id,
            'nim' => 'J1A123001',
            'nama' => 'Ahmad Mahasiswa',
            'jurusan' => 'Teknik Informatika',
            'fakultas' => 'MIPA',
            'semester' => 5,
            'tahun_masuk' => 2022,
        ]);

        // Create Dosen
        $dosenUser = User::create([
            'username' => 'dosen1',
            'email' => 'dosen1@untad.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        Dosen::create([
            'user_id' => $dosenUser->id,
            'nip' => '198501012010121001',
            'nama' => 'Dr. Budi Dosen, M.Kom',
            'fakultas' => 'MIPA',
            'jurusan' => 'Teknik Informatika',
        ]);
    }
}
