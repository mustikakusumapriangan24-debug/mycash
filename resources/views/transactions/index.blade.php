@php
    $layout = auth()->user()->role === 'wali_kelas'
        ? 'layouts.wali-kelas'
        : 'layouts.bendahara';
@endphp

@extends($layout)

@section('content')

<style>
    /* =========================================================
       MYCASH - TRANSAKSI
       Mengikuti visual Dashboard & Status Pembayaran
    ========================================================= */

    .transactions-page {
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
        --border-gold: rgba(181,154,99,.38);
        --green: #56856c;
        --red: #a65353;

        width: 100%;
        color: var(--text);
    }

    .transactions-page *,
    .transactions-page *::before,
    .transactions-page *::after {
        box-sizing: border-box;
    }

    .transactions-page button,
    .transactions-page input,
    .transactions-page select,
    .transactions-page textarea {
        font-family: "Plus Jakarta Sans", sans-serif;
    }

    /* =========================================================
       TOP HEADER
    ========================================================= */

    .transactions-page .page-header {
        margin-bottom: 28px;
    }

    .transactions-page .page-header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .transactions-page .page-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 31px;
        font-weight: 700;
        letter-spacing: -.4px;
        line-height: 1.2;
    }

    .transactions-page .page-subtitle {
        margin: 8px 0 0;
        color: var(--text-soft);
        font-size: 13px;
        line-height: 1.6;
    }

    .transactions-page .gold-line {
        width: 42px;
        height: 3px;
        margin-top: 15px;
        border-radius: 10px;
        background: var(--gold);
    }

    .transactions-page .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .transactions-page .class-info {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 175px;
        padding: 11px 16px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: 0 5px 18px rgba(31,29,32,.04);
    }

    .transactions-page .class-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #f4eee5;
        color: var(--maroon);
    }

    .transactions-page .class-label {
        display: block;
        margin-bottom: 2px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .transactions-page .class-name {
        color: var(--maroon-deep);
        font-size: 12px;
        font-weight: 800;
    }

    .transactions-page .notification-button {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--white);
        color: var(--maroon);
        cursor: pointer;
        box-shadow: 0 5px 18px rgba(31,29,32,.04);
    }

    /* =========================================================
       ACTION BUTTON
    ========================================================= */

    .transactions-page .add-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 22px;
        padding: 11px 17px;
        border: 1px solid var(--maroon);
        border-radius: 11px;
        background: var(--maroon);
        color: #fff;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 7px 18px rgba(128,62,47,.16);
        transition: .2s ease;
    }

    .transactions-page .add-button:hover {
        background: var(--maroon-dark);
        transform: translateY(-1px);
    }

    /* =========================================================
       ALERT
    ========================================================= */

    .transactions-page .alert {
        margin-bottom: 18px;
        padding: 13px 16px;
        border-radius: 11px;
        font-size: 12px;
    }

    .transactions-page .alert-success {
        color: #3f6d55;
        background: #edf4ef;
        border: 1px solid #d2e3d7;
    }

    .transactions-page .alert-error {
        color: #934c4c;
        background: #faf0ef;
        border: 1px solid #ead3d0;
    }

    .transactions-page .alert-error ul {
        margin: 0;
        padding-left: 18px;
    }

    /* =========================================================
       SUMMARY
    ========================================================= */

    .transactions-page .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }

    .transactions-page .summary-card {
        min-height: 132px;
        padding: 21px 22px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 7px 22px rgba(31,29,32,.045);
    }

    .transactions-page .summary-card:first-child {
        background: linear-gradient(
            145deg,
            #6d3529,
            #54251F
        );
        border-color: transparent;
        color: #fff;
    }

    .transactions-page .summary-label {
        margin-bottom: 10px;
        color: var(--text-soft);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .transactions-page .summary-card:first-child .summary-label {
        color: rgba(255,255,255,.8);
    }

    .transactions-page .summary-value {
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 25px;
        font-weight: 700;
    }

    .transactions-page .summary-card:first-child .summary-value {
        color: #fff;
    }

    .transactions-page .summary-income .summary-value {
        color: var(--green);
    }

    .transactions-page .summary-expense .summary-value {
        color: var(--red);
    }

    .transactions-page .summary-note {
        margin-top: 8px;
        color: var(--text-soft);
        font-size: 10px;
    }

    .transactions-page .summary-card:first-child .summary-note {
        color: rgba(255,255,255,.72);
    }

    /* =========================================================
       HISTORY CARD
    ========================================================= */

    .transactions-page .history-card {
        overflow: hidden;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: 0 9px 28px rgba(31,29,32,.05);
    }

    .transactions-page .history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 23px 26px;
        border-bottom: 1px solid var(--border);
    }

    .transactions-page .history-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 20px;
        font-weight: 700;
    }

    .transactions-page .history-description {
        margin: 5px 0 0;
        color: var(--text-soft);
        font-size: 11px;
    }

    .transactions-page .history-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 29px;
        padding: 0 10px;
        border-radius: 9px;
        background: #f4eee5;
        border: 1px solid #e4d9c8;
        color: var(--maroon);
        font-size: 10px;
        font-weight: 800;
    }

    /* =========================================================
       TABLE
    ========================================================= */

    .transactions-page .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .transactions-page .transaction-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
    }

    .transactions-page .transaction-table th {
        padding: 13px 17px;
        background: #f7f3ed;
        color: var(--text-soft);
        border-bottom: 1px solid var(--border);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .35px;
        text-align: left;
        white-space: nowrap;
    }

    .transactions-page .transaction-table td {
        padding: 14px 17px;
        border-bottom: 1px solid #eee9e2;
        color: var(--text);
        font-size: 11px;
        vertical-align: middle;
    }

    .transactions-page .transaction-table tbody tr {
        transition: .15s ease;
    }

    .transactions-page .transaction-table tbody tr:hover {
        background: #fbf8f4;
    }

    .transactions-page .transaction-table tbody tr:last-child td {
        border-bottom: none;
    }

    .transactions-page .date-main {
        color: var(--text);
        font-size: 11px;
        font-weight: 700;
    }

    .transactions-page .date-time {
        margin-top: 3px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .transactions-page .transaction-description {
        max-width: 260px;
        color: var(--text);
        font-size: 11px;
        font-weight: 600;
        line-height: 1.5;
    }

    .transactions-page .transaction-description.empty {
        color: var(--text-soft);
        font-weight: 400;
    }

    .transactions-page .category-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 8px;
        border-radius: 7px;
        background: #f6f1e9;
        border: 1px solid #e5dac9;
        color: var(--maroon);
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .transactions-page .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 8px;
        border-radius: 7px;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .transactions-page .type-income {
        color: var(--green);
        background: #edf4ef;
        border: 1px solid #d4e4d9;
    }

    .transactions-page .type-expense {
        color: var(--red);
        background: #faf0ef;
        border: 1px solid #ead5d1;
    }

    .transactions-page .amount {
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .transactions-page .amount-income {
        color: var(--green);
    }

    .transactions-page .amount-expense {
        color: var(--red);
    }

    /* =========================================================
       ACTION
    ========================================================= */

    .transactions-page .action-group {
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .transactions-page .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 9px;
        border-radius: 7px;
        font-size: 9px;
        font-weight: 800;
        cursor: pointer;
        transition: .2s ease;
    }

    .transactions-page .edit-button {
        background: #f6f1e9;
        border: 1px solid #e5dac9;
        color: var(--maroon);
    }

    .transactions-page .edit-button:hover {
        background: #eee5d8;
    }

    .transactions-page .delete-button {
        background: #faf0ef;
        border: 1px solid #ead5d1;
        color: var(--red);
    }

    .transactions-page .delete-button:hover {
        background: #f4e2df;
    }

    /* =========================================================
       EMPTY
    ========================================================= */

    .transactions-page .empty-state {
        padding: 60px 25px;
        text-align: center;
    }

    .transactions-page .empty-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        border-radius: 15px;
        background: #f6f1e9;
        border: 1px solid #e5dac9;
        color: var(--maroon);
        font-size: 22px;
    }

    .transactions-page .empty-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 17px;
    }

    .transactions-page .empty-description {
        margin: 7px 0 0;
        color: var(--text-soft);
        font-size: 11px;
    }

    /* =========================================================
       MODAL
    ========================================================= */

    .transactions-modal {
        position: fixed;
        inset: 0;
        z-index: 5000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(31,29,32,.48);
        backdrop-filter: blur(4px);
    }

    .transactions-modal.show {
        display: flex;
    }

    .transactions-modal .modal {
        width: 100%;
        max-width: 610px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: 0 25px 70px rgba(31,29,32,.2);
    }

    .transactions-modal .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 25px 18px;
        border-bottom: 1px solid var(--border);
    }

    .transactions-modal .modal-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 20px;
    }

    .transactions-modal .modal-description {
        margin: 5px 0 0;
        color: var(--text-soft);
        font-size: 11px;
    }

    .transactions-modal .close-button {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: #f7f3ed;
        color: var(--text-soft);
        font-size: 18px;
        cursor: pointer;
    }

    .transactions-modal .modal-body {
        padding: 23px 25px 25px;
    }

    /* =========================================================
       FORM
    ========================================================= */

    .transactions-modal .form-group {
        margin-bottom: 17px;
    }

    .transactions-modal .form-label {
        display: block;
        margin-bottom: 7px;
        color: var(--text);
        font-size: 11px;
        font-weight: 800;
    }

    .transactions-modal .required {
        color: var(--maroon);
    }

    .transactions-modal input,
    .transactions-modal select,
    .transactions-modal textarea {
        width: 100%;
        padding: 11px 13px;
        outline: none;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: #fff;
        color: var(--text);
        font-size: 12px;
    }

    .transactions-modal input:focus,
    .transactions-modal select:focus,
    .transactions-modal textarea:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(181,154,99,.12);
    }

    .transactions-modal textarea {
        min-height: 90px;
        resize: vertical;
    }

    /* =========================================================
       RADIO
    ========================================================= */

    .transactions-modal .radio-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 9px;
    }

    .transactions-modal .radio-option {
        position: relative;
    }

    .transactions-modal .radio-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .transactions-modal .radio-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 11px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: #fff;
        color: var(--text);
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .transactions-modal .radio-option input:checked + .radio-label {
        border-color: var(--maroon);
        background: rgba(128,62,47,.06);
        color: var(--maroon);
    }

    /* =========================================================
       STUDENT
    ========================================================= */

    .transactions-modal .student-section {
        display: none;
    }

    .transactions-modal .student-section.show {
        display: block;
    }

    .transactions-modal .student-search-wrapper {
        position: relative;
    }

    .transactions-modal .student-search {
        padding-left: 38px;
    }

    .transactions-modal .search-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-soft);
        pointer-events: none;
    }

    .transactions-modal .student-results {
        position: absolute;
        left: 0;
        right: 0;
        z-index: 50;
        display: none;
        max-height: 210px;
        overflow-y: auto;
        margin-top: 6px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        box-shadow: 0 12px 30px rgba(31,29,32,.1);
    }

    .transactions-modal .student-results.show {
        display: block;
    }

    .transactions-modal .student-result {
        padding: 11px 13px;
        border-bottom: 1px solid #eee9e2;
        cursor: pointer;
    }

    .transactions-modal .student-result:hover {
        background: #f8f4ee;
    }

    .transactions-modal .student-name {
        color: var(--text);
        font-size: 11px;
        font-weight: 800;
    }

    .transactions-modal .student-nis {
        margin-top: 3px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .transactions-modal .no-result {
        padding: 13px;
        color: var(--text-soft);
        font-size: 10px;
        text-align: center;
    }

    .transactions-modal .selected-student {
        display: none;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 7px;
        padding: 11px 13px;
        border: 1px solid #e5dac9;
        border-radius: 10px;
        background: #f6f1e9;
    }

    .transactions-modal .selected-student.show {
        display: flex;
    }

    .transactions-modal .selected-name {
        color: var(--maroon-deep);
        font-size: 11px;
        font-weight: 800;
    }

    .transactions-modal .selected-nis {
        margin-top: 3px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .transactions-modal .change-student {
        border: none;
        background: transparent;
        color: var(--maroon);
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
    }

    /* =========================================================
       AMOUNT / INFO
    ========================================================= */

    .transactions-modal .amount-wrapper {
        position: relative;
    }

    .transactions-modal .amount-prefix {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-soft);
        font-size: 11px;
        font-weight: 800;
        pointer-events: none;
    }

    .transactions-modal .amount-input {
        padding-left: 37px;
    }

    .transactions-modal .helper-text {
        margin-top: 5px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .transactions-modal .edit-info {
        margin-bottom: 17px;
        padding: 12px 13px;
        border: 1px solid #e5dac9;
        border-radius: 10px;
        background: #f6f1e9;
    }

    .transactions-modal .edit-info-label {
        margin-bottom: 4px;
        color: var(--text-soft);
        font-size: 8px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .transactions-modal .edit-info-value {
        color: var(--maroon-deep);
        font-size: 11px;
        font-weight: 800;
    }

    /* =========================================================
       FOOTER
    ========================================================= */

    .transactions-modal .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 7px;
    }

    .transactions-modal .cancel-button,
    .transactions-modal .submit-button {
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .transactions-modal .cancel-button {
        border: 1px solid var(--border);
        background: #fff;
        color: var(--text);
    }

    .transactions-modal .submit-button {
        border: none;
        background: var(--maroon);
        color: #fff;
    }

    .transactions-modal .submit-button:hover {
        background: var(--maroon-dark);
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 900px) {
        .transactions-page .summary-grid {
            grid-template-columns: 1fr;
        }

        .transactions-page .page-header-top {
            flex-direction: column;
        }
    }

    @media (max-width: 650px) {
        .transactions-page .page-title {
            font-size: 25px;
        }

        .transactions-page .header-actions {
            width: 100%;
        }

        .transactions-page .class-info {
            flex: 1;
        }

        .transactions-page .radio-group {
            grid-template-columns: 1fr;
        }

        .transactions-modal {
            padding: 10px;
        }

        .transactions-modal .modal {
            max-height: calc(100vh - 20px);
            border-radius: 15px;
        }

        .transactions-modal .modal-footer {
            flex-direction: column-reverse;
        }

        .transactions-modal .cancel-button,
        .transactions-modal .submit-button {
            width: 100%;
        }
    }
</style>


<div class="transactions-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="page-header">

        <div class="page-header-top">

            <div>

                <h1 class="page-title">
                    Transaksi Kas
                </h1>

                <p class="page-subtitle">
                    Kelola dan pantau seluruh transaksi kas MyCash.
                </p>

                <div class="gold-line"></div>

            </div>


            <div class="header-actions">

                <div class="class-info">

                    <div class="class-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <div>
                        <span class="class-label">
                            Kelas
                        </span>

                        <span class="class-name">
                            XI RPL 1
                        </span>
                    </div>

                </div>


                <button
                    type="button"
                    class="notification-button"
                >
                    <i class="fa-regular fa-bell"></i>
                </button>

            </div>

        </div>


        <button
            type="button"
            class="add-button"
            id="openModalButton"
        >
            <i class="fa-solid fa-plus"></i>
            Tambah Transaksi
        </button>

    </div>


    {{-- =====================================================
         ALERT
    ====================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-error">

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
         SUMMARY
    ====================================================== --}}

    @php

        $totalIncome = collect($transactions ?? [])
            ->where('type', 'in')
            ->sum('amount');

        $totalExpense = collect($transactions ?? [])
            ->where('type', 'out')
            ->sum('amount');

        $totalBalance =
            $totalIncome - $totalExpense;

    @endphp


    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-label">
                Total Pemasukan
            </div>

            <div class="summary-value">
                Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </div>

            <div class="summary-note">
                Total kas masuk
            </div>

        </div>


        <div class="summary-card summary-income">

            <div class="summary-label">
                Total Pengeluaran
            </div>

            <div class="summary-value">
                Rp {{ number_format($totalExpense, 0, ',', '.') }}
            </div>

            <div class="summary-note">
                Total kas keluar
            </div>

        </div>


        <div class="summary-card summary-expense">

            <div class="summary-label">
                Saldo Bersih
            </div>

            <div class="summary-value">
                Rp {{ number_format($totalBalance, 0, ',', '.') }}
            </div>

            <div class="summary-note">
                Pemasukan − Pengeluaran
            </div>

        </div>

    </div>


    {{-- =====================================================
         RIWAYAT TRANSAKSI
    ====================================================== --}}

    <div class="history-card">

        <div class="history-header">

            <div>

                <h2 class="history-title">
                    Riwayat Transaksi
                </h2>

                <p class="history-description">
                    Daftar pemasukan dan pengeluaran yang telah dicatat.
                </p>

            </div>

            <div class="history-count">
                {{ collect($transactions ?? [])->count() }}
                Transaksi
            </div>

        </div>


        @if(collect($transactions ?? [])->count() > 0)

            <div class="table-wrapper">

                <table class="transaction-table">

                    <thead>

                        <tr>

                            <th>Tanggal</th>

                            <th>Jenis</th>

                            <th>Kategori</th>

                            <th>Siswa / Keterangan</th>

                            <th>Nominal</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($transactions as $transaction)

                            <tr>

                                <td>

                                    <div class="date-main">

                                        {{ $transaction->created_at
                                            ? $transaction->created_at->format('d M Y')
                                            : '-'
                                        }}

                                    </div>

                                    <div class="date-time">

                                        {{ $transaction->created_at
                                            ? $transaction->created_at->format('H:i')
                                            : '-'
                                        }}

                                    </div>

                                </td>


                                <td>

                                    @if($transaction->type === 'in')

                                        <span class="type-badge type-income">
                                            ↑ Pemasukan
                                        </span>

                                    @else

                                        <span class="type-badge type-expense">
                                            ↓ Pengeluaran
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <span class="category-badge">
                                        {{ $transaction->category ?? '-' }}
                                    </span>

                                </td>


                                <td>

                                    @if($transaction->description)

                                        <div class="transaction-description">
                                            {{ $transaction->description }}
                                        </div>

                                    @else

                                        <div class="transaction-description empty">
                                            Tidak ada keterangan
                                        </div>

                                    @endif

                                </td>


                                <td>

                                    @if($transaction->type === 'in')

                                        <span class="amount amount-income">

                                            + Rp
                                            {{ number_format(
                                                $transaction->amount,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </span>

                                    @else

                                        <span class="amount amount-expense">

                                            - Rp
                                            {{ number_format(
                                                $transaction->amount,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <div class="action-group">

                                        <button
                                            type="button"
                                            class="action-button edit-button"
                                            onclick="openEditModal(
                                                {{ $transaction->id }},
                                                @js($transaction->type),
                                                @js($transaction->category),
                                                @js($transaction->amount),
                                                @js($transaction->description)
                                            )"
                                        >
                                            Edit
                                        </button>


                                        <form
                                            action="{{ route('transactions.destroy', $transaction->id) }}"
                                            method="POST"
                                            onsubmit="return confirmDelete(
                                                '{{ $transaction->category === 'Kas Siswa'
                                                    ? 'Transaksi Kas Siswa ini akan dihapus dan alokasi pembayaran yang terhubung akan dikosongkan.'
                                                    : 'Transaksi ini akan dihapus.'
                                                }}'
                                            )"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-button delete-button"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>

                <h3 class="empty-title">
                    Belum Ada Transaksi
                </h3>

                <p class="empty-description">
                    Belum ada transaksi yang tercatat.
                    Klik tombol Tambah Transaksi untuk mulai mencatat.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH
========================================================= --}}

<div
    class="transactions-modal"
    id="transactionModal"
>

    <div
        class="modal"
        role="dialog"
        aria-modal="true"
    >

        <div class="modal-header">

            <div>

                <h2 class="modal-title">
                    Tambah Transaksi
                </h2>

                <p class="modal-description">
                    Masukkan data transaksi kas yang ingin dicatat.
                </p>

            </div>

            <button
                type="button"
                class="close-button"
                id="closeModalButton"
            >
                ×
            </button>

        </div>


        <div class="modal-body">

            <form
                action="{{ route('transactions.store') }}"
                method="POST"
                id="transactionForm"
            >

                @csrf


                <div class="form-group">

                    <label class="form-label">
                        Jenis Transaksi
                    </label>

                    <div class="radio-group">

                        <div class="radio-option">

                            <input
                                type="radio"
                                name="type"
                                id="typeIn"
                                value="in"
                                {{ old('type', 'in') === 'in' ? 'checked' : '' }}
                            >

                            <label
                                for="typeIn"
                                class="radio-label"
                            >
                                Pemasukan
                            </label>

                        </div>


                        <div class="radio-option">

                            <input
                                type="radio"
                                name="type"
                                id="typeOut"
                                value="out"
                                {{ old('type') === 'out' ? 'checked' : '' }}
                            >

                            <label
                                for="typeOut"
                                class="radio-label"
                            >
                                Pengeluaran
                            </label>

                        </div>

                    </div>

                </div>


                <div class="form-group">

                    <label
                        for="category"
                        class="form-label"
                    >
                        Kategori
                        <span class="required">*</span>
                    </label>

                    <select
                        name="category"
                        id="category"
                        required
                    ></select>

                </div>


                <div
                    class="form-group student-section"
                    id="studentSection"
                >

                    <label class="form-label">

                        Siswa
                        <span class="required">*</span>

                    </label>


                    <div class="student-search-wrapper">

                        <span class="search-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>

                        <input
                            type="text"
                            id="studentSearch"
                            class="student-search"
                            placeholder="Cari berdasarkan nama atau NIS siswa..."
                            autocomplete="off"
                        >

                        <div
                            class="student-results"
                            id="studentResults"
                        ></div>

                    </div>


                    <input
                        type="hidden"
                        name="student_id"
                        id="studentId"
                        value="{{ old('student_id') }}"
                    >


                    <div
                        class="selected-student"
                        id="selectedStudent"
                    >

                        <div>

                            <div
                                class="selected-name"
                                id="selectedStudentName"
                            ></div>

                            <div
                                class="selected-nis"
                                id="selectedStudentNis"
                            ></div>

                        </div>

                        <button
                            type="button"
                            class="change-student"
                            id="changeStudent"
                        >
                            Ganti
                        </button>

                    </div>

                </div>


                <div
                    class="form-group student-section"
                    id="paymentMonthSection"
                >

                    <label
                        for="paymentMonth"
                        class="form-label"
                    >
                        Bulan Pembayaran
                        <span class="required">*</span>
                    </label>

                    <input
                        type="month"
                        name="payment_month"
                        id="paymentMonth"
                        value="{{ old('payment_month', now()->format('Y-m')) }}"
                    >

                    <div class="helper-text">
                        Menunjukkan bulan saat pembayaran kas dilakukan.
                    </div>

                </div>


                <div class="form-group">

                    <label
                        for="amount"
                        class="form-label"
                    >
                        Nominal
                        <span class="required">*</span>
                    </label>

                    <div class="amount-wrapper">

                        <span class="amount-prefix">
                            Rp
                        </span>

                        <input
                            type="number"
                            name="amount"
                            id="amount"
                            class="amount-input"
                            min="1"
                            step="1"
                            value="{{ old('amount') }}"
                            placeholder="0"
                            required
                        >

                    </div>

                    <div class="helper-text">
                        Masukkan nominal uang yang benar-benar dibayarkan.
                    </div>

                </div>


                <div
                    class="form-group"
                    id="descriptionSection"
                >

                    <label
                        for="description"
                        class="form-label"
                    >
                        Keterangan
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        placeholder="Masukkan keterangan transaksi..."
                    >{{ old('description') }}</textarea>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="cancel-button"
                        id="cancelButton"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="submit-button"
                    >
                        Simpan Transaksi
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL EDIT
========================================================= --}}

<div
    class="transactions-modal"
    id="editModal"
>

    <div
        class="modal"
        role="dialog"
        aria-modal="true"
    >

        <div class="modal-header">

            <div>

                <h2 class="modal-title">
                    Edit Transaksi
                </h2>

                <p class="modal-description">
                    Perbarui data transaksi yang telah dicatat.
                </p>

            </div>

            <button
                type="button"
                class="close-button"
                id="closeEditModalButton"
            >
                ×
            </button>

        </div>


        <div class="modal-body">

            <form
                method="POST"
                id="editTransactionForm"
            >

                @csrf
                @method('PUT')


                <div class="edit-info">

                    <div class="edit-info-label">
                        Jenis Transaksi
                    </div>

                    <div
                        class="edit-info-value"
                        id="editTransactionType"
                    >
                        -
                    </div>

                </div>


                <div class="form-group">

                    <label
                        for="editCategory"
                        class="form-label"
                    >
                        Kategori
                        <span class="required">*</span>
                    </label>

                    <select
                        id="editCategory"
                        required
                    >

                        <option value="Kas Siswa">
                            Kas Siswa
                        </option>

                        <option value="Iuran">
                            Iuran
                        </option>

                        <option value="Operasional">
                            Operasional
                        </option>

                        <option value="Kebutuhan Kelas">
                            Kebutuhan Kelas
                        </option>

                        <option value="Lainnya">
                            Lainnya
                        </option>

                    </select>

                    <input
                        type="hidden"
                        name="category"
                        id="editCategoryHidden"
                    >

                </div>


                <div class="form-group">

                    <label
                        for="editAmount"
                        class="form-label"
                    >
                        Nominal
                        <span class="required">*</span>
                    </label>

                    <div class="amount-wrapper">

                        <span class="amount-prefix">
                            Rp
                        </span>

                        <input
                            type="number"
                            name="amount"
                            id="editAmount"
                            class="amount-input"
                            min="1"
                            step="1"
                            required
                        >

                    </div>

                </div>


                <div
                    class="form-group"
                    id="editDescriptionSection"
                >

                    <label
                        for="editDescription"
                        class="form-label"
                    >
                        Keterangan
                    </label>

                    <textarea
                        name="description"
                        id="editDescription"
                        placeholder="Masukkan keterangan transaksi..."
                    ></textarea>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="cancel-button"
                        id="cancelEditButton"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="submit-button"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>
    /* =========================================================
       DATA SISWA
    ========================================================= */

    const students = {!! json_encode(
        collect($students ?? [])->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis ?? '-',
            ];
        })->values()
    ) !!};


    /* =========================================================
       MODAL TAMBAH
    ========================================================= */

    const modal =
        document.getElementById('transactionModal');

    const openModalButton =
        document.getElementById('openModalButton');

    const closeModalButton =
        document.getElementById('closeModalButton');

    const cancelButton =
        document.getElementById('cancelButton');


    function openModal() {

        modal.classList.add('show');

        document.body.style.overflow = 'hidden';

    }


    function closeModal() {

        modal.classList.remove('show');

        document.body.style.overflow = '';

    }


    openModalButton.addEventListener(
        'click',
        openModal
    );


    closeModalButton.addEventListener(
        'click',
        closeModal
    );


    cancelButton.addEventListener(
        'click',
        closeModal
    );


    modal.addEventListener(
        'click',
        function(event) {

            if (event.target === modal) {
                closeModal();
            }

        }
    );


    /* =========================================================
       MODAL EDIT
    ========================================================= */

    const editModal =
        document.getElementById('editModal');

    const closeEditModalButton =
        document.getElementById('closeEditModalButton');

    const cancelEditButton =
        document.getElementById('cancelEditButton');

    const editTransactionForm =
        document.getElementById('editTransactionForm');

    const editTransactionType =
        document.getElementById('editTransactionType');

    const editCategory =
        document.getElementById('editCategory');

    const editCategoryHidden =
        document.getElementById('editCategoryHidden');

    const editAmount =
        document.getElementById('editAmount');

    const editDescription =
        document.getElementById('editDescription');

    const editDescriptionSection =
        document.getElementById('editDescriptionSection');


    function openEditModal(
        id,
        type,
        categoryValue,
        amount,
        descriptionValue
    ) {

        editTransactionForm.action =
            "{{ url('/transactions') }}/" + id;


        editTransactionType.textContent =
            type === 'in'
                ? 'Pemasukan'
                : 'Pengeluaran';


        editCategory.value =
            categoryValue || '';


        editCategoryHidden.value =
            categoryValue || '';


        editAmount.value =
            Number(amount);


        editDescription.value =
            descriptionValue || '';


        if (categoryValue === 'Kas Siswa') {

            editCategory.value =
                'Kas Siswa';

            editCategory.disabled =
                true;

            editCategoryHidden.disabled =
                false;

            editDescriptionSection.style.display =
                'none';

            editDescription.removeAttribute(
                'name'
            );

        } else {

            editCategory.disabled =
                false;

            editCategoryHidden.disabled =
                true;

            editDescriptionSection.style.display =
                'block';

            editDescription.setAttribute(
                'name',
                'description'
            );

        }


        editModal.classList.add('show');

        document.body.style.overflow = 'hidden';

    }


    function closeEditModal() {

        editModal.classList.remove('show');

        document.body.style.overflow = '';

    }


    closeEditModalButton.addEventListener(
        'click',
        closeEditModal
    );


    cancelEditButton.addEventListener(
        'click',
        closeEditModal
    );


    editModal.addEventListener(
        'click',
        function(event) {

            if (event.target === editModal) {
                closeEditModal();
            }

        }
    );


    /* =========================================================
       HAPUS
    ========================================================= */

    function confirmDelete(message) {

        return confirm(
            message +
            '\n\nApakah kamu yakin ingin melanjutkan?'
        );

    }


    /* =========================================================
       FORM
    ========================================================= */

    const typeIn =
        document.getElementById('typeIn');

    const typeOut =
        document.getElementById('typeOut');

    const category =
        document.getElementById('category');

    const studentSection =
        document.getElementById('studentSection');

    const paymentMonthSection =
        document.getElementById('paymentMonthSection');

    const studentSearch =
        document.getElementById('studentSearch');

    const studentResults =
        document.getElementById('studentResults');

    const studentId =
        document.getElementById('studentId');

    const selectedStudent =
        document.getElementById('selectedStudent');

    const selectedStudentName =
        document.getElementById('selectedStudentName');

    const selectedStudentNis =
        document.getElementById('selectedStudentNis');

    const changeStudent =
        document.getElementById('changeStudent');

    const descriptionSection =
        document.getElementById('descriptionSection');

    const description =
        document.getElementById('description');

    const oldCategory =
        @json(old('category'));


    /* =========================================================
       UPDATE CATEGORY
    ========================================================= */

    function updateCategory() {

        if (typeOut.checked) {

            category.innerHTML = `

                <option value="">
                    Pilih kategori pengeluaran
                </option>

                <option value="Operasional">
                    Operasional
                </option>

                <option value="Kebutuhan Kelas">
                    Kebutuhan Kelas
                </option>

                <option value="Lainnya">
                    Lainnya
                </option>

            `;

        } else {

            category.innerHTML = `

                <option value="">
                    Pilih kategori pemasukan
                </option>

                <option value="Kas Siswa">
                    Kas Siswa
                </option>

                <option value="Iuran">
                    Iuran
                </option>

                <option value="Lainnya">
                    Lainnya
                </option>

            `;

        }


        if (oldCategory) {
            category.value = oldCategory;
        }

    }


    /* =========================================================
       UPDATE FORM
    ========================================================= */

    function updateForm() {

        const isIncome =
            typeIn.checked;

        const isStudentCash =
            isIncome &&
            category.value === 'Kas Siswa';


        if (isStudentCash) {

            studentSection.classList.add('show');

            paymentMonthSection.classList.add('show');

            descriptionSection.style.display =
                'none';

            description.removeAttribute('required');

        } else {

            studentSection.classList.remove('show');

            paymentMonthSection.classList.remove('show');

            descriptionSection.style.display =
                'block';

        }

    }


    /* =========================================================
       SEARCH SISWA
    ========================================================= */

    studentSearch.addEventListener(
        'input',
        function() {

            const keyword =
                this.value.toLowerCase().trim();

            studentResults.innerHTML = '';


            if (!keyword) {

                studentResults.classList.remove('show');

                return;

            }


            const filteredStudents =
                students.filter(function(student) {

                    const name =
                        String(
                            student.name ?? ''
                        ).toLowerCase();

                    const nis =
                        String(
                            student.nis ?? ''
                        ).toLowerCase();


                    return (
                        name.includes(keyword) ||
                        nis.includes(keyword)
                    );

                });


            if (filteredStudents.length === 0) {

                studentResults.innerHTML = `
                    <div class="no-result">
                        Siswa tidak ditemukan.
                    </div>
                `;

                studentResults.classList.add('show');

                return;

            }


            filteredStudents.forEach(
                function(student) {

                    const item =
                        document.createElement('div');

                    item.className =
                        'student-result';

                    item.innerHTML = `

                        <div class="student-name">
                            ${escapeHtml(student.name)}
                        </div>

                        <div class="student-nis">
                            NIS: ${escapeHtml(student.nis)}
                        </div>

                    `;


                    item.addEventListener(
                        'click',
                        function() {

                            selectStudent(student);

                        }
                    );


                    studentResults.appendChild(item);

                }
            );


            studentResults.classList.add('show');

        }
    );


    /* =========================================================
       SELECT SISWA
    ========================================================= */

    function selectStudent(student) {

        studentId.value =
            student.id;

        selectedStudentName.textContent =
            student.name;

        selectedStudentNis.textContent =
            'NIS: ' + student.nis;

        selectedStudent.classList.add('show');

        studentSearch.value = '';

        studentResults.innerHTML = '';

        studentResults.classList.remove('show');

    }


    /* =========================================================
       GANTI SISWA
    ========================================================= */

    changeStudent.addEventListener(
        'click',
        function() {

            studentId.value = '';

            selectedStudentName.textContent = '';

            selectedStudentNis.textContent = '';

            selectedStudent.classList.remove('show');

            studentSearch.value = '';

            studentResults.innerHTML = '';

            studentResults.classList.remove('show');

            studentSearch.focus();

        }
    );


    /* =========================================================
       TYPE CHANGE
    ========================================================= */

    typeIn.addEventListener(
        'change',
        function() {

            updateCategory();

            updateForm();

        }
    );


    typeOut.addEventListener(
        'change',
        function() {

            updateCategory();

            updateForm();

        }
    );


    /* =========================================================
       CATEGORY CHANGE
    ========================================================= */

    category.addEventListener(
        'change',
        function() {

            if (
                !(
                    typeIn.checked &&
                    category.value === 'Kas Siswa'
                )
            ) {

                studentId.value = '';

                selectedStudent.classList.remove('show');

                studentSearch.value = '';

                studentResults.innerHTML = '';

                studentResults.classList.remove('show');

            }

            updateForm();

        }
    );


    /* =========================================================
       CLOSE SEARCH
    ========================================================= */

    document.addEventListener(
        'click',
        function(event) {

            if (
                !event.target.closest(
                    '.student-search-wrapper'
                )
            ) {

                studentResults.classList.remove('show');

            }

        }
    );


    /* =========================================================
       ESCAPE HTML
    ========================================================= */

    function escapeHtml(value) {

        return String(value)

            .replace(/&/g, '&amp;')

            .replace(/</g, '&lt;')

            .replace(/>/g, '&gt;')

            .replace(/"/g, '&quot;')

            .replace(/'/g, '&#039;');

    }


    /* =========================================================
       ESCAPE KEY
    ========================================================= */

    document.addEventListener(
        'keydown',
        function(event) {

            if (event.key === 'Escape') {

                if (modal.classList.contains('show')) {
                    closeModal();
                }

                if (editModal.classList.contains('show')) {
                    closeEditModal();
                }

            }

        }
    );


    /* =========================================================
       INITIAL
    ========================================================= */

    updateCategory();

    updateForm();


    /* =========================================================
       RESTORE OLD STUDENT
    ========================================================= */

    const oldStudentId =
        @json(old('student_id'));


    if (oldStudentId) {

        const oldStudent =
            students.find(function(student) {

                return String(student.id) ===
                    String(oldStudentId);

            });


        if (oldStudent) {

            selectStudent(oldStudent);

        }

    }


    /* =========================================================
       VALIDATION ERROR
    ========================================================= */

    @if($errors->any())

        openModal();

    @endif
</script>

@endsection