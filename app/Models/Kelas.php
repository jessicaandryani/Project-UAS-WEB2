<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'mata_kuliah_id',
        'nama_kelas',
        'kapasitas',
        'tahun_akademik',
        'semester_aktif',
        'status',
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function krs()
    {
        return $this->hasMany(Krs::class);
    }

    public function mahasiswa()
    {
        return $this->hasManyThrough(Mahasiswa::class, Krs::class, 'kelas_id', 'id', 'id', 'mahasiswa_id');
    }

    public function getJumlahMahasiswaAttribute()
    {
        return $this->krs()->count();
    }
}
