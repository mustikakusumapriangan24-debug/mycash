<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - MyCash</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --maroon: #4d0710;
            --gold: #e6c875;
            --background: #f7f5f2;
            --text: #292329;
            --muted: #8b8285;
            --border: #eee7e5;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--background);
            color: var(--text);
        }

        .main {
            margin-left: 250px;
            padding: 32px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 32px;
        }

        .eyebrow {
            color: #987b42;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .topbar h1 {
            margin-top: 8px;
            font-size: 25px;
            font-weight: 800;
        }

        .topbar p {
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            border: 1px solid var(--border);
            padding: 10px 15px;
            border-radius: 12px;
        }

        .profile-icon {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--maroon);
            color: var(--gold);
        }

        .profile strong {
            display: block;
            font-size: 12px;
        }

        .profile span {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 10px;
        }

        .welcome {
            background: linear-gradient(115deg, #4d0710, #741c29);
            color: white;
            padding: 28px;
            border-radius: 18px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .welcome::after {
            content: "✦";
            position: absolute;
            right: 32px;
            top: -25px;
            font-size: 145px;
            color: rgba(230,200,117,.12);
        }

        .welcome h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .welcome p {
            max-width: 550px;
            color: #f0dfe0;
            font-size: 12px;
            line-height: 1.8;
        }

        .welcome-label {
            display: inline-block;
            margin-top: 18px;
            border: 1px solid rgba(230,200,117,.45);
            border-radius: 30px;
            padding: 7px 12px;
            color: var(--gold);
            font-size: 10px;
        }

        .section-title {
            margin: 28px 0 16px;
            font-size: 15px;
            font-weight: 800;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 22px;
            min-width: 0;
            transition: .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(77,7,16,.06);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
        }

        .stat-top span {
            color: var(--muted);
            font-size: 11px;
            font-weight: 600;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: #f7eeee;
            color: var(--maroon);
        }

        .stat-card h3 {
            font-size: 30px;
            margin-top: 20px;
            color: var(--maroon);
            overflow-wrap: anywhere;
        }

        .stat-card p {
            color: var(--muted);
            font-size: 10px;
            margin-top: 8px;
            line-height: 1.7;
        }

        .stat-detail {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 13px;
        }

        .stat-detail span {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 7px;
            background: #f8f0e2;
            color: #765a24;
            font-size: 9px;
            font-weight: 700;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 18px;
            margin-top: 20px;
        }

        .panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 22px;
            scroll-margin-top: 20px;
        }

        .panel h3 {
            font-size: 14px;
            margin-bottom: 8px;
        }

        .panel-description {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .role-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 14px 0;
            border-bottom: 1px solid #f2eeee;
        }

        .role-item:last-child {
            border-bottom: 0;
        }

        .role-icon {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 12px;
            background: #f8f0e2;
            color: #87631d;
        }

        .role-item strong {
            display: block;
            font-size: 12px;
        }

        .role-item p {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.7;
            margin-top: 5px;
        }

        .role-badge {
            margin-left: auto;
            border-radius: 30px;
            padding: 6px 9px;
            background: #f6eeee;
            color: var(--maroon);
            font-size: 9px;
            white-space: nowrap;
        }

        .responsibility {
            padding: 14px 0;
            border-bottom: 1px solid #f2eeee;
        }

        .responsibility:last-child {
            border-bottom: 0;
        }

        .responsibility strong {
            display: block;
            font-size: 12px;
        }

        .responsibility p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
            margin-top: 6px;
        }

        .notice {
            background: #fbf7eb;
            border: 1px solid #efe3bd;
            color: #715b26;
            border-radius: 12px;
            padding: 15px;
            margin-top: 18px;
            font-size: 11px;
            line-height: 1.8;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: var(--muted);
            font-size: 10px;
        }

        @media (max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .main {
                margin-left: 0;
                padding: 20px 15px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .topbar h1 {
                font-size: 22px;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stat-card {
                padding: 18px;
            }

            .role-badge {
                display: none;
            }
        }
    </style>
</head>

<body>

{{-- SIDEBAR BERSAMA --}}
@include('partials.sidebar-super-admin')

<main class="main">

    <header class="topbar">
        <div>
            <div class="eyebrow">Panel Administrasi Utama</div>
            <h1>Dashboard Super Admin</h1>
            <p>
                Pantau sistem MyCash dan lihat informasi seluruh bagian
                dalam satu halaman.
            </p>
        </div>

        <div class="profile">
            <div class="profile-icon">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div>
                <strong>{{ auth()->user()->name }}</strong>
                <span>Super Administrator</span>
            </div>
        </div>
    </header>

    <section class="welcome">
        <h2>Selamat Datang di MyCash</h2>
        <p>
            Halaman pengawasan utama untuk melihat informasi Bendahara,
            Wali Kelas, dan Siswa. Pencatatan transaksi tetap dilakukan
            oleh Bendahara, sedangkan pengelolaan akun dilakukan oleh
            Wali Kelas sesuai hak aksesnya.
        </p>

        <span class="welcome-label">
            <i class="fa-solid fa-shield-halved"></i>
            Akses Pengawasan Sistem
        </span>
    </section>

    <h2 class="section-title">Ringkasan Sistem</h2>

    <section class="stats">

        <div class="stat-card">
            <div class="stat-top">
                <span>Rombel Kelas</span>
                <div class="stat-icon">
                    <i class="fa-solid fa-school"></i>
                </div>
            </div>

            <h3>{{ number_format($totalKelas ?? 0, 0, ',', '.') }}</h3>

            <p>Jumlah kelas yang terdaftar dan berstatus aktif.</p>

            <div class="stat-detail">
                <span>
                    <i class="fa-solid fa-circle-check"></i>
                    Kelas Aktif
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span>Total Siswa</span>
                <div class="stat-icon">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>

            <h3>{{ number_format($totalSiswa ?? 0, 0, ',', '.') }}</h3>

            <p>Jumlah data siswa yang terdaftar di dalam sistem MyCash.</p>

            <div class="stat-detail">
                <span>
                    <i class="fa-solid fa-users"></i>
                    Data Siswa
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span>Petugas Pengelola</span>
                <div class="stat-icon">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
            </div>

            <h3>{{ number_format($totalPetugas ?? 0, 0, ',', '.') }}</h3>

            <p>Jumlah akun petugas pengelola yang berstatus aktif.</p>

            <div class="stat-detail">
                <span>
                    {{ number_format($totalBendahara ?? 0, 0, ',', '.') }}
                    Bendahara
                </span>

                <span>
                    {{ number_format($totalWaliKelas ?? 0, 0, ',', '.') }}
                    Wali Kelas
                </span>
            </div>
        </div>

    </section>

    <section class="content-grid">

        <div class="panel" id="data-pengguna">
            <h3>Bagian dalam MyCash</h3>
            <p class="panel-description">
                Setiap bagian memiliki tanggung jawab dan hak akses tersendiri.
            </p>

            <div class="role-item">
                <div class="role-icon">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <strong>Super Admin</strong>
                    <p>Mengawasi sistem dan melihat data keseluruhan.</p>
                </div>
                <span class="role-badge">Pengawasan</span>
            </div>

            <div class="role-item">
                <div class="role-icon">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <div>
                    <strong>Bendahara</strong>
                    <p>Mencatat pemasukan, pengeluaran, dan transaksi kas.</p>
                </div>
                <span class="role-badge">Keuangan</span>
            </div>

            <div class="role-item">
                <div class="role-icon">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <strong>Wali Kelas</strong>
                    <p>Mengelola akun Bendahara dan akun Siswa.</p>
                </div>
                <span class="role-badge">Pengelolaan Akun</span>
            </div>

            <div class="role-item">
                <div class="role-icon">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div>
                    <strong>Siswa</strong>
                    <p>Melihat informasi kas yang diperuntukkan bagi dirinya.</p>
                </div>
                <span class="role-badge">Pengguna</span>
            </div>
        </div>

        <div class="panel" id="pengawasan">
            <h3>Pengawasan Sistem</h3>
            <p class="panel-description">
                Informasi tentang batas tanggung jawab setiap bagian.
            </p>

            <div class="responsibility">
                <strong>
                    <i class="fa-solid fa-eye" style="color:#987b42"></i>
                    Pemantauan Data
                </strong>
                <p>
                    Super Admin dapat melihat informasi keseluruhan
                    sesuai kewenangan tanpa mengambil alih pekerjaan operasional.
                </p>
            </div>

            <div class="responsibility">
                <strong>
                    <i class="fa-solid fa-wallet" style="color:#987b42"></i>
                    Pencatatan Kas
                </strong>
                <p>Input pemasukan dan pengeluaran dilakukan Bendahara.</p>
            </div>

            <div class="responsibility">
                <strong>
                    <i class="fa-solid fa-user-gear" style="color:#987b42"></i>
                    Pengelolaan Akun
                </strong>
                <p>
                    Wali Kelas bertanggung jawab mengelola akun Bendahara
                    dan akun Siswa sesuai aturan aplikasi.
                </p>
            </div>

            <div class="notice" id="hak-akses">
                <i class="fa-solid fa-circle-info"></i>
                Angka statistik di atas diambil dari database MyCash.
                Jumlah petugas hanya menghitung akun Bendahara dan Wali Kelas
                yang berstatus aktif.
            </div>
        </div>

    </section>

    <footer class="footer">
        MYCASH &copy; {{ date('Y') }} — Smart Class Finance
    </footer>

</main>

</body>
</html>
