@php
    $layout = auth()->user()->role === 'wali_kelas'
        ? 'layouts.wali-kelas'
        : 'layouts.bendahara';

    $studentData = collect($students ?? [])->map(function ($student) {
        return [
            'id' => $student->id,
            'name' => $student->name,
            'nis' => $student->nis ?? '-',
        ];
    })->values()->all();
@endphp

@extends($layout)

@section('content')

<style>
    .transactions-page {
        --maroon: #803E2F;
        --maroon-dark: #54251F;
        --maroon-deep: #1F1D20;
        --gold: #B59A63;
        --cream: #F1ECE4;
        --white: #FFFEFC;
        --text: #3E3D38;
        --text-soft: #756E69;
        --border: #DED6CC;
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

    .page-header { margin-bottom: 25px; }

    .page-header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .page-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 31px;
        font-weight: 700;
    }

    .page-subtitle {
        margin: 8px 0 0;
        color: var(--text-soft);
        font-size: 13px;
    }

    .gold-line {
        width: 42px;
        height: 3px;
        margin-top: 15px;
        border-radius: 10px;
        background: var(--gold);
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .class-info {
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

    .class-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #f4eee5;
        color: var(--maroon);
    }

    .class-label {
        display: block;
        margin-bottom: 2px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .class-name {
        color: var(--maroon-deep);
        font-size: 12px;
        font-weight: 800;
    }

    .notification-button {
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
    }

    .add-button {
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
    }

    .add-button:hover,
    .submit-button:hover {
        background: var(--maroon-dark);
    }

    .alert {
        margin-bottom: 18px;
        padding: 13px 16px;
        border-radius: 11px;
        font-size: 12px;
    }

    .alert-success {
        color: #3f6d55;
        background: #edf4ef;
        border: 1px solid #d2e3d7;
    }

    .alert-error {
        color: #934c4c;
        background: #faf0ef;
        border: 1px solid #ead3d0;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 18px;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }

    .summary-card {
        min-height: 132px;
        padding: 21px 22px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 7px 22px rgba(31,29,32,.045);
    }

    .summary-card:first-child {
        background: linear-gradient(145deg,#6d3529,#54251F);
        border-color: transparent;
        color: #fff;
    }

    .summary-label {
        margin-bottom: 10px;
        color: var(--text-soft);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .summary-card:first-child .summary-label {
        color: rgba(255,255,255,.8);
    }

    .summary-value {
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 25px;
        font-weight: 700;
    }

    .summary-card:first-child .summary-value { color: #fff; }
    .summary-income .summary-value { color: var(--green); }
    .summary-expense .summary-value { color: var(--red); }

    .summary-note {
        margin-top: 8px;
        color: var(--text-soft);
        font-size: 10px;
    }

    .summary-card:first-child .summary-note {
        color: rgba(255,255,255,.72);
    }

    .history-card {
        overflow: hidden;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: 0 9px 28px rgba(31,29,32,.05);
    }

    .history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 23px 26px;
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap;
    }

    .history-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 20px;
    }

    .history-description {
        margin: 5px 0 0;
        color: var(--text-soft);
        font-size: 11px;
    }

    .history-count {
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

    .filter-form {
        display: flex;
        align-items: flex-end;
        gap: 9px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-field {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-label {
        color: var(--text-soft);
        font-size: 9px;
        font-weight: 800;
    }

    .search-input,
    .filter-select,
    .filter-date {
        min-width: 145px;
        max-width: 100%;
        padding: 10px 11px;
        border: 1px solid var(--border);
        border-radius: 9px;
        outline: none;
        background: #fff;
        color: var(--text);
        font-size: 10px;
    }

    .search-input { width: 230px; }

    .search-input:focus,
    .filter-select:focus,
    .filter-date:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(181,154,99,.12);
    }

    .search-button,
    .reset-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 13px;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .search-button {
        border: 1px solid var(--maroon);
        background: var(--maroon);
        color: white;
    }

    .reset-button {
        border: 1px solid var(--border);
        background: white;
        color: var(--text);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .transaction-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
    }

    .transaction-table th {
        padding: 13px 17px;
        background: #f7f3ed;
        color: var(--text-soft);
        border-bottom: 1px solid var(--border);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        text-align: left;
        white-space: nowrap;
    }

    .transaction-table td {
        padding: 14px 17px;
        border-bottom: 1px solid #eee9e2;
        color: var(--text);
        font-size: 11px;
        vertical-align: middle;
    }

    .transaction-table tbody tr:hover { background: #fbf8f4; }
    .transaction-table tbody tr:last-child td { border-bottom: none; }

    .date-main {
        color: var(--text);
        font-size: 11px;
        font-weight: 700;
    }

    .date-time {
        margin-top: 3px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .transaction-description {
        max-width: 260px;
        color: var(--text);
        font-size: 11px;
        font-weight: 600;
        line-height: 1.5;
    }

    .transaction-description.empty {
        color: var(--text-soft);
        font-weight: 400;
    }

    .category-badge {
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

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 8px;
        border-radius: 7px;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .type-income {
        color: var(--green);
        background: #edf4ef;
        border: 1px solid #d4e4d9;
    }

    .type-expense {
        color: var(--red);
        background: #faf0ef;
        border: 1px solid #ead5d1;
    }

    .amount {
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .amount-income { color: var(--green); }
    .amount-expense { color: var(--red); }

    .action-group {
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 9px;
        border-radius: 7px;
        font-size: 9px;
        font-weight: 800;
        cursor: pointer;
    }

    .edit-button {
        background: #f6f1e9;
        border: 1px solid #e5dac9;
        color: var(--maroon);
    }

    .delete-button {
        background: #faf0ef;
        border: 1px solid #ead5d1;
        color: var(--red);
    }

    .empty-state {
        padding: 60px 25px;
        text-align: center;
    }

    .empty-icon {
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

    .empty-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 17px;
    }

    .empty-description {
        margin: 7px 0 0;
        color: var(--text-soft);
        font-size: 11px;
    }

    /* PAGINATION */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
        padding: 18px;
        border-top: 1px solid var(--border);
    }

    .pagination-arrow,
    .pagination-page {
        min-width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: white;
        color: var(--maroon);
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .pagination-arrow:hover,
    .pagination-page:hover {
        background: #f6f1e9;
        border-color: var(--gold);
    }

    .pagination-page.active {
        background: var(--maroon);
        border-color: var(--maroon);
        color: white;
        cursor: default;
    }

    .pagination-arrow.disabled {
        opacity: .35;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination-info {
        margin-left: 8px;
        color: var(--text-soft);
        font-size: 10px;
    }

    /* MODAL */
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

    .transactions-modal.show { display: flex; }

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

    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 25px 18px;
        border-bottom: 1px solid var(--border);
    }

    .modal-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 20px;
    }

    .modal-description {
        margin: 5px 0 0;
        color: var(--text-soft);
        font-size: 11px;
    }

    .close-button {
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

    .modal-body { padding: 23px 25px 25px; }
    .form-group { margin-bottom: 17px; }

    .form-label {
        display: block;
        margin-bottom: 7px;
        color: var(--text);
        font-size: 11px;
        font-weight: 800;
    }

    .required { color: var(--maroon); }

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

    .radio-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 9px;
    }

    .radio-option { position: relative; }

    .radio-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .radio-label {
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

    .radio-option input:checked + .radio-label {
        border-color: var(--maroon);
        background: rgba(128,62,47,.06);
        color: var(--maroon);
    }

    .student-section { display: none; }
    .student-section.show { display: block; }

    .student-search-wrapper { position: relative; }

    .student-search { padding-left: 38px !important; }

    .search-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-soft);
        pointer-events: none;
    }

    .student-results {
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

    .student-results.show { display: block; }

    .student-result {
        padding: 11px 13px;
        border-bottom: 1px solid #eee9e2;
        cursor: pointer;
    }

    .student-result:hover { background: #f8f4ee; }

    .student-name {
        color: var(--text);
        font-size: 11px;
        font-weight: 800;
    }

    .student-nis {
        margin-top: 3px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .no-result {
        padding: 13px;
        color: var(--text-soft);
        font-size: 10px;
        text-align: center;
    }

    .selected-student {
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

    .selected-student.show { display: flex; }

    .selected-name {
        color: var(--maroon-deep);
        font-size: 11px;
        font-weight: 800;
    }

    .selected-nis {
        margin-top: 3px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .change-student {
        border: none;
        background: transparent;
        color: var(--maroon);
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
    }

    .amount-wrapper { position: relative; }

    .amount-prefix {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-soft);
        font-size: 11px;
        font-weight: 800;
        pointer-events: none;
    }

    .amount-input { padding-left: 37px !important; }

    .helper-text {
        margin-top: 5px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .edit-info {
        margin-bottom: 17px;
        padding: 12px 13px;
        border: 1px solid #e5dac9;
        border-radius: 10px;
        background: #f6f1e9;
    }

    .edit-info-label {
        margin-bottom: 4px;
        color: var(--text-soft);
        font-size: 8px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .edit-info-value {
        color: var(--maroon-deep);
        font-size: 11px;
        font-weight: 800;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 7px;
    }

    .cancel-button,
    .submit-button {
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .cancel-button {
        border: 1px solid var(--border);
        background: #fff;
        color: var(--text);
    }

    .submit-button {
        border: none;
        background: var(--maroon);
        color: #fff;
    }

    @media (max-width: 900px) {
        .summary-grid { grid-template-columns: 1fr; }
        .page-header-top { flex-direction: column; }
    }

    @media (max-width: 650px) {
        .page-title { font-size: 25px; }
        .header-actions { width: 100%; }
        .class-info { flex: 1; }
        .filter-form { align-items: stretch; }
        .filter-field { width: 100%; }
        .search-input,
        .filter-select,
        .filter-date { width: 100%; }
        .radio-group { grid-template-columns: 1fr; }
        .transactions-modal { padding: 10px; }
        .transactions-modal .modal {
            max-height: calc(100vh - 20px);
            border-radius: 15px;
        }
        .modal-footer { flex-direction: column-reverse; }
        .cancel-button,
        .submit-button { width: 100%; }

        .pagination-wrapper {
            gap: 5px;
            padding: 15px 8px;
        }

        .pagination-arrow,
        .pagination-page {
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
        }

        .pagination-info {
            width: 100%;
            margin: 7px 0 0;
            text-align: center;
        }
    }
</style>

<div class="transactions-page">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-header-top">
            <div>
                <h1 class="page-title">Transaksi Kas</h1>
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
                        <span class="class-label">Kelas</span>
                        <span class="class-name">XI RPL 1</span>
                    </div>
                </div>

                <button type="button" class="notification-button">
                    <i class="fa-regular fa-bell"></i>
                </button>
            </div>
        </div>

        <button type="button" class="add-button" id="openModalButton">
            <i class="fa-solid fa-plus"></i>
            Tambah Transaksi
        </button>
    </div>

    {{-- ALERT --}}
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

    {{-- RINGKASAN --}}
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Total Pemasukan</div>
            <div class="summary-value">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </div>
            <div class="summary-note">Total kas masuk</div>
        </div>

        <div class="summary-card summary-income">
            <div class="summary-label">Total Pengeluaran</div>
            <div class="summary-value">
                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
            </div>
            <div class="summary-note">Total kas keluar</div>
        </div>

        <div class="summary-card summary-expense">
            <div class="summary-label">Saldo Bersih</div>
            <div class="summary-value">
                Rp {{ number_format($totalSaldo, 0, ',', '.') }}
            </div>
            <div class="summary-note">Pemasukan − Pengeluaran</div>
        </div>
    </div>

    {{-- RIWAYAT TRANSAKSI --}}
    <div class="history-card">
        <div class="history-header">
            <div>
                <h2 class="history-title">Riwayat Transaksi</h2>
                <p class="history-description">
                    Daftar pemasukan dan pengeluaran yang telah dicatat.
                </p>
            </div>

            <div class="history-count">
                {{ $transactions->total() }} Transaksi
            </div>

            {{-- FORM FILTER --}}
            <form
                action="{{ route('transactions.index') }}"
                method="GET"
                class="filter-form"
            >
                <input
                    type="hidden"
                    name="year"
                    value="{{ $selectedYear }}"
                >

                <div class="filter-field">
                    <label class="filter-label">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari kategori atau keterangan..."
                        value="{{ $search ?? '' }}"
                    >
                </div>

                <div class="filter-field">
                    <label class="filter-label">Jenis Transaksi</label>
                    <select name="type" class="filter-select">
                        <option value="">Semua Jenis</option>
                        <option value="in" {{ ($type ?? '') === 'in' ? 'selected' : '' }}>
                            Kas Masuk (+)
                        </option>
                        <option value="out" {{ ($type ?? '') === 'out' ? 'selected' : '' }}>
                            Kas Keluar (-)
                        </option>
                    </select>
                </div>

                <div class="filter-field">
                    <label class="filter-label">Kategori</label>
                    <select name="category" class="filter-select">
                        <option value="">Semua Kategori</option>

                        <optgroup label="Pemasukan">
                            @foreach($incomeCategories as $item)
                                <option
                                    value="{{ $item }}"
                                    {{ ($category ?? '') === $item ? 'selected' : '' }}
                                >
                                    {{ $item }}
                                </option>
                            @endforeach
                        </optgroup>

                        <optgroup label="Pengeluaran">
                            @foreach($expenseCategories as $item)
                                <option
                                    value="{{ $item }}"
                                    {{ ($category ?? '') === $item ? 'selected' : '' }}
                                >
                                    {{ $item }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <div class="filter-field">
                    <label class="filter-label">Dari Tanggal</label>
                    <input
                        type="date"
                        name="from_date"
                        class="filter-date"
                        value="{{ $fromDate ?? '' }}"
                    >
                </div>

                <div class="filter-field">
                    <label class="filter-label">Sampai Tanggal</label>
                    <input
                        type="date"
                        name="to_date"
                        class="filter-date"
                        value="{{ $toDate ?? '' }}"
                    >
                </div>

                <button type="submit" class="search-button">
                    <i class="fa-solid fa-filter"></i>
                    Filter
                </button>

                <a
                    href="{{ route('transactions.index', ['year' => $selectedYear]) }}"
                    class="reset-button"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset Filter
                </a>
            </form>
        </div>

        {{-- TABEL TRANSAKSI --}}
        @if($transactions->count() > 0)
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
                                        {{ $transaction->created_at ? $transaction->created_at->format('d M Y') : '-' }}
                                    </div>
                                    <div class="date-time">
                                        {{ $transaction->created_at ? $transaction->created_at->format('H:i') : '-' }}
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
                                        @if($transaction->category === 'Kas Siswa')
                                            Iuran Kas Siswa
                                        @elseif($transaction->category === 'Lainnya')
                                            Pemasukan Lainnya
                                        @else
                                            {{ $transaction->category ?? '-' }}
                                        @endif
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
                                            + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="amount amount-expense">
                                            - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
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
                                                @js($transaction->category === 'Kas Siswa'
                                                    ? 'Transaksi Kas Siswa ini akan dihapus dan alokasi pembayaran yang terhubung akan dikosongkan.'
                                                    : 'Transaksi ini akan dihapus.')
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
                    Transaksi Tidak Ditemukan
                </h3>

                <p class="empty-description">
                    Tidak ada transaksi yang sesuai dengan pencarian atau filter.
                </p>
            </div>
        @endif

        {{-- PAGINATION --}}
        @if($transactions->hasPages())
            <div class="pagination-wrapper">

                {{-- TOMBOL SEBELUMNYA --}}
                @if($transactions->onFirstPage())
                    <span class="pagination-arrow disabled">
                        <i class="fa-solid fa-chevron-left"></i>
                    </span>
                @else
                    <a
                        href="{{ $transactions->previousPageUrl() }}"
                        class="pagination-arrow"
                        aria-label="Halaman sebelumnya"
                    >
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                {{-- NOMOR HALAMAN --}}
                @foreach(
                    $transactions->getUrlRange(
                        max(1, $transactions->currentPage() - 2),
                        min($transactions->lastPage(), $transactions->currentPage() + 2)
                    ) as $page => $url
                )
                    @if($transactions->currentPage() == $page)
                        <span
                            class="pagination-page active"
                            aria-current="page"
                        >
                            {{ $page }}
                        </span>
                    @else
                        <a
                            href="{{ $url }}"
                            class="pagination-page"
                            aria-label="Halaman {{ $page }}"
                        >
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- TOMBOL BERIKUTNYA --}}
                @if($transactions->hasMorePages())
                    <a
                        href="{{ $transactions->nextPageUrl() }}"
                        class="pagination-arrow"
                        aria-label="Halaman berikutnya"
                    >
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <span class="pagination-arrow disabled">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                @endif

                {{-- INFORMASI JUMLAH DATA --}}
                <span class="pagination-info">
                    Menampilkan
                    {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }}
                    dari {{ $transactions->total() }} transaksi
                </span>

            </div>
        @endif
    </div>
</div>

{{-- MODAL TAMBAH TRANSAKSI --}}
<div class="transactions-modal" id="transactionModal">
    <div class="modal" role="dialog" aria-modal="true">
        <div class="modal-header">
            <div>
                <h2 class="modal-title">Tambah Transaksi</h2>
                <p class="modal-description">
                    Masukkan data transaksi kas yang ingin dicatat.
                </p>
            </div>

            <button type="button" class="close-button" id="closeModalButton">
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
                    <label class="form-label">Jenis Transaksi</label>

                    <div class="radio-group">
                        <div class="radio-option">
                            <input
                                type="radio"
                                name="type"
                                id="typeIn"
                                value="in"
                                {{ old('type', 'in') === 'in' ? 'checked' : '' }}
                            >
                            <label for="typeIn" class="radio-label">
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
                            <label for="typeOut" class="radio-label">
                                Pengeluaran
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="categorySection">
                    <label for="category" class="form-label">
                        Kategori <span class="required">*</span>
                    </label>
                    <select name="category" id="category" required></select>
                </div>

                {{-- PILIH SISWA --}}
                <div class="form-group student-section" id="studentSection">
                    <label class="form-label">
                        Siswa <span class="required">*</span>
                    </label>

                    <div class="student-search-wrapper">
                        <span class="search-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>

                        <input
                            type="text"
                            id="studentSearch"
                            class="student-search"
                            placeholder="Cari nama atau NIS siswa..."
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

                    <div class="selected-student" id="selectedStudent">
                        <div>
                            <div class="selected-name" id="selectedStudentName"></div>
                            <div class="selected-nis" id="selectedStudentNis"></div>
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

                {{-- BULAN PEMBAYARAN --}}
                <div class="form-group student-section" id="paymentMonthSection">
                    <label for="paymentMonth" class="form-label">
                        Bulan Pembayaran <span class="required">*</span>
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

                {{-- NOMINAL --}}
                <div class="form-group">
                    <label for="amount" class="form-label">
                        Nominal <span class="required">*</span>
                    </label>

                    <div class="amount-wrapper">
                        <span class="amount-prefix">Rp</span>
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

                {{-- KETERANGAN --}}
                <div class="form-group" id="descriptionSection">
                    <label for="description" class="form-label">
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

                    <button type="submit" class="submit-button">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT TRANSAKSI --}}
<div class="transactions-modal" id="editModal">
    <div class="modal" role="dialog" aria-modal="true">
        <div class="modal-header">
            <div>
                <h2 class="modal-title">Edit Transaksi</h2>
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
            <form method="POST" id="editTransactionForm">
                @csrf
                @method('PUT')

                <div class="edit-info">
                    <div class="edit-info-label">Jenis Transaksi</div>
                    <div class="edit-info-value" id="editTransactionType">-</div>
                </div>

                <div class="form-group" id="editCategorySection">
                    <label for="editCategory" class="form-label">
                        Kategori <span class="required">*</span>
                    </label>

                    <select
                        name="category"
                        id="editCategory"
                        required
                    ></select>

                    <div class="helper-text" id="editCategoryHelp"></div>
                </div>

                <div class="form-group">
                    <label for="editAmount" class="form-label">
                        Nominal <span class="required">*</span>
                    </label>

                    <div class="amount-wrapper">
                        <span class="amount-prefix">Rp</span>
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

                <div class="form-group" id="editDescriptionSection">
                    <label for="editDescription" class="form-label">
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

                    <button type="submit" class="submit-button">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // DATA SISWA
    const students = @json($studentData);

    // KATEGORI TRANSAKSI
    const incomeCategories = [
        { value: 'Iuran Kas Siswa', label: 'Iuran Kas Siswa' },
        { value: 'Denda Piket Siswa', label: 'Denda Piket Siswa' },
        { value: 'Donasi & Sumbangan', label: 'Donasi & Sumbangan' },
        { value: 'Kas Awal / Saldo Awal', label: 'Kas Awal / Saldo Awal' },
        { value: 'Pemasukan Lainnya', label: 'Pemasukan Lainnya' }
    ];

    const expenseCategories = [
        { value: 'Alat & Perlengkapan Belajar', label: 'Alat & Perlengkapan Belajar' },
        { value: 'Fotokopi & Cetak Dokumen', label: 'Fotokopi & Cetak Dokumen' },
        { value: 'Kebersihan & Sanitasi Kelas', label: 'Kebersihan & Sanitasi Kelas' },
        { value: 'Konsumsi & Acara Kelas', label: 'Konsumsi & Acara Kelas' },
        { value: 'Pengeluaran Lainnya', label: 'Pengeluaran Lainnya' },
        { value: 'Sosial & Santunan Siswa', label: 'Sosial & Santunan Siswa' }
    ];

    // ELEMEN MODAL TAMBAH
    const modal = document.getElementById('transactionModal');
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');
    const cancelButton = document.getElementById('cancelButton');

    function openModal() {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    openModalButton.addEventListener('click', openModal);
    closeModalButton.addEventListener('click', closeModal);
    cancelButton.addEventListener('click', closeModal);

    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // ELEMEN FORM TAMBAH
    const typeIn = document.getElementById('typeIn');
    const typeOut = document.getElementById('typeOut');
    const category = document.getElementById('category');
    const categorySection = document.getElementById('categorySection');

    const studentSection = document.getElementById('studentSection');
    const paymentMonthSection = document.getElementById('paymentMonthSection');

    const studentSearch = document.getElementById('studentSearch');
    const studentResults = document.getElementById('studentResults');
    const studentId = document.getElementById('studentId');

    const selectedStudent = document.getElementById('selectedStudent');
    const selectedStudentName = document.getElementById('selectedStudentName');
    const selectedStudentNis = document.getElementById('selectedStudentNis');

    const changeStudent = document.getElementById('changeStudent');

    const descriptionSection = document.getElementById('descriptionSection');
    const description = document.getElementById('description');

    const oldCategory = @json(old('category'));

    // MEMPERBARUI PILIHAN KATEGORI TAMBAH
    function updateCategory() {
        const previousValue = category.value;
        category.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = typeOut.checked
            ? 'Pilih kategori pengeluaran'
            : 'Pilih kategori pemasukan';

        category.appendChild(placeholder);

        const categories = typeOut.checked
            ? expenseCategories
            : incomeCategories;

        categories.forEach(function(item) {
            const option = document.createElement('option');
            option.value = item.value;
            option.textContent = item.label;
            category.appendChild(option);
        });

        const desiredValue = oldCategory || previousValue;

        if (desiredValue === 'Kas Siswa') {
            category.value = 'Iuran Kas Siswa';
        } else if (desiredValue === 'Lainnya') {
            category.value = 'Pemasukan Lainnya';
        } else {
            category.value = desiredValue;
        }
    }

    // MEMPERBARUI FORM TAMBAH
    function updateForm() {
        const isIncome = typeIn.checked;
        const isStudentCash = isIncome &&
            category.value === 'Iuran Kas Siswa';

        categorySection.style.display = 'block';
        category.disabled = false;
        category.required = true;

        if (isStudentCash) {
            studentSection.classList.add('show');
            paymentMonthSection.classList.add('show');

            descriptionSection.style.display = 'none';
            description.disabled = true;

            studentId.required = true;
            document.getElementById('paymentMonth').required = true;
        } else {
            studentSection.classList.remove('show');
            paymentMonthSection.classList.remove('show');

            descriptionSection.style.display = 'block';
            description.disabled = false;

            studentId.required = false;
            document.getElementById('paymentMonth').required = false;
        }
    }

    typeIn.addEventListener('change', function() {
        updateCategory();
        updateForm();
        resetStudentSelection();
    });

    typeOut.addEventListener('change', function() {
        updateCategory();
        updateForm();
        resetStudentSelection();
    });

    category.addEventListener('change', function() {
        if (category.value !== 'Iuran Kas Siswa') {
            resetStudentSelection();
        }

        updateForm();
    });

    // PENCARIAN SISWA
    studentSearch.addEventListener('input', function() {
        const keyword = this.value.toLowerCase().trim();

        studentResults.innerHTML = '';

        if (!keyword) {
            studentResults.classList.remove('show');
            return;
        }

        const filteredStudents = students.filter(function(student) {
            const name = String(student.name ?? '').toLowerCase();
            const nis = String(student.nis ?? '').toLowerCase();

            return name.includes(keyword) || nis.includes(keyword);
        });

        if (filteredStudents.length === 0) {
            studentResults.innerHTML =
                '<div class="no-result">Siswa tidak ditemukan.</div>';

            studentResults.classList.add('show');
            return;
        }

        filteredStudents.forEach(function(student) {
            const item = document.createElement('div');
            item.className = 'student-result';

            const name = document.createElement('div');
            name.className = 'student-name';
            name.textContent = student.name;

            const nis = document.createElement('div');
            nis.className = 'student-nis';
            nis.textContent = 'NIS: ' + student.nis;

            item.appendChild(name);
            item.appendChild(nis);

            item.addEventListener('click', function() {
                selectStudent(student);
            });

            studentResults.appendChild(item);
        });

        studentResults.classList.add('show');
    });

    function selectStudent(student) {
        studentId.value = student.id;

        selectedStudentName.textContent = student.name;
        selectedStudentNis.textContent = 'NIS: ' + student.nis;

        selectedStudent.classList.add('show');

        studentSearch.value = '';
        studentResults.innerHTML = '';
        studentResults.classList.remove('show');
    }

    function resetStudentSelection() {
        studentId.value = '';
        selectedStudentName.textContent = '';
        selectedStudentNis.textContent = '';

        selectedStudent.classList.remove('show');

        studentSearch.value = '';
        studentResults.innerHTML = '';
        studentResults.classList.remove('show');
    }

    changeStudent.addEventListener('click', function() {
        resetStudentSelection();
        studentSearch.focus();
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.student-search-wrapper')) {
            studentResults.classList.remove('show');
        }
    });

    // MODAL EDIT
    const editModal = document.getElementById('editModal');

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

    const editCategorySection =
        document.getElementById('editCategorySection');

    const editCategoryHelp =
        document.getElementById('editCategoryHelp');

    const editAmount =
        document.getElementById('editAmount');

    const editDescription =
        document.getElementById('editDescription');

    const editDescriptionSection =
        document.getElementById('editDescriptionSection');

    function fillEditCategories(type, selectedCategory) {
        editCategory.innerHTML = '';

        const categories = type === 'in'
            ? incomeCategories
            : expenseCategories;

        categories.forEach(function(item) {
            const option = document.createElement('option');
            option.value = item.value;
            option.textContent = item.label;

            editCategory.appendChild(option);
        });

        let normalizedCategory = selectedCategory;

        if (selectedCategory === 'Kas Siswa') {
            normalizedCategory = 'Iuran Kas Siswa';
        }

        if (selectedCategory === 'Lainnya') {
            normalizedCategory = 'Pemasukan Lainnya';
        }

        editCategory.value = normalizedCategory;
    }

    function openEditModal(id, type, categoryValue, amount, descriptionValue) {
        editTransactionForm.action =
            "{{ url('/transactions') }}/" + id;

        editTransactionType.textContent =
            type === 'in' ? 'Pemasukan' : 'Pengeluaran';

        editAmount.value = Number(amount);
        editDescription.value = descriptionValue || '';

        const isStudentCash = categoryValue === 'Kas Siswa';

        fillEditCategories(type, categoryValue);

        if (isStudentCash) {
            editCategorySection.style.display = 'block';
            editCategory.value = 'Iuran Kas Siswa';
            editCategory.disabled = true;
            editCategory.required = false;

            editCategoryHelp.textContent =
                'Kategori pembayaran kas siswa tidak dapat diubah karena terhubung dengan data pembayaran bulanan.';

            editDescriptionSection.style.display = 'none';
            editDescription.disabled = true;
        } else {
            editCategorySection.style.display = 'block';
            editCategory.disabled = false;
            editCategory.required = true;
            editCategoryHelp.textContent = '';

            editDescriptionSection.style.display = 'block';
            editDescription.disabled = false;
        }

        editModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        editModal.classList.remove('show');
        document.body.style.overflow = '';
    }

    closeEditModalButton.addEventListener('click', closeEditModal);
    cancelEditButton.addEventListener('click', closeEditModal);

    editModal.addEventListener('click', function(event) {
        if (event.target === editModal) {
            closeEditModal();
        }
    });

    // KONFIRMASI HAPUS
    function confirmDelete(message) {
        return confirm(
            message + '\n\nApakah kamu yakin ingin melanjutkan?'
        );
    }

    // TUTUP MODAL DENGAN ESCAPE
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (modal.classList.contains('show')) {
                closeModal();
            }

            if (editModal.classList.contains('show')) {
                closeEditModal();
            }
        }
    });

    // INISIALISASI FORM
    updateCategory();
    updateForm();

    const oldStudentId = @json(old('student_id'));

    if (oldStudentId) {
        const oldStudent = students.find(function(student) {
            return String(student.id) === String(oldStudentId);
        });

        if (oldStudent) {
            selectStudent(oldStudent);
        }
    }

    // BUKA MODAL KEMBALI JIKA VALIDASI GAGAL
    @if($errors->any())
        openModal();
    @endif
</script>

@endsection
