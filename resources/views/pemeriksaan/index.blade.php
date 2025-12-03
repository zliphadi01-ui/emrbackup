@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pt-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Antrean Pemeriksaan</h1>
            <p class="text-muted">Daftar pasien yang menunggu pemeriksaan dokter hari ini.</p>
        </div>
        <div>
            <button class="btn btn-primary" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-2"></i> Refresh Data
            </button>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card warning h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon mb-0 me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="stat-value mb-0">{{ $daftar_pasien->where('status', 'Menunggu')->count() }}</h3>
                        <small class="text-muted">Menunggu</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card info h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon mb-0 me-3">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div>
                        <h3 class="stat-value mb-0">{{ $daftar_pasien->where('status', 'Dalam Pemeriksaan')->count() }}</h3>
                        <small class="text-muted">Sedang Diperiksa</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card success h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon mb-0 me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="stat-value mb-0">{{ $daftar_pasien->where('status', 'Selesai')->count() }}</h3>
                        <small class="text-muted">Selesai</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card primary h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon mb-0 me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="stat-value mb-0">{{ $daftar_pasien->count() }}</h3>
                        <small class="text-muted">Total Pasien</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom py-3">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="fas fa-list-ul me-2"></i> Daftar Antrean
            </h5>
            <div class="input-group" style="width: 250px;">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari pasien...">
            </div>
        </div>
        <div class="card-body p-0">

            @if(session('success'))
                <div class="alert alert-success m-3">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th width="25%">Pasien</th>
                            <th width="15%">No. RM</th>
                            <th width="15%">Poli</th>
                            <th width="15%">Waktu Daftar</th>
                            <th width="10%">Status</th>
                            <th width="15%" class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftar_pasien as $item)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary-light text-primary d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                                            {{ substr($item->pasien->nama ?? $item->nama ?? '?', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $item->pasien->nama ?? $item->nama ?? 'Data Tidak Lengkap' }}</div>
                                            <small class="text-muted">
                                                {{ $item->pasien->jenis_kelamin ?? '-' }} |
                                                @if($item->pasien && $item->pasien->tanggal_lahir)
                                                    {{ \Carbon\Carbon::parse($item->pasien->tanggal_lahir)->age }} Thn
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="font-monospace fw-bold text-secondary">
                                        {{ $item->pasien->no_rm ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $item->poli ?? '-' }}
                                    </span>
                                </td>

                                <td class="text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $item->created_at ? $item->created_at->format('H:i') : '-' }}
                                </td>

                                <td>
                                    @if($item->status == 'Menunggu')
                                        <span class="badge bg-warning text-dark rounded-pill px-3">
                                            <i class="fas fa-clock me-1"></i> Menunggu
                                        </span>
                                    @elseif($item->status == 'Dalam Pemeriksaan')
                                        <span class="badge bg-info text-dark rounded-pill px-3">
                                            <i class="fas fa-stethoscope me-1"></i> Periksa
                                        </span>
                                    @elseif($item->status == 'Selesai')
                                        <span class="badge bg-success rounded-pill px-3">
                                            <i class="fas fa-check me-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3">{{ $item->status }}</span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <a href="{{ route('pemeriksaan.soap', $item->id) }}" class="btn btn-primary btn-sm shadow-sm">
                                        <i class="fas fa-stethoscope me-1"></i> Periksa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="display-1 text-muted opacity-25 mb-3">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>
                                        <h5 class="fw-bold text-muted">Belum ada antrean</h5>
                                        <p class="text-muted">Saat ini belum ada pasien yang mendaftar untuk pemeriksaan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0 py-3">
            <!-- Pagination could go here -->
             <small class="text-muted">Menampilkan {{ $daftar_pasien->count() }} data hari ini.</small>
        </div>
    </div>
</div>
@endsection
