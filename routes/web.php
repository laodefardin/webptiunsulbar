<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FaviconController;

// Route::get('/', function () {
//     return view('welcome');
// });
// Halaman Utama
Route::get('/', [HomeController::class, 'index']);

// Halaman Detail Berita
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Halaman Statis (Profil Prodi, dll.)
Route::get('/pages/{page:slug}', [PageController::class, 'show'])->name('pages.show');

// Halaman Detail Agenda
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Halaman Daftar Dosen & Staff
Route::get('/lecturers', [LecturerController::class, 'index'])->name('lecturers.index');

// Halaman Kurikulum
Route::get('/curriculum', [CurriculumController::class, 'index'])->name('curriculum.index');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/favicon.ico', FaviconController::class)->name('favicon');
