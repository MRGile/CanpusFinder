<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\CampusContentController;
use App\Http\Controllers\Admin\ScholarshipController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - CampusFinder
|--------------------------------------------------------------------------
*/

// ── Beranda ──
Route::get('/', [HomeController::class, 'index']);

// ── Kampus ──
Route::get('/kampus', [CatalogController::class, 'campuses']);
Route::get('/kampus/{slug}', [CatalogController::class, 'campusDetail']);
Route::get('/kampus/{campus:slug}/fakultas/{faculty}', [CatalogController::class, 'facultyDetail'])
    ->scopeBindings()->name('faculties.show');
Route::post('/kampus/{slug}/favorit', [AccountController::class, 'toggleFavorite'])->middleware('auth')->name('campus.favorite.toggle');
Route::post('/kampus/{campus:slug}/ulasan', [ReviewController::class, 'store'])->middleware(['auth', 'throttle:5,1'])->name('campus.review.store');

// ── Program Studi ──
Route::get('/program-studi', [CatalogController::class, 'programs'])->name('programs.index');
Route::get('/program-studi/{slug}', [CatalogController::class, 'programDetail'])->name('programs.show');

// ── Beasiswa ──
Route::get('/beasiswa', [CatalogController::class, 'scholarships'])->name('scholarships.index');
Route::get('/beasiswa/{scholarship}', [CatalogController::class, 'scholarshipDetail'])->name('scholarships.show');

// ── Bandingkan ──
Route::get('/bandingkan', [CatalogController::class, 'compare'])->name('campus.compare');

// ── Blog ──
Route::get('/blog', [CatalogController::class, 'articles']);

// ── Auth ──
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'create'])->name('login');
    Route::post('/masuk', [AuthController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/daftar', [AuthController::class, 'register'])->name('register');
    Route::post('/daftar', [AuthController::class, 'createAccount']);
});

// ── Dashboard (auth protected) ──
Route::middleware('auth')->group(function () {
    Route::post('/keluar', [AuthController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [AccountController::class, 'dashboard']);
    Route::get('/favorit', [AccountController::class, 'favorites']);
    Route::get('/profil', fn () => view('pages.profil'));
    Route::get('/notifikasi', [AccountController::class, 'notifications']);
    Route::get('/pengaturan', fn () => view('pages.pengaturan'));
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('blog', ArticleController::class)->except('show');
    Route::get('universitas/{campus}/konten', [CampusContentController::class, 'index'])->name('universitas.konten.index');
    Route::post('universitas/{campus}/konten', [CampusContentController::class, 'store'])->name('universitas.konten.store');
    Route::put('universitas/{campus}/konten/{campusContent}', [CampusContentController::class, 'update'])->name('universitas.konten.update');
    Route::delete('universitas/{campus}/konten/{campusContent}', [CampusContentController::class, 'destroy'])->name('universitas.konten.destroy');
    Route::resource('universitas', UniversityController::class)->parameters(['universitas' => 'campus'])->except('show');
    Route::resource('universitas.fakultas', FacultyController::class)->parameters(['universitas' => 'campus', 'fakultas' => 'faculty'])->scoped()->except('show');
    Route::resource('beasiswa', ScholarshipController::class)->except('show');
});
