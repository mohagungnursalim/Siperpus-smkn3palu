<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard.dashboard.index');
})->middleware(['auth', 'verified', 'RedirectIfAdmin'])->name('dashboard');

Route::resource('/dashboard/anggota', AnggotaController::class)->middleware(['auth','RedirectIfNotLibrarian']);

Route::resource('/dashboard/kategori', KategoriController::class)->middleware(['auth','RedirectIfNotLibrarian']);

Route::resource('/dashboard/buku', BukuController::class)->middleware(['auth','RedirectIfNotLibrarian']);

Route::resource('/dashboard/peminjaman', PeminjamanController::class)->middleware(['auth','RedirectIfNotLibrarian']);

// Only Admin
Route::resource('/dashboard/user', UserController::class)->middleware(['auth','is_admin']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/profile', [ProfileController::class, 'index']);
    Route::patch('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/dashboard/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
