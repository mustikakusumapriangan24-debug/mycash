<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentPaymentController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;


// =====================================================
// LOGIN
// =====================================================

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post(
    '/web-login',
    [AuthController::class, 'webLogin']
)->name('web.login');


// =====================================================
// HALAMAN YANG HARUS SUDAH LOGIN
// =====================================================

Route::middleware('auth')->group(function () {

    // =================================================
    // LOGOUT
    // =================================================

    Route::post('/logout', function () {

        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');

    })->name('logout');


    // =================================================
    // DASHBOARD BENDAHARA
    // =================================================

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    // =================================================
    // DASHBOARD WALI KELAS
    // =================================================

    Route::get(
        '/wali-kelas',
        function () {
            return view('wali-kelas');
        }
    )->name('wali-kelas.dashboard');


    // =================================================
    // DATA SISWA WALI KELAS
    // =================================================

    Route::get(
        '/wali-kelas/data-siswa',
        [StudentController::class, 'waliKelasIndex']
    )->name('wali-kelas.students.index');


    // =================================================
    // PANTAU KAS WALI KELAS
    // =================================================

    Route::get(
        '/wali-kelas/pantau-kas',
        [DashboardController::class, 'waliKelasKas']
    )->name('wali-kelas.kas');


    // =================================================
    // STATUS PEMBAYARAN
    // =================================================

    Route::get(
        '/status-pembayaran',
        [DashboardController::class, 'paymentStatus']
    )->name('status-pembayaran');


    // =================================================
    // DASHBOARD SISWA
    // =================================================

    Route::get(
        '/siswa',
        [SiswaDashboardController::class, 'index']
    )->name('siswa.dashboard');


    // =================================================
    // TRANSAKSI BENDAHARA
    // =================================================

    Route::get(
        '/transactions',
        [StudentPaymentController::class, 'index']
    )->name('transactions.index');

    Route::post(
        '/transactions',
        [StudentPaymentController::class, 'store']
    )->name('transactions.store');

    Route::put(
        '/transactions/{id}',
        [StudentPaymentController::class, 'updateTransaction']
    )->name('transactions.update');

    Route::delete(
        '/transactions/{id}',
        [StudentPaymentController::class, 'destroyTransaction']
    )->name('transactions.destroy');


    // =================================================
    // TRANSAKSI UMUM
    // =================================================

    Route::post(
        '/transactions/general',
        [TransactionController::class, 'store']
    )->name('transactions.general.store');


    // =================================================
    // DATA SISWA BENDAHARA
    // =================================================

    Route::get(
        '/students',
        [StudentController::class, 'index']
    )->name('students.index');

    Route::post(
        '/students',
        [StudentController::class, 'store']
    )->name('students.store');

    Route::put(
        '/students/{id}',
        [StudentController::class, 'update']
    )->name('students.update');

    Route::delete(
        '/students/{id}',
        [StudentController::class, 'destroy']
    )->name('students.destroy');


    // =================================================
    // LAPORAN
    // =================================================

    Route::get(
        '/laporan',
        [ReportController::class, 'index']
    )->name('laporan.index');

});