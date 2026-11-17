<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\VillageProfileController;
use App\Http\Controllers\Admin\VillageOfficialController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\VillageStatisticController;
use App\Http\Controllers\Admin\VillagePotentialController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\GovernmentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\Public\NewsController as PublicNewsController;
use App\Http\Controllers\Public\AnnouncementController as PublicAnnouncementController;
use App\Http\Controllers\Public\AgendaController as PublicAgendaController;
use App\Http\Controllers\Public\StatisticsController;
use App\Http\Controllers\Public\PotentialController;
use App\Http\Controllers\Public\UmkmController as PublicUmkmController;
use App\Http\Controllers\Public\GalleryController as PublicGalleryController;
use App\Http\Controllers\Public\ContactController as PublicContactController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\LetterController as AdminLetterController;


// ==================== PUBLIC ROUTES ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
Route::get('/pemerintahan', [GovernmentController::class, 'index'])->name('government');
Route::get('/berita', [PublicNewsController::class, 'index'])->name('public.news.index');
Route::get('/berita/{slug}', [PublicNewsController::class, 'show'])->name('public.news.show');
Route::get('/pengumuman', [PublicAnnouncementController::class, 'index'])->name('public.announcements');
Route::get('/agenda', [PublicAgendaController::class, 'index'])->name('public.agendas');
Route::get('/statistik', [StatisticsController::class, 'index'])->name('public.statistics');
Route::get('/potensi', [PotentialController::class, 'index'])->name('public.potentials');
Route::get('/umkm', [PublicUmkmController::class, 'index'])->name('public.umkm');
Route::get('/galeri', [PublicGalleryController::class, 'index'])->name('public.gallery');
Route::get('/kontak', [PublicContactController::class, 'index'])->name('public.contact');
Route::get('/surat/{letter}/download', [LetterController::class, 'downloadPdf'])
    ->name('public.letters.download');

// ==================== PENGADUAN PUBLIK ====================
Route::get('/pengaduan', [ComplaintController::class, 'create'])->name('public.complaints.create');
Route::post('/pengaduan', [ComplaintController::class, 'store'])
    ->name('public.complaints.store')
    ->middleware('throttle:5,1');

// Cek status pengaduan (tiket + email, dengan throttle)
Route::get('/pengaduan/cek', [ComplaintController::class, 'checkForm'])->name('public.complaints.check');
Route::post('/pengaduan/cek', [ComplaintController::class, 'checkResult'])
    ->name('public.complaints.check.result')
    ->middleware('throttle:5,1');

// ==================== SURAT MENYURAT PUBLIK ====================
Route::get('/surat', [LetterController::class, 'create'])->name('public.letters.create');
Route::post('/surat', [LetterController::class, 'store'])
    ->name('public.letters.store')
    ->middleware('throttle:5,1');

Route::get('/surat/cek', [LetterController::class, 'checkForm'])->name('public.letters.check');
Route::post('/surat/cek', [LetterController::class, 'checkResult'])
    ->name('public.letters.check.result')
    ->middleware('throttle:5,1');

// ==================== AUTH ROUTES ====================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Slider
    Route::resource('/sliders', SliderController::class)->names('admin.sliders');
    Route::put('/sliders/{slider}/toggle', [SliderController::class, 'toggle'])->name('admin.sliders.toggle');

    // Profile
    Route::get('/profile', [VillageProfileController::class, 'index'])->name('admin.profile.index');
    Route::put('/profile', [VillageProfileController::class, 'update'])->name('admin.profile.update');

    // Officials
    Route::resource('/officials', VillageOfficialController::class)->names('admin.officials');
    Route::put('/officials/{official}/toggle', [VillageOfficialController::class, 'toggle'])->name('admin.officials.toggle');

    // News
    Route::resource('/news', NewsController::class)->names('admin.news');

    // Announcements
    Route::resource('/announcements', AnnouncementController::class)->names('admin.announcements');

    // Agendas
    Route::resource('/agendas', AgendaController::class)->names('admin.agendas');

    // Statistics
    Route::resource('/statistics', VillageStatisticController::class)->names('admin.statistics');

    // Potentials
    Route::resource('/potentials', VillagePotentialController::class)->names('admin.potentials');

    // UMKM
    Route::resource('/umkm', UmkmController::class)->names('admin.umkm');

    // Gallery
    Route::resource('/gallery', GalleryController::class)->names('admin.gallery');

    // Contact
    Route::get('/contact', [ContactController::class, 'edit'])->name('admin.contact.edit');
    Route::put('/contact', [ContactController::class, 'update'])->name('admin.contact.update');

    // ==================== PENGADUAN ADMIN ====================
    Route::prefix('complaints')->name('admin.complaints.')->group(function () {
        Route::get('/', [AdminComplaintController::class, 'index'])->name('index');
        Route::get('/{complaint}', [AdminComplaintController::class, 'show'])->name('show');
        Route::put('/{complaint}', [AdminComplaintController::class, 'update'])->name('update');
        Route::delete('/{complaint}', [AdminComplaintController::class, 'destroy'])->name('destroy');
    });

    // ==================== SURAT MENYURAT ADMIN ====================
    Route::prefix('letters')->name('admin.letters.')->group(function () {
    Route::get('/', [AdminLetterController::class, 'index'])->name('index');
    Route::get('/{letter}', [AdminLetterController::class, 'show'])->name('show');
    Route::get('/{letter}/download-pdf', [AdminLetterController::class, 'downloadPdf'])->name('downloadPdf'); // ← TAMBAH
    Route::put('/{letter}', [AdminLetterController::class, 'update'])->name('update');
    Route::delete('/{letter}', [AdminLetterController::class, 'destroy'])->name('destroy');
});
    
});