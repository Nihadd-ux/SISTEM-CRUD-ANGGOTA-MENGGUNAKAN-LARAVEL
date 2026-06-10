<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Models\Buku;
use App\Models\Anggota;


// ===== HOME =====
Route::get('/', function () {
    return view('home');
})->name('home');


// ===== DASHBOARD =====
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// ===== BUKU =====
// ⚠️ Route spesifik HARUS di atas Route::resource agar tidak bentrok dengan {id}

// Search
Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');

// Export CSV
Route::get('/buku/export', [BukuController::class, 'export'])->name('buku.export');

// Bulk Delete
Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])->name('buku.bulk-delete');

// Filter Kategori
Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])->name('buku.kategori');

// Resource (index, create, store, show, edit, update, destroy)
Route::resource('buku', BukuController::class);


// ===== KATEGORI =====
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/search/{keyword}', [KategoriController::class, 'search'])->name('kategori.search');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');

// Export Excel
Route::get('/anggota/export', [AnggotaController::class, 'export'])
    ->name('anggota.export');

// Search & Filter
Route::get('/anggota/search', [AnggotaController::class, 'search'])
    ->name('anggota.search');


// ===== ANGGOTA =====
Route::resource('anggota', AnggotaController::class);


// ===== PERPUSTAKAAN =====
Route::get('/perpustakaan', [PerpustakaanController::class, 'index']);
Route::get('/about', [PerpustakaanController::class, 'about']);


// ===== TESTING (bisa dihapus setelah selesai) =====
Route::get('/test-query', function () {
    $html = '<h1>Testing Query Eloquent</h1>';

    $tersedia = Buku::tersedia()->get();
    $html .= '<h3>Buku Tersedia (Stok > 0): ' . $tersedia->count() . '</h3>';
    $html .= '<ul>';
    foreach ($tersedia as $buku) {
        $html .= '<li>' . $buku->judul . ' (Stok: ' . $buku->stok . ')</li>';
    }
    $html .= '</ul>';

    $programming = Buku::kategori('Programming')->get();
    $html .= '<h3>Buku Programming: ' . $programming->count() . '</h3>';
    $html .= '<ul>';
    foreach ($programming as $buku) {
        $html .= '<li>' . $buku->judul . '</li>';
    }
    $html .= '</ul>';

    $aktif = Anggota::aktif()->get();
    $html .= '<h3>Anggota Aktif: ' . $aktif->count() . '</h3>';
    $html .= '<ul>';
    foreach ($aktif as $anggota) {
        $html .= '<li>' . $anggota->nama . ' (' . $anggota->email . ')</li>';
    }
    $html .= '</ul>';

    return $html;
});

Route::get('/test-accessor-scope', function () {
    $html = '
    <html>
    <head>
        <title>Testing Accessor & Scope</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container mt-4">
    <h1>Testing Accessor & Scope</h1><hr>';

    $html .= '
    <div class="card mb-4">
        <div class="card-header bg-dark text-white fw-bold">
            1. Buku dengan status_stok_badge
        </div>
        <div class="card-body">
            <ul class="list-group">';

    $semuaBuku = \App\Models\Buku::all();
    foreach ($semuaBuku as $buku) {
        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
            . $buku->judul . ' (Stok: ' . $buku->stok . ')'
            . '<span>' . $buku->status_stok_badge . '</span>'
            . '</li>';
    }
    if ($semuaBuku->isEmpty()) {
        $html .= '<li class="list-group-item text-muted">Tidak ada data buku</li>';
    }
    $html .= '</ul></div></div>';

    $html .= '
    <div class="card mb-4">
        <div class="card-header bg-dark text-white fw-bold">
            2. Buku Terbaru - tahun >= 2024 (Scope)
        </div>
        <div class="card-body">
            <ul class="list-group">';

    $bukuTerbaru = \App\Models\Buku::terbaru()->get();
    foreach ($bukuTerbaru as $buku) {
        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
            . $buku->judul
            . '<span class="badge bg-primary">' . $buku->tahun_terbit . ' - ' . $buku->tahun_label . '</span>'
            . '</li>';
    }
    if ($bukuTerbaru->isEmpty()) {
        $html .= '<li class="list-group-item text-muted">Tidak ada buku terbaru</li>';
    }
    $html .= '</ul></div></div>';

    $html .= '
    <div class="card mb-4">
        <div class="card-header bg-dark text-white fw-bold">
            3. Buku Stok Menipis - stok &lt; 5 (Scope)
        </div>
        <div class="card-body">
            <ul class="list-group">';

    $bukuMenipis = \App\Models\Buku::stokMenipis()->get();
    foreach ($bukuMenipis as $buku) {
        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
            . $buku->judul . ' (Stok: ' . $buku->stok . ')'
            . '<span>' . $buku->status_stok_badge . '</span>'
            . '</li>';
    }
    if ($bukuMenipis->isEmpty()) {
        $html .= '<li class="list-group-item text-muted">Tidak ada buku stok menipis</li>';
    }
    $html .= '</ul></div></div>';

    $html .= '
    <div class="card mb-4">
        <div class="card-header bg-dark text-white fw-bold">
            4. Anggota dengan status_badge
        </div>
        <div class="card-body">
            <ul class="list-group">';

    $semuaAnggota = \App\Models\Anggota::all();
    foreach ($semuaAnggota as $anggota) {
        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
            . $anggota->nama
            . '<span>' . $anggota->status_badge . '</span>'
            . '</li>';
    }
    if ($semuaAnggota->isEmpty()) {
        $html .= '<li class="list-group-item text-muted">Tidak ada data anggota</li>';
    }
    $html .= '</ul></div></div>';

    $html .= '
    <div class="card mb-4">
        <div class="card-header bg-dark text-white fw-bold">
            5. Anggota dengan kategori_usia
        </div>
        <div class="card-body">
            <ul class="list-group">';

    foreach ($semuaAnggota as $anggota) {
        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
            . $anggota->nama
            . '<span class="badge bg-info text-dark">' . $anggota->kategori_usia . '</span>'
            . '</li>';
    }
    if ($semuaAnggota->isEmpty()) {
        $html .= '<li class="list-group-item text-muted">Tidak ada data anggota</li>';
    }
    $html .= '</ul></div></div>';

    $html .= '
    <div class="card mb-4">
        <div class="card-header bg-dark text-white fw-bold">
            6. Anggota Terdaftar Bulan Ini (Scope)
        </div>
        <div class="card-body">
            <ul class="list-group">';

    $anggotaBulanIni = \App\Models\Anggota::terdaftarBulanIni()->get();
    foreach ($anggotaBulanIni as $anggota) {
        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
            . $anggota->nama . ' (' . $anggota->tanggal_daftar->format('d/m/Y') . ')'
            . '<span>' . $anggota->status_badge . '</span>'
            . '</li>';
    }
    if ($anggotaBulanIni->isEmpty()) {
        $html .= '<li class="list-group-item text-muted">Tidak ada anggota terdaftar bulan ini</li>';
    }
    $html .= '</ul></div></div>';

    $html .= '</div></body></html>';

    return $html;
});
