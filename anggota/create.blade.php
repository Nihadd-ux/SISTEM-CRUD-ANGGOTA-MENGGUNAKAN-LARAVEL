@extends('layouts.app')

@section('title', 'Tambah Anggota')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus"></i>
                        Tambah Anggota Baru
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('anggota.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Kode Anggota --}}
                            <div class="col-md-4 mb-3">
                                <label for="kode_anggota" class="form-label">
                                    Kode Anggota <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="kode_anggota" id="kode_anggota"
                                    class="form-control @error('kode_anggota') is-invalid @enderror"
                                    value="{{ old('kode_anggota', $kodeAnggota) }}" readonly>
                                @error('kode_anggota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i> Kode otomatis di-generate
                                </small>
                            </div>

                            {{-- Nama --}}
                            <div class="col-md-8 mb-3">
                                <label for="nama" class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                    placeholder="Nama lengkap anggota">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="email@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Telepon --}}
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">
                                    Nomor Telepon <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="telepon" id="telepon"
                                    class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}"
                                    placeholder="081234567890">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: 08xxxxxxxxxx atau +628xxxxxxxxxx</small>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="alamat" class="form-label">
                                Alamat Lengkap <span class="text-danger">*</span>
                            </label>
                            <textarea name="alamat" id="alamat" rows="3"
                                class="form-control @error('alamat') is-invalid @enderror"
                                placeholder="Alamat lengkap dengan kota dan kode pos">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Tanggal Lahir --}}
                            <div class="col-md-4 mb-3">
                                <label for="tanggal_lahir" class="form-label">
                                    Tanggal Lahir <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir') }}" max="{{ date('Y-m-d') }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="col-md-4 mb-3">
                                <label for="jenis_kelamin" class="form-label">
                                    Jenis Kelamin <span class="text-danger">*</span>
                                </label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="col-md-4 mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="pekerjaan"
                                    class="form-control @error('pekerjaan') is-invalid @enderror"
                                    value="{{ old('pekerjaan') }}" placeholder="Contoh: Mahasiswa, Pegawai, dll">
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Tanggal Daftar --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_daftar" class="form-label">
                                    Tanggal Pendaftaran <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal_daftar" id="tanggal_daftar"
                                    class="form-control @error('tanggal_daftar') is-invalid @enderror"
                                    value="{{ old('tanggal_daftar', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}">
                                @error('tanggal_daftar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>
                                        Nonaktif
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan Anggota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        // Initialize Flatpickr untuk tanggal lahir
        flatpickr("#tanggal_lahir", {
            dateFormat: "Y-m-d",
            maxDate: "today",
            locale: "id",
            altInput: true,
            altFormat: "d F Y",
        });

        // Initialize Flatpickr untuk tanggal daftar
        flatpickr("#tanggal_daftar", {
            dateFormat: "Y-m-d",
            maxDate: "today",
            locale: "id",
            altInput: true,
            altFormat: "d F Y",
            defaultDate: "today",
        });

        // Auto format telepon (hapus karakter non-digit)
        document.getElementById('telepon').addEventListener('input', function () {
            let value = this.value.replace(/[^\d+]/g, '');
            this.value = value;
        });
    </script>
@endpush