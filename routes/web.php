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
use App\Http\Controllers\SuperAdminProfileController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CashSettingController;
use App\Http\Controllers\TransactionAuditController;

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

    // LOGOUT

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

        Route::get('/super-admin', function () {

            $totalKelas = Kelas::where('status', 'aktif')->count();

            $totalSiswa = DB::table('students')->count();

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


        // PROFIL SUPER ADMIN

        Route::get(
            '/super-admin/profil',
            [SuperAdminProfileController::class, 'index']
        )->name('super-admin.profile');

        Route::put(
            '/super-admin/profil',
            [SuperAdminProfileController::class, 'update']
        )->name('super-admin.profile.update');

        Route::put(
            '/super-admin/profil/password',
            [SuperAdminProfileController::class, 'updatePassword']
        )->name('super-admin.profile.password');


        // DATA KELAS

        Route::get(
            '/super-admin/kelas',
            [SuperAdminKelasController::class, 'index']
        )->name('super-admin.kelas.index');

        Route::get(
            '/super-admin/kelas/tambah',
            [SuperAdminKelasController::class, 'create']
        )->name('super-admin.kelas.create');

        Route::post(
            '/super-admin/kelas',
            [SuperAdminKelasController::class, 'store']
        )->name('super-admin.kelas.store');

        Route::get(
            '/super-admin/kelas/{id}',
            [SuperAdminKelasController::class, 'show']
        )->whereNumber('id')
            ->name('super-admin.kelas.show');

        Route::post(
            '/super-admin/kelas/{id}/siswa',
            [SuperAdminKelasController::class, 'assignStudent']
        )->whereNumber('id')
            ->name('super-admin.kelas.students.store');

        Route::delete(
            '/super-admin/kelas/{id}/siswa/{studentId}',
            [SuperAdminKelasController::class, 'removeStudent']
        )->whereNumber('id')
            ->whereNumber('studentId')
            ->name('super-admin.kelas.students.destroy');

        Route::get(
            '/super-admin/kelas/{id}/edit',
            [SuperAdminKelasController::class, 'edit']
        )->whereNumber('id')
            ->name('super-admin.kelas.edit');

        Route::put(
            '/super-admin/kelas/{id}',
            [SuperAdminKelasController::class, 'update']
        )->whereNumber('id')
            ->name('super-admin.kelas.update');

        Route::delete(
            '/super-admin/kelas/{id}',
            [SuperAdminKelasController::class, 'destroy']
        )->whereNumber('id')
            ->name('super-admin.kelas.destroy');


        // KELOLA BENDAHARA

        Route::get(
            '/super-admin/bendahara',
            [SuperAdminBendaharaController::class, 'index']
        )->name('super-admin.bendahara.index');

        Route::get(
            '/super-admin/bendahara/{id}/edit',
            [SuperAdminBendaharaController::class, 'edit']
        )->whereNumber('id')
            ->name('super-admin.bendahara.edit');

        Route::put(
            '/super-admin/bendahara/{id}',
            [SuperAdminBendaharaController::class, 'update']
        )->whereNumber('id')
            ->name('super-admin.bendahara.update');

        Route::patch(
            '/super-admin/bendahara/{id}/status',
            [SuperAdminBendaharaController::class, 'toggleStatus']
        )->whereNumber('id')
            ->name('super-admin.bendahara.toggle-status');

        Route::delete(
            '/super-admin/bendahara/{id}',
            [SuperAdminBendaharaController::class, 'destroy']
        )->whereNumber('id')
            ->name('super-admin.bendahara.destroy');

        Route::get(
            '/super-admin/bendahara/{id}',
            [SuperAdminBendaharaController::class, 'show']
        )->whereNumber('id')
            ->name('super-admin.bendahara.show');

    });


    // =====================================================
    // BENDAHARA
    // =====================================================

    Route::middleware('role:bendahara')->group(function () {

        Route::put(
            '/pengaturan-kas',
            [CashSettingController::class, 'updateForBendahara']
        )->name('cash-settings.bendahara.update');

        Route::post(
            '/pengaturan-kas/reset',
            [CashSettingController::class, 'resetForBendahara']
        )->name('cash-settings.bendahara.reset');

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
            '/pengumuman',
            [AnnouncementController::class, 'index']
        )->name('pengumuman.index');

        Route::post(
            '/pengumuman',
            [AnnouncementController::class, 'store']
        )->name('pengumuman.store');

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
            '/transactions/audit',
            [TransactionAuditController::class, 'index']
        )->name('transactions.audit');

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

        Route::get('/wali-kelas', function () {
            return view('wali-kelas');
        })->name('wali-kelas.dashboard');


        // PROFIL

        Route::get(
            '/wali-kelas/profil',
            [WaliKelasProfileController::class, 'index']
        )->name('wali-kelas.profile');

        Route::put(
            '/wali-kelas/profil',
            [WaliKelasProfileController::class, 'update']
        )->name('wali-kelas.profile.update');


        // DATA SISWA

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


        // PANTAU KAS

        Route::get(
            '/wali-kelas/pantau-kas',
            [DashboardController::class, 'waliKelasKas']
        )->name('wali-kelas.kas');


        // =================================================
        // MANAJEMEN AKUN SISWA
        // =================================================

        Route::get(
            '/wali-kelas/akun-siswa',
            [StudentAccountController::class, 'index']
        )->name('wali-kelas.akun-siswa');


        // TAMBAH AKUN SATU PER SATU

        Route::post(
            '/wali-kelas/akun-siswa',
            [StudentAccountController::class, 'store']
        )->name('wali-kelas.akun-siswa.store');

        Route::post(
            '/wali-kelas/akun-siswa/buat-semua',
            [StudentAccountController::class, 'createAllMissingAccounts']
        )->name('wali-kelas.akun-siswa.buat-semua');


        // EDIT DATA SISWA DAN AKUN

        Route::put(
            '/wali-kelas/akun-siswa/{studentId}',
            [StudentAccountController::class, 'update']
        )->whereNumber('studentId')
            ->name('wali-kelas.akun-siswa.update');


        // RESET PASSWORD

        Route::post(
            '/wali-kelas/akun-siswa/{studentId}/reset-password',
            [StudentAccountController::class, 'resetPassword']
        )->whereNumber('studentId')
            ->name('wali-kelas.akun-siswa.reset-password');


        // PROMOSI MENJADI BENDAHARA

        Route::post(
            '/wali-kelas/akun-siswa/{studentId}/promote',
            [StudentAccountController::class, 'promoteToBendahara']
        )->whereNumber('studentId')
            ->name('wali-kelas.akun-siswa.promote');


        // KEMBALIKAN MENJADI SISWA

        Route::post(
            '/wali-kelas/akun-siswa/{studentId}/demote',
            [StudentAccountController::class, 'demoteToSiswa']
        )->whereNumber('studentId')
            ->name('wali-kelas.akun-siswa.demote');


        // NONAKTIFKAN AKUN

        Route::post(
            '/wali-kelas/akun-siswa/{studentId}/deactivate',
            [StudentAccountController::class, 'deactivateAccount']
        )->whereNumber('studentId')
            ->name('wali-kelas.akun-siswa.deactivate');


        // AKTIFKAN AKUN

        Route::post(
            '/wali-kelas/akun-siswa/{studentId}/activate',
            [StudentAccountController::class, 'activateAccount']
        )->whereNumber('studentId')
            ->name('wali-kelas.akun-siswa.activate');


        // HAPUS DATA SISWA

        Route::delete(
            '/wali-kelas/akun-siswa/{studentId}',
            [StudentAccountController::class, 'destroy']
        )->whereNumber('studentId')
            ->name('wali-kelas.akun-siswa.destroy');

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

        Route::post(
            '/siswa/pengumuman/{id}/baca',
            [SiswaDashboardController::class, 'markAnnouncementAsRead']
        )->name('siswa.announcement.read');

    });

});
