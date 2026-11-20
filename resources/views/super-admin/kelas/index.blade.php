<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kelas - MyCash</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --maroon: #4d0710;
            --dark-maroon: #1e0307;
            --gold: #e6c875;
            --background: #f7f5f2;
            --white: #ffffff;
            --text: #292329;
            --muted: #8b8285;
            --border: #eee7e5;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--background);
            color: var(--text);
        }

        .main {
            margin-left: 250px;
            padding: 32px;
            min-height: 100vh;
        }

        .admin-strip {
            min-height: 54px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: -32px -32px 27px;
            padding: 0 32px;
            border-bottom: 1px solid var(--border);
            background: rgba(255, 254, 252, .9);
        }

        .admin-identity,
        .admin-date {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 600;
        }

        .admin-role {
            padding: 6px 11px;
            border-radius: 20px;
            background: #F1ECE4;
            color: var(--maroon);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        .admin-date {
            padding: 8px 11px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--white);
        }

        .class-page-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 22px;
            padding-bottom: 17px;
            border-bottom: 1px solid var(--border);
        }

        .class-page-heading h1 {
            margin: 0;
            color: var(--text);
            font-size: 24px;
            font-weight: 800;
        }

        .class-page-heading p {
            margin-top: 7px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .class-count,
        .panel-count {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: #FAF7F0;
            color: var(--text-soft, #756E69);
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .class-count { margin-left: 8px; vertical-align: middle; }

        .panel-header {
            align-items: center;
        }

        .panel-header-title {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
        }

        .panel-header-title h2 {
            margin: 0;
        }

        .panel-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 9px;
        }

        .class-search {
            position: relative;
            width: min(255px, 100%);
        }

        .class-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 11px;
        }

        .class-search input {
            width: 100%;
            min-height: 38px;
            padding: 9px 12px 9px 34px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #FAF7F0;
            color: var(--text);
            font-family: inherit;
            font-size: 10px;
        }

        .class-search input:focus {
            outline: 2px solid rgba(181,154,99,.2);
            border-color: var(--gold);
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-height: 38px;
            padding: 9px 13px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 32px;
        }

        .eyebrow {
            color: #987b42;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .topbar h1 {
            margin-top: 8px;
            font-size: 25px;
            font-weight: 800;
        }

        .topbar p {
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .role {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1px solid var(--border);
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--maroon);
            font-size: 11px;
            font-weight: 700;
        }

        .panel {
            overflow: hidden;
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            padding: 22px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h2 {
            font-size: 14px;
            margin-bottom: 8px;
        }

        .panel-header p {
            color: var(--muted);
            font-size: 11px;
        }

        .btn-add {
            display: inline-block;
            padding: 11px 16px;
            border-radius: 9px;
            background: var(--maroon);
            color: white;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s;
        }

        .btn-add:hover {
            background: #6b101c;
            color: var(--gold);
        }

        .panel-header-title h2 {
            margin-bottom: 0;
        }

        .panel-actions .btn-add {
            display: inline-flex;
            align-items: center;
        }

        .alert {
            margin: 20px 22px 0;
            padding: 13px 16px;
            border-radius: 9px;
            font-size: 12px;
            line-height: 1.7;
        }

        .alert-success {
            border: 1px solid #b9e5c9;
            background: #e9f7ef;
            color: #236c46;
        }

        .alert-error {
            border: 1px solid #f0c4c4;
            background: #fff0f0;
            color: #9b3030;
        }

        .alert ul {
            margin: 5px 0 0;
            padding-left: 18px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            min-width: 900px;
        }

        th {
            padding: 16px 18px;
            background: #fcf8f2;
            color: #78666b;
            font-size: 11px;
            white-space: nowrap;
        }

        td {
            padding: 17px 18px;
            border-top: 1px solid #f1ece6;
            font-size: 12px;
            vertical-align: middle;
        }

        .class-code {
            color: var(--maroon);
            font-weight: 700;
        }

        .class-name {
            display: block;
            color: var(--text);
            font-size: 12px;
            font-weight: 800;
        }

        .class-meta,
        .cash-range {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 10px;
        }

        .class-info-main {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
        }

        .class-code-badge,
        .cashier-badge,
        .student-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 8px;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: #FAF7F0;
            color: var(--muted);
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .student-badge {
            border-color: #D7E5CB;
            background: #EEF5E8;
            color: #52723D;
        }

        .class-info-sub {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 9px;
        }

        .wali-cell strong {
            display: block;
            color: var(--text);
            font-size: 10px;
        }

        .wali-cell small {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 9px;
        }

        .cash-rule {
            color: var(--maroon);
            font-weight: 800;
            white-space: nowrap;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .aktif {
            color: #236c46;
            background: #e9f7ef;
        }

        .nonaktif {
            color: #8a4c28;
            background: #fff0e5;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 10px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s;
            cursor: pointer;
        }

        .btn-detail {
            background: var(--maroon);
            color: #fff;
            border: 1px solid var(--maroon);
        }

        .btn-detail:hover {
            background: var(--dark-maroon);
        }

        .btn-edit {
            background: #F1ECE4;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-edit:hover {
            background: #E8DFD2;
        }

        .btn-delete {
            background: #fff0f0;
            color: #a52d35;
            border: 1px solid #f0caca;
        }

        .btn-delete:hover {
            background: #a52d35;
            color: white;
        }

        .empty {
            padding: 55px 20px;
            text-align: center;
            color: var(--muted);
        }

        .empty-icon {
            margin-bottom: 14px;
            font-size: 35px;
        }

        .empty h3 {
            margin: 0 0 8px;
            color: var(--maroon);
            font-size: 16px;
        }

        .empty p {
            margin: 0;
            font-size: 12px;
            line-height: 1.8;
        }

        .back {
            display: inline-block;
            margin-top: 25px;
            color: var(--maroon);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        .back:hover {
            color: #8b2936;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: var(--muted);
            font-size: 10px;
        }

        .pagination-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 10px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--white);
            color: var(--text);
            font-size: 10px;
            text-decoration: none;
        }

        .pagination .current {
            border-color: var(--gold);
            background: var(--gold);
            color: #3E3D38;
            font-weight: 800;
        }

        .pagination .disabled {
            color: #B5ADA5;
            pointer-events: none;
        }

        /* MODAL */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(30, 3, 7, .65);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: .2s;
        }

        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-box {
            width: 100%;
            max-width: 470px;
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
            transform: translateY(12px);
            transition: .2s;
        }

        .modal-overlay.show .modal-box {
            transform: translateY(0);
        }

        .modal-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 17px;
            border-radius: 50%;
            background: #fff0f0;
            color: #a52d35;
            font-size: 23px;
        }

        .modal-box h2 {
            color: var(--maroon);
            text-align: center;
            font-size: 19px;
            margin-bottom: 10px;
        }

        .modal-description {
            text-align: center;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
            margin-bottom: 22px;
        }

        .modal-info {
            background: #fcf8f2;
            border: 1px solid #eee2ca;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 13px;
        }

        .modal-info small {
            display: block;
            color: #987b42;
            font-size: 10px;
            font-weight: 800;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: .7px;
        }

        .modal-info strong {
            display: block;
            color: var(--maroon);
            font-size: 12px;
            line-height: 1.7;
        }

        .modal-reason {
            background: #fff5f3;
            border: 1px solid #f1d7d2;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .modal-reason small {
            display: block;
            color: #a34c43;
            font-size: 10px;
            font-weight: 800;
            margin-bottom: 7px;
            text-transform: uppercase;
        }

        .modal-reason p {
            color: #783a35;
            font-size: 11px;
            line-height: 1.8;
        }

        .modal-note {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.8;
            text-align: center;
            margin-bottom: 20px;
        }

        .modal-button {
            display: block;
            width: 100%;
            border: none;
            border-radius: 9px;
            padding: 12px;
            background: var(--maroon);
            color: white;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .modal-button:hover {
            background: #6b101c;
            color: var(--gold);
        }

        @media (max-width: 1100px) {
            .main {
                padding: 25px;
            }
        }

        @media (max-width: 700px) {
            .main {
                margin-left: 0;
                padding: 20px 15px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .topbar h1 {
                font-size: 22px;
            }

            .panel-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .admin-strip {
                margin: -20px -15px 20px;
                padding: 0 15px;
            }

            .class-page-heading h1 { font-size: 21px; }
            .panel-actions { width: 100%; justify-content: stretch; }
            .class-search { width: 100%; flex: 1 1 100%; }
            .panel-actions .btn-add { width: 100%; justify-content: center; }
            .pagination-footer { align-items: flex-start; flex-direction: column; }
            .pagination { max-width: 100%; overflow-x: auto; }
            .modal-box {
                padding: 23px;
            }
        }
    </style>
</head>

<body>

{{-- SIDEBAR BERSAMA --}}
@include('partials.sidebar-super-admin')

<main class="main">

    <div class="admin-strip">
        <div class="admin-identity">
            <span class="admin-role">ADMINISTRATOR</span>
            <span>Pengaturan Sistem &amp; Hak Akses</span>
        </div>
        <div class="admin-date">
            <i class="fa-regular fa-calendar"></i>
            {{ now()->translatedFormat('d M Y') }}
        </div>
    </div>

    <header class="class-page-heading">
        <div>
            <h1>
                Kelola Kelas
                <span class="class-count">Total {{ number_format($totalKelas, 0, ',', '.') }} Kelas</span>
            </h1>
            <p>Manajemen rombongan belajar, wali kelas, dan bendahara yang ditugaskan.</p>
        </div>
    </header>

    <section class="panel">

        <div class="panel-header">
            <div>
                <div class="panel-header-title">
                    <h2>Data Master Rombel Kelas</h2>
                    <span class="panel-count">{{ number_format($kelas->total(), 0, ',', '.') }} Kelas</span>
                </div>
            </div>

            <div class="panel-actions">
                <form action="{{ route('super-admin.kelas.index') }}" method="GET" class="class-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari rombel kelas..."
                        aria-label="Cari rombel kelas"
                    >
                </form>

                @if($search !== '')
                    <a href="{{ route('super-admin.kelas.index') }}" class="btn-action btn-edit" title="Hapus pencarian" aria-label="Hapus pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif

                <a href="{{ route('super-admin.kelas.create') }}" class="btn-add">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Kelas Baru
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Data belum berhasil diproses:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kelas &amp; Info</th>
                        <th>Wali Kelas</th>
                        <th>Siswa</th>
                        <th>Bendahara</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($kelas as $item)
                        <tr>
                            <td>{{ ($kelas->firstItem() ?? 1) + $loop->index }}</td>

                            <td>
                                <div class="class-info-main">
                                    <span class="class-name">{{ $item->nama_kelas ?: $item->kode_kelas }}</span>
                                    <span class="class-code-badge">{{ $item->kode_kelas }}</span>
                                </div>
                                <span class="class-info-sub">TA {{ $item->tahun_ajaran ?: '-' }}</span>
                                @if($item->keterangan)
                                    <span class="class-info-sub">{{ $item->keterangan }}</span>
                                @endif
                                <span class="status {{ $item->status === 'aktif' ? 'aktif' : 'nonaktif' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            <td class="wali-cell">
                                @if($item->waliKelas)
                                    <strong>{{ $item->waliKelas->nama }}</strong>
                                    <small>NIP: {{ $item->waliKelas->nip ?: '-' }}</small>
                                @else
                                    <span class="class-meta">Belum ditentukan</span>
                                @endif
                            </td>

                            <td>
                                <span class="student-badge">
                                    <i class="fa-solid fa-user-graduate"></i>
                                    {{ number_format($item->students_count, 0, ',', '.') }} Siswa
                                </span>
                            </td>

                            <td>
                                @forelse($item->bendahara as $bendahara)
                                    <span class="cashier-badge">
                                        <i class="fa-solid fa-user-tie"></i>
                                        {{ $bendahara->nama }}
                                    </span>
                                @empty
                                    <span class="class-meta">Belum ditentukan</span>
                                @endforelse
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        href="{{ route('super-admin.kelas.show', $item->id) }}"
                                        class="btn-action btn-detail"
                                        title="Lihat detail"
                                        aria-label="Lihat detail {{ $item->nama_kelas }}"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a
                                        href="{{ route('super-admin.kelas.edit', $item->id) }}"
                                        class="btn-action btn-edit"
                                        title="Edit kelas"
                                        aria-label="Edit {{ $item->nama_kelas }}"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button
                                        type="button"
                                        class="btn-action btn-delete"
                                        title="Hapus kelas"
                                        aria-label="Hapus {{ $item->nama_kelas }}"
                                        onclick="confirmDelete('{{ $item->id }}', @js($item->nama_kelas))"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="fa-solid fa-school"></i>
                                    </div>

                                    <h3>{{ $search !== '' ? 'Kelas Tidak Ditemukan' : 'Belum Ada Kelas' }}</h3>

                                    <p>
                                        {{ $search !== '' ? 'Coba gunakan kata kunci lain.' : 'Tambahkan kelas baru untuk mulai mengelola rombongan belajar.' }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-footer">
            <span>
                Menampilkan {{ $kelas->firstItem() ?? 0 }} s/d {{ $kelas->lastItem() ?? 0 }}
                dari {{ $kelas->total() }} kelas
            </span>
            @if($kelas->hasPages())
                <nav class="pagination" aria-label="Halaman daftar kelas">
                    @if($kelas->onFirstPage())
                        <span class="disabled" aria-disabled="true">Sebelum</span>
                    @else
                        <a href="{{ $kelas->previousPageUrl() }}">Sebelum</a>
                    @endif

                    @foreach($kelas->getUrlRange(1, $kelas->lastPage()) as $page => $url)
                        @if($page === $kelas->currentPage())
                            <span class="current" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" aria-label="Halaman {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($kelas->hasMorePages())
                        <a href="{{ $kelas->nextPageUrl() }}">Lanjut</a>
                    @else
                        <span class="disabled" aria-disabled="true">Lanjut</span>
                    @endif
                </nav>
            @endif
        </div>
    </section>

    <footer class="footer">
        MYCASH &copy; {{ date('Y') }} — Smart Class Finance
    </footer>

</main>


<!-- MODAL KONFIRMASI HAPUS -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <div class="modal-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <h2>Konfirmasi Penghapusan</h2>

        <p class="modal-description">
            Apakah kamu yakin ingin menghapus data kelas ini?
        </p>

        <div class="modal-info">
            <small>Data Terpilih</small>
            <strong id="selectedClassName">-</strong>
        </div>

        <p class="modal-note">
            Sistem akan memeriksa keterkaitan data terlebih dahulu.
            Data yang masih digunakan tidak boleh dihapus.
        </p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit" class="modal-button">
                Ya, Lanjutkan
            </button>
        </form>

        <button
            type="button"
            class="modal-button"
            style="margin-top: 9px; background: #f2eeee; color: #55484b;"
            onclick="closeModal('confirmModal')"
        >
            Batal
        </button>
    </div>
</div>


<!-- MODAL TIDAK DAPAT DIHAPUS -->
@if (session('delete_blocked'))
    <div class="modal-overlay show" id="blockedModal">
        <div class="modal-box">

            <div class="modal-icon">
                <i class="fa-solid fa-lock"></i>
            </div>

            <h2>Tidak Dapat Dihapus</h2>

            <p class="modal-description">
                Data kelas tidak dapat dihapus karena masih memiliki keterkaitan dengan data lain.
            </p>

            <div class="modal-info">
                <small>Data Terpilih</small>
                <strong>{{ session('delete_blocked.nama_kelas') }}</strong>
            </div>

            <div class="modal-reason">
                <small>Alasan Pembatalan</small>
                <p>{{ session('delete_blocked.alasan') }}</p>
            </div>

            <p class="modal-note">
                Untuk menjaga integritas riwayat pembukuan kas,
                data master yang masih terikat tidak dapat dihapus
                sebelum data terkait diselesaikan.
            </p>

            <button
                type="button"
                class="modal-button"
                onclick="closeModal('blockedModal')"
            >
                Tutup
            </button>

        </div>
    </div>
@endif


<script>
    function confirmDelete(id, namaKelas) {
        const modal = document.getElementById('confirmModal');
        const form = document.getElementById('deleteForm');
        const name = document.getElementById('selectedClassName');

        name.textContent = namaKelas;

        form.action = "{{ url('/super-admin/kelas') }}/" + id;

        modal.classList.add('show');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.remove('show');
        }
    }

    document.querySelectorAll('.modal-overlay').forEach(function(modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('show');
            }
        });
    });
</script>

</body>
</html>
