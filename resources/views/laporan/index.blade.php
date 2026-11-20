@extends(
    auth()->user()->role === 'wali_kelas'
        ? 'layouts.wali-kelas'
        : 'layouts.bendahara'
)

@php
    \Carbon\Carbon::setLocale('id');

    $startDate = $startDate ?? '';
    $endDate = $endDate ?? '';
    $type = $type ?? 'all';
    $category = $category ?? 'all';

    $transactions = $transactions ?? collect();
    $students = $students ?? collect();
    $paymentDetails = $paymentDetails ?? collect();
    $weeklyPaymentDetails = $weeklyPaymentDetails ?? collect();
    $categories = $categories ?? collect();

    $totalSaldo = $totalSaldo ?? 0;
    $totalPemasukan = $totalPemasukan ?? 0;
    $totalPengeluaran = $totalPengeluaran ?? 0;
    $totalTransaksi = $totalTransaksi ?? 0;
@endphp

@section('content')

<style>
    .report-page { width: 100%; }

    .report-header { margin-bottom: 22px; }

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
        flex-wrap: wrap;
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

    .filter-form select { min-width: 120px; }

    .filter-form input {
        width: 140px;
        text-align: center;
    }

    .filter-form select:focus,
    .filter-form input:focus {
        border-color: #B59A63;
    }

    .filter-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 34px;
        padding: 0 14px;
        border: 0;
        border-radius: 7px;
        background: #803E2F;
        color: #FFFFFF;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: .2s ease;
    }

    .filter-button:hover { background: #54251F; }

    .report-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
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
        overflow-wrap: anywhere;
    }

    .summary-card.saldo .summary-value,
    .summary-card.total .summary-value { color: #803E2F; }

    .summary-card.income .summary-value { color: #56856C; }
    .summary-card.expense .summary-value { color: #A53636; }

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
        gap: 16px;
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

    .report-export-buttons {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 8px;
    }

    .report-export-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 35px;
        padding: 0 13px;
        border-radius: 7px;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: .2s ease;
    }

    .report-export-button.pdf {
        background: #803E2F;
        border: 1px solid #803E2F;
        color: #FFFFFF;
    }

    .report-export-button.pdf:hover {
        background: #54251F;
        border-color: #54251F;
    }

    .report-export-button.excel {
        background: #EAF5EF;
        border: 1px solid #CFE5D8;
        color: #56856C;
    }

    .report-export-button.excel:hover { background: #D9EDE1; }

    .period-badge {
        padding: 6px 10px;
        border: 1px solid #DECFAE;
        border-radius: 20px;
        background: #FFFAF0;
        color: #876B25;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .table-wrapper { width: 100%; overflow-x: auto; }

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

    .report-table tr:last-child td { border-bottom: 0; }

    .main-row.has-detail {
        cursor: pointer;
        transition: background .15s ease;
    }

    .main-row.has-detail:hover { background: #FCF9F4; }

    .number-cell { color: #8B817B; text-align: center; }

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
        overflow-wrap: anywhere;
    }

    .type-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
    }

    .type-badge.in { background: #EAF5EF; color: #56856C; }
    .type-badge.out { background: #FAEDED; color: #A53636; }

    .amount-cell {
        font-weight: 800;
        text-align: right;
        white-space: nowrap;
    }

    .amount-cell.in { color: #56856C; }
    .amount-cell.out { color: #A53636; }

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

    .payment-detail-row {
        display: none;
        background: #FBF8F3;
    }

    .payment-detail-row.show { display: table-row; }
    .payment-detail-row td { padding: 0 !important; }

    .payment-detail { padding: 15px 20px 17px 65px; }

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
        margin-bottom: 12px;
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

    .payment-month i { font-size: 9px; }
    .payment-month.paid i { color: #56856C; }
    .payment-month.unpaid i { color: #A53636; }

    .payment-status { font-weight: 800; }
    .partial-amount { margin-left: 2px; font-weight: 700; }

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

    @media (max-width: 1000px) {
        .report-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 750px) {
        .report-filter {
            align-items: flex-start;
            flex-direction: column;
        }

        .filter-form { width: 100%; flex-wrap: wrap; }

        .report-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .report-export-buttons { justify-content: flex-start; }
        .payment-detail { padding-left: 20px; }
    }

    @media (max-width: 550px) {
        .report-summary { grid-template-columns: 1fr; }

        .payment-month-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .payment-month { width: 100%; flex-wrap: wrap; }
    }
</style>

<div class="report-page">

    {{-- HEADER --}}
    <div class="report-header">
        <h1>Laporan Kas</h1>
        <p>Ringkasan dan transaksi kas kelas.</p>
    </div>

    {{-- FILTER --}}
    <div class="report-filter">

        <div class="filter-period">
            Periode

            <strong>
                @if($startDate || $endDate)
                    {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Awal' }}
                    -
                    {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Sekarang' }}
                @else
                    Semua Tanggal
                @endif
            </strong>
        </div>

        <form method="GET" action="{{ route('laporan.index') }}" class="filter-form">

            <label for="start_date">Dari</label>
            <input
                type="date"
                name="start_date"
                id="start_date"
                value="{{ $startDate }}"
            >

            <label for="end_date">Sampai</label>
            <input
                type="date"
                name="end_date"
                id="end_date"
                value="{{ $endDate }}"
            >

            <label for="type">Jenis</label>
            <select name="type" id="type">
                <option value="all" {{ $type === 'all' ? 'selected' : '' }}>
                    Semua Jenis
                </option>
                <option value="in" {{ $type === 'in' ? 'selected' : '' }}>
                    Pemasukan
                </option>
                <option value="out" {{ $type === 'out' ? 'selected' : '' }}>
                    Pengeluaran
                </option>
            </select>

            <label for="category">Kategori</label>
            <select name="category" id="category">
                <option value="all" {{ $category === 'all' ? 'selected' : '' }}>
                    Semua Kategori
                </option>

                @foreach($categories as $item)
                    <option
                        value="{{ $item }}"
                        {{ $category === $item ? 'selected' : '' }}
                    >
                        {{ $item }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="filter-button">
                Filter
            </button>

            <a
                href="{{ route('laporan.index') }}"
                class="filter-button"
                style="background:#756E69;"
            >
                Reset
            </a>

        </form>
    </div>

    {{-- RINGKASAN --}}
    <div class="report-summary">

        <div class="summary-card saldo">
            <div class="summary-label">Saldo</div>
            <div class="summary-value">
                Rp{{ number_format($totalSaldo, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-card income">
            <div class="summary-label">Pemasukan</div>
            <div class="summary-value">
                Rp{{ number_format($totalPemasukan, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-card expense">
            <div class="summary-label">Pengeluaran</div>
            <div class="summary-value">
                Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-card total">
            <div class="summary-label">Transaksi</div>
            <div class="summary-value">
                {{ number_format($totalTransaksi, 0, ',', '.') }}
            </div>
        </div>

    </div>

    {{-- RIWAYAT TRANSAKSI --}}
    <div class="report-card">

        <div class="report-card-header">
            <div>
                <h2>Riwayat Transaksi</h2>
                <p>Daftar transaksi berdasarkan filter yang dipilih.</p>
            </div>

            {{-- TOMBOL EKSPOR --}}
            <div class="report-export-buttons">

                <a
                    href="{{ route('laporan.export.pdf', request()->query()) }}"
                    class="report-export-button pdf"
                >
                    <i class="fa-solid fa-file-pdf"></i>
                    Unduh PDF
                </a>

                <a
                    href="{{ route('laporan.export.excel', request()->query()) }}"
                    class="report-export-button excel"
                >
                    <i class="fa-solid fa-file-excel"></i>
                    Unduh Excel
                </a>

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
                                $weeklyDetails = $weeklyPaymentDetails->get(
                                    $transaction->id,
                                    collect()
                                );

                                $hasDetail = $details->isNotEmpty()
                                    || $weeklyDetails->isNotEmpty();

                                $studentNames = $details
                                    ->map(function ($payment) use ($students) {
                                        $student = $students->get($payment->student_id);

                                        return $student ? $student->name : null;
                                    })
                                    ->merge($weeklyDetails->map(function ($payment) use ($students) {
                                        $student = $students->get($payment->student_id);

                                        return $student ? $student->name : null;
                                    }))
                                    ->filter()
                                    ->unique()
                                    ->values();
                                $periodFee = $transaction->bendahara?->kelas?->nominal_standar;

                                $transactionDate = $transaction->created_at
                                    ? \Carbon\Carbon::parse($transaction->created_at)
                                    : null;
                            @endphp

                            {{-- TRANSAKSI UTAMA --}}
                            <tr
                                class="main-row {{ $hasDetail ? 'has-detail' : '' }}"
                                @if($hasDetail)
                                    data-transaction-id="{{ $transaction->id }}"
                                @endif
                            >
                                <td class="number-cell">
                                    {{ $index + 1 }}
                                </td>

                                <td class="date-cell">
                                    @if($transactionDate)
                                        {{ $transactionDate->format('d/m/Y') }}
                                        <br>
                                        <small>
                                            {{ $transactionDate->format('H:i') }}
                                        </small>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="category-cell">
                                    {{ $transaction->category ?? 'Transaksi Kas' }}
                                </td>

                                <td class="description-cell">
                                    @if(
                                        ($transaction->category ?? '') === 'Kas Siswa'
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
                                        <span class="type-badge in">Pemasukan</span>
                                    @else
                                        <span class="type-badge out">Pengeluaran</span>
                                    @endif
                                </td>

                                <td class="amount-cell {{ $transaction->type === 'in' ? 'in' : 'out' }}">
                                    {{ $transaction->type === 'in' ? '+' : '-' }}Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>

                                <td style="text-align:right;">
                                    @if($hasDetail)
                                        <button
                                            type="button"
                                            class="detail-button"
                                            data-detail-button="{{ $transaction->id }}"
                                            aria-expanded="false"
                                            aria-label="Lihat detail pembayaran"
                                            title="Lihat detail pembayaran"
                                        >
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </button>
                                    @else
                                        <span style="color:#C0B8B1;">—</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- DETAIL PEMBAYARAN --}}
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
                                                $studentDetails = $details->groupBy('student_id');
                                            @endphp

                                            @foreach($studentDetails as $studentId => $studentPayments)

                                                @php
                                                    $paymentsByMonth = $studentPayments
                                                        ->filter(function ($payment) {
                                                            return !empty($payment->payment_month);
                                                        })
                                                        ->groupBy(function ($payment) {
                                                            return \Carbon\Carbon::parse(
                                                                $payment->payment_month
                                                            )->format('Y-m');
                                                        });
                                                @endphp

                                                @if($paymentsByMonth->isNotEmpty())

                                                    <div class="payment-month-list">

                                                        @foreach($paymentsByMonth as $month => $monthPayments)

                                                            @php
                                                                $monthAmount = $monthPayments->sum('amount');

                                                                $monthLabel = \Carbon\Carbon::parse(
                                                                    $month . '-01'
                                                                )->translatedFormat('F');

                                                                $isPaid = $periodFee !== null
                                                                    && $monthAmount >= (float) $periodFee;
                                                            @endphp

                                                            @if($isPaid)
                                                                <div class="payment-month paid">
                                                                    <i class="fa-solid fa-circle-check"></i>
                                                                    <span>{{ $monthLabel }}</span>
                                                                    <span class="payment-status">Lunas</span>
                                                                </div>
                                                            @else
                                                                <div class="payment-month unpaid">
                                                                    <i class="fa-solid fa-circle-exclamation"></i>
                                                                    <span>{{ $monthLabel }}</span>
                                                                    <span class="payment-status">Belum Lunas</span>
                                                                    <span class="partial-amount">
                                                                        @if($periodFee !== null)
                                                                            Rp{{ number_format($monthAmount, 0, ',', '.') }}/{{ number_format((float) $periodFee, 0, ',', '.') }}
                                                                        @else
                                                                            Tarif belum ditentukan
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            @endif

                                                        @endforeach

                                                        @php
                                                            $weeklyStudentDetails = $weeklyDetails->groupBy('student_id');
                                                        @endphp
                                                        @foreach($weeklyStudentDetails as $studentId => $studentWeeks)
                                                            <div class="payment-month-list">
                                                                @foreach($studentWeeks as $weeklyPayment)
                                                                    @php
                                                                        $isWeekPaid = $periodFee !== null
                                                                            && (float) $weeklyPayment->amount >= (float) $periodFee;
                                                                    @endphp
                                                                    <div class="payment-month {{ $isWeekPaid ? 'paid' : 'unpaid' }}">
                                                                        <i class="fa-solid {{ $isWeekPaid ? 'fa-circle-check' : 'fa-circle-exclamation' }}"></i>
                                                                        <span>M{{ $weeklyPayment->week_number }} · {{ $weeklyPayment->school_year }}</span>
                                                                        <span class="payment-status">{{ $isWeekPaid ? 'Lunas' : 'Belum Lunas' }}</span>
                                                                        @unless($isWeekPaid)
                                                                            <span class="partial-amount">
                                                                                @if($periodFee !== null)
                                                                                    Rp{{ number_format((float) $weeklyPayment->amount, 0, ',', '.') }}/{{ number_format((float) $periodFee, 0, ',', '.') }}
                                                                                @else
                                                                                    Tarif belum ditentukan
                                                                                @endif
                                                                            </span>
                                                                        @endunless
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                @else
                                                    <p class="normal-description">
                                                        Belum ada detail bulan pembayaran.
                                                    </p>
                                                @endif

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
                <h3>Belum Ada Transaksi</h3>
                <p>Belum ada transaksi yang sesuai dengan filter ini.</p>
            </div>

        @endif

    </div>

    <div class="report-footer">
        Laporan MyCash • {{ now()->format('Y') }}
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailButtons = document.querySelectorAll('[data-detail-button]');

        function closeAllDetails() {
            document.querySelectorAll('.payment-detail-row.show').forEach(function (row) {
                row.classList.remove('show');
            });

            document.querySelectorAll('[data-detail-button]').forEach(function (button) {
                button.setAttribute('aria-expanded', 'false');

                const icon = button.querySelector('i');

                if (icon) {
                    icon.className = 'fa-solid fa-chevron-down';
                }
            });
        }

        function togglePaymentDetail(transactionId) {
            const detailRow = document.getElementById(
                'payment-detail-' + transactionId
            );

            const button = document.querySelector(
                '[data-detail-button="' + transactionId + '"]'
            );

            if (!detailRow || !button) {
                return;
            }

            const wasOpen = detailRow.classList.contains('show');

            closeAllDetails();

            if (!wasOpen) {
                detailRow.classList.add('show');
                button.setAttribute('aria-expanded', 'true');

                const icon = button.querySelector('i');

                if (icon) {
                    icon.className = 'fa-solid fa-chevron-up';
                }
            }
        }

        detailButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.stopPropagation();

                togglePaymentDetail(
                    button.getAttribute('data-detail-button')
                );
            });
        });

        document.querySelectorAll('.main-row.has-detail').forEach(function (row) {
            row.addEventListener('click', function () {
                togglePaymentDetail(
                    row.getAttribute('data-transaction-id')
                );
            });
        });
    });
</script>

@endsection
