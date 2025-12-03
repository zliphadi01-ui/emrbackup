@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pt-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="text-muted">Selamat datang di Sistem Informasi Klinik</p>
        </div>
        <div>
            <span class="text-muted">{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        {{-- Total Pasien --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card primary h-100">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h2 class="stat-value" id="kunjunganCount">{{ $kunjungan_hari_ini ?? 0 }}</h2>
                <p class="stat-label">Total Kunjungan</p>
                <small class="text-success">
                    <i class="fas fa-arrow-up"></i> Hari ini
                </small>
            </div>
        </div>

        {{-- Pasien Baru --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card success h-100">
                <div class="stat-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2 class="stat-value" id="pasienBaruCount">{{ $pasien_baru ?? 0 }}</h2>
                <p class="stat-label">Pasien Baru</p>
                <small class="text-muted">
                    <i class="fas fa-clock"></i> Terdaftar hari ini
                </small>
            </div>
        </div>

        {{-- Antrian Aktif --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card warning h-100">
                <div class="stat-icon">
                    <i class="fas fa-list-ol"></i>
                </div>
                <h2 class="stat-value" id="antreanCount">{{ $antrean_aktif ?? 0 }}</h2>
                <p class="stat-label">Antrian Aktif</p>
                <small class="text-muted">
                    <i class="fas fa-hourglass-half"></i> Sedang menunggu
                </small>
            </div>
        </div>

        {{-- Resep Pending --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card danger h-100">
                <div class="stat-icon">
                    <i class="fas fa-capsules"></i>
                </div>
                <h2 class="stat-value" id="resepCount">{{ $resep_pending ?? 0 }}</h2>
                <p class="stat-label">Resep Pending</p>
                <small class="text-muted">
                    <i class="fas fa-exclamation-circle"></i> Belum diproses
                </small>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(in_array(Auth::user()->role, ['admin', 'pendaftaran']))
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('pendaftaran.create-baru') }}" class="btn btn-primary btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-user-plus fa-2x mb-2"></i>
                                <span>Pendaftaran Pasien</span>
                            </a>
                        </div>
                        @endif

                        @if(in_array(Auth::user()->role, ['admin', 'dokter']))
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('pemeriksaan.index') }}" class="btn btn-success btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-stethoscope fa-2x mb-2"></i>
                                <span>Pemeriksaan</span>
                            </a>
                        </div>
                        @endif

                        @if(in_array(Auth::user()->role, ['admin', 'pendaftaran']))
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('pendaftaran.list') }}" class="btn btn-info btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-search fa-2x mb-2"></i>
                                <span>Cari Pasien</span>
                            </a>
                        </div>
                        @endif

                        @if(in_array(Auth::user()->role, ['admin', 'apotek']))
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('gudang') }}" class="btn btn-warning btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-boxes fa-2x mb-2"></i>
                                <span>Stok Obat</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts & Recent Activities --}}
    <div class="row">
        {{-- Chart Kunjungan --}}
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line"></i> Grafik Kunjungan 7 Hari Terakhir
                    </h5>
                    <span class="badge badge-light text-dark">Weekly</span>
                </div>
                <div class="card-body">
                    <canvas id="kunjunganChart" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Recent Activities / Live Queue --}}
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Antrean Live
                    </h5>
                    <span class="badge badge-danger blink">LIVE</span>
                </div>
                <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    <div class="list-group list-group-flush">
                        @forelse($recent ?? [] as $r)
                        <div class="list-group-item d-flex align-items-center p-3 border-bottom">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ substr($r->nama, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-0 fw-bold">{{ $r->nama }}</p>
                                <small class="text-muted">
                                    <span class="badge badge-light border">{{ $r->no_daftar }}</span>
                                    {{ $r->poli ?? 'Umum' }}
                                </small>
                            </div>
                            <div>
                                @php
                                    $statusClass = match($r->status) {
                                        'Menunggu' => 'badge-warning',
                                        'Diperiksa' => 'badge-info',
                                        'Selesai' => 'badge-success',
                                        default => 'badge-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $r->status }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <p class="text-muted">Tidak ada antrean aktif saat ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('pendaftaran.list') }}" class="btn btn-sm btn-light text-primary fw-bold w-100">
                        Lihat Semua Antrean
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .blink {
        animation: blinker 1.5s linear infinite;
    }
    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart.js example
const ctx = document.getElementById('kunjunganChart');
if (ctx) {
    const labels = @json($grafik_kunjungan['labels'] ?? []);
    const dataPoints = @json($grafik_kunjungan['data'] ?? []);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Kunjungan',
                data: dataPoints,
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#FFFFFF',
                pointBorderColor: '#3B82F6',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1E293B',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: {
                        family: "'Poppins', sans-serif",
                        size: 13
                    },
                    bodyFont: {
                        family: "'Poppins', sans-serif",
                        size: 13
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [4, 4],
                        color: '#E5E7EB'
                    },
                    ticks: {
                        font: {
                            family: "'Poppins', sans-serif"
                        },
                        color: '#6B7280'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: "'Poppins', sans-serif"
                        },
                        color: '#6B7280'
                    }
                }
            }
        }
    });
}

// Realtime Polling (Optional - keep existing logic if needed)
function updateStats() {
    fetch('{{ route('dashboard.stats') }}')
        .then(r => r.json())
        .then(data => {
            if(document.getElementById("kunjunganCount")) document.getElementById("kunjunganCount").innerText = data.kunjungan_hari_ini;
            if(document.getElementById("pasienBaruCount")) document.getElementById("pasienBaruCount").innerText = data.pasien_baru;
            if(document.getElementById("antreanCount")) document.getElementById("antreanCount").innerText = data.antrean_aktif;
            if(document.getElementById("resepCount")) document.getElementById("resepCount").innerText = data.resep_pending || 0;
        })
        .catch(console.error);
}
setInterval(updateStats, 10000);
</script>
@endpush
@endsection
