<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard RME - RS Polije</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Design System (Must come LAST to override Bootstrap) -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        /* Additional Sidebar Overrides if needed */
        .sidebar {
            width: 280px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: white !important;
            border-right: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            bottom: 0;
            z-index: 100;
            overflow-y: auto;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background-color: var(--bg-body);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar { margin-left: -280px; }
            .main-content { margin-left: 0; }
            body.sidebar-toggled .sidebar { margin-left: 0; }
        }

        /* Desktop Toggled */
        @media (min-width: 769px) {
            body.sidebar-toggled .sidebar { margin-left: -280px; }
            body.sidebar-toggled .main-content { margin-left: 0; }
        }

        /* Active Link Style */
        .nav-link.active {
            background-color: var(--primary) !important;
            color: white !important;
            box-shadow: var(--shadow-md);
        }

        .nav-link:hover:not(.active) {
            background-color: var(--primary-light) !important;
            color: var(--primary) !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- SIDEBAR -->
    <nav class="sidebar d-flex flex-column p-0">
        <!-- Logo Area -->
        <div class="p-4 d-flex align-items-center border-bottom bg-white sticky-top">
            <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px;">
                <i class="fas fa-heartbeat fs-5"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-dark">RME Polije</h5>
                <small class="text-muted" style="font-size: 0.75rem;">Sistem Informasi RS</small>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex-grow-1 p-3">
            @php
                $user = Auth::user();
                $role = $user ? $user->role : 'guest';
            @endphp

            <ul class="nav flex-column gap-1">
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home me-3"></i> Dashboard
                    </a>
                </li>

                {{-- Admin & Pendaftaran Section --}}
                @if(in_array($role, ['admin', 'pendaftaran']))
                <div class="mt-4 mb-2 ps-3 text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Layanan Pasien</div>

                <li class="nav-item">
                    <a href="{{ route('pendaftaran.create-baru') }}" class="nav-link {{ request()->routeIs('pendaftaran.create-baru') ? 'active' : '' }}">
                        <i class="fas fa-user-plus me-3"></i> Pendaftaran Baru
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pendaftaran.list') }}" class="nav-link {{ request()->routeIs('pendaftaran.list') ? 'active' : '' }}">
                        <i class="fas fa-list-alt me-3"></i> Antrean & Kunjungan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/pasien/data') }}" class="nav-link {{ request()->is('pasien/data*') ? 'active' : '' }}">
                        <i class="fas fa-users me-3"></i> Database Pasien
                    </a>
                </li>
                @endif

                {{-- Medis Section --}}
                @if(in_array($role, ['admin', 'dokter', 'perawat']))
                <div class="mt-4 mb-2 ps-3 text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Medis & Klinis</div>

                <li class="nav-item">
                    <a href="{{ route('pemeriksaan.index') }}" class="nav-link {{ request()->routeIs('pemeriksaan.*') ? 'active' : '' }}">
                        <i class="fas fa-stethoscope me-3"></i> Pemeriksaan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/rawat-inap') }}" class="nav-link {{ request()->is('rawat-inap*') ? 'active' : '' }}">
                        <i class="fas fa-bed me-3"></i> Rawat Inap
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('igd.index') }}" class="nav-link {{ request()->routeIs('igd.*') ? 'active' : '' }}">
                        <i class="fas fa-ambulance me-3"></i> IGD
                    </a>
                </li>
                @endif

                {{-- Admin Section --}}
                @if($role === 'admin')
                <div class="mt-4 mb-2 ps-3 text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Administrasi</div>

                <li class="nav-item">
                    <a href="{{ route('master-data.pegawai') }}" class="nav-link {{ request()->is('master-data/pegawai*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie me-3"></i> Data Pegawai
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar me-3"></i> Laporan
                    </a>
                </li>
                @endif
            </ul>
        </div>

        <!-- Footer User Profile -->
        <div class="p-3 border-top bg-light">
            <div class="d-flex align-items-center">
                <img src="{{ 
                    (Auth::check() && Auth::user()->profile_photo_url) ? Auth::user()->profile_photo_url : 
                    (Auth::check() && isset(Auth::user()->avatar) ? asset('storage/' . Auth::user()->avatar) : (session('user_photo') ?? 'https://ui-avatars.com/api/?name=User&background=2563EB&color=fff'))
                }}" class="rounded-circle shadow-sm" width="40" height="40">
                <div class="ms-3 overflow-hidden">
                    <h6 class="mb-0 text-dark fw-bold text-truncate">{{ Auth::check() ? Auth::user()->name : (session('user') ?? 'Petugas') }}</h6>
                    <small class="text-muted d-block text-truncate">{{ ucfirst($role) }}</small>
                </div>
            </div>
            <div class="mt-3 d-grid gap-2">
                <a href="{{ url('/logout') }}" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light topbar px-4 py-3 sticky-top">
            <button id="sidebarToggle" class="btn btn-light rounded-circle shadow-sm me-3 border">
                <i class="fas fa-bars text-primary"></i>
            </button>

            <h5 class="mb-0 fw-bold text-dark d-none d-md-block">
                @yield('title', 'Sistem Informasi Klinik')
            </h5>

            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3">
                    <a href="#" class="nav-link position-relative text-secondary">
                        <i class="fas fa-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="text-end d-none d-md-block">
                        <small class="text-muted d-block" style="font-size: 0.7rem;">{{ now()->translatedFormat('l, d F Y') }}</small>
                        <span class="fw-bold text-primary" id="clock">{{ now()->format('H:i') }}</span>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Content Body -->
        <main class="p-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle Logic
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-toggled');
        });

        // Close sidebar on mobile when link clicked
        if (window.innerWidth < 768) {
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    document.body.classList.remove('sidebar-toggled');
                });
            });
        }

        // Realtime Clock
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const clock = document.getElementById('clock');
            if(clock) clock.textContent = `${hours}:${minutes}`;
        }
        setInterval(updateClock, 1000);
    </script>
    @stack('scripts')
</body>
</html>
