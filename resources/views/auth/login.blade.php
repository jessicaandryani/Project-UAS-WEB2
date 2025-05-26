@extends('layouts.auth')

@section('title', 'Login - SIAKAD UNTAD')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Sticky Header -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-wider">SIAKAD</h1>
                <div class="bg-red-400 bg-opacity-80 px-4 py-2 rounded-md">
                    <div class="flex items-center text-sm font-medium">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        <span>Dashboard</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content with top padding to account for fixed header -->
    <div class="pt-20">
        <!-- UNTAD Section -->
        <div class="bg-white">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <h2 class="text-3xl font-bold text-gray-900">UNTAD</h2>
                <p class="text-gray-600 mt-1">Selamat Datang di Sistem Informasi Akademik</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-gray-50 py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid lg:grid-cols-2 gap-6">
                    <!-- Login Form -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <!-- Login Header -->
                        <div class="bg-gray-600 text-white px-4 py-3 rounded-t-lg">
                            <div class="flex items-center">
                                <i class="fas fa-user-circle mr-2"></i>
                                <span class="font-medium">Login Page</span>
                            </div>
                        </div>
                        
                        <!-- Login Form Container -->
                        <div class="p-8">
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-800 mb-1">Login</h3>
                                <p class="text-gray-500 text-sm">Siakad Untad</p>
                            </div>

                            @if ($errors->any())
                                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                                    @foreach ($errors->all() as $error)
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                                @csrf
                                
                                <!-- Username -->
                                <div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400 text-sm"></i>
                                        </div>
                                        <input type="text" 
                                               name="username" 
                                               class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-300 rounded text-sm focus:ring-1 focus:ring-red-500 focus:border-red-500 focus:bg-white transition duration-200" 
                                               placeholder="Username" 
                                               value="{{ old('username') }}" 
                                               required>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                                        </div>
                                        <input type="password" 
                                               name="password" 
                                               class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-300 rounded text-sm focus:ring-1 focus:ring-red-500 focus:border-red-500 focus:bg-white transition duration-200" 
                                               placeholder="Password" 
                                               required>
                                    </div>
                                </div>

                                <!-- Role Selection -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Login Sebagai :</label>
                                    <select name="role" 
                                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-300 rounded text-sm focus:ring-1 focus:ring-red-500 focus:border-red-500 focus:bg-white transition duration-200" 
                                            required>
                                        <option value="">----- Silahkan Pilih -----</option>
                                        <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>
                                            Mahasiswa
                                        </option>
                                        <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>
                                            Dosen
                                        </option>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-2">
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white py-3 px-4 rounded font-bold text-sm tracking-wide hover:from-red-600 hover:to-red-700 transition duration-200">
                                        SIGN IN
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Announcements -->
                    <div>
                        <!-- Pengumuman Header -->
                        <div class="bg-gray-600 text-white px-4 py-3 rounded-t-lg">
                            <div class="flex items-center">
                                <i class="fas fa-bullhorn mr-2"></i>
                                <span class="font-medium">Pengumuman</span>
                            </div>
                        </div>

                        <!-- Himbauan -->
                        <div class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-b-lg mb-4 shadow-sm">
                            <div class="px-4 py-3 border-b border-red-400 border-opacity-30">
                                <h6 class="font-semibold">Himbauan</h6>
                            </div>
                            <div class="p-4 text-sm leading-relaxed space-y-3">
                                <p>1. Disampaikan kepada seluruh mahasiswa agar berhati-hati terhadap penipuan yang mengatasnamakan dosen kemudian meminta bantuan berupa uang dan pulsa.</p>
                                <p>2. Disampaikan kepada seluruh masyarakat bahwa penerimaan mahasiswa baru Universitas Tadulako tahun 2023 pada jenjang Diploma dan Sarjana telah ditutup. Jika ada oknum yang mengatasnamakan Pimpinan Universitas Tadulako menyampaikan bahwa ada penambahan kuota mahasiswa, mohon diabaikan karena sifatnya penipuan.</p>
                            </div>
                        </div>

                        <!-- Kuesioner -->
                        <div class="bg-gradient-to-br from-teal-500 to-teal-600 text-white rounded-lg shadow-sm">
                            <div class="px-4 py-3 border-b border-teal-400 border-opacity-30">
                                <h6 class="font-semibold">Kuesioner</h6>
                            </div>
                            <div class="p-4 text-sm leading-relaxed space-y-3">
                                <p>Bagi seluruh mahasiswa Universitas Tadulako, diharapkan untuk mengisi kuesioner survey kepuasan mahasiswa atas layanan Universitas Tadulako <span class="bg-yellow-400 bg-opacity-30 px-1 py-0.5 rounded font-medium">sebelum mengisi KRS pada halaman input KRS</span>.</p>
                                <p>Kuesioner tersebut untuk mengetahui tingkat kepuasan dan kepentingan dari layanan yang telah diberikan oleh Universitas Tadulako, serta menghimpun pendapat mahasiswa untuk bahan evaluasi dan masukan dalam penyusunan rencana layanan periode berikutnya.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-800 text-white py-4 mt-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center justify-between text-sm">
                    <div class="mb-2 md:mb-0">
                        <span class="font-semibold">SIAKAD UNTAD</span>
                        <span class="text-gray-400 ml-2">Sistem Informasi Akademik Universitas Tadulako</span>
                    </div>
                    <div class="text-gray-400">
                        Version 2.0 | &copy; {{ date('Y') }} Universitas Tadulako. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
