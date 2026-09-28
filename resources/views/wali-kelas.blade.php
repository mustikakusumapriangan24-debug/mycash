@extends('layouts.wali-kelas')

@section('title', 'Dashboard Wali Kelas - MyCash')

@section('content')

<style>
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
    }

    .welcome h2 {
        font-family: "Playfair Display", serif;
        font-size: 30px;
        color: #3E3D38;
    }

    .welcome p {
        margin-top: 8px;
        color: #756E69;
        font-size: 13px;
    }

    .welcome-line {
        width: 50px;
        height: 3px;
        margin-top: 18px;
        border-radius: 20px;
        background: linear-gradient(90deg, #B59A63, #D8D0C5);
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .class-box,
    .notification {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(181, 154, 99, 0.38);
        border-radius: 12px;
        box-shadow: 0 5px 18px rgba(31, 29, 32, 0.06);
    }

    .class-box {
        min-width: 220px;
        padding: 13px 18px;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .class-box i {
        color: #803E2F;
    }

    .class-box span {
        display: block;
        font-size: 10px;
        color: #756E69;
    }

    .class-box strong {
        display: block;
        margin-top: 3px;
        font-size: 13px;
    }

    .notification {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #803E2F;
    }

    /* =====================================================
       STATISTICS
    ====================================================== */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .stat-card {
        min-height: 165px;
        padding: 20px;
        border-radius: 15px;
        background: #FFFEFC;
        border: 1px solid #DED6CC;
        box-shadow: 0 8px 24px rgba(45, 28, 20, 0.05);
    }

    .stat-card.primary {
        position: relative;
        overflow: hidden;
        color: white;
        background: linear-gradient(
            135deg,
            #803E2F 0%,
            #54251F 58%,
            #2B2222 100%
        );
        border-color: rgba(181, 154, 99, 0.42);
        box-shadow: 0 12px 28px rgba(84, 37, 31, 0.18);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        background: #F1ECE4;
        color: #B59A63;
    }

    .primary .stat-icon {
        background: rgba(181, 154, 99, 0.16);
    }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        margin-top: 15px;
        font-family: "Playfair Display", serif;
        font-size: 28px;
        font-weight: 700;
    }

    .stat-description {
        margin-top: 10px;
        font-size: 11px;
        color: #756E69;
    }

    .primary .stat-description {
        color: #D8D0C5;
    }

    /* =====================================================
       CONTENT
    ====================================================== */

    .content-grid {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 18px;
    }

    .panel {
        background: #FFFEFC;
        border: 1px solid #DED6CC;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 8px 24px rgba(45, 28, 20, 0.055);
    }

    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .panel-title {
        font-family: "Playfair Display", serif;
        font-size: 19px;
        color: #54251F;
    }

    /* =====================================================
       ACTION CARD
    ====================================================== */

    .action-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .action-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px;
        border: 1px solid #DED6CC;
        border-radius: 12px;
        text-decoration: none;
        color: #3E3D38;
        transition: 0.2s;
    }

    .action-card:hover {
        border-color: rgba(181, 154, 99, 0.38);
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(45, 28, 20, 0.06);
    }

    .action-icon {
        width: 45px;
        height: 45px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #F1ECE4;
        color: #803E2F;
    }

    .action-card strong {
        display: block;
        font-size: 13px;
    }

    .action-card span {
        display: block;
        margin-top: 4px;
        font-size: 10px;
        color: #756E69;
    }

    /* =====================================================
       CLASS INFO
    ====================================================== */

    .class-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px 40px;
    }

    .info-item span {
        display: block;
        font-size: 11px;
        color: #756E69;
    }

    .info-item strong {
        display: block;
        margin-top: 7px;
        font-size: 16px;
        color: #3E3D38;
    }

    /* =====================================================
       WELCOME PANEL
    ====================================================== */

    .welcome-panel {
        margin-top: 18px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(
            135deg,
            #FFFDF9,
            #F1ECE4
        );
        border: 1px solid rgba(181, 154, 99, 0.38);
    }

    .welcome-panel::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -60px;
        top: -70px;
        border-radius: 50%;
        border: 1px solid rgba(181, 154, 99, 0.18);
    }

    .welcome-panel h3 {
        font-family: "Playfair Display", serif;
        font-size: 20px;
        color: #54251F;
    }

    .welcome-panel p {
        margin-top: 8px;
        max-width: 650px;
        font-size: 12px;
        line-height: 1.7;
        color: #756E69;
    }

    /* =====================================================
       RESPONSIVE
    ====================================================== */

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 700px) {
        .topbar {
            flex-direction: column;
            gap: 15px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .action-list {
            grid-template-columns: 1fr;
        }

        .class-info {
            grid-template-columns: 1fr;
        }

        .topbar-right {
            width: 100%;
        }

        .class-box {
            flex: 1;
        }
    }
</style>


<!-- =====================================================
     HEADER
====================================================== -->

<header class="topbar">

    <div class="welcome">

        <h2>
            Halo,
            {{ auth()->user()->name ?? 'Wali Kelas' }}! 👋
        </h2>

        <p>
            Kelola data dan informasi siswa kelas XI RPL 1 dengan mudah.
        </p>

        <div class="welcome-line"></div>

    </div>


    <div class="topbar-right">

        <div class="class-box">

            <i class="fa-solid fa-users"></i>

            <div>

                <span>
                    Kelas
                </span>

                <strong>
                    XI RPL 1
                </strong>

            </div>

        </div>


        <div class="notification">

            <i class="fa-regular fa-bell"></i>

        </div>

    </div>

</header>


<!-- =====================================================
     STATISTICS
====================================================== -->

<section class="stats-grid">


    <!-- JUMLAH SISWA -->

    <div class="stat-card primary">

        <div class="stat-icon">

            <i class="fa-solid fa-users"></i>

        </div>

        <div class="stat-label">
            Jumlah Siswa
        </div>

        <div class="stat-value">

            {{ \App\Models\Student::count() }}

            <span style="font-size:16px;">
                Siswa
            </span>

        </div>

        <div class="stat-description">
            Total siswa aktif di kelas
        </div>

    </div>


    <!-- SISWA LAKI-LAKI -->

    <div class="stat-card">

        <div class="stat-icon">

            <i class="fa-solid fa-person"></i>

        </div>

        <div class="stat-label">
            Siswa Laki-laki
        </div>

        <div class="stat-value">

            {{ \App\Models\Student::where('gender', 'L')->count() }}

        </div>

        <div class="stat-description">
            Siswa laki-laki aktif
        </div>

    </div>


    <!-- SISWA PEREMPUAN -->

    <div class="stat-card">

        <div class="stat-icon">

            <i class="fa-solid fa-person-dress"></i>

        </div>

        <div class="stat-label">
            Siswa Perempuan
        </div>

        <div class="stat-value">

            {{ \App\Models\Student::where('gender', 'P')->count() }}

        </div>

        <div class="stat-description">
            Siswa perempuan aktif
        </div>

    </div>

</section>


<!-- =====================================================
     CONTENT
====================================================== -->

<section class="content-grid">


    <!-- PENGELOLAAN KELAS -->

    <div class="panel">

        <div class="panel-header">

            <h3 class="panel-title">
                Pengelolaan Kelas
            </h3>

        </div>


        <div class="action-list">


            <!-- DATA SISWA -->

            <a
                href="{{ route('students.index') }}"
                class="action-card"
            >

                <div class="action-icon">

                    <i class="fa-solid fa-users"></i>

                </div>

                <div>

                    <strong>
                        Data Siswa
                    </strong>

                    <span>
                        Tambah, edit, dan hapus data siswa
                    </span>

                </div>

            </a>


            <!-- AKUN SISWA -->

            <a
                href="#"
                class="action-card"
            >

                <div class="action-icon">

                    <i class="fa-solid fa-user-plus"></i>

                </div>

                <div>

                    <strong>
                        Akun Siswa
                    </strong>

                    <span>
                        Kelola akun login siswa
                    </span>

                </div>

            </a>

        </div>

    </div>


    <!-- INFORMASI KELAS -->

    <div class="panel">

        <div class="panel-header">

            <h3 class="panel-title">
                Informasi Kelas
            </h3>

        </div>


        <div class="class-info">


            <div class="info-item">

                <span>
                    Kelas
                </span>

                <strong>
                    XI RPL 1
                </strong>

            </div>


            <div class="info-item">

                <span>
                    Wali Kelas
                </span>

                <strong>
                    Bu Lilis
                </strong>

            </div>


            <div class="info-item">

                <span>
                    Jumlah Siswa
                </span>

                <strong>

                    {{ \App\Models\Student::count() }}

                    Siswa

                </strong>

            </div>


            <div class="info-item">

                <span>
                    Tahun Ajaran
                </span>

                <strong>
                    2026 / 2027
                </strong>

            </div>

        </div>

    </div>

</section>


<!-- =====================================================
     WELCOME INFORMATION
====================================================== -->

<section class="panel welcome-panel">

    <h3>
        Ruang Pengelolaan Wali Kelas
    </h3>

    <p>

        Halaman ini digunakan oleh Wali Kelas untuk mengelola
        data siswa dan akun siswa kelas XI RPL 1. Pastikan
        informasi siswa selalu diperbarui agar data kelas
        tetap terorganisir dan dapat digunakan oleh Bendahara
        dalam pencatatan kas kelas.

    </p>

</section>

@endsection