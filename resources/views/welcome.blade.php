<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rekam Medis Elektronik - Klinik Polije</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 8rem 0 6rem;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.5;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .feature-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-light);
            box-shadow: var(--shadow-soft);
        }

        .feature-icon-wrapper {
            width: 80px;
            height: 80px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary);
            font-size: 2rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon-wrapper {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            box-shadow: var(--shadow-sm);
        }

        .btn-light-primary {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .btn-light-primary:hover {
            background: white;
            color: var(--primary);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="#">
                <span class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                    <i class="fas fa-heartbeat"></i>
                </span>
                RME POLIJE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3"><a class="nav-link text-dark fw-medium" href="#features">Fitur</a></li>
                    <li class="nav-item me-3"><a class="nav-link text-dark fw-medium" href="#about">Tentang</a></li>
                    <li class="nav-item me-4"><a class="nav-link text-dark fw-medium" href="#contact">Kontak</a></li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                            <i class="fas fa-sign-in-alt me-2"></i> Login Portal
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="hero-pattern"></div>
        <div class="container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill fw-bold shadow-sm">
                        <i class="fas fa-star me-1"></i> Sistem Informasi Klinik Terpadu
                    </span>
                    <h1 class="hero-title">Solusi Cerdas untuk <br>Manajemen Kesehatan</h1>
                    <p class="lead mb-5 opacity-90 fw-light">
                        Platform Rekam Medis Elektronik yang terintegrasi, aman, dan mudah digunakan.
                        Tingkatkan efisiensi pelayanan medis di Klinik Polije.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold text-primary shadow-lg">
                            Mulai Sekarang <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#features" class="btn btn-light-primary btn-lg px-5 py-3 rounded-pill fw-bold">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <!-- Illustration Placeholder -->
                    <img src="https://img.freepik.com/free-vector/health-professional-team-concept-illustration_114360-1618.jpg" alt="Medical Team" class="img-fluid rounded-4 shadow-soft hover-lift" style="border: 4px solid rgba(255,255,255,0.2);">
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-5 mt-5" id="features">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase tracking-wide">Keunggulan Kami</h6>
                <h2 class="fw-bold display-5 mb-3">Mengapa Memilih RME Polije?</h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">
                    Dirancang khusus untuk memenuhi kebutuhan operasional klinik modern dengan teknologi terkini.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto">
                            <i class="fas fa-database"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Data Terintegrasi</h4>
                        <p class="text-muted">
                            Satu sistem untuk semua unit. Data pasien mengalir mulus dari pendaftaran, poli, hingga farmasi tanpa duplikasi.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Keamanan Tinggi</h4>
                        <p class="text-muted">
                            Dilengkapi enkripsi data dan manajemen hak akses bertingkat untuk menjamin kerahasiaan rekam medis pasien.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Analitik Real-time</h4>
                        <p class="text-muted">
                            Pantau kinerja klinik dengan dashboard interaktif. Dapatkan wawasan mendalam untuk pengambilan keputusan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4 mb-md-0">
                    <h2 class="fw-bold text-primary display-4">10k+</h2>
                    <p class="text-muted fw-bold">Pasien Terdaftar</p>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h2 class="fw-bold text-primary display-4">50+</h2>
                    <p class="text-muted fw-bold">Tenaga Medis</p>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h2 class="fw-bold text-primary display-4">24/7</h2>
                    <p class="text-muted fw-bold">Layanan Sistem</p>
                </div>
                <div class="col-md-3">
                    <h2 class="fw-bold text-primary display-4">99%</h2>
                    <p class="text-muted fw-bold">Kepuasan User</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="fas fa-heartbeat text-primary me-2"></i> RME POLIJE
                    </h5>
                    <p class="text-white-50">
                        Sistem Informasi Manajemen Klinik Politeknik Negeri Jember. Mewujudkan layanan kesehatan digital yang efisien dan akuntabel.
                    </p>
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <h6 class="fw-bold mb-3">Navigasi</h6>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Fitur</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">Layanan</h6>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Pendaftaran</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Jadwal Dokter</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Konsultasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Hubungi Kami</h6>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Jl. Mastrip, Jember</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (0331) 333532</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> klinik@polije.ac.id</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center text-white-50">
                <small>&copy; {{ date('Y') }} UPT Klinik Politeknik Negeri Jember. All Rights Reserved.</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
