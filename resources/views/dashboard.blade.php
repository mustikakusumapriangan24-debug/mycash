@extends('layouts.bendahara')

@section('title', 'Dashboard - MyCash')

@section('content')

<style>
    .dashboard-page {
        width: 100%;
    }

    /* =========================
       HEADER
    ========================== */

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
        color: var(--text-soft);
        font-size: 13px;
    }

    .welcome-line {
        width: 50px;
        height: 3px;
        margin-top: 18px;
        border-radius: 20px;
        background: linear-gradient(
            90deg,
            var(--gold),
            var(--gold-soft)
        );
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .class-box,
    .notification {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid var(--border-gold);
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
        color: var(--maroon);
    }

    .class-box span {
        display: block;
        font-size: 10px;
        color: var(--text-soft);
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
        color: var(--maroon);
    }

    /* =========================
       STATISTICS
    ========================== */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .stat-card {
        min-height: 170px;
        padding: 20px;
        border-radius: 15px;
        background: #FFFEFC;
        border: 1px solid var(--border);
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
        color: var(--gold);
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
        margin-top: 20px;
        font-family: "Playfair Display", serif;
        font-size: 27px;
        font-weight: 700;
    }

    .stat-growth {
        margin-top: 14px;
        font-size: 11px;
        font-weight: 600;
        color: var(--green);
    }

    .primary .stat-growth {
        color: var(--gold-soft);
    }

    .negative {
        color: var(--red);
    }

    .income {
        color: var(--green);
    }

    .expense {
        color: var(--red);
    }

    /* =========================
       DASHBOARD GRID
    ========================== */

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 18px;
    }

    .left-column,
    .right-column {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    /* =========================
       PANEL
    ========================== */

    .panel {
        background: #FFFEFC;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 8px 24px rgba(45, 28, 20, 0.055);
    }

    .panel-title {
        font-family: "Playfair Display", serif;
        font-size: 18px;
        color: #54251F;
        margin-bottom: 18px;
    }

    /* =========================
       DISTRIBUTION
    ========================== */

    .distribution-content {
        display: flex;
        align-items: center;
        gap: 35px;
    }

    .donut {
        width: 180px;
        height: 180px;
        flex-shrink: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: conic-gradient(
            #803E2F 0deg 120deg,
            #58776c 120deg 216deg,
            #B59A63 216deg 288deg,
            #8C6C61 288deg 336deg,
            #9A5C52 336deg 360deg
        );
    }

    .donut-center {
        width: 112px;
        height: 112px;
        border-radius: 50%;
        background: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .donut-center span {
        font-size: 11px;
        color: var(--text-soft);
    }

    .donut-center strong {
        margin-top: 6px;
        font-size: 16px;
    }

    .legend {
        flex: 1;
    }

    .legend-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 0;
        font-size: 12px;
    }

    .legend-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #803E2F;
    }

    /* =========================
       CLASS INFORMATION
    ========================== */

    .class-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px 50px;
    }

    .info-item span {
        display: block;
        font-size: 12px;
        color: var(--text-soft);
    }

    .info-item strong {
        display: block;
        margin-top: 8px;
        font-size: 16px;
    }

    /* =========================
       RESPONSIVE
    ========================== */

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .topbar {
            flex-direction: column;
            gap: 20px;
        }

        .topbar-right {
            width: 100%;
        }

        .class-box {
            flex: 1;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .distribution-content {
            flex-direction: column;
        }

        .class-info {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
</style>


<div class="dashboard-page">

    {{-- =========================
         HEADER
    ========================== --}}

    <header class="topbar">

        <div class="welcome">

            <h2>
                Halo,
                {{ auth()->user()->name ?? 'Bendahara' }}!
            </h2>

            <p>
                Berikut adalah ringkasan keuangan kelas XI RPL 1.
            </p>

            <div class="welcome-line"></div>

        </div>


        <div class="topbar-right">

            <div class="class-box">

                <i class="fa-solid fa-users"></i>

                <div>

                    <span>Kelas</span>

                    <strong>XI RPL 1</strong>

                </div>

            </div>


            <div class="notification">

                <i class="fa-regular fa-bell"></i>

            </div>

        </div>

    </header>


    {{-- =========================
         STATISTICS
    ========================== --}}

    <section class="stats-grid">

        {{-- SALDO --}}

        <div class="stat-card primary">

            <div class="stat-icon">
                <i class="fa-solid fa-wallet"></i>
            </div>

            <div class="stat-label">
                Total Saldo Kas
            </div>

            <div class="stat-value">
                Rp
                {{ number_format(
                    $totalSaldo ?? 0,
                    0,
                    ',',
                    '.'
                ) }}
            </div>

            <div class="stat-growth">
                Saldo kas saat ini
            </div>

        </div>


        {{-- PEMASUKAN --}}

        <div class="stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-arrow-down income"></i>
            </div>

            <div class="stat-label">
                Total Pemasukan
            </div>

            <div class="stat-value">
                Rp
                {{ number_format(
                    $totalPemasukan ?? 0,
                    0,
                    ',',
                    '.'
                ) }}
            </div>

            <div class="stat-growth">
                Total kas masuk
            </div>

        </div>


        {{-- PENGELUARAN --}}

        <div class="stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-arrow-up expense"></i>
            </div>

            <div class="stat-label">
                Total Pengeluaran
            </div>

            <div class="stat-value">
                Rp
                {{ number_format(
                    $totalPengeluaran ?? 0,
                    0,
                    ',',
                    '.'
                ) }}
            </div>

            <div class="stat-growth negative">
                Total kas keluar
            </div>

        </div>


        {{-- SALDO BERSIH --}}

        <div class="stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-coins"></i>
            </div>

            <div class="stat-label">
                Saldo Bersih
            </div>

            <div class="stat-value">
                Rp
                {{ number_format(
                    $totalSaldo ?? 0,
                    0,
                    ',',
                    '.'
                ) }}
            </div>

            <div class="stat-growth">
                Pemasukan - Pengeluaran
            </div>

        </div>

    </section>


    {{-- =========================
         CONTENT GRID
    ========================== --}}

    <section class="dashboard-grid">


        {{-- LEFT COLUMN --}}

        <div class="left-column">

            <div class="panel">

                <h3 class="panel-title">
                    Distribusi Pengeluaran
                </h3>


                <div class="distribution-content">

                    <div class="donut">

                        <div class="donut-center">

                            <span>Total</span>

                            <strong>
                                Rp
                                {{ number_format(
                                    $totalPengeluaran ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>

                        </div>

                    </div>


                    <div class="legend">

                        @forelse(
                            $expenseByCategory ?? []
                            as $expense
                        )

                            <div class="legend-item">

                                <div class="legend-name">

                                    <span
                                        class="dot"
                                    ></span>

                                    {{ $expense->category ?? 'Lainnya' }}

                                </div>


                                <strong>
                                    Rp
                                    {{ number_format(
                                        $expense->total,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </strong>

                            </div>

                        @empty

                            <div class="legend-item">

                                <span
                                    style="color: var(--text-soft);"
                                >
                                    Belum ada data pengeluaran.
                                </span>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>


        {{-- RIGHT COLUMN --}}

        <div class="right-column">

            <div class="panel">

                <h3 class="panel-title">
                    Informasi Kelas
                </h3>


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
                            Periode Aktif
                        </span>

                        <strong>
                            Juli - Desember 2026
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection