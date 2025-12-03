@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pt-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Pendaftaran Pasien Baru</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pendaftaran.index') }}">Pendaftaran</a></li>
                    <li class="breadcrumb-item active">Pasien Baru</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Error Alert --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Registration Form --}}
    <div class="row justify-content-center">
        <div class="col-lg-12">
            {{-- Progress Steps --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="step-item active" id="step-indicator-1">
                            <div class="step-number">1</div>
                            <div class="step-label">Data Identitas</div>
                        </div>
                        <div class="step-item" id="step-indicator-2">
                            <div class="step-number">2</div>
                            <div class="step-label">Alamat & Kontak</div>
                        </div>
                        <div class="step-item" id="step-indicator-3">
                            <div class="step-number">3</div>
                            <div class="step-label">Pembayaran & Poli</div>
                        </div>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 33%"></div>
                    </div>
                </div>
            </div>

            <form action="{{ route('pendaftaran.store-baru') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
                @csrf

                {{-- Step 1: Data Identitas --}}
                <div class="card step-content" id="step-1">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user-circle"></i> Step 1: Data Identitas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control" required placeholder="Nama sesuai KTP" value="{{ old('nama') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">NIK <span class="required">*</span></label>
                                    <input type="text" name="nik" id="nik" class="form-control" required pattern="[0-9]{16}" maxlength="16" placeholder="16 digit NIK" value="{{ old('nik') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota/Kabupaten" value="{{ old('tempat_lahir') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 2: Alamat & Kontak --}}
                <div class="card step-content" id="step-2" style="display: none;">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt"></i> Step 2: Alamat & Kontak
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea name="alamat" class="form-control" rows="2" placeholder="Jalan, Nomor Rumah">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">RT/RW</label>
                                    <input type="text" name="rt_rw" class="form-control" placeholder="001/002" value="{{ old('rt_rw') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Kelurahan</label>
                                    <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Kota/Kabupaten</label>
                                    <input type="text" name="kota" class="form-control" value="{{ old('kota') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Telepon/HP</label>
                                    <input type="text" name="telepon" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="email@example.com" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control" maxlength="5" value="{{ old('kode_pos') }}">
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <h6 class="text-primary border-bottom pb-2">Kontak Darurat</h6>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">Nama Keluarga/PJ</label>
                                    <input type="text" name="nama_keluarga" class="form-control" placeholder="Nama lengkap" value="{{ old('nama_keluarga') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Hubungan</label>
                                    <select name="hubungan_keluarga" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="Ayah" {{ old('hubungan_keluarga') == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                        <option value="Ibu" {{ old('hubungan_keluarga') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                        <option value="Suami" {{ old('hubungan_keluarga') == 'Suami' ? 'selected' : '' }}>Suami</option>
                                        <option value="Istri" {{ old('hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                                        <option value="Anak" {{ old('hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                        <option value="Saudara" {{ old('hubungan_keluarga') == 'Saudara' ? 'selected' : '' }}>Saudara</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Telepon Keluarga</label>
                                    <input type="text" name="telepon_keluarga" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('telepon_keluarga') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(1)">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 3: Pembayaran & Poli --}}
                <div class="card step-content" id="step-3" style="display: none;">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card"></i> Step 3: Pembayaran & Poli
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label">Jenis Pembayaran</label>
                                <div class="d-flex gap-4 flex-wrap">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_pembayaran" id="umum" value="Umum" checked>
                                        <label class="form-check-label fw-bold" for="umum">Umum/Tunai</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_pembayaran" id="bpjs" value="BPJS">
                                        <label class="form-check-label fw-bold" for="bpjs">BPJS</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_pembayaran" id="asuransi" value="Asuransi">
                                        <label class="form-check-label fw-bold" for="asuransi">Asuransi Swasta</label>
                                    </div>
                                </div>
                            </div>

                            {{-- BPJS Fields --}}
                            <div class="col-12 conditional-field mb-3" id="bpjsFields" style="display: none;">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Nomor BPJS</label>
                                                    <input type="text" name="no_bpjs" class="form-control" placeholder="13 digit nomor BPJS" value="{{ old('no_bpjs') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Upload Kartu BPJS (Opsional)</label>
                                                    <input type="file" name="scan_bpjs" class="form-control" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Asuransi Fields --}}
                            <div class="col-12 conditional-field mb-3" id="asuransiFields" style="display: none;">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Nama Asuransi</label>
                                                    <input type="text" name="nama_asuransi" class="form-control" placeholder="Contoh: Prudential, Allianz" value="{{ old('nama_asuransi') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Nomor Polis</label>
                                                    <input type="text" name="no_polis" class="form-control" placeholder="Nomor polis asuransi" value="{{ old('no_polis') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Alergi Obat</label>
                                    <textarea name="alergi_obat" class="form-control" rows="2" placeholder="Contoh: Penisilin, Aspirin">{{ old('alergi_obat') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Riwayat Penyakit</label>
                                    <textarea name="riwayat_penyakit" class="form-control" rows="2" placeholder="Contoh: Diabetes, Hipertensi">{{ old('riwayat_penyakit') }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label">Poli Tujuan <span class="required">*</span></label>
                                    <select name="poli" class="form-control form-control-lg border-primary" required>
                                        <option value="">-- Pilih Poli Tujuan --</option>
                                        @foreach($poliList as $poli)
                                            <option value="{{ $poli }}" {{ old('poli') == $poli ? 'selected' : '' }}>{{ $poli }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(2)">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle"></i> Simpan & Daftar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.step-item {
    text-align: center;
    flex: 1;
    position: relative;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #E5E7EB;
    color: #6B7280;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
    font-weight: bold;
    transition: all 0.3s ease;
}

.step-item.active .step-number {
    background: var(--primary);
    color: white;
}

.step-item.completed .step-number {
    background: var(--success);
    color: white;
}

.step-label {
    font-size: 0.875rem;
    color: #6B7280;
}

.step-item.active .step-label {
    color: var(--primary);
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
// Multi-step form navigation
function nextStep(step) {
    // Basic validation (optional)
    if (step === 2) {
        if (!document.getElementById('nama').value || !document.getElementById('nik').value) {
            alert('Mohon lengkapi Nama dan NIK terlebih dahulu.');
            return;
        }
    }

    // Hide all steps
    document.querySelectorAll('.step-content').forEach(el => el.style.display = 'none');

    // Show target step
    document.getElementById('step-' + step).style.display = 'block';

    // Update progress
    updateProgress(step);
}

function prevStep(step) {
    document.querySelectorAll('.step-content').forEach(el => el.style.display = 'none');
    document.getElementById('step-' + step).style.display = 'block';
    updateProgress(step);
}

function updateProgress(step) {
    const progress = (step / 3) * 100;
    document.getElementById('progress-bar').style.width = progress + '%';

    // Update step indicators
    for (let i = 1; i <= 3; i++) {
        const indicator = document.getElementById('step-indicator-' + i);
        indicator.classList.remove('active', 'completed');

        if (i < step) {
            indicator.classList.add('completed');
        } else if (i === step) {
            indicator.classList.add('active');
        }
    }
}

// Conditional Payment Fields
document.querySelectorAll('[name="jenis_pembayaran"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('bpjsFields').style.display = 'none';
        document.getElementById('asuransiFields').style.display = 'none';

        if (this.value === 'BPJS') {
            document.getElementById('bpjsFields').style.display = 'block';
        } else if (this.value === 'Asuransi') {
            document.getElementById('asuransiFields').style.display = 'block';
        }
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const selectedPayment = document.querySelector('[name="jenis_pembayaran"]:checked');
    if (selectedPayment && selectedPayment.value === 'BPJS') {
        document.getElementById('bpjsFields').style.display = 'block';
    } else if (selectedPayment && selectedPayment.value === 'Asuransi') {
        document.getElementById('asuransiFields').style.display = 'block';
    }
});
</script>
@endpush
@endsection
