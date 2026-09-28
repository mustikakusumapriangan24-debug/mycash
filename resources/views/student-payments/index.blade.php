<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Transaksi - MyCash</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        :root {
            --maroon: #6f0d14;
            --maroon-dark: #4b060b;
            --gold: #dca936;
            --gold-soft: #f3d98d;

            --cream: #f6f3ee;
            --white: #ffffff;

            --text: #342a2b;
            --text-soft: #837878;

            --border: #ebe5dd;

            --green: #56856c;
            --red: #c95555;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "DM Sans", sans-serif;
            background: var(--cream);
            color: var(--text);
        }

        .layout {
            min-height: 100vh;
            display: flex;
        }

        /* =========================
           SIDEBAR
        ========================== */

        .sidebar {
            width: 220px;
            min-height: 100vh;

            position: fixed;
            left: 0;
            top: 0;

            background:
                linear-gradient(
                    180deg,
                    var(--maroon),
                    var(--maroon-dark)
                );

            color: white;

            padding: 28px 16px;

            display: flex;
            flex-direction: column;

            overflow: hidden;
        }

        .sidebar::before,
        .sidebar::after {

            content: "✿";

            position: absolute;

            color: var(--gold);

            opacity: .15;

            font-size: 230px;

            font-family: Georgia, serif;
        }

        .sidebar::before {
            top: -60px;
            right: -80px;
        }

        .sidebar::after {
            bottom: -80px;
            left: -90px;
            font-size: 300px;
        }

        .brand {
            position: relative;
            z-index: 2;

            text-align: center;

            padding-bottom: 28px;

            border-bottom:
                1px solid rgba(220,169,54,.25);
        }

        .logo-icon {

            width: 58px;
            height: 58px;

            margin: 0 auto 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            border:
                1px solid rgba(220,169,54,.55);

            border-radius: 16px;

            color: var(--gold);

            font-size: 25px;
        }

        .brand h1 {

            font-size: 22px;

            letter-spacing: 2px;

            font-weight: 700;
        }

        .brand p {

            margin-top: 5px;

            font-size: 8px;

            letter-spacing: 1.8px;

            color: var(--gold-soft);

            text-transform: uppercase;
        }

        .menu {

            position: relative;
            z-index: 2;

            margin-top: 18px;
        }

        .menu a {

            text-decoration: none;

            color: #f8eeee;

            display: flex;

            align-items: center;

            gap: 15px;

            padding: 14px 16px;

            margin-bottom: 6px;

            border-radius: 10px;

            font-size: 14px;

            font-weight: 600;

            transition: .2s;
        }

        .menu a i {

            width: 20px;

            color: var(--gold);
        }

        .menu a:hover {

            background:
                rgba(255,255,255,.08);
        }

        .menu a.active {

            color: #4d3010;

            background:
                linear-gradient(
                    135deg,
                    #ffe0a1,
                    #e9ae39
                );

            box-shadow:
                0 8px 20px rgba(0,0,0,.15);
        }

        .menu a.active i {

            color: #5b3809;
        }

        /* =========================
           PROFILE
        ========================== */

        .sidebar-profile {

            position: relative;

            z-index: 2;

            margin-top: auto;

            padding-top: 25px;

            text-align: center;
        }

        .avatar {

            width: 68px;
            height: 68px;

            margin: auto auto 12px;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    #ffd66e,
                    #d89b21
                );

            color: var(--maroon);

            font-size: 28px;
        }

        .sidebar-profile h3 {
            font-size: 15px;
        }

        .sidebar-profile p {

            margin-top: 5px;

            font-size: 11px;

            color: #f0dca4;
        }

        .profile-btn {

            width: 100%;

            margin-top: 18px;

            padding: 12px;

            border: none;

            border-radius: 9px;

            background:
                linear-gradient(
                    135deg,
                    #f2c65e,
                    #d99b24
                );

            color: #563407;

            font-weight: 700;

            cursor: pointer;
        }

        .logout-form {

            width: 100%;

            margin-top: 10px;
        }

        .logout-btn {

            width: 100%;

            padding: 12px;

            border:
                1px solid rgba(220,169,54,.35);

            border-radius: 9px;

            background:
                rgba(255,255,255,.06);

            color: #f8eeee;

            font-family:
                "DM Sans", sans-serif;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 9px;
        }

        .logout-btn i {
            color: var(--gold);
        }

        /* =========================
           MAIN
        ========================== */

        .main {

            width: calc(100% - 220px);

            margin-left: 220px;

            padding: 32px;
        }

        .topbar {

            display: flex;

            justify-content:
                space-between;

            align-items: flex-start;

            margin-bottom: 28px;
        }

        .title h2 {

            font-family:
                "Playfair Display", serif;

            font-size: 30px;

            color: #3b2929;
        }

        .title p {

            margin-top: 8px;

            color: var(--text-soft);

            font-size: 13px;
        }

        .title-line {

            width: 50px;

            height: 3px;

            margin-top: 18px;

            border-radius: 20px;

            background: var(--gold);
        }

        .back-btn {

            text-decoration: none;

            color: var(--maroon);

            background: white;

            border:
                1px solid var(--border);

            padding: 11px 16px;

            border-radius: 9px;

            font-size: 12px;

            font-weight: 700;
        }

        /* =========================
           FORM
        ========================== */

        .panel {

            background: white;

            border:
                1px solid var(--border);

            border-radius: 16px;

            padding: 24px;

            box-shadow:
                0 8px 24px rgba(45,28,20,.045);

            margin-bottom: 20px;
        }

        .panel-title {

            font-family:
                "Playfair Display", serif;

            font-size: 20px;

            margin-bottom: 6px;
        }

        .panel-subtitle {

            color: var(--text-soft);

            font-size: 12px;

            margin-bottom: 22px;
        }

        .form-grid {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 18px;
        }

        .form-group {

            display: flex;

            flex-direction: column;

            gap: 7px;
        }

        .form-group.full {

            grid-column:
                span 2;
        }

        label {

            font-size: 11px;

            font-weight: 700;

            color: #5a4c4d;
        }

        input,
        select {

            width: 100%;

            padding: 12px 13px;

            border:
                1px solid var(--border);

            border-radius: 9px;

            background: #fff;

            color: var(--text);

            font-family:
                "DM Sans", sans-serif;

            font-size: 12px;

            outline: none;
        }

        input:focus,
        select:focus {

            border-color:
                var(--gold);

            box-shadow:
                0 0 0 3px
                rgba(220,169,54,.10);
        }

        .save-btn {

            margin-top: 20px;

            padding: 12px 22px;

            border: none;

            border-radius: 9px;

            background:
                linear-gradient(
                    135deg,
                    #f2c65e,
                    #d99b24
                );

            color: #563407;

            font-family:
                "DM Sans", sans-serif;

            font-weight: 700;

            cursor: pointer;
        }

        /* =========================
           TABLE
        ========================== */

        .table-wrapper {

            overflow-x: auto;
        }

        table {

            width: 100%;

            border-collapse:
                collapse;
        }

        th {

            text-align: left;

            padding: 12px;

            font-size: 10px;

            color: var(--text-soft);

            border-bottom:
                1px solid var(--border);

            text-transform:
                uppercase;
        }

        td {

            padding: 13px 12px;

            font-size: 12px;

            border-bottom:
                1px solid #f0ece7;
        }

        .amount {

            font-weight: 700;

            color: var(--green);
        }

        .status {

            display: inline-flex;

            padding: 5px 9px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: 700;
        }

        .status-paid {

            color: var(--green);

            background:
                rgba(86,133,108,.10);
        }

        .status-partial {

            color: #b37a17;

            background:
                rgba(220,169,54,.12);
        }

        .status-unpaid {

            color: var(--red);

            background:
                rgba(201,85,85,.10);
        }

        .delete-btn {

            border: none;

            background: transparent;

            color: var(--red);

            cursor: pointer;

            font-size: 12px;
        }

        .success {

            padding: 12px 15px;

            margin-bottom: 20px;

            border-radius: 9px;

            background:
                rgba(86,133,108,.10);

            color: var(--green);

            font-size: 12px;

            font-weight: 600;
        }

        .empty {

            text-align: center;

            padding: 30px;

            color: var(--text-soft);

            font-size: 12px;
        }

        @media(max-width: 768px) {

            .sidebar {
                display: none;
            }

            .main {

                width: 100%;

                margin-left: 0;

                padding: 20px;
            }

            .form-grid {

                grid-template-columns: 1fr;
            }

            .form-group.full {

                grid-column:
                    span 1;
            }

            .topbar {

                flex-direction:
                    column;

                gap: 15px;
            }
        }

    </style>

</head>


<body>

<div class="layout">


    <!-- =========================
         SIDEBAR
    ========================== -->

    <aside class="sidebar">

        <div class="brand">

            <div class="logo-icon">

                <i class="fa-solid fa-book-open"></i>

            </div>

            <h1>MYCASH</h1>

            <p>Smart Class Finance</p>

        </div>


        <nav class="menu">

            <a href="{{ route('dashboard') }}">

                <i class="fa-solid fa-house"></i>

                Dashboard

            </a>


            <a href="{{ route('transactions.index') }}"
               class="active">

                <i class="fa-regular fa-file-lines"></i>

                Transaksi

            </a>


            <a href="{{ route('transactions.index') }}">

                <i class="fa-solid fa-arrow-down"></i>

                Pemasukan

            </a>


            <a href="#">

                <i class="fa-solid fa-arrow-up"></i>

                Pengeluaran

            </a>


            <a href="#">

                <i class="fa-solid fa-chart-column"></i>

                Laporan

            </a>


            <a href="{{ route('students.index') }}">

                <i class="fa-solid fa-users"></i>

                Data Siswa

            </a>


            <a href="#">

                <i class="fa-solid fa-gear"></i>

                Pengaturan

            </a>

        </nav>


        <div class="sidebar-profile">

            <div class="avatar">

                <i class="fa-solid fa-user"></i>

            </div>


            <h3>

                {{ auth()->user()->name ?? 'Bendahara' }}

            </h3>


            <p>

                {{ auth()->user()->role == 'bendahara'
                    ? 'Bendahara'
                    : ucfirst(
                        str_replace(
                            '_',
                            ' ',
                            auth()->user()->role ?? 'Bendahara'
                        )
                    )
                }}

            </p>


            <p>XI RPL 1</p>


            <button class="profile-btn">

                <i class="fa-regular fa-user"></i>

                Profil Saya

            </button>


            <form
                action="{{ route('logout') }}"
                method="POST"
                class="logout-form">

                @csrf

                <button
                    type="submit"
                    class="logout-btn">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </button>

            </form>

        </div>

    </aside>


    <!-- =========================
         MAIN CONTENT
    ========================== -->

    <main class="main">


        <header class="topbar">

            <div class="title">

                <h2>Transaksi Kas</h2>

                <p>
                    Catat pemasukan kas siswa yang benar-benar diterima.
                </p>

                <div class="title-line"></div>

            </div>


            <a
                href="{{ route('dashboard') }}"
                class="back-btn">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali ke Dashboard

            </a>

        </header>


        @if(session('success'))

            <div class="success">

                <i class="fa-solid fa-circle-check"></i>

                {{ session('success') }}

            </div>

        @endif


        <!-- =========================
             FORM TRANSAKSI
        ========================== -->

        <div class="panel">

            <h3 class="panel-title">
                Catat Pemasukan Kas
            </h3>

            <p class="panel-subtitle">
                Pencatatan dilakukan berdasarkan uang kas
                yang benar-benar diterima dari siswa.
            </p>


            <form
                action="{{ route('transactions.store') }}"
                method="POST">

                @csrf


                <div class="form-grid">


                    <!-- SISWA -->

                    <div class="form-group">

                        <label>
                            Nama Siswa
                        </label>

                        <select
                            name="student_id"
                            required>

                            <option value="">
                                Pilih siswa
                            </option>

                            @foreach($students as $student)

                                <option
                                    value="{{ $student->id }}">

                                    {{ $student->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- NOMINAL -->

                    <div class="form-group">

                        <label>
                            Jumlah Diterima
                        </label>

                        <input
                            type="number"
                            name="amount"
                            min="0"
                            step="500"
                            placeholder="Contoh: 7000"
                            required>

                    </div>


                    <!-- BULAN -->

                    <div class="form-group">

                        <label>
                            Bulan Kas
                        </label>

                        <input
                            type="month"
                            name="payment_month"
                            value="{{ now()->format('Y-m') }}"
                            required>

                    </div>


                    <!-- TANGGAL -->

                    <div class="form-group">

                        <label>
                            Tanggal Diterima
                        </label>

                        <input
                            type="date"
                            name="paid_at"
                            value="{{ now()->format('Y-m-d') }}"
                            required>

                    </div>

                </div>


                <button
                    type="submit"
                    class="save-btn">

                    <i class="fa-solid fa-plus"></i>

                    Simpan Transaksi

                </button>

            </form>

        </div>


        <!-- =========================
             REKAP PEMBAYARAN
        ========================== -->

        <div class="panel">

            <h3 class="panel-title">
                Rekap Kas Siswa
            </h3>

            <p class="panel-subtitle">
                Status dihitung berdasarkan jumlah kas
                yang sudah dicatat pada bulan tersebut.
            </p>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nama Siswa</th>

                            @foreach($months as $monthNumber => $monthName)

                                <th>
                                    {{ $monthName }}
                                </th>

                            @endforeach

                            <th>Total</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($students as $index => $student)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>


                                <td>
                                    <strong>
                                        {{ $student->name }}
                                    </strong>
                                </td>


                                @foreach($months as $monthNumber => $monthName)

                                    @php

                                        $payment =
                                            $studentPayments[
                                                $student->id
                                            ][$monthNumber]
                                            ?? null;

                                        $amount =
                                            $payment['amount']
                                            ?? 0;

                                        $required =
                                            $payment['required']
                                            ?? 0;

                                        $status =
                                            $payment['status']
                                            ?? 'belum';

                                    @endphp


                                    <td>

                                        @if($status === 'lunas')

                                            <span
                                                class="status status-paid">

                                                ✓ LUNAS

                                            </span>

                                            <br>

                                            <small>
                                                Rp
                                                {{ number_format(
                                                    $amount,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}
                                            </small>


                                        @elseif($status === 'sebagian')

                                            <span
                                                class="status status-partial">

                                                SEBAGIAN

                                            </span>

                                            <br>

                                            <small>
                                                Rp
                                                {{ number_format(
                                                    $amount,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                                /
                                                Rp
                                                {{ number_format(
                                                    $required,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}
                                            </small>


                                        @else

                                            <span
                                                class="status status-unpaid">

                                                BELUM

                                            </span>

                                            <br>

                                            <small>
                                                Rp 0
                                            </small>

                                        @endif

                                    </td>

                                @endforeach


                                <td class="amount">

                                    Rp
                                    {{ number_format(
                                        $studentTotals[
                                            $student->id
                                        ] ?? 0,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="10"
                                    class="empty">

                                    Belum ada data siswa.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>

</html>