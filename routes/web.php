<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAccountController;
use App\Http\Controllers\StudentPaymentController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SuperAdminKelasController;
use App\Http\Controllers\SuperAdminBendaharaController;
use App\Http\Controllers\WaliKelasProfileController;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Kelas;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


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
// SEMUA HALAMAN YANG HARUS SUDAH LOGIN
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
    // SUPER ADMIN
    // =================================================

    Route::middleware('role:super_admin')->group(function () {

        // DASHBOARD SUPER ADMIN

        Route::get('/super-admin', function () {

            $totalKelas = Kelas::where('status', 'aktif')
                ->count();

            $totalSiswa = DB::table('students')
                ->count();

            $totalBendahara = User::where('role', 'bendahara')
                ->where('status', 'aktif')
                ->count();

            $totalWaliKelas = User::where('role', 'wali_kelas')
                ->where('status', 'aktif')
                ->count();

            $totalPetugas = $totalBendahara + $totalWaliKelas;

            $totalPengguna = User::count();

            $totalPemasukan = Transaction::where('type', 'in')
                ->sum('amount');

            $totalPengeluaran = Transaction::where('type', 'out')
                ->sum('amount');

            return view('super-admin.dashboard', compact(
                'totalKelas',
                'totalSiswa',
                'totalBendahara',
                'totalWaliKelas',
                'totalPetugas',
                'totalPengguna',
                'totalPemasukan',
                'totalPengeluaran'
            ));

        })->name('super-admin.dashboard');


        // =================================================
        // DATA KELAS
        // =================================================

        // Daftar kelas
        Route::get(
            '/super-admin/kelas',
            [SuperAdminKelasController::class, 'index']
        )->name('super-admin.kelas.index');


        // Form tambah kelas
        Route::get(
            '/super-admin/kelas/tambah',
            [SuperAdminKelasController::class, 'create']
        )->name('super-admin.kelas.create');


        // Simpan kelas baru
        Route::post(
            '/super-admin/kelas',
            [SuperAdminKelasController::class, 'store']
        )->name('super-admin.kelas.store');


        // Detail kelas
        Route::get(
            '/super-admin/kelas/{id}',
            [SuperAdminKelasController::class, 'show']
        )->whereNumber('id')
            ->name('super-admin.kelas.show');


        // Form edit kelas
        Route::get(
            '/super-admin/kelas/{id}/edit',
            [SuperAdminKelasController::class, 'edit']
        )->whereNumber('id')
            ->name('super-admin.kelas.edit');


        // Perbarui data kelas
        Route::put(
            '/super-admin/kelas/{id}',
            [SuperAdminKelasController::class, 'update']
        )->whereNumber('id')
            ->name('super-admin.kelas.update');


        // Hapus kelas dengan perlindungan data
        Route::delete(
            '/super-admin/kelas/{id}',
            [SuperAdminKelasController::class, 'destroy']
        )->whereNumber('id')
            ->name('super-admin.kelas.destroy');


        // =================================================
        // KELOLA BENDAHARA
        // =================================================

        Route::get(
            '/super-admin/bendahara',
            [SuperAdminBendaharaController::class, 'index']
        )->name('super-admin.bendahara.index');

        Route::get(
            '/super-admin/bendahara/{id}',
            [SuperAdminBendaharaController::class, 'show']
        )->name('super-admin.bendahara.show');

    });


    // =====================================================
    // BENDAHARA
    // =====================================================

    Route::middleware('role:bendahara')->group(function () {

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');

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

        Route::post(
            '/transactions/general',
            [TransactionController::class, 'store']
        )->name('transactions.general.store');

        Route::get(
            '/laporan',
            [ReportController::class, 'index']
        )->name('laporan.index');

        Route::get(
            '/laporan/unduh/pdf',
            [ReportController::class, 'exportPdf']
        )->name('laporan.export.pdf');

        Route::get(
            '/laporan/unduh/excel',
            [ReportController::class, 'exportExcel']
        )->name('laporan.export.excel');

    });


    // =====================================================
    // BENDAHARA + WALI KELAS
    // =====================================================

    Route::middleware('role:bendahara|wali_kelas')->group(function () {

        Route::get(
            '/status-pembayaran',
            [DashboardController::class, 'paymentStatus']
        )->name('status-pembayaran');

        Route::get(
            '/students',
            [StudentController::class, 'index']
        )->name('students.index');

    });


    // =====================================================
    // WALI KELAS
    // =====================================================

    Route::middleware('role:wali_kelas')->group(function () {

        Route::get(
            '/wali-kelas',
            function () {
                return view('wali-kelas');
            }
        )->name('wali-kelas.dashboard');

        Route::get(
            '/wali-kelas/profil',
            [WaliKelasProfileController::class, 'index']
        )->name('wali-kelas.profile');

        Route::put(
            '/wali-kelas/profil',
            [WaliKelasProfileController::class, 'update']
        )->name('wali-kelas.profile.update');

        Route::get(
            '/wali-kelas/data-siswa',
            [StudentController::class, 'waliKelasIndex']
        )->name('wali-kelas.students.index');

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

        Route::get(
            '/wali-kelas/pantau-kas',
            [DashboardController::class, 'waliKelasKas']
        )->name('wali-kelas.kas');


        // MANAJEMEN AKUN SISWA

        Route::get(
            '/wali-kelas/akun-siswa',
            [StudentAccountController::class, 'index']
        )->name('wali-kelas.akun-siswa');

        Route::post(
            '/wali-kelas/akun-siswa',
            [StudentAccountController::class, 'store']
        )->name('wali-kelas.akun-siswa.store');

        Route::put(
            '/wali-kelas/akun-siswa/{studentId}',
            [StudentAccountController::class, 'update']
        )->name('wali-kelas.akun-siswa.update');

        Route::post(
            '/wali-kelas/akun-siswa/{studentId}/reset-password',
            [StudentAccountController::class, 'resetPassword']
        )->name('wali-kelas.akun-siswa.reset-password');

        Route::post(
            '/wali-kelas/akun-siswa/{studentId}/promote',
            [StudentAccountController::class, 'promoteToBendahara']
        )->name('wali-kelas.akun-siswa.promote');

        Route::post(
            '/wali-kelas/akun-siswa/{studentId}/demote',
            [StudentAccountController::class, 'demoteToSiswa']
        )->name('wali-kelas.akun-siswa.demote');

        Route::post(
            '/wali-kelas/akun-siswa/{studentId}/deactivate',
            [StudentAccountController::class, 'deactivateAccount']
        )->name('wali-kelas.akun-siswa.deactivate');

        Route::post(
            '/wali-kelas/akun-siswa/{studentId}/activate',
            [StudentAccountController::class, 'activateAccount']
        )->name('wali-kelas.akun-siswa.activate');

    });


    // =====================================================
    // SISWA
    // =====================================================

    Route::middleware('role:siswa')->group(function () {

        Route::get(
            '/siswa',
            [SiswaDashboardController::class, 'index']
        )->name('siswa.dashboard');

        Route::post(
            '/siswa/notifikasi/{id}/baca',
            [SiswaDashboardController::class, 'markNotificationAsRead']
        )->name('siswa.notification.read');

    });

});
