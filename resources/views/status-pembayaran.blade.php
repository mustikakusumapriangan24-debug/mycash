@php
    $layout = auth()->user()->role === 'wali_kelas'
        ? 'layouts.wali-kelas'
        : 'layouts.bendahara';
@endphp

@extends($layout)

@section('content')

<style>
    .payment-status-page {
        --maroon: #803E2F;
        --maroon-dark: #54251F;
        --gold: #B59A63;
        --gold-light: #D8C7A8;
        --cream: #F1ECE4;
        --cream-light: #F8F4EE;
        --white: #FFFFFF;
        --text: #37332F;
        --text-soft: #817872;
        --border: #E1D9CF;
        --green: #5D876D;
        --green-soft: #EAF2EC;
        --red: #B9675C;
        --red-soft: #F6ECE9;
    }

    .payment-status-page {
        width: 100%;
        color: var(--text);
        font-family: "Plus Jakarta Sans", sans-serif;
    }

    /* TOPBAR */

    .payment-status-page .topbar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 26px;
    }

    .payment-status-page .welcome h2 {
        margin: 0;
        font-family: "Playfair Display", serif;
        color: var(--maroon-dark);
        font-size: 31px;
        line-height: 1.15;
    }

    .payment-status-page .welcome p {
        margin-top: 8px;
        color: var(--text-soft);
        font-size: 12px;
    }

    .payment-status-page .welcome-line {
        width: 48px;
        height: 3px;
        margin-top: 16px;
        border-radius: 20px;
        background: linear-gradient(90deg, var(--gold), var(--gold-light));
    }

    .payment-status-page .topbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .payment-status-page .back-report-button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 13px;
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--maroon-dark);
        background: white;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .payment-status-page .back-report-button:hover {
        background: var(--cream-light);
        border-color: var(--gold);
    }

    .payment-status-page .class-box {
        min-width: 190px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(181, 154, 99, 0.28);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.88);
        box-shadow: 0 5px 18px rgba(50, 35, 25, 0.045);
    }

    .payment-status-page .class-box > i {
        color: var(--maroon);
        font-size: 17px;
    }

    .payment-status-page .class-box span {
        display: block;
        color: var(--text-soft);
        font-size: 9px;
    }

    .payment-status-page .class-box strong {
        display: block;
        margin-top: 3px;
        color: var(--text);
        font-size: 12px;
    }

    .payment-status-page .notification {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(181, 154, 99, 0.28);
        border-radius: 12px;
        color: var(--maroon);
        background: rgba(255, 255, 255, 0.88);
        box-shadow: 0 5px 18px rgba(50, 35, 25, 0.045);
    }

    /* SUMMARY */

    .payment-status-page .payment-summary {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: center;
        gap: 25px;
        margin-bottom: 18px;
        padding: 22px 24px;
        border: 1px solid var(--border);
        border-radius: 16px;
        background: rgba(255, 254, 252, 0.96);
        box-shadow: 0 8px 24px rgba(45, 28, 20, 0.05);
    }

    .payment-status-page .summary-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .payment-status-page .summary-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        color: var(--maroon);
        background: rgba(128, 62, 47, 0.09);
        font-size: 20px;
    }

    .payment-status-page .summary-title h3 {
        margin: 0;
        font-family: "Playfair Display", serif;
        color: var(--maroon-dark);
        font-size: 20px;
    }

    .payment-status-page .summary-title p {
        margin-top: 4px;
        color: var(--text-soft);
        font-size: 10px;
    }

    /* FILTER */

    .payment-status-page .filter-form {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .payment-status-page .year-selector {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .payment-status-page .year-selector label {
        color: var(--text-soft);
        font-size: 10px;
        font-weight: 600;
    }

    .payment-status-page .year-selector select {
        min-width: 100px;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 9px;
        outline: none;
        color: var(--text);
        background: white;
        font-family: inherit;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }

    .payment-status-page .year-selector select:focus,
    .payment-status-page .search-input:focus {
        border-color: var(--gold);
    }

    .payment-status-page .search-box {
        position: relative;
        display: flex;
        align-items: center;
    }

    .payment-status-page .search-box i {
        position: absolute;
        left: 12px;
        color: var(--text-soft);
        font-size: 12px;
    }

    .payment-status-page .search-input {
        width: 210px;
        padding: 10px 12px 10px 34px;
        border: 1px solid var(--border);
        border-radius: 9px;
        outline: none;
        color: var(--text);
        background: white;
        font-family: inherit;
        font-size: 11px;
    }

    .payment-status-page .search-button {
        padding: 10px 14px;
        border: none;
        border-radius: 9px;
        color: white;
        background: var(--maroon);
        font-family: inherit;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .payment-status-page .search-button:hover {
        background: var(--maroon-dark);
    }

    .payment-status-page .reset-button {
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 9px;
        color: var(--text-soft);
        background: white;
        font-family: inherit;
        font-size: 10px;
        text-decoration: none;
    }

    /* FEE INFORMATION */

    .payment-status-page .fee-information {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-top: -3px;
        margin-bottom: 18px;
        padding: 10px 14px;
        border-radius: 9px;
        color: var(--maroon-dark);
        background: rgba(181, 154, 99, 0.08);
        font-size: 10px;
    }

    .payment-status-page .fee-information i {
        color: var(--gold);
    }

    .payment-status-page .fee-information strong {
        color: var(--maroon);
    }

    /* PANEL */

    .payment-status-page .panel {
        padding: 22px;
        border: 1px solid var(--border);
        border-radius: 16px;
        background: rgba(255, 254, 252, 0.97);
        box-shadow: 0 8px 24px rgba(45, 28, 20, 0.05);
    }

    .payment-status-page .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .payment-status-page .panel-header h3 {
        margin: 0;
        font-family: "Playfair Display", serif;
        color: var(--maroon-dark);
        font-size: 18px;
    }

    .payment-status-page .student-badge {
        padding: 7px 12px;
        border-radius: 20px;
        color: var(--maroon);
        background: rgba(128, 62, 47, 0.08);
        font-size: 9px;
        font-weight: 700;
    }

    /* TABLE */

    .payment-status-page .table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid var(--border);
        border-radius: 12px;
        scrollbar-width: thin;
    }

    .payment-status-page .payment-table {
        width: 100%;
        min-width: 1150px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .payment-status-page .payment-table thead th {
        padding: 13px 9px;
        color: var(--text-soft);
        background: #F5F0E9;
        border-bottom: 1px solid var(--border);
        font-size: 9px;
        font-weight: 700;
        text-align: center;
        white-space: nowrap;
    }

    .payment-status-page .payment-table thead th:first-child {
        width: 52px;
        border-top-left-radius: 11px;
    }

    .payment-status-page .payment-table thead th:nth-child(2) {
        min-width: 225px;
        text-align: left;
    }

    .payment-status-page .payment-table thead th:last-child {
        border-top-right-radius: 11px;
    }

    .payment-status-page .payment-table tbody td {
        padding: 12px 8px;
        color: var(--text);
        background: #FFFEFC;
        border-bottom: 1px solid #F0ECE7;
        font-size: 10px;
        text-align: center;
    }

    .payment-status-page .payment-table tbody tr:last-child td {
        border-bottom: none;
    }

    .payment-status-page .payment-table tbody tr:hover td {
        background: #FCF9F5;
    }

    .payment-status-page .number-cell {
        color: var(--text-soft) !important;
        font-weight: 600;
    }

    .payment-status-page .student-cell {
        text-align: left !important;
    }

    .payment-status-page .student-name {
        color: var(--text);
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .payment-status-page .student-subtitle {
        margin-top: 3px;
        color: var(--text-soft);
        font-size: 8px;
    }

    /* PAYMENT CELL */

    .payment-status-page .payment-cell {
        min-width: 60px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .payment-status-page .payment-checkbox {
        width: 18px;
        height: 18px;
        margin: 0;
        accent-color: var(--maroon);
        cursor: default;
    }

    .payment-status-page .payment-checkbox:disabled {
        opacity: 1;
    }

    .payment-status-page .payment-amount {
        font-size: 8px;
        white-space: nowrap;
    }

    .payment-status-page .payment-amount.paid {
        color: var(--green);
        font-weight: 700;
    }

    .payment-status-page .payment-amount.unpaid {
        color: var(--text-soft);
    }

    .payment-status-page .payment-total {
        color: var(--maroon) !important;
        font-size: 10px !important;
        font-weight: 700;
        white-space: nowrap;
    }

    /* EMPTY STATE */

    .payment-status-page .empty-payment {
        padding: 55px 20px !important;
        color: var(--text-soft) !important;
        text-align: center !important;
    }

    .payment-status-page .empty-payment i {
        display: block;
        margin-bottom: 12px;
        color: var(--gold);
        font-size: 26px;
    }

    .payment-status-page .empty-payment strong {
        display: block;
        margin-bottom: 4px;
        color: var(--text);
        font-size: 12px;
    }

    .payment-status-page .empty-payment span {
        font-size: 10px;
    }

    /* PAGINATION */

    .payment-status-page .pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 18px;
    }

    .payment-status-page .pagination-info {
        color: var(--text-soft);
        font-size: 10px;
    }

    .payment-status-page .pagination-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .payment-status-page .page-arrow {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        border-radius: 9px;
        color: var(--maroon);
        background: white;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .payment-status-page .page-arrow:hover {
        border-color: var(--gold);
        background: var(--cream-light);
    }

    .payment-status-page .page-arrow.disabled {
        color: #C9C1B8;
        background: #F7F4F0;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* NOTE */

    .payment-status-page .table-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 15px;
        padding-top: 14px;
        border-top: 1px solid var(--border);
        color: var(--text-soft);
        font-size: 9px;
        line-height: 1.5;
    }

    .payment-status-page .table-footer i {
        flex-shrink: 0;
        color: var(--gold);
    }

    /* RESPONSIVE */

    @media (max-width: 1000px) {
        .payment-status-page .payment-summary {
            grid-template-columns: 1fr;
        }

        .payment-status-page .filter-form {
            justify-content: flex-start;
        }
    }

    @media (max-width: 800px) {
        .payment-status-page .topbar {
            flex-direction: column;
            gap: 18px;
        }

        .payment-status-page .topbar-right {
            width: 100%;
        }

        .payment-status-page .class-box {
            flex: 1;
        }

        .payment-status-page .filter-form {
            align-items: stretch;
            flex-direction: column;
        }

        .payment-status-page .search-box,
        .payment-status-page .search-input {
            width: 100%;
        }

        .payment-status-page .year-selector {
            justify-content: flex-start;
        }

        .payment-status-page .pagination-wrapper {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>


<div class="payment-status-page">

    <!-- TOPBAR -->

    <header class="topbar">

        <div class="welcome">

            <h2>Status Pembayaran Kas</h2>

            <p>
                Pantau pembayaran iuran kas setiap siswa
                secara terstruktur dan mudah.
            </p>

            <div class="welcome-line"></div>

        </div>

        <div class="topbar-right">

            @if(auth()->user()->role === 'wali_kelas')
                <a href="{{ route('wali-kelas.kas') }}"
                    class="back-report-button">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali ke Laporan
                </a>
            @endif

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


    <!-- SUMMARY -->

    <section class="payment-summary">

        <div class="summary-title">

            <div class="summary-icon">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>

            <div>
                <h3>Pembayaran Iuran Kas</h3>

                <p>
                    Rekap pembayaran siswa berdasarkan bulan.
                </p>
            </div>

        </div>


        <!-- SEARCH AND YEAR FILTER -->

        <form
            method="GET"
            action="{{ url('/status-pembayaran') }}"
            class="filter-form"
        >

            <div class="search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Cari nama atau NIS siswa..."
                    value="{{ request('search') }}"
                >

            </div>

            <div class="year-selector">

                <label for="year">Tahun</label>

                <select
                    name="year"
                    id="year"
                    onchange="this.form.submit()"
                >

                    @for(
                        $year = now()->year;
                        $year >= now()->year - 5;
                        $year--
                    )

                        <option
                            value="{{ $year }}"
                            {{ (int)($selectedYear ?? now()->year) === $year ? 'selected' : '' }}
                        >
                            {{ $year }}
                        </option>

                    @endfor

                </select>

            </div>

            <button type="submit" class="search-button">
                Cari
            </button>

            @if(request('search'))
                <a
                    href="{{ url('/status-pembayaran') }}?year={{ $selectedYear ?? now()->year }}"
                    class="reset-button"
                >
                    Reset
                </a>
            @endif

        </form>

    </section>


    <!-- FEE INFORMATION -->

    <div class="fee-information">

        <i class="fa-solid fa-circle-info"></i>

        <span>
            Iuran wajib setiap siswa:

            <strong>
                @if($periodFee !== null)
                    Rp {{ number_format($periodFee, 0, ',', '.') }} per {{ $periodType === 'Mingguan' ? 'minggu' : 'bulan' }}
                @else
                    Belum ditentukan
                @endif
            </strong>
        </span>

    </div>


    <!-- TABLE -->

    <section class="panel">

        <div class="panel-header">

            <h3>Daftar Pembayaran Siswa</h3>

            <div class="student-badge">
                {{ $students->total() ?? collect($studentPayments ?? [])->count() }}
                Siswa
            </div>

        </div>


        <div class="table-wrapper">

            <table class="payment-table">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Nama Siswa</th>

                        @foreach(
                            $studentPayments->first()['periods'] ?? []
                            as $period
                        )

                            <th>
                                {{ $period['label'] }}
                            </th>

                        @endforeach

                        <th>Total</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($studentPayments ?? [] as $index => $data)

                        <tr>

                            <!-- NUMBER -->

                            <td class="number-cell">
                                {{ ($students->firstItem() ?? 1) + $index }}
                            </td>


                            <!-- STUDENT -->

                            <td class="student-cell">

                                <div class="student-name">
                                    {{ $data['student']->name }}
                                </div>

                                @if(!empty($data['student']->nis))

                                    <div class="student-subtitle">
                                        NIS: {{ $data['student']->nis }}
                                    </div>

                                @endif

                            </td>


                            <!-- MONTHS -->

                            @foreach($data['periods'] as $period)

                                <td>

                                    <div class="payment-cell">

                                        <input
                                            type="checkbox"
                                            class="payment-checkbox"
                                            {{ $period['paid'] ? 'checked' : '' }}
                                            disabled
                                        >

                                        <span class="payment-amount {{ $period['paid'] ? 'paid' : 'unpaid' }}">

                                            Rp {{ number_format($period['amount'], 0, ',', '.') }}

                                        </span>

                                    </div>

                                </td>

                            @endforeach


                            <!-- TOTAL -->

                            <td class="payment-total">

                                Rp {{ number_format($data['total'], 0, ',', '.') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="15" class="empty-payment">

                                <i class="fa-regular fa-folder-open"></i>

                                <strong>
                                    @if(request('search'))
                                        Siswa tidak ditemukan
                                    @else
                                        Belum ada data siswa
                                    @endif
                                </strong>

                                <span>
                                    @if(request('search'))
                                        Coba periksa kembali nama atau NIS yang kamu masukkan.
                                    @else
                                        Data pembayaran akan tampil setelah siswa ditambahkan.
                                    @endif
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- PAGINATION -->

        @if(isset($students) && $students->hasPages())

            <div class="pagination-wrapper">

                <div class="pagination-info">

                    Menampilkan
                    {{ $students->firstItem() }}
                    -
                    {{ $students->lastItem() }}
                    dari
                    {{ $students->total() }}
                    siswa

                </div>

                <div class="pagination-buttons">

                    @if($students->onFirstPage())

                        <span class="page-arrow disabled">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>

                    @else

                        <a
                            href="{{ $students->previousPageUrl() }}"
                            class="page-arrow"
                            aria-label="Halaman sebelumnya"
                        >
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>

                    @endif


                    @if($students->hasMorePages())

                        <a
                            href="{{ $students->nextPageUrl() }}"
                            class="page-arrow"
                            aria-label="Halaman berikutnya"
                        >
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>

                    @else

                        <span class="page-arrow disabled">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>

                    @endif

                </div>

            </div>

        @endif


        <!-- NOTE -->

        <div class="table-footer">

            <i class="fa-solid fa-circle-info"></i>

            <span>

                @if($periodFee !== null)
                    Checkbox akan tercentang otomatis apabila nominal pembayaran pada periode tersebut telah mencapai Rp
                    {{ number_format($periodFee, 0, ',', '.') }}.
                @else
                    Tarif kas belum ditentukan. Status pembayaran belum bisa ditandai lunas sampai tarif ditetapkan.
                @endif

            </span>

        </div>

    </section>

</div>

@endsection
