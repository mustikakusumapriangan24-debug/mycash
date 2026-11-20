@extends('layouts.bendahara')

@section('title', 'Pengumuman & Notifikasi - MyCash')

@section('content')
<div class="announcements-page">
    <style>
        .announcements-page {
            --surface: var(--white);
            --muted: var(--text-soft);
            color: var(--text);
        }

        .toolbar,
        .toolbar-actions,
        .tabs,
        .tab,
        .page-heading,
        .announcement-card-heading,
        .announcement-meta,
        .payment-row,
        .payment-person {
            display: flex;
            align-items: center;
        }

        .page-main {
            width: min(1100px, 100%);
            margin: 0 auto;
        }

        .page-heading {
            justify-content: space-between;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .page-heading h1 {
            margin: 0;
            color: var(--maroon-deep);
            font-family: "Playfair Display", serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -.5px;
        }

        .page-heading p {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 10px;
        }

        .content-card {
            margin-top: 20px;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 17px;
            background: var(--surface);
            box-shadow: 0 2px 6px rgba(48, 41, 28, .035);
        }

        .toolbar {
            min-height: 68px;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
        }

        .tabs {
            flex: 0 0 auto;
            gap: 4px;
            padding: 4px;
            border: 1px solid var(--border);
            border-radius: 11px;
        }

        .tab {
            min-height: 34px;
            gap: 8px;
            padding: 0 12px;
            border-radius: 8px;
            color: var(--muted);
            font-size: 9px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
        }

        .tab.active {
            background: var(--maroon);
            color: #fff;
        }

        .tab-count {
            min-width: 17px;
            height: 17px;
            padding: 0 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            background: #f0eee7;
            color: var(--muted);
            font-size: 8px;
        }

        .tab.active .tab-count {
            background: rgba(255, 255, 255, .16);
            color: #fff;
        }

        .toolbar-actions {
            justify-content: flex-end;
            gap: 7px;
        }

        .filter-form {
            display: flex;
            gap: 7px;
        }

        .search-field,
        .priority-select {
            height: 34px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: var(--text);
            font: inherit;
            font-size: 9px;
        }

        .search-field {
            width: 188px;
            padding: 0 11px;
        }

        .search-submit {
            width: 34px;
            height: 34px;
            flex: 0 0 auto;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: var(--maroon);
            cursor: pointer;
        }

        .search-submit:hover {
            border-color: var(--gold);
            background: #f8f4ec;
        }

        .search-field::placeholder {
            color: #9aa097;
        }

        .priority-select {
            padding: 0 9px;
        }

        .create-button {
            height: 34px;
            padding: 0 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border: 0;
            border-radius: 8px;
            background: var(--maroon);
            color: var(--gold);
            font: inherit;
            font-size: 9px;
            font-weight: 800;
            white-space: nowrap;
            cursor: pointer;
        }

        .create-button:hover {
            background: #293128;
        }

        .content-body {
            min-height: 174px;
            padding: 24px 28px;
        }

        .empty-state {
            min-height: 174px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .empty-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #faf8f1;
            color: var(--gold);
            font-size: 15px;
        }

        .empty-state strong {
            margin-top: 10px;
            font-size: 10px;
        }

        .empty-state p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 9px;
        }

        .announcement-list,
        .payment-list {
            display: flex;
            flex-direction: column;
        }

        .announcement-card {
            padding: 17px 4px;
            border-bottom: 1px solid #f0ede6;
        }

        .announcement-card:first-child {
            padding-top: 2px;
        }

        .announcement-card:last-child,
        .payment-row:last-child {
            border-bottom: 0;
        }

        .announcement-card-heading {
            justify-content: space-between;
            gap: 12px;
        }

        .announcement-card h2 {
            margin: 0;
            font-size: 12px;
            font-weight: 800;
        }

        .announcement-priority,
        .payment-type {
            padding: 4px 7px;
            border-radius: 99px;
            background: #f1ece4;
            color: var(--maroon);
            font-size: 8px;
            font-weight: 800;
            white-space: nowrap;
        }

        .announcement-priority.important {
            background: #fff2d6;
            color: #997020;
        }

        .announcement-priority.urgent {
            background: #fae7e5;
            color: #a4473d;
        }

        .announcement-message {
            margin: 9px 0;
            color: #555b53;
            font-size: 10px;
            line-height: 1.7;
            white-space: pre-line;
        }

        .announcement-meta {
            flex-wrap: wrap;
            gap: 12px;
            color: var(--muted);
            font-size: 8px;
        }

        .announcement-meta i {
            margin-right: 4px;
        }

        .payment-table-wrap {
            overflow-x: auto;
        }

        .payment-table {
            width: 100%;
            min-width: 790px;
            border-collapse: collapse;
            text-align: left;
        }

        .payment-table th {
            padding: 11px 12px;
            border-bottom: 1px solid var(--border);
            background: #f8f5ef;
            color: var(--text-soft);
            font-size: 9px;
            font-weight: 800;
            white-space: nowrap;
        }

        .payment-table td {
            padding: 12px;
            border-bottom: 1px solid #eee9e1;
            color: var(--text);
            font-size: 10px;
            vertical-align: middle;
        }

        .payment-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .payment-table .amount-cell {
            color: var(--maroon);
            font-weight: 800;
            white-space: nowrap;
        }

        .proof-reference {
            display: block;
            color: var(--maroon-deep);
            font-size: 9px;
            font-weight: 800;
            white-space: nowrap;
        }

        .proof-link {
            display: inline-block;
            margin-top: 4px;
            color: var(--maroon);
            font-size: 8px;
            text-decoration: none;
        }

        .payment-action {
            padding: 6px 9px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: #fff;
            color: var(--maroon);
            font: inherit;
            font-size: 9px;
            font-weight: 700;
            cursor: pointer;
        }

        .payment-action:hover {
            border-color: var(--gold);
            background: #f8f4ec;
        }

        .payment-detail-modal {
            position: fixed;
            inset: 0;
            z-index: 5500;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            background: rgba(31, 29, 32, .48);
            backdrop-filter: blur(3px);
        }

        .payment-detail-modal.show {
            display: flex;
        }

        .payment-detail-dialog {
            width: min(100%, 460px);
            max-height: calc(100vh - 36px);
            overflow-y: auto;
            border: 1px solid var(--border);
            border-radius: 15px;
            background: var(--white);
            box-shadow: 0 20px 55px rgba(31, 29, 32, .2);
        }

        .payment-detail-header {
            min-height: 54px;
            padding: 11px 20px;
            display: flex;
            align-items: center;
            gap: 9px;
            border-bottom: 1px solid var(--border);
            background: #fbf8f2;
        }

        .payment-detail-header h2 {
            margin: 0;
            color: var(--text);
            font-size: 11px;
            font-weight: 800;
        }

        .payment-detail-header-icon {
            width: 23px;
            height: 23px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            background: #f1ece4;
            color: var(--maroon);
            font-size: 10px;
        }

        .payment-detail-close {
            width: 28px;
            height: 28px;
            margin-left: auto;
            border: 0;
            background: transparent;
            color: var(--text-soft);
            font-size: 18px;
            cursor: pointer;
        }

        .payment-detail-body {
            padding: 20px 22px 12px;
        }

        .payment-detail-summary {
            padding: 4px 0 14px;
            display: flex;
            align-items: center;
            flex-direction: column;
            border-bottom: 1px solid var(--border);
        }

        .payment-detail-reference {
            padding: 5px 10px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: #f8f5ef;
            color: var(--text-soft);
            font-family: monospace;
            font-size: 9px;
            font-weight: 700;
        }

        .payment-detail-total {
            margin-top: 8px;
            color: var(--maroon);
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .payment-detail-status {
            margin-top: 5px;
            padding: 4px 9px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: 1px solid #d5e3d2;
            border-radius: 99px;
            background: #eff5ed;
            color: var(--green);
            font-size: 8px;
            font-weight: 800;
        }

        .payment-detail-grid {
            padding-top: 7px;
            display: block;
        }

        .payment-detail-field {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 9px 0;
            border-bottom: 1px solid var(--border);
        }

        .payment-detail-field span,
        .payment-detail-field strong {
            display: inline-block;
        }

        .payment-detail-field span {
            flex: 0 0 42%;
            color: var(--text-soft);
            font-size: 10px;
        }

        .payment-detail-field strong {
            flex: 1;
            color: var(--text);
            font-size: 10px;
            text-align: right;
            overflow-wrap: anywhere;
        }

        .payment-detail-description {
            align-items: flex-start;
            border-bottom: 0;
        }

        .payment-detail-description strong {
            line-height: 1.5;
        }

        .payment-detail-close-footer {
            display: flex;
            justify-content: flex-end;
            padding: 12px 18px;
            border-top: 1px solid var(--border);
            background: #fbf8f2;
        }

        .payment-detail-close-footer .payment-action {
            min-width: 70px;
            border-color: var(--maroon);
            background: var(--maroon);
            color: #fff;
        }

        .payment-detail-close-footer .payment-action:hover {
            border-color: var(--maroon-dark);
            background: var(--maroon-dark);
        }

        .pagination {
            padding-top: 15px;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .pagination a,
        .pagination span {
            min-width: 28px;
            height: 28px;
            padding: 0 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 7px;
            color: var(--muted);
            font-size: 9px;
            text-decoration: none;
        }

        .pagination .current {
            border-color: var(--maroon);
            background: var(--maroon);
            color: #fff;
        }

        @media (max-width: 800px) {
            .toolbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .toolbar-actions,
            .filter-form {
                width: 100%;
            }

            .toolbar-actions {
                justify-content: space-between;
            }

            .filter-form {
                flex: 1;
            }

            .search-field {
                width: 100%;
                min-width: 80px;
            }
        }

        @media (max-width: 540px) {
            .page-main {
                width: 100%;
            }

            .page-heading h1 {
                font-size: 17px;
            }

            .toolbar-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .filter-form {
                display: flex;
            }

            .search-field {
                flex: 1;
            }

            .priority-select {
                max-width: 130px;
            }

            .create-button {
                align-self: flex-end;
            }

            .content-body {
                padding: 18px 16px;
            }
        }
    </style>
    <div class="page-main">
        <div class="page-heading">
            <div>
                <h1>Pengumuman &amp; Notifikasi</h1>
                <p>Kelola catatan pengumuman kelas dan pantau riwayat konfirmasi kas siswa.</p>
            </div>
        </div>

        <section class="content-card" aria-label="Daftar pengumuman dan riwayat pembayaran">
            <div class="toolbar">
                <nav class="tabs" aria-label="Kategori notifikasi">
                    <a
                        class="tab {{ $tab === 'announcements' ? 'active' : '' }}"
                        href="{{ route('pengumuman.index', ['tab' => 'announcements']) }}"
                    >
                        <i class="fa-solid fa-bullhorn"></i>
                        Pengumuman Kelas
                        <span class="tab-count">{{ $announcementCount }}</span>
                    </a>
                    <a
                        class="tab {{ $tab === 'payments' ? 'active' : '' }}"
                        href="{{ route('pengumuman.index', ['tab' => 'payments']) }}"
                    >
                        <i class="fa-regular fa-clipboard"></i>
                        Riwayat Pembayaran
                        <span class="tab-count">{{ $paymentHistoryCount }}</span>
                    </a>
                </nav>

                <div class="toolbar-actions">
                    <form class="filter-form" action="{{ route('pengumuman.index') }}" method="GET">
                        <input type="hidden" name="tab" value="{{ $tab }}">
                        <input
                            class="search-field"
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="{{ $tab === 'announcements' ? 'Cari pengumuman...' : 'Cari pembayaran...' }}"
                            aria-label="{{ $tab === 'announcements' ? 'Cari pengumuman' : 'Cari pembayaran' }}"
                        >
                        @if($tab === 'announcements')
                            <select
                                class="priority-select"
                                name="priority"
                                aria-label="Filter prioritas"
                                onchange="this.form.submit()"
                            >
                                <option value="all" {{ $priority === 'all' ? 'selected' : '' }}>Semua Prioritas</option>
                                <option value="normal" {{ $priority === 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="important" {{ $priority === 'important' ? 'selected' : '' }}>Penting</option>
                                <option value="urgent" {{ $priority === 'urgent' ? 'selected' : '' }}>Mendesak</option>
                            </select>
                        @endif
                        <button class="search-submit" type="submit" aria-label="Cari">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>

                    @if($tab === 'announcements')
                        <button type="button" class="create-button" onclick="openAnnouncementModal()">
                            <i class="fa-solid fa-plus"></i>
                            Buat Pengumuman
                        </button>
                    @endif
                </div>
            </div>

            <div class="content-body">
                @if($tab === 'announcements')
                    @if($announcements->count())
                        <div class="announcement-list">
                            @foreach($announcements as $announcement)
                                @php
                                    $priorityLabels = [
                                        'normal' => 'Normal',
                                        'important' => 'Penting',
                                        'urgent' => 'Mendesak',
                                    ];
                                    $announcementPriority = $announcement->prioritas ?? 'normal';
                                @endphp
                                <article class="announcement-card">
                                    <div class="announcement-card-heading">
                                        <h2>{{ $announcement->judul }}</h2>
                                        <span class="announcement-priority {{ $announcementPriority }}">
                                            {{ $priorityLabels[$announcementPriority] ?? 'Normal' }}
                                        </span>
                                    </div>
                                    <p class="announcement-message">{{ $announcement->isi }}</p>
                                    <div class="announcement-meta">
                                        <span>
                                            <i class="fa-regular fa-clock"></i>
                                            {{ $announcement->created_at->format('d M Y, H:i') }}
                                        </span>
                                        <span>
                                            <i class="fa-solid fa-user"></i>
                                            {{ $announcement->creator->name ?? 'Bendahara' }}
                                        </span>
                                        <span>
                                            <i class="fa-solid fa-users"></i>
                                            {{ $announcement->recipients_count }} penerima
                                        </span>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        @if($announcements->hasPages())
                            <nav class="pagination" aria-label="Halaman pengumuman">
                                @if($announcements->onFirstPage())
                                    <span aria-disabled="true"><i class="fa-solid fa-chevron-left"></i></span>
                                @else
                                    <a href="{{ $announcements->previousPageUrl() }}" aria-label="Sebelumnya">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </a>
                                @endif

                                @foreach($announcements->getUrlRange(1, $announcements->lastPage()) as $page => $url)
                                    @if($page === $announcements->currentPage())
                                        <span class="current" aria-current="page">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if($announcements->hasMorePages())
                                    <a href="{{ $announcements->nextPageUrl() }}" aria-label="Berikutnya">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span aria-disabled="true"><i class="fa-solid fa-chevron-right"></i></span>
                                @endif
                            </nav>
                        @endif
                    @else
                        <div class="empty-state">
                            <span class="empty-icon"><i class="fa-solid fa-bullhorn"></i></span>
                            <strong>{{ $search !== '' || $priority !== 'all' ? 'Pengumuman tidak ditemukan' : 'Belum ada pengumuman' }}</strong>
                            <p>
                                {{ $search !== '' || $priority !== 'all'
                                    ? 'Coba ubah kata pencarian atau filter prioritas.'
                                    : 'Klik “Buat Pengumuman” untuk mengirim pesan ke seluruh siswa atau siswa tertentu.' }}
                            </p>
                        </div>
                    @endif
                @else
                    @if($paymentHistory->count())
                        <div class="payment-list">
                            <div class="payment-table-wrap">
                                <table class="payment-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Siswa</th>
                                            <th>No. Bukti / Nota</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paymentHistory as $index => $paymentTransaction)
                                            @php
                                                $studentNames = $paymentTransaction->studentPayments
                                                    ->pluck('student.name')
                                                    ->filter()
                                                    ->merge($paymentTransaction->weeklyPayments->pluck('student.name')->filter())
                                                    ->unique()
                                                    ->values();
                                                $studentNis = $paymentTransaction->studentPayments
                                                    ->pluck('student.nis')
                                                    ->filter()
                                                    ->merge($paymentTransaction->weeklyPayments->pluck('student.nis')->filter())
                                                    ->unique()
                                                    ->values();
                                                $receiptNumber = 'TRX-' . str_pad(
                                                    (string) $paymentTransaction->id,
                                                    6,
                                                    '0',
                                                    STR_PAD_LEFT
                                                );
                                                $paymentAmount = 'Rp ' . number_format(
                                                    (float) $paymentTransaction->amount,
                                                    0,
                                                    ',',
                                                    '.'
                                                );
                                                $paymentDescription = $paymentTransaction->description
                                                    ?: 'Pembayaran kas siswa';
                                            @endphp
                                            <tr>
                                                <td>{{ ($paymentHistory->firstItem() ?? 1) + $index }}</td>
                                                <td>{{ $studentNames->implode(', ') ?: '-' }}</td>
                                                <td>
                                                    <span class="proof-reference">{{ $receiptNumber }}</span>
                                                </td>
                                                <td>{{ $paymentTransaction->created_at->format('d M Y, H:i') }}</td>
                                                <td class="amount-cell">{{ $paymentAmount }}</td>
                                                <td>
                                                    <button
                                                        type="button"
                                                        class="payment-action"
                                                        data-payment-detail
                                                        data-reference="{{ $receiptNumber }}"
                                                        data-student="{{ $studentNames->implode(', ') ?: '-' }}"
                                                        data-nis="{{ $studentNis->implode(', ') ?: '-' }}"
                                                        data-date="{{ $paymentTransaction->created_at->format('d F Y H:i') }} WIB"
                                                        data-amount="{{ $paymentAmount }}"
                                                        data-description="{{ $paymentDescription }}"
                                                        data-verifier="{{ $paymentTransaction->bendahara->user->name ?? $paymentTransaction->bendahara->nama ?? 'Tidak tercatat (data lama)' }}"
                                                    >
                                                        Detail
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($paymentHistory->hasPages())
                            <nav class="pagination" aria-label="Halaman riwayat pembayaran">
                                @if($paymentHistory->onFirstPage())
                                    <span aria-disabled="true"><i class="fa-solid fa-chevron-left"></i></span>
                                @else
                                    <a href="{{ $paymentHistory->previousPageUrl() }}" aria-label="Sebelumnya">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </a>
                                @endif

                                @foreach($paymentHistory->getUrlRange(1, $paymentHistory->lastPage()) as $page => $url)
                                    @if($page === $paymentHistory->currentPage())
                                        <span class="current" aria-current="page">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if($paymentHistory->hasMorePages())
                                    <a href="{{ $paymentHistory->nextPageUrl() }}" aria-label="Berikutnya">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span aria-disabled="true"><i class="fa-solid fa-chevron-right"></i></span>
                                @endif
                            </nav>
                        @endif
                    @else
                        <div class="empty-state">
                            <span class="empty-icon"><i class="fa-regular fa-clipboard"></i></span>
                            <strong>Belum ada riwayat pembayaran</strong>
                            <p>Catatan pembayaran kas siswa akan tampil di sini.</p>
                        </div>
                    @endif
                @endif
            </div>
        </section>
    </div>

    <div class="payment-detail-modal" id="paymentDetailModal">
        <section
            class="payment-detail-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="paymentDetailTitle"
        >
            <header class="payment-detail-header">
                <span class="payment-detail-header-icon">
                    <i class="fa-solid fa-receipt"></i>
                </span>
                <h2 id="paymentDetailTitle">Rincian Bukti Pembayaran</h2>
                <button type="button" class="payment-detail-close" data-close-payment-detail aria-label="Tutup">
                    ×
                </button>
            </header>
            <div class="payment-detail-body">
                <div class="payment-detail-summary">
                    <span class="payment-detail-reference" id="paymentDetailReference"></span>
                    <strong class="payment-detail-total" id="paymentDetailAmount"></strong>
                    <span class="payment-detail-status">
                        <i class="fa-solid fa-check"></i>
                        Tercatat Sah di Buku Kas
                    </span>
                </div>
                <div class="payment-detail-grid">
                    <div class="payment-detail-field">
                        <span>Nama Siswa</span>
                        <strong id="paymentDetailStudent"></strong>
                    </div>
                    <div class="payment-detail-field">
                        <span>Nomor Induk Siswa (NIS)</span>
                        <strong id="paymentDetailNis"></strong>
                    </div>
                    <div class="payment-detail-field">
                        <span>Waktu Pembayaran</span>
                        <strong id="paymentDetailDate"></strong>
                    </div>
                    <div class="payment-detail-field payment-detail-description">
                        <span>Keterangan Transaksi</span>
                        <strong id="paymentDetailDescription"></strong>
                    </div>
                    <div class="payment-detail-field">
                        <span>Diverifikasi Oleh</span>
                        <strong id="paymentDetailVerifier"></strong>
                    </div>
                </div>
            </div>
            <div class="payment-detail-close-footer">
                <button type="button" class="payment-action" data-close-payment-detail>Tutup</button>
            </div>
        </section>
    </div>

    @include('partials.announcement-composer')

    <script>
        const paymentDetailModal = document.getElementById('paymentDetailModal');
        const paymentDetailFields = {
            student: document.getElementById('paymentDetailStudent'),
            nis: document.getElementById('paymentDetailNis'),
            reference: document.getElementById('paymentDetailReference'),
            date: document.getElementById('paymentDetailDate'),
            amount: document.getElementById('paymentDetailAmount'),
            description: document.getElementById('paymentDetailDescription'),
            verifier: document.getElementById('paymentDetailVerifier')
        };
        document.querySelectorAll('[data-payment-detail]').forEach(function(button) {
            button.addEventListener('click', function() {
                paymentDetailFields.student.textContent = button.dataset.student;
                paymentDetailFields.nis.textContent = button.dataset.nis;
                paymentDetailFields.reference.textContent = button.dataset.reference;
                paymentDetailFields.date.textContent = button.dataset.date;
                paymentDetailFields.amount.textContent = button.dataset.amount;
                paymentDetailFields.description.textContent = button.dataset.description;
                paymentDetailFields.verifier.textContent = button.dataset.verifier;

                paymentDetailModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });
        });

        function closePaymentDetail() {
            paymentDetailModal.classList.remove('show');
            document.body.style.overflow = '';
        }

        document.querySelectorAll('[data-close-payment-detail]').forEach(function(button) {
            button.addEventListener('click', closePaymentDetail);
        });

        paymentDetailModal.addEventListener('click', function(event) {
            if (event.target === paymentDetailModal) {
                closePaymentDetail();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && paymentDetailModal.classList.contains('show')) {
                closePaymentDetail();
            }
        });
    </script>
</div>
@endsection
