<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Bendahara - MyCash</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --maroon: #4d0710;
            --dark-maroon: #1e0307;
            --gold: #e6c875;
            --background: #f7f5f2;
            --muted: #8b8285;
            --border: #eee7e5;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--background);
            color: #292329;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 250px;
            background: linear-gradient(180deg, var(--maroon), var(--dark-maroon));
            color: white;
            padding: 28px 18px;
            display: flex;
            flex-direction: column;
        }

        .brand { padding: 0 12px 30px; border-bottom: 1px solid rgba(230,200,117,.2); }
        .brand h2 { color: var(--gold); font-size: 23px; letter-spacing: 2px; }
        .brand p { margin-top: 7px; color: #d9c7c7; font-size: 11px; }

        .menu-label {
            margin: 28px 12px 12px;
            color: #c5a7a9;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            margin-bottom: 7px;
            border-radius: 10px;
            text-decoration: none;
            color: #eadfe0;
            font-size: 12px;
        }

        .nav-link i { width: 18px; text-align: center; }

        .nav-link.active, .nav-link:hover {
            background: rgba(230,200,117,.13);
            color: var(--gold);
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(230,200,117,.2);
        }

        .logout-button {
            width: 100%;
            border: 0;
            background: rgba(255,255,255,.08);
            color: white;
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            font: inherit;
            font-size: 12px;
            text-align: left;
        }

        .main { margin-left: 250px; padding: 32px; min-height: 100vh; }

        .eyebrow {
            color: #987b42;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        h1 { margin-top: 8px; font-size: 25px; }

        .topbar { margin-bottom: 30px; }

        .topbar p {
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
        }

        .panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 25px;
        }

        .panel h2 { color: var(--maroon); font-size: 15px; margin-bottom: 20px; }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .detail-item {
            padding: 16px;
            background: #fcf8f2;
            border-radius: 10px;
        }

        .detail-item span {
            display: block;
            color: var(--muted);
            font-size: 10px;
            margin-bottom: 8px;
        }

        .detail-item strong { font-size: 13px; }

        .back {
            display: inline-block;
            margin-top: 25px;
            color: var(--maroon);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: var(--muted);
            font-size: 10px;
        }

        @media (max-width: 700px) {
            .sidebar { position: relative; width: 100%; min-height: auto; }
            .main { margin-left: 0; padding: 20px 15px; }
            .detail-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

<aside class="sidebar">
    <div class="brand">
        <h2>MYCASH</h2>
        <p>Smart Class Finance</p>
    </div>

    <div class="menu-label">MENU UTAMA</div>

    <a href="{{ route('super-admin.dashboard') }}" class="nav-link">
        <i class="fa-solid fa-chart-pie"></i> Dashboard
    </a>

    <div class="menu-label">PENGELOLAAN SISTEM</div>

    <a href="#" class="nav-link">
        <i class="fa-solid fa-users"></i> Data Pengguna
    </a>

    <a href="{{ route('super-admin.kelas.index') }}" class="nav-link">
        <i class="fa-solid fa-school"></i> Data Kelas
    </a>

    <a href="{{ route('super-admin.bendahara.index') }}" class="nav-link active">
        <i class="fa-solid fa-user-tie"></i> Kelola Bendahara
    </a>

    <a href="#" class="nav-link">
        <i class="fa-solid fa-chalkboard-user"></i> Kelola Wali Kelas
    </a>

    <a href="{{ route('super-admin.dashboard') }}#pengawasan" class="nav-link">
        <i class="fa-solid fa-eye"></i> Pengawasan Kas
    </a>

    <a href="{{ route('super-admin.dashboard') }}#hak-akses" class="nav-link">
        <i class="fa-solid fa-shield-halved"></i> Hak Akses
    </a>

    <div class="sidebar-bottom">
        <div class="menu-label">AKUN</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">
                <i class="fa-solid fa-right-from-bracket"></i>
                &nbsp; Keluar
            </button>
        </form>
    </div>
</aside>

<main class="main">

    <header class="topbar">
        <div class="eyebrow">Panel Administrasi Utama</div>
        <h1>Detail Bendahara</h1>
        <p>Informasi akun dan penugasan bendahara.</p>
    </header>

    <section class="panel">
        <h2><i class="fa-solid fa-user-tie"></i> Informasi Bendahara</h2>

        <div class="detail-grid">
            <div class="detail-item">
                <span>Nama Bendahara</span>
                <strong>{{ $bendahara->nama }}</strong>
            </div>

            <div class="detail-item">
                <span>NIP</span>
                <strong>{{ $bendahara->nip ?: '-' }}</strong>
            </div>

            <div class="detail-item">
                <span>Email Akun</span>
                <strong>{{ $bendahara->user?->email ?? '-' }}</strong>
            </div>

            <div class="detail-item">
                <span>No. Telepon / WA</span>
                <strong>{{ $bendahara->no_hp ?: '-' }}</strong>
            </div>

            <div class="detail-item">
                <span>Kelas Dikelola</span>
                <strong>{{ $bendahara->kelas?->kode_kelas ?? 'Belum ditentukan' }}</strong>
            </div>

            <div class="detail-item">
                <span>Status Akun</span>
                <strong>{{ ucfirst($bendahara->user?->status ?? 'Tidak diketahui') }}</strong>
            </div>
        </div>
    </section>

    <a href="{{ route('super-admin.bendahara.index') }}" class="back">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke Daftar Bendahara
    </a>

    <footer class="footer">
        MYCASH &copy; {{ date('Y') }} — Smart Class Finance
    </footer>

</main>

</body>
</html>
