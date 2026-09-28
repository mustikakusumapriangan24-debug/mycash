<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pantau Kas - MyCash</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>
        :root {
            --maroon: #803E2F;
            --maroon-dark: #54251F;
            --maroon-deep: #1F1D20;

            --gold: #B59A63;
            --gold-soft: #D8D0C5;

            --cream: #F1ECE4;
            --white: #FFFEFC;

            --text: #3E3D38;
            --text-soft: #756E69;

            --border: #DED6CC;

            --green: #56856c;
            --red: #9B5750;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F7F4EF;
            color: var(--text);
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;

            width: 220px;
            height: 100vh;

            background:
                linear-gradient(
                    180deg,
                    var(--maroon-dark),
                    var(--maroon-deep)
                );

            color: white;

            display: flex;
            flex-direction: column;

            padding: 28px 16px;

            z-index: 100;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;

            padding: 0 8px;
            margin-bottom: 36px;
        }

        .brand-logo {
            width: 40px;
            height: 40px;

            border-radius: 10px;

            object-fit: cover;

            background: white;
            padding: 3px;
        }

        .brand-text strong {
            display: block;

            font-family: 'Playfair Display', serif;

            font-size: 18px;
            letter-spacing: 1px;
        }

        .brand-text span {
            display: block;

            color: #D8C8BC;

            font-size: 9px;

            margin-top: 2px;

            letter-spacing: .4px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu a {
            display: flex;
            align-items: center;

            gap: 13px;

            padding: 12px 13px;

            border-radius: 9px;

            text-decoration: none;

            color: #E8DDD7;

            font-size: 13px;
            font-weight: 500;

            transition: .2s;
        }

        .menu a i {
            width: 18px;
            text-align: center;
        }

        .menu a:hover {
            background: rgba(255,255,255,.08);
            color: white;
        }

        .menu a.active {
            background: rgba(255,255,255,.13);
            color: white;

            box-shadow:
                inset 3px 0 0 var(--gold);
        }

        /* =========================
           PROFILE
        ========================= */

        .profile {
            margin-top: auto;

            padding: 15px 10px;

            border-top: 1px solid rgba(255,255,255,.12);
        }

        .profile-name {
            font-size: 12px;
            font-weight: 600;

            color: white;
        }

        .profile-role {
            font-size: 10px;

            color: #CBBDB5;

            margin-top: 4px;
        }

        .profile-class {
            font-size: 10px;

            color: #A99A93;

            margin-top: 2px;
        }

        .logout {
            margin-top: 12px;

            width: 100%;

            border: none;

            background: transparent;

            color: #D4C5BE;

            padding: 8px 0;

            text-align: left;

            cursor: pointer;

            font-family: inherit;

            font-size: 11px;
        }

        .logout:hover {
            color: white;
        }

        /* =========================
           MAIN
        ========================= */

        .main {
            margin-left: 220px;

            min-height: 100vh;

            padding: 34px 42px;
        }

        .topbar {
            display: flex;

            justify-content: space-between;
            align-items: flex-start;

            margin-bottom: 30px;
        }

        .eyebrow {
            color: var(--gold);

            text-transform: uppercase;

            font-size: 10px;
            font-weight: 700;

            letter-spacing: 1.8px;

            margin-bottom: 7px;
        }

        h1 {
            font-family: 'Playfair Display', serif;

            color: var(--maroon-deep);

            font-size: 30px;

            margin-bottom: 7px;
        }

        .subtitle {
            color: var(--text-soft);

            font-size: 12px;
        }

        .date-box {
            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 12px;

            padding: 12px 16px;

            text-align: right;
        }

        .date-box span {
            display: block;

            font-size: 9px;

            color: var(--text-soft);

            margin-bottom: 4px;
        }

        .date-box strong {
            font-size: 12px;

            color: var(--maroon-dark);
        }

        /* =========================
           STAT CARDS
        ========================= */

        .stats {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 18px;

            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 15px;

            padding: 21px;

            position: relative;

            overflow: hidden;
        }

        .stat-card::after {
            content: '';

            position: absolute;

            right: -30px;
            bottom: -30px;

            width: 100px;
            height: 100px;

            border-radius: 50%;

            background: rgba(181,154,99,.08);
        }

        .stat-top {
            display: flex;

            justify-content: space-between;
            align-items: center;

            margin-bottom: 15px;
        }

        .stat-label {
            font-size: 11px;

            color: var(--text-soft);
        }

        .stat-icon {
            width: 34px;
            height: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: var(--cream);

            color: var(--maroon);
        }

        .stat-value {
            font-size: 24px;

            font-weight: 700;

            color: var(--maroon-deep);
        }

        .stat-card.balance {
            background:
                linear-gradient(
                    135deg,
                    var(--maroon),
                    var(--maroon-dark)
                );

            border: none;
        }

        .stat-card.balance .stat-label {
            color: #E7D9D1;
        }

        .stat-card.balance .stat-value {
            color: white;
        }

        .stat-card.balance .stat-icon {
            background: rgba(255,255,255,.12);
            color: #E5C987;
        }

        /* =========================
           CONTENT
        ========================= */

        .content-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1.7fr)
                minmax(280px, .9fr);

            gap: 22px;
        }

        .panel {
            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 16px;

            overflow: hidden;
        }

        .panel-header {
            padding: 19px 21px;

            border-bottom: 1px solid #ECE5DD;

            display: flex;

            justify-content: space-between;
            align-items: center;
        }

        .panel-title {
            font-family: 'Playfair Display', serif;

            font-size: 17px;

            color: var(--maroon-deep);
        }

        .panel-subtitle {
            font-size: 10px;

            color: var(--text-soft);

            margin-top: 3px;
        }

        /* =========================
           TABLE
        ========================= */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;
        }

        th {
            padding: 13px 18px;

            text-align: left;

            font-size: 9px;

            text-transform: uppercase;

            letter-spacing: .8px;

            color: var(--text-soft);

            background: #FAF8F4;

            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 15px 18px;

            font-size: 11px;

            border-bottom: 1px solid #EEE8E0;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .transaction-date {
            color: var(--text-soft);

            white-space: nowrap;
        }

        .transaction-name {
            font-weight: 600;

            color: var(--maroon-deep);
        }

        .transaction-desc {
            color: var(--text-soft);

            font-size: 10px;

            margin-top: 3px;

            max-width: 280px;
        }

        .badge {
            display: inline-flex;

            align-items: center;

            gap: 5px;

            padding: 5px 8px;

            border-radius: 20px;

            font-size: 9px;

            font-weight: 600;
        }

        .badge.in {
            background: #E9F1EC;
            color: var(--green);
        }

        .badge.out {
            background: #F5E8E6;
            color: var(--red);
        }

        .amount-in {
            color: var(--green);

            font-weight: 700;

            white-space: nowrap;
        }

        .amount-out {
            color: var(--red);

            font-weight: 700;

            white-space: nowrap;
        }

        .empty {
            text-align: center;

            padding: 40px 20px;

            color: var(--text-soft);

            font-size: 11px;
        }

        .empty i {
            font-size: 22px;

            margin-bottom: 10px;
        }

        /* =========================
           SIDE INFO
        ========================= */

        .info-list {
            padding: 7px 21px 20px;
        }

        .info-item {
            display: flex;

            justify-content: space-between;
            align-items: center;

            padding: 15px 0;

            border-bottom: 1px solid #EEE8E0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 10px;

            color: var(--text-soft);
        }

        .info-value {
            font-size: 11px;

            font-weight: 700;

            color: var(--maroon-dark);
        }

        .notice {
            margin: 0 21px 21px;

            padding: 14px;

            background: #F7F1E7;

            border-left: 3px solid var(--gold);

            border-radius: 8px;
        }

        .notice-title {
            font-size: 10px;

            font-weight: 700;

            color: var(--maroon-dark);

            margin-bottom: 5px;
        }

        .notice-text {
            font-size: 9px;

            line-height: 1.6;

            color: var(--text-soft);
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1000px) {

            .stats {
                grid-template-columns: 1fr;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {

            .sidebar {
                width: 70px;

                padding: 22px 10px;
            }

            .brand-text,
            .menu span,
            .profile {
                display: none;
            }

            .brand {
                justify-content: center;

                padding: 0;
            }

            .menu a {
                justify-content: center;

                padding: 12px;
            }

            .main {
                margin-left: 70px;

                padding: 25px 18px;
            }

            .topbar {
                flex-direction: column;

                gap: 15px;
            }

            .date-box {
                text-align: left;
            }
        }
    </style>
</head>

<body>

<!-- =====================================================
     SIDEBAR
===================================================== -->

<aside class="sidebar">

    <div class="brand">

        <img
            src="{{ asset('images/logo_MYCASH.png') }}"
            class="brand-logo"
            alt="MyCash"
        >

        <div class="brand-text">
            <strong>MYCASH</strong>
            <span>SMART CLASS FINANCE</span>
        </div>

    </div>


    <nav class="menu">

        <a href="{{ route('wali-kelas.dashboard') }}">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('students.index') }}">
            <i class="fa-solid fa-users"></i>
            <span>Data Siswa</span>
        </a>

        <a href="#">
            <i class="fa-solid fa-user-lock"></i>
            <span>Akun Siswa</span>
        </a>

        <a
            href="{{ route('wali-kelas.kas') }}"
            class="active"
        >
            <i class="fa-solid fa-wallet"></i>
            <span>Pantau Kas</span>
        </a>

        <a href="#">
            <i class="fa-solid fa-file-lines"></i>
            <span>Laporan</span>
        </a>

        <a href="#">
            <i class="fa-solid fa-gear"></i>
            <span>Pengaturan</span>
        </a>

    </nav>


    <div class="profile">

        <div class="profile-name">
            {{ auth()->user()->name ?? 'Wali Kelas' }}
        </div>

        <div class="profile-role">
            Wali Kelas
        </div>

        <div class="profile-class">
            XI RPL 1
        </div>

        <form
            action="{{ route('logout') }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="logout"
            >
                <i class="fa-solid fa-right-from-bracket"></i>
                &nbsp; Keluar
            </button>
        </form>

    </div>

</aside>


<!-- =====================================================
     MAIN
===================================================== -->

<main class="main">

    <div class="topbar">

        <div>

            <div class="eyebrow">
                Monitoring Keuangan
            </div>

            <h1>Pantau Kas</h1>

            <p class="subtitle">
                Pantau kondisi dan riwayat keuangan kelas XI RPL 1.
            </p>

        </div>


        <div class="date-box">

            <span>
                Tahun Ajaran
            </span>

            <strong>
                2026 / 2027
            </strong>

        </div>

    </div>


    <!-- =================================================
         STAT CARDS
    ================================================== -->

    <section class="stats">

        <!-- PEMASUKAN -->

        <div class="stat-card">

            <div class="stat-top">

                <span class="stat-label">
                    Total Pemasukan
                </span>

                <div class="stat-icon">
                    <i class="fa-solid fa-arrow-down"></i>
                </div>

            </div>

            <div class="stat-value">
                Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
            </div>

        </div>


        <!-- PENGELUARAN -->

        <div class="stat-card">

            <div class="stat-top">

                <span class="stat-label">
                    Total Pengeluaran
                </span>

                <div class="stat-icon">
                    <i class="fa-solid fa-arrow-up"></i>
                </div>

            </div>

            <div class="stat-value">
                Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
            </div>

        </div>


        <!-- SALDO -->

        <div class="stat-card balance">

            <div class="stat-top">

                <span class="stat-label">
                    Saldo Kas
                </span>

                <div class="stat-icon">
                    <i class="fa-solid fa-wallet"></i>
                </div>

            </div>

            <div class="stat-value">
                Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}
            </div>

        </div>

    </section>


    <!-- =================================================
         CONTENT
    ================================================== -->

    <section class="content-grid">


        <!-- =================================================
             RIWAYAT TRANSAKSI
        ================================================== -->

        <div class="panel">

            <div class="panel-header">

                <div>

                    <div class="panel-title">
                        Riwayat Transaksi
                    </div>

                    <div class="panel-subtitle">
                        Informasi transaksi kas kelas
                    </div>

                </div>

            </div>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Jenis
                            </th>

                            <th>
                                Keterangan
                            </th>

                            <th>
                                Jumlah
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($transactions as $transaction)

                            <tr>

                                <td class="transaction-date">
                                    {{ $transaction->created_at?->format('d/m/Y') ?? '-' }}
                                </td>


                                <td>

                                    @if ($transaction->type === 'in')

                                        <span class="badge in">
                                            <i class="fa-solid fa-arrow-down"></i>
                                            Pemasukan
                                        </span>

                                    @else

                                        <span class="badge out">
                                            <i class="fa-solid fa-arrow-up"></i>
                                            Pengeluaran
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <div class="transaction-name">

                                        {{ $transaction->category ?? 'Transaksi' }}

                                    </div>

                                    @if ($transaction->description)

                                        <div class="transaction-desc">

                                            {{ $transaction->description }}

                                        </div>

                                    @endif

                                </td>


                                <td>

                                    @if ($transaction->type === 'in')

                                        <span class="amount-in">
                                            + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>

                                    @else

                                        <span class="amount-out">
                                            - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4">

                                    <div class="empty">

                                        <i class="fa-regular fa-folder-open"></i>

                                        <br>

                                        Belum ada transaksi yang dapat ditampilkan.

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        <!-- =================================================
             INFORMASI KAS
        ================================================== -->

        <div class="panel">

            <div class="panel-header">

                <div>

                    <div class="panel-title">
                        Informasi Kas
                    </div>

                    <div class="panel-subtitle">
                        Ringkasan kondisi kas kelas
                    </div>

                </div>

            </div>


            <div class="info-list">

                <div class="info-item">

                    <span class="info-label">
                        Kelas
                    </span>

                    <span class="info-value">
                        XI RPL 1
                    </span>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Wali Kelas
                    </span>

                    <span class="info-value">
                        Bu Lilis
                    </span>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Iuran Bulanan
                    </span>

                    <span class="info-value">
                        Rp 10.000
                    </span>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Total Transaksi
                    </span>

                    <span class="info-value">
                        {{ $transactions->count() }}
                    </span>

                </div>

            </div>


            <div class="notice">

                <div class="notice-title">

                    <i class="fa-solid fa-circle-info"></i>
                    &nbsp; Informasi

                </div>

                <div class="notice-text">

                    Halaman ini bersifat monitoring.
                    Wali Kelas dapat melihat kondisi kas
                    dan riwayat transaksi tanpa melakukan
                    perubahan terhadap data keuangan.

                </div>

            </div>

        </div>

    </section>

</main>

</body>
</html>

