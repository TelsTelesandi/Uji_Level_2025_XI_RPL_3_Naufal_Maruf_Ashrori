<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanPengembalianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserPeminjamanController;
use App\Http\Controllers\UserPengembalianController;

Route::get('/', function () {

    if (!Auth::check()) {
        return redirect('login');
    }

    if (Auth::user()->role == "admin") {
        return redirect()->route('dashboard');
    }

    if (Auth::user()->role == "user") {
        return redirect()->route('user.dashboard');
    }
});

Route::get('/login', function () {
    return view("auth.login");
})->middleware('guest')->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');

    Route::middleware(['role:admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/import', [UserController::class, 'importForm'])->name('users.import.form');
        Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
        Route::get('/template/download', [UserController::class, 'downloadTemplate'])->name('template.download');

        Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
        Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
        Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
        Route::get('/ruangan/{ruangan}', [RuanganController::class, 'show'])->name('ruangan.show');
        Route::get('/ruangan/{ruangan}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
        Route::put('/ruangan/{ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');
        Route::delete('/ruangan/{ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
        Route::get('/ruangan/import', [RuanganController::class, 'importForm'])->name('ruangan.import.form');
        Route::post('/ruangan/import', [RuanganController::class, 'import'])->name('ruangan.import');
        Route::get('/template/ruangan/download', [RuanganController::class, 'downloadTemplate'])->name('template.ruangan.download');

        Route::prefix('peminjaman-ruangan')->name('peminjaman-pengembalian.')->group(function () {
            Route::get('/check-availability', [PeminjamanPengembalianController::class, 'checkAvailability'])->name('admin.check-availability');
            Route::get('/', [PeminjamanPengembalianController::class, 'index'])->name('index');
            // Route::get('/create', [PeminjamanPengembalianController::class, 'create'])->name('create');
            Route::post('/', [PeminjamanPengembalianController::class, 'store'])->name('store');
            Route::get('/{peminjaman_ruangan:peminjaman_id}', [PeminjamanPengembalianController::class, 'show'])->name('show');
            Route::patch('/{id}/status', [PeminjamanPengembalianController::class, 'updateStatus'])->name('update-status');
            Route::patch('/pengembalian/{id}/status', [PeminjamanPengembalianController::class, 'updatePengembalianStatus'])->name('update-pengembalian-status');
            Route::post('/export', [PeminjamanPengembalianController::class, 'exportData'])->name('export');
        });

        Route::get('/pengembalian/{pengembalian}', [PeminjamanPengembalianController::class, 'showPengembalian']);

    });

    // User Routes
    Route::middleware(['role:user'])->group(function () {

        Route::get('/user', function () {
            return redirect()->route('user.dashboard');
        });

        // User Dashboard
        Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

        // User Peminjaman Routes
        Route::prefix('user/peminjaman')->name('user.peminjaman.')->group(function () {
            Route::get('/', [UserPeminjamanController::class, 'index'])->name('index');
            Route::get('/create', [UserPeminjamanController::class, 'create'])->name('create');
            Route::get('/check-availability', [UserPeminjamanController::class, 'checkAvailability'])->name('check-availability');
            Route::post('/', [UserPeminjamanController::class, 'store'])->name('store');
            Route::get('/{id}', [UserPeminjamanController::class, 'show'])->name('show');
            Route::patch('/{id}/cancel', [UserPeminjamanController::class, 'cancel'])->name('cancel');
        });

        // User Pengembalian Routes
        Route::prefix('user/pengembalian')->name('user.pengembalian.')->middleware(['auth'])->group(function () {
            Route::get('/', [UserPengembalianController::class, 'index'])->name('index'); // ini penting!
            Route::get('/create/{peminjamanId}', [UserPengembalianController::class, 'create'])->name('create');
            Route::post('/', [UserPengembalianController::class, 'store'])->name('store');
            Route::get('/{id}', [UserPengembalianController::class, 'show'])->where('pengembalian_id', '[0-9]+')->name('show');
        });

        Route::prefix('user')->group(function () {
            Route::get('/ruangan', [RuanganUserController::class, 'index'])->name('user.ruangan.index');
            Route::get('/ruangan/{ruangan}', [RuanganUserController::class, 'show'])->name('user.ruangan.show');
        });
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
