<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliah')->onDelete('cascade');
            $table->string('nama_kelas'); // A, B, C, dll
            $table->integer('kapasitas')->default(40);
            $table->string('tahun_akademik');
            $table->enum('semester_aktif', ['ganjil', 'genap']);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['mata_kuliah_id', 'nama_kelas', 'tahun_akademik', 'semester_aktif'], 'kelas_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
