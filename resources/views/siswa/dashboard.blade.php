<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'MyCash - Siswa')
    </title>

    <!-- Google Fonts -->
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
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
            --border-gold: rgba(181, 154, 99, .38);

            --green: #56856c;
            --red: #9B5750;
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family: "Plus Jakarta Sans", sans-serif;

            background: #F7F4EF;

            color: var(--text);

            min-height: 100vh;

        }


        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {

            width: 220px;

            position: fixed;

            left: 0;
            top: 0;
            bottom: 0;

            background:
                linear-gradient(
                    180deg,
                    #803E2F 0%,
                    #54251F 100%
                );

            padding: 28px 16px;

            display: flex;

            flex-direction: column;

            z-index: 1000;

        }


        /* =========================
           BRAND
        ========================= */

        .brand {

            text-align: center;

            margin-bottom: 18px;

        }


        .brand-logo {

            width: 58px;
            height: 58px;

            margin: 0 auto 10px;

            border-radius: 16px;

            overflow: hidden;

            background: rgba(255,255,255,.10);

            border: 1px solid rgba(216,208,197,.35);

            display: flex;

            align-items: center;
            justify-content: center;

        }


        .brand-logo img {

            width: 100%;
            height: 100%;

            object-fit: cover;

        }


        .brand h1 {

            font-family: "Playfair Display", serif;

            font-size: 22px;

            letter-spacing: 2px;

            color: #F1ECE4;

        }


        .brand p {

            margin-top: 3px;

            font-size: 9px;

            color: #D8D0C5;

            letter-spacing: .4px;

        }


        /* =========================
           MENU
        ========================= */

        .menu {

            margin-top: 18px;

        }


        .menu a {

            display: flex;

            align-items: center;

            gap: 15px;

            padding: 14px 16px;

            margin-bottom: 6px;

            border-radius: 10px;

            text-decoration: none;

            font-size: 12px;

            font-weight: 600;

            color: #F1ECE4;

            transition: .2s;

        }


        .menu a i {

            width: 18px;

            text-align: center;

            font-size: 14px;

        }


        .menu a:hover {

            background: rgba(255,255,255,.08);

            transform: translateX(2px);

        }


        .menu a.active {

            background:
                linear-gradient(
                    135deg,
                    #D8C7A8,
                    #B59A63
                );

            color: #3E3D38;

            box-shadow:
                0 8px 20px rgba(181,154,99,.18);

        }


        /* =========================
           SIDEBAR PROFILE
        ========================= */

        .sidebar-profile {

            margin-top: auto;

            padding-top: 20px;

            text-align: center;

            border-top: 1px solid rgba(255,255,255,.10);

        }


        .avatar {

            width: 68px;
            height: 68px;

            margin: 0 auto 10px;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #D8C7A8,
                    #8C6C61
                );

            display: flex;

            align-items: center;
            justify-content: center;

            color: #54251F;

            font-size: 25px;

            border: 3px solid rgba(255,255,255,.12);

        }


        .sidebar-profile strong {

            display: block;

            color: #F1ECE4;

            font-size: 12px;

            font-weight: 700;

        }


        .sidebar-profile span {

            display: block;

            margin-top: 3px;

            color: #D8D0C5;

            font-size: 9px;

        }


        .profile-class {

            margin-top: 2px;

            color: #D8C7A8 !important;

        }


        /* =========================
           LOGOUT
        ========================= */

        .logout-btn {

            width: 100%;

            margin-top: 13px;

            padding: 10px;

            border-radius: 9px;

            border: 1px solid rgba(216,208,197,.35);

            background: rgba(255,255,255,.08);

            color: #F1ECE4;

            font-family: "Plus Jakarta Sans", sans-serif;

            font-size: 10px;

            font-weight: 600;

            cursor: pointer;

            transition: .2s;

        }


        .logout-btn:hover {

            background: rgba(255,255,255,.14);

        }


        /* =========================
           MAIN CONTENT
        ========================= */

        .main-content {

            margin-left: 220px;

            min-height: 100vh;

            padding: 36px 40px;

        }


        /* =========================
           PAGE HEADER
        ========================= */

        .page-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 28px;

        }


        .page-title h1 {

            font-family: "Playfair Display", serif;

            font-size: 30px;

            color: var(--maroon-deep);

        }


        .page-title p {

            margin-top: 7px;

            font-size: 12px;

            color: var(--text-soft);

        }


        .role-badge {

            padding: 9px 15px;

            border-radius: 30px;

            border: 1px solid var(--border-gold);

            background: #FFFDF7;

            color: var(--maroon-dark);

            font-size: 10px;

            font-weight: 700;

            letter-spacing: .6px;

        }


        /* =========================
           STATISTIC CARDS
        ========================= */

        .cards {

            display: grid;

            grid-template-columns:
                1.5fr
                1fr
                1fr;

            gap: 20px;

            margin-bottom: 25px;

        }


        .card {

            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 16px;

            padding: 22px;

            box-shadow:
                0 8px 24px
                rgba(45, 28, 20, .055);

        }


        .balance-card {

            background:
                linear-gradient(
                    135deg,
                    var(--maroon),
                    var(--maroon-dark)
                );

            color: white;

            border: none;

            position: relative;

            overflow: hidden;

        }


        .balance-card::after {

            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            border:
                1px solid
                rgba(230,200,117,.18);

            border-radius: 50%;

            right: -60px;
            top: -70px;

        }


        .card-label {

            font-size: 10px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .8px;

            color: var(--text-soft);

            margin-bottom: 12px;

        }


        .balance-card .card-label {

            color: #D8D0C5;

        }


        .balance {

            font-family:
                "Playfair Display",
                serif;

            font-size: 30px;

            margin-bottom: 7px;

        }


        .balance-note {

            color: #D8D0C5;

            font-size: 10px;

        }


        .amount {

            font-size: 22px;

            font-weight: 800;

            color: var(--maroon);

        }


        .income .amount {

            color: var(--green);

        }


        .expense .amount {

            color: var(--red);

        }


        .icon-box {

            width: 37px;
            height: 37px;

            border-radius: 10px;

            background: #F1ECE4;

            color: var(--gold);

            display: flex;

            align-items: center;
            justify-content: center;

            margin-bottom: 14px;

            font-size: 14px;

        }


        /* =========================
           CONTENT GRID
        ========================= */

        .content-grid {

            display: grid;

            grid-template-columns:
                1.5fr
                1fr;

            gap: 20px;

            align-items: start;

        }


        /* =========================
           SECTION
        ========================= */

        .section {

            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 16px;

            padding: 22px;

            box-shadow:
                0 8px 24px
                rgba(45, 28, 20, .055);

        }


        .section-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 18px;

        }


        .section-title {

            font-family:
                "Playfair Display",
                serif;

            color: var(--maroon-dark);

            font-size: 19px;

        }


        .section-subtitle {

            font-size: 10px;

            color: var(--text-soft);

            margin-top: 4px;

        }


        /* =========================
           TRANSACTION
        ========================= */

        .transaction {

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 14px 4px;

            border-bottom:
                1px solid #EEE8E0;

        }


        .transaction:last-child {

            border-bottom: none;

        }


        .transaction-left {

            display: flex;

            align-items: center;

            gap: 12px;

            min-width: 0;

        }


        .transaction-icon {

            width: 40px;
            height: 40px;

            border-radius: 10px;

            display: flex;

            align-items: center;
            justify-content: center;

            font-weight: 800;

            flex-shrink: 0;

        }


        .transaction-icon.in {

            background: #E9F1EC;

            color: var(--green);

        }


        .transaction-icon.out {

            background: #F5EAEA;

            color: var(--red);

        }


        .transaction-name {

            font-size: 12px;

            font-weight: 700;

            color: var(--maroon-deep);

        }


        .transaction-date {

            font-size: 9px;

            color: var(--text-soft);

            margin-top: 4px;

        }


        .transaction-amount {

            font-size: 12px;

            font-weight: 800;

            white-space: nowrap;

        }


        .transaction-amount.in {

            color: var(--green);

        }


        .transaction-amount.out {

            color: var(--red);

        }


        .empty {

            text-align: center;

            padding: 35px;

            color: var(--text-soft);

            font-size: 12px;

        }


        /* =========================
           NOTIFICATION
        ========================= */

        .notification-list {

            display: flex;

            flex-direction: column;

            gap: 2px;

        }


        .notification-item {

            display: flex;

            gap: 12px;

            padding: 14px 4px;

            border-bottom:
                1px solid #EEE8E0;

        }


        .notification-item:last-child {

            border-bottom: none;

        }


        .notification-icon {

            flex: 0 0 38px;

            width: 38px;
            height: 38px;

            border-radius: 10px;

            background: #F1ECE4;

            color: var(--gold);

            display: flex;

            align-items: center;
            justify-content: center;

            font-weight: 800;

        }


        .notification-content {

            min-width: 0;

        }


        .notification-title {

            font-size: 11px;

            font-weight: 800;

            color: var(--text);

        }


        .notification-text {

            font-size: 9px;

            line-height: 1.6;

            color: var(--text-soft);

            margin-top: 4px;

        }


        .notification-time {

            font-size: 8px;

            color: #A69F99;

            margin-top: 5px;

        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1050px) {

            .content-grid {

                grid-template-columns: 1fr;

            }

        }


        @media (max-width: 900px) {

            .sidebar {

                width: 200px;

            }


            .main-content {

                margin-left: 200px;

                padding: 28px;

            }


            .cards {

                grid-template-columns: 1fr;

            }

        }


        @media (max-width: 700px) {

            .sidebar {

                position: relative;

                width: 100%;

                min-height: auto;

            }


            .main-content {

                margin-left: 0;

                padding: 24px 18px;

            }


            .page-header {

                flex-direction: column;

                align-items: flex-start;

                gap: 15px;

            }


            .content-grid {

                grid-template-columns: 1fr;

            }

        }

    </style>

</head>


<body>


    <!-- =========================
         SIDEBAR
    ========================= -->

    <aside class="sidebar">


        <!-- BRAND -->

        <div class="brand">

            <div class="brand-logo">

                <img
                    src="{{ asset('images/logo_MYCASH.png') }}"
                    alt="MyCash"
                >

            </div>


            <h1>
                MYCASH
            </h1>


            <p>
                Smart Class Finance
            </p>

        </div>


        <!-- MENU -->

        <nav class="menu">


            <!-- DASHBOARD -->

            <a
                href="{{ route('siswa.dashboard') }}"
                class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"
            >

                <i class="fa-solid fa-house"></i>

                <span>
                    Dashboard
                </span>

            </a>


            <!-- RIWAYAT KAS -->

            <a href="#">

                <i class="fa-solid fa-clock-rotate-left"></i>

                <span>
                    Riwayat Kas
                </span>

            </a>


            <!-- LAPORAN -->

            <a href="#">

                <i class="fa-solid fa-chart-column"></i>

                <span>
                    Laporan
                </span>

            </a>


            <!-- NOTIFIKASI -->

            <a
                href="#notifikasi"
                class="notification-menu"
            >

                <i class="fa-solid fa-bell"></i>

                <span>
                    Notifikasi
                </span>

                <span class="notification-badge">
                    0
                </span>

            </a>


        </nav>


        <!-- PROFILE -->

        <div class="sidebar-profile">


            <div class="avatar">

                <i class="fa-solid fa-user"></i>

            </div>


            <strong>

                {{ auth()->user()->name ?? 'Akbar' }}

            </strong>


            <span>

                Siswa

            </span>


            <span class="profile-class">

                XII RPL 1

            </span>


            <!-- LOGOUT -->

            <form
                action="{{ route('logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-btn"
                >

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </button>

            </form>


        </div>


    </aside>


    <!-- =========================
         MAIN CONTENT
    ========================= -->

    <main class="main-content">


        <!-- PAGE HEADER -->

        <div class="page-header">


            <div class="page-title">

                <h1>
                    Halo, {{ auth()->user()->name }}!
                </h1>

                <p>
                    Selamat datang di dashboard keuangan kelas XII RPL 1.
                </p>

            </div>


            <div class="role-badge">

                SISWA

            </div>


        </div>


        <!-- =========================
             STATISTICS
        ========================= -->

        <div class="cards">


            <!-- SALDO -->

            <div class="card balance-card">

                <div class="card-label">
                    Saldo Kas Kelas
                </div>

                <div class="balance">

                    Rp{{ number_format(
                        $totalSaldo,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

                <div class="balance-note">

                    Saldo berdasarkan seluruh transaksi kas

                </div>

            </div>


            <!-- PEMASUKAN -->

            <div class="card income">

                <div class="icon-box">

                    <i class="fa-solid fa-arrow-trend-up"></i>

                </div>

                <div class="card-label">

                    Total Pemasukan

                </div>

                <div class="amount">

                    Rp{{ number_format(
                        $totalPemasukan,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>


            <!-- PENGELUARAN -->

            <div class="card expense">

                <div class="icon-box">

                    <i class="fa-solid fa-arrow-trend-down"></i>

                </div>

                <div class="card-label">

                    Total Pengeluaran

                </div>

                <div class="amount">

                    Rp{{ number_format(
                        $totalPengeluaran,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>


        </div>


        <!-- =========================
             CONTENT
        ========================= -->

        <div class="content-grid">


            <!-- RIWAYAT TRANSAKSI -->

            <section class="section">


                <div class="section-header">

                    <div>

                        <div class="section-title">
                            Riwayat Transaksi
                        </div>

                        <div class="section-subtitle">
                            Lima transaksi kas terbaru
                        </div>

                    </div>

                </div>


                @forelse($transactions as $transaction)


                    <div class="transaction">


                        <div class="transaction-left">


                            <div
                                class="transaction-icon {{ $transaction->type }}"
                            >

                                <i
                                    class="fa-solid
                                    {{ $transaction->type === 'in'
                                        ? 'fa-plus'
                                        : 'fa-minus'
                                    }}"
                                ></i>

                            </div>


                            <div>


                                <div class="transaction-name">

                                    {{ $transaction->category ?? 'Transaksi Kas' }}

                                </div>


                                <div class="transaction-date">

                                    {{ $transaction->description ?? 'Tidak ada keterangan' }}

                                    &middot;

                                    {{ $transaction->created_at->format('d M Y') }}

                                </div>


                            </div>


                        </div>


                        <div
                            class="transaction-amount {{ $transaction->type }}"
                        >

                            {{ $transaction->type === 'in'
                                ? '+'
                                : '-'
                            }}

                            Rp{{ number_format(
                                $transaction->amount,
                                0,
                                ',',
                                '.'
                            ) }}

                        </div>


                    </div>


                @empty


                    <div class="empty">

                        Belum ada transaksi kas.

                    </div>


                @endforelse


            </section>


            <!-- NOTIFIKASI -->

            <section
                class="section"
                id="notifikasi"
            >


                <div class="section-header">

                    <div>

                        <div class="section-title">
                            Notifikasi
                        </div>

                        <div class="section-subtitle">
                            Informasi terbaru untuk kamu
                        </div>

                    </div>

                </div>


                <div class="notification-list">


                    <div class="notification-item">


                        <div class="notification-icon">

                            <i class="fa-solid fa-circle-info"></i>

                        </div>


                        <div class="notification-content">


                            <div class="notification-title">

                                Informasi Kas

                            </div>


                            <div class="notification-text">

                                Notifikasi pembayaran dan informasi kas
                                akan muncul di bagian ini.

                            </div>


                            <div class="notification-time">

                                Sistem MyCash

                            </div>


                        </div>


                    </div>


                </div>


            </section>


        </div>


    </main>


</body>

</html>