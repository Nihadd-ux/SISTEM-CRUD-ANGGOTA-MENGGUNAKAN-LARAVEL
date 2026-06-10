@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="bi bi-people"></i>
            Daftar Anggota
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('anggota.export') }}" class="btn btn-success">
                <i class="bi bi-download"></i> Export Excel
            </a>
            <a href="{{ route('anggota.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Anggota
            </a>
        </div>
    </div>

    {{-- Form Search & Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('anggota.search') }}" method="GET">
                <div class="row g-2">

                    {{-- Keyword --}}
                    <div class="col-md-3">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari nama/email/telepon"
                            value="{{ request('keyword') }}">
                    </div>

                    {{-- Filter Jenis Kelamin --}}
                    <div class="col-md-2">
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Semua Jenis Kelamin</option>
                            <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
                    </div>

                    {{-- Filter Pekerjaan --}}
                    <div class="col-md-2">
                        <select name="pekerjaan" class="form-select">
                            <option value="">Semua Pekerjaan</option>
                            <option value="Mahasiswa" {{ request('pekerjaan') == 'Mahasiswa' ? 'selected' : '' }}>
                                Mahasiswa
                            </option>
                            <option value="Pegawai" {{ request('pekerjaan') == 'Pegawai' ? 'selected' : '' }}>
                                Pegawai
                            </option>
                            <option value="Wiraswasta" {{ request('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>
                                Wiraswasta
                            </option>
                        </select>
                    </div>

                    {{-- Tombol --}}
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x"></i> Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Total Anggota</h6>
                            <h2>{{ $totalAnggota }}</h2>
                        </div>
                        <i class="bi bi-people-fill text-success" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Anggota Aktif</h6>
                            <h2>{{ $anggotaAktif }}</h2>
                        </div>
                        <i class="bi bi-person-check-fill text-primary" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Anggota Nonaktif</h6>
                            <h2>{{ $anggotaNonaktif }}</h2>
                        </div>
                        <i class="bi bi-person-x-fill text-secondary" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Anggota --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anggotas as $anggota)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <code>{{ $anggota->kode_anggota }}</code>
                                </td>
                                <td>
                                    <strong>{{ $anggota->nama }}</strong>
                                </td>
                                <td>
                                    <i class="bi bi-envelope"></i>
                                    {{ $anggota->email }}
                                </td>
                                <td>
                                    <i class="bi bi-telephone"></i>
                                    {{ $anggota->telepon }}
                                </td>
                                <td>
                                    @if ($anggota->jenis_kelamin == 'Laki-laki')
                                        <i class="bi bi-gender-male text-primary"></i>
                                    @else
                                        <i class="bi bi-gender-female text-danger"></i>
                                    @endif
                                    {{ $anggota->jenis_kelamin }}
                                </td>
                                <td>
                                    @if ($anggota->status == 'Aktif')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle"></i> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('anggota.show', $anggota->id) }}"
                                            class="btn btn-sm btn-info text-white" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    <i class="bi bi-inbox"></i>
                                    Tidak ada data anggota
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection