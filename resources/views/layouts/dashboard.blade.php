<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIAKAD UNTAD')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: calc(100vh - 80px);
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        .main-content {
            margin-top: 80px; /* Account for fixed header */
        }
        .sticky-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background: linear-gradient(135deg, #e53e3e 0%, #dd6b20 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Sticky Header -->
    <div class="sticky-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center py-3 text-white">
                <h1 class="h3 mb-0 fw-bold" style="letter-spacing: 2px;">SIAKAD</h1>
                <div class="bg-danger bg-opacity-75 px-3 py-2 rounded">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span class="fw-medium">Dashboard</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar text-white">
                <div class="p-3 main-content">
                    <div class="text-center mb-4">
                        <h5 class="fw-bold">{{ Auth::user()->role == 'mahasiswa' ? 'MAHASISWA' : 'DOSEN' }}</h5>
                        <small class="opacity-75">{{ Auth::user()->name }}</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        @if(Auth::user()->role == 'mahasiswa')
                            <a class="nav-link text-white {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-white bg-opacity-25 rounded' : '' }}" 
                               href="{{ route('mahasiswa.dashboard') }}">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                            <a class="nav-link text-white {{ request()->routeIs('mahasiswa.krs') || request()->routeIs('mahasiswa.tambah-krs') ? 'bg-white bg-opacity-25 rounded' : '' }}" 
                               href="{{ route('mahasiswa.krs') }}">
                                <i class="fas fa-book me-2"></i> KRS
                            </a>
                            <a class="nav-link text-white {{ request()->routeIs('mahasiswa.khs') ? 'bg-white bg-opacity-25 rounded' : '' }}" 
                               href="{{ route('mahasiswa.khs') }}">
                                <i class="fas fa-file-alt me-2"></i> KHS
                            </a>
                        @else
                            <a class="nav-link text-white {{ request()->routeIs('dosen.dashboard') ? 'bg-white bg-opacity-25 rounded' : '' }}" 
                               href="{{ route('dosen.dashboard') }}">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                            <a class="nav-link text-white {{ request()->routeIs('dosen.jadwal') ? 'bg-white bg-opacity-25 rounded' : '' }}" 
                               href="{{ route('dosen.jadwal') }}">
                                <i class="fas fa-calendar me-2"></i> Jadwal Mengajar
                            </a>
                            <a class="nav-link text-white {{ request()->routeIs('dosen.mahasiswa') ? 'bg-white bg-opacity-25 rounded' : '' }}" 
                               href="{{ route('dosen.mahasiswa') }}">
                                <i class="fas fa-users me-2"></i> Daftar Mahasiswa
                            </a>
                            <a class="nav-link text-white {{ request()->routeIs('dosen.absensi') ? 'bg-white bg-opacity-25 rounded' : '' }}" 
                               href="{{ route('dosen.absensi') }}">
                                <i class="fas fa-check-square me-2"></i> Absensi
                            </a>
                        @endif
                        
                        <hr class="my-3 opacity-50">
                        
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link text-white border-0 bg-transparent w-100 text-start">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content p-4">
                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {!! session('error') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
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

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
