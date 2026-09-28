@php
    // Gunakan Bahasa Indonesia untuk Carbon
    \Carbon\Carbon::setLocale('id');

    $layout = auth()->user()->role === 'wali_kelas'
        ? 'layouts.wali-kelas'
        : 'layouts.bendahara';
@endphp

@extends($layout)

@section('content')

<style>
    .report-page {
        width: 100%;
    }

    /* =========================
       HEADER
    ========================= */
    .report-header {
        margin-bottom: 22px;
    }

    .report-header h1 {
        margin: 0;
        color: #803E2F;
        font-family: "Playfair Display", serif;
        font-size: 30px;
        font-weight: 600;
    }

    .report-header p {
        margin: 6px 0 0;
        color: #756E69;
        font-size: 12px;
    }

    /* =========================
       FILTER
    ========================= */
    .report-filter {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 20px;
        padding: 16px 20px;
        background: #FFFEFC;
        border: 1px solid #DED6CC;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(45, 28, 20, .04);
    }

    .filter-period {
        color: #756E69;
        font-size: 11px;
    }

    .filter-period strong {
        display: block;
        margin-top: 3px;
        color: #803E2F;
        font-family: "Playfair Display", serif;
        font-size: 18px;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-form label {
        color: #3E3D38;
        font-size: 11px;
        font-weight: 700;
    }

    .filter-form select,
    .filter-form input {
        height: 34px;
        padding: 0 9px;
        border: 1px solid #DED6CC;
        border-radius: 7px;
        background: #FFFFFF;
        color: #3E3D38;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 11px;
        outline: none;
    }

    .filter-form select {
        min-width: 120px;
    }

    .filter-form input {
        width: 70px;
        text-align: center;
    }

    .filter-form select:focus,
    .filter-form input:focus {
        border-color: #B59A63;
    }

    .filter-button {
        height: 34px;
        padding: 0 14px;
        border: 0;
        border-radius: 7px;
        background: #803E2F;
        color: #FFFFFF;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .filter-button:hover {
        background: #54251F;
    }

    /* =========================
       SUMMARY
    ========================= */
    .report-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .summary-card {
        padding: 18px;
        background: #FFFEFC;
        border: 1px solid #DED6CC;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(45, 28, 20, .04);
    }

    .summary-label {
        color: #756E69;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .summary-value {
        margin-top: 7px;
        color: #3E3D38;
        font-size: 20px;
        font-weight: 800;
    }

    .summary-card.saldo .summary-value {
        color: #803E2F;
    }

    .summary-card.income .summary-value {
        color: #56856C;
    }

    .summary-card.expense .summary-value {
        color: #A53636;
    }

    .summary-card.total .summary-value {
        color: #803E2F;
    }

    /* =========================
       REPORT CARD
    ========================= */
    .report-card {
        overflow: hidden;
        background: #FFFEFC;
        border: 1px solid #DED6CC;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(45, 28, 20, .04);
    }

    .report-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid #E8E0D7;
    }

    .report-card-header h2 {
        margin: 0;
        color: #803E2F;
        font-family: "Playfair Display", serif;
        font-size: 20px;
        font-weight: 600;
    }

    .report-card-header p {
        margin: 4px 0 0;
        color: #756E69;
        font-size: 10px;
    }

    .period-badge {
        padding: 6px 10px;
        border: 1px solid #DECFAE;
        border-radius: 20px;
        background: #FFFAF0;
        color: #876B25;
        font-size: 10px;
        font-weight: 700;
    }

    /* =========================
       TABLE
    ========================= */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        min-width: 760px;
        border-collapse: collapse;
    }

    .report-table th {
        padding: 12px;
        background: #803E2F;
        color: #FFFFFF;
        font-size: 10px;
        font-weight: 700;
        text-align: left;
    }

    .report-table th:first-child {
        width: 50px;
        text-align: center;
    }

    .report-table th:last-child {
        width: 65px;
        text-align: right;
    }

    .report-table td {
        padding: 13px 12px;
        border-bottom: 1px solid #F0EAE2;
        color: #3E3D38;
        font-size: 11px;
        vertical-align: middle;
    }

    .report-table tr:last-child td {
        border-bottom: 0;
    }

    .main-row.has-detail {
        cursor: pointer;
        transition: background .15s ease;
    }

    .main-row.has-detail:hover {
        background: #FCF9F4;
    }

    .number-cell {
        color: #8B817B;
        text-align: center;
    }

    .date-cell {
        color: #5F5753;
        font-weight: 600;
        white-space: nowrap;
        line-height: 1.5;
    }

    .date-cell small {
        color: #9A928D;
        font-size: 9px;
        font-weight: 500;
    }

    .category-cell {
        color: #403A37;
        font-weight: 700;
        white-space: nowrap;
    }

    .description-cell {
        max-width: 270px;
        color: #403A37;
        font-weight: 600;
    }

    .student-name-cell {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #403A37;
        font-weight: 700;
    }

    .student-name-cell i {
        color: #B59A63;
        font-size: 10px;
    }

    .normal-description {
        color: #756E69;
        font-weight: 500;
    }

    .type-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
    }

    .type-badge.in {
        background: #EAF5EF;
        color: #56856C;
    }

    .type-badge.out {
        background: #FAEDED;
        color: #A53636;
    }

    .amount-cell {
        font-weight: 800;
        text-align: right;
        white-space: nowrap;
    }

    .amount-cell.in {
        color: #56856C;
    }

    .amount-cell.out {
        color: #A53636;
    }

    /* =========================
       DETAIL BUTTON
    ========================= */
    .detail-button {
        width: 28px;
        height: 28px;
        border: 1px solid #DED6CC;
        border-radius: 7px;
        background: #FFFFFF;
        color: #803E2F;
        cursor: pointer;
        transition: .2s ease;
    }

    .detail-button:hover {
        background: #F7F0E8;
        border-color: #B59A63;
    }

    /* =========================
       DETAIL PEMBAYARAN
    ========================= */
    .payment-detail-row {
        display: none;
        background: #FBF8F3;
    }

    .payment-detail-row.show {
        display: table-row;
    }

    .payment-detail-row td {
        padding: 0 !important;
    }

    .payment-detail {
        padding: 15px 20px 17px 65px;
    }

    .payment-detail-title {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 10px;
        color: #803E2F;
        font-size: 10px;
        font-weight: 800;
    }

    .payment-detail-title i {
        color: #B59A63;
        font-size: 10px;
    }

    .payment-month-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .payment-month {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        min-height: 29px;
        padding: 5px 9px;
        border: 1px solid #E2D9CF;
        border-radius: 7px;
        background: #FFFFFF;
        color: #5F5753;
        font-size: 9px;
        font-weight: 600;
    }

    .payment-month.paid {
        border-color: #CFE5D8;
        background: #F0F8F3;
        color: #56856C;
    }

    .payment-month.unpaid {
        border-color: #EACACA;
        background: #FFF3F3;
        color: #A53636;
    }

    .payment-month i {
        font-size: 9px;
    }

    .payment-month.paid i {
        color: #56856C;
    }

    .payment-month.unpaid i {
        color: #A53636;
    }

    .payment-status {
        font-weight: 800;
    }

    .partial-amount {
        margin-left: 2px;
        font-weight: 700;
    }

    /* =========================
       EMPTY
    ========================= */
    .empty-report {
        padding: 45px 20px;
        text-align: center;
    }

    .empty-report i {
        margin-bottom: 10px;
        color: #B59A63;
        font-size: 27px;
    }

    .empty-report h3 {
        margin: 0;
        color: #803E2F;
        font-family: "Playfair Display", serif;
        font-size: 18px;
    }

    .empty-report p {
        margin-top: 5px;
        color: #8B817B;
        font-size: 10px;
    }

    .report-footer {
        margin-top: 12px;
        color: #9A928D;
        font-size: 9px;
        text-align: right;
    }

    /* =========================
       RESPONSIVE
    ========================= */
    @media (max-width: 1000px) {
        .report-summary {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 750px) {
        .report-filter {
            align-items: flex-start;
            flex-direction: column;
        }

        .filter-form {
            width: 100%;
            flex-wrap: wrap;
        }

        .report-card-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 10px;
        }

        .payment-detail {
            padding-left: 20px;
        }
    }

    @media (max-width: 550px) {
        .report-summary {
            grid-template-columns: 1fr;
        }

        .payment-month-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .payment-month {
            width: 100%;
        }
    }
</style>


<div class="report-page">

    {{-- HEADER --}}
    <div class="report-header">
        <h1>Laporan Kas</h1>

        <p>
            Ringkasan dan transaksi kas kelas.
        </p>
    </div>


    {{-- FILTER --}}
    <div class="report-filter">

        <div class="filter-period">
            Periode

            <strong>
                @if($selectedMonth === 'all')
                    Semua Bulan {{ $selectedYear }}
                @else
                    {{ \Carbon\Carbon::create(
                        $selectedYear,
                        (int) $selectedMonth,
                        1
                    )->translatedFormat('F Y') }}
                @endif
            </strong>
        </div>


        <form
            method="GET"
            action="{{ route('laporan.index') }}"
            class="filter-form"
        >

            <label for="month">
                Bulan
            </label>

            <select name="month" id="month">

                <option
                    value="all"
                    {{ $selectedMonth === 'all' ? 'selected' : '' }}
                >
                    Semua Bulan
                </option>

                @foreach([
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ] as $number => $name)

                    <option
                        value="{{ $number }}"
                        {{ (string) $selectedMonth === (string) $number ? 'selected' : '' }}
                    >
                        {{ $name }}
                    </option>

                @endforeach

            </select>


            <label for="year">
                Tahun
            </label>

            <input
                type="number"
                name="year"
                id="year"
                min="2020"
                max="2100"
                value="{{ $selectedYear }}"
            >


            <button
                type="submit"
                class="filter-button"
            >
                Tampilkan
            </button>

        </form>

    </div>


    {{-- RINGKASAN --}}
    <div class="report-summary">

        <div class="summary-card saldo">
            <div class="summary-label">
                Saldo
            </div>

            <div class="summary-value">
                Rp{{ number_format($totalSaldo, 0, ',', '.') }}
            </div>
        </div>


        <div class="summary-card income">
            <div class="summary-label">
                Pemasukan
            </div>

            <div class="summary-value">
                Rp{{ number_format($totalPemasukan, 0, ',', '.') }}
            </div>
        </div>


        <div class="summary-card expense">
            <div class="summary-label">
                Pengeluaran
            </div>

            <div class="summary-value">
                Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}
            </div>
        </div>


        <div class="summary-card total">
            <div class="summary-label">
                Transaksi
            </div>

            <div class="summary-value">
                {{ number_format($totalTransaksi, 0, ',', '.') }}
            </div>
        </div>

    </div>


    {{-- RIWAYAT TRANSAKSI --}}
    <div class="report-card">

        <div class="report-card-header">

            <div>
                <h2>
                    Riwayat Transaksi
                </h2>

                <p>
                    Daftar transaksi pada periode yang dipilih.
                </p>
            </div>


            <div class="period-badge">

                @if($selectedMonth === 'all')
                    {{ $selectedYear }}
                @else
                    {{ \Carbon\Carbon::create(
                        $selectedYear,
                        (int) $selectedMonth,
                        1
                    )->translatedFormat('F Y') }}
                @endif

            </div>

        </div>


        @if($transactions->isNotEmpty())

            <div class="table-wrapper">

                <table class="report-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Detail</th>
                        </tr>
                    </thead>


                    <tbody>

                        @foreach($transactions as $index => $transaction)

                            @php

                                $details = $paymentDetails->get(
                                    $transaction->id,
                                    collect()
                                );

                                $hasDetail = $details->isNotEmpty();


                                /*
                                 * Untuk Kas Siswa,
                                 * Keterangan = nama lengkap siswa.
                                 */
                                $studentNames = $details
                                    ->map(function ($payment) use ($students) {

                                        $student = $students->get(
                                            $payment->student_id
                                        );

                                        return $student
                                            ? $student->name
                                            : null;
                                    })
                                    ->filter()
                                    ->unique()
                                    ->values();

                            @endphp


                            {{-- TRANSAKSI UTAMA --}}
                            <tr
                                class="main-row {{ $hasDetail ? 'has-detail' : '' }}"

                                @if($hasDetail)
                                    onclick="togglePaymentDetail({{ $transaction->id }})"
                                @endif
                            >

                                <td class="number-cell">
                                    {{ $index + 1 }}
                                </td>


                                <td class="date-cell">

                                    {{ $transaction->created_at->format('d/m/Y') }}

                                    <br>

                                    <small>
                                        {{ $transaction->created_at->format('H:i') }}
                                    </small>

                                </td>


                                <td class="category-cell">
                                    {{ $transaction->category ?? 'Transaksi Kas' }}
                                </td>


                                <td class="description-cell">

                                    @if(
                                        $transaction->category === 'Kas Siswa'
                                        && $studentNames->isNotEmpty()
                                    )

                                        <span class="student-name-cell">

                                            <i class="fa-solid fa-user"></i>

                                            {{ $studentNames->implode(', ') }}

                                        </span>

                                    @else

                                        <span class="normal-description">
                                            {{ $transaction->description ?? 'Tidak ada keterangan' }}
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    @if($transaction->type === 'in')

                                        <span class="type-badge in">
                                            Pemasukan
                                        </span>

                                    @else

                                        <span class="type-badge out">
                                            Pengeluaran
                                        </span>

                                    @endif

                                </td>


                                <td class="amount-cell {{ $transaction->type }}">

                                    {{ $transaction->type === 'in' ? '+' : '-' }}

                                    Rp{{ number_format(
                                        $transaction->amount,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>


                                <td style="text-align:right;">

                                    @if($hasDetail)

                                        <button
                                            type="button"
                                            class="detail-button"

                                            onclick="event.stopPropagation(); togglePaymentDetail({{ $transaction->id }})"

                                            title="Lihat detail pembayaran"
                                        >

                                            <i
                                                id="detail-icon-{{ $transaction->id }}"
                                                class="fa-solid fa-chevron-down"
                                            ></i>

                                        </button>

                                    @else

                                        <span style="color:#C0B8B1;">
                                            —
                                        </span>

                                    @endif

                                </td>

                            </tr>


                            {{-- DETAIL --}}
                            @if($hasDetail)

                                <tr
                                    id="payment-detail-{{ $transaction->id }}"
                                    class="payment-detail-row"
                                >

                                    <td colspan="7">

                                        <div class="payment-detail">

                                            <div class="payment-detail-title">

                                                <i class="fa-solid fa-calendar-days"></i>

                                                Detail Pembayaran

                                            </div>


                                            @php
                                                $studentDetails = $details
                                                    ->groupBy('student_id');
                                            @endphp


                                            @foreach(
                                                $studentDetails
                                                as $studentId => $studentPayments
                                            )

                                                @php

                                                    $monthStatus = [];

                                                    foreach (
                                                        $studentPayments
                                                            ->groupBy(function ($payment) {

                                                                return \Carbon\Carbon::parse(
                                                                    $payment->payment_month
                                                                )->format('Y-m');

                                                            })
                                                        as $month => $monthPayments
                                                    ) {

                                                        $monthAmount =
                                                            $monthPayments->sum('amount');

                                                        $monthLabel =
                                                            \Carbon\Carbon::createFromFormat(
                                                                'Y-m',
                                                                $month
                                                            )->translatedFormat('F');

                                                        $monthStatus[] = [
                                                            'label' => $monthLabel,
                                                            'amount' => $monthAmount,
                                                            'paid' => $monthAmount >= 10000,
                                                        ];
                                                    }

                                                @endphp


                                                <div class="payment-month-list">

                                                    @foreach($monthStatus as $status)

                                                        @if($status['paid'])

                                                            <div class="payment-month paid">

                                                                <i class="fa-solid fa-circle-check"></i>

                                                                <span>
                                                                    {{ $status['label'] }}
                                                                </span>

                                                                <span class="payment-status">
                                                                    Lunas
                                                                </span>

                                                            </div>

                                                        @else

                                                            <div class="payment-month unpaid">

                                                                <i class="fa-solid fa-circle-exclamation"></i>

                                                                <span>
                                                                    {{ $status['label'] }}
                                                                </span>

                                                                <span class="payment-status">
                                                                    Belum Lunas
                                                                </span>

                                                                <span class="partial-amount">
                                                                    Rp{{ number_format(
                                                                        $status['amount'],
                                                                        0,
                                                                        ',',
                                                                        '.'
                                                                    ) }}/10.000
                                                                </span>

                                                            </div>

                                                        @endif

                                                    @endforeach

                                                </div>

                                            @endforeach

                                        </div>

                                    </td>

                                </tr>

                            @endif

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-report">

                <i class="fa-regular fa-folder-open"></i>

                <h3>
                    Belum Ada Transaksi
                </h3>

                <p>
                    Belum ada transaksi pada periode ini.
                </p>

            </div>

        @endif

    </div>


    <div class="report-footer">
        Laporan MyCash • {{ $selectedYear }}
    </div>

</div>


<script>
    function togglePaymentDetail(transactionId) {

        const detailRow = document.getElementById(
            'payment-detail-' + transactionId
        );

        if (!detailRow) {
            return;
        }

        const isShown =
            detailRow.classList.contains('show');


        /*
         * Tutup detail lainnya.
         */
        document
            .querySelectorAll('.payment-detail-row.show')
            .forEach(function (row) {

                row.classList.remove('show');

            });


        /*
         * Reset semua icon.
         */
        document
            .querySelectorAll('.detail-button i')
            .forEach(function (icon) {

                icon.className =
                    'fa-solid fa-chevron-down';

            });


        /*
         * Buka detail yang dipilih.
         */
        if (!isShown) {

            detailRow.classList.add('show');

            const icon =
                document.getElementById(
                    'detail-icon-' + transactionId
                );

            if (icon) {

                icon.className =
                    'fa-solid fa-chevron-up';

            }
        }
    }
</script>

@endsection