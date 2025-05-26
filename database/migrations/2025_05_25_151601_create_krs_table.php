<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliah')->onDelete('cascade');
            $table->string('tahun_akademik');
            $table->enum('semester_aktif', ['ganjil', 'genap']);
            $table->enum('status', ['diambil', 'lulus', 'tidak_lulus', 'mengulang'])->default('diambil');
            $table->timestamps();
            
            // Prevent duplicate enrollment with custom constraint name
            $table->unique(['mahasiswa_id', 'mata_kuliah_id', 'tahun_akademik', 'semester_aktif'], 'krs_unique_enrollment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
