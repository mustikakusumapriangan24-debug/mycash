<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Bendahara Kelas - MyCash</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --maroon: #4d0710;
            --dark-maroon: #1e0307;
            --gold: #e6c875;
            --background: #f7f5f2;
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

        .unknown {
            color: #777;
            background: #eee;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 8px 10px;
            border: none;
            border-radius: 7px;
            font-family: inherit;
            font-size: 10px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-detail {
            background: var(--maroon);
            color: white;
        }

        .btn-detail:hover {
            background: #6b101c;
            color: var(--gold);
        }

        .btn-edit {
            background: #fff5dc;
            color: #85651e;
        }

        .btn-edit:hover {
            background: #f5e5b9;
            color: #60460d;
        }

        .btn-toggle {
            background: #e9f7ef;
            color: #236c46;
        }

        .btn-toggle.nonaktif-btn {
            background: #fff0e5;
            color: #8a4c28;
        }

        .btn-delete {
            background: #fdecec;
            color: #a32d2d;
        }

        .btn-delete:hover {
            background: #f8dada;
        }

        .empty {
            padding: 55px 20px;
            text-align: center;
            color: var(--muted);
        }

        .empty i {
            margin-bottom: 14px;
            font-size: 35px;
            color: var(--gold);
        }

        .empty h3 {
            margin-bottom: 8px;
            color: var(--maroon);
            font-size: 16px;
        }

        .empty p {
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

        .footer {
            margin-top: 30px;
            text-align: center;
            color: var(--muted);
            font-size: 10px;
        }

        .alert {
            margin: 15px 22px;
            padding: 13px 16px;
            border-radius: 9px;
            font-size: 12px;
        }

        .alert-success {
            color: #236c46;
            background: #e9f7ef;
        }

        .alert-danger {
            color: #a32d2d;
            background: #fdecec;
        }

        /* MODAL TIDAK DAPAT DIHAPUS */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(30, 3, 7, 0.65);
            backdrop-filter: blur(5px);
        }

        .modal-box {
            width: 100%;
            max-width: 460px;
            padding: 32px;
            background: #fff;
            border: 1px solid rgba(230, 200, 117, 0.6);
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            animation: modalShow 0.25s ease;
        }

        @keyframes modalShow {
            from {
                opacity: 0;
                transform: translateY(15px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-icon {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border-radius: 50%;
            background: #fff0e5;
            color: #a32d2d;
            font-size: 23px;
        }

        .modal-box h2 {
            color: var(--maroon);
            font-size: 21px;
            font-weight: 800;
            margin-bottom: 22px;
        }

        .modal-label {
            display: block;
            margin-bottom: 8px;
            color: #8b8285;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .selected-name {
            padding: 13px 15px;
            margin-bottom: 20px;
            background: #fcf8f2;
            border: 1px solid #eee3d0;
            border-radius: 9px;
            color: var(--maroon);
            font-size: 13px;
            font-weight: 700;
        }

        .reason-title {
            margin-bottom: 9px;
            color: #78666b;
            font-size: 11px;
            font-weight: 800;
        }

        .reason-text {
            color: #62595c;
            font-size: 12px;
            line-height: 1.9;
        }

        .reason-text strong {
            color: var(--maroon);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 27px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn-close-modal {
            padding: 11px 27px;
            border: none;
            border-radius: 8px;
            background: var(--maroon);
            color: white;
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-close-modal:hover {
            background: #6b101c;
            color: var(--gold);
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

            .modal-box {
                padding: 25px;
            }
        }

        .admin-strip {
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: -32px -32px 27px;
            padding: 0 32px;
            border-bottom: 1px solid #e8e1d5;
            background: #fbf8ee;
        }

        .admin-identity,
        .admin-date {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #77796f;
            font-size: 10px;
            font-weight: 600;
        }

        .admin-role {
            padding: 6px 11px;
            border-radius: 20px;
            background: #D8C7A8;
            color: #3E3D38;
            font-size: 9px;
            font-weight: 800;
        }

        .admin-actions {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .admin-icon,
        .admin-date {
            min-height: 34px;
            padding: 7px 10px;
            border: 1px solid #e8e1d5;
            border-radius: 9px;
            background: #fff;
            color: #666b60;
            font-size: 10px;
        }

        .admin-icon {
            width: 34px;
            justify-content: center;
        }

        .manager-heading {
            margin-bottom: 22px;
            padding-bottom: 14px;
            border-bottom: 1px solid #e8e1d5;
        }

        .manager-heading h1 {
            margin: 0;
            color: #3E3D38;
            font-size: 24px;
            font-weight: 800;
        }

        .manager-heading p {
            margin-top: 7px;
            color: #756E69;
            font-size: 11px;
            line-height: 1.6;
        }

        .manager-count,
        .panel-count {
            display: inline-flex;
            align-items: center;
            margin-left: 7px;
            padding: 5px 9px;
            border: 1px solid #ebe4d8;
            border-radius: 6px;
            background: #faf7f0;
            color: #696b62;
            font-size: 9px;
            font-weight: 700;
            vertical-align: middle;
            white-space: nowrap;
        }

        .manager-panel {
            overflow: hidden;
            border: 1px solid #e9e2d6;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 4px 16px rgba(48, 41, 28, .035);
        }

        .manager-panel-header {
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 14px 20px;
            border-bottom: 1px solid #eee8dd;
        }

        .manager-panel-title {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0;
        }

        .manager-panel-title h2 {
            margin: 0;
            color: #3E3D38;
            font-size: 12px;
            font-weight: 800;
        }

        .manager-search {
            position: relative;
            width: min(255px, 100%);
        }

        .manager-search i {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #909188;
            font-size: 11px;
        }

        .manager-search input {
            width: 100%;
            min-height: 36px;
            padding: 8px 11px 8px 32px;
            border: 1px solid #eae3d8;
            border-radius: 8px;
            background: #faf8f2;
            color: #343831;
            font: inherit;
            font-size: 10px;
        }

        .manager-search input:focus {
            outline: 2px solid rgba(181, 154, 99, .18);
            border-color: #b59a63;
        }

        .manager-table-wrap { width: 100%; overflow-x: auto; }
        .manager-table { width: 100%; min-width: 1080px; border-collapse: collapse; text-align: left; }

        .manager-table th {
            padding: 13px 15px;
            border-bottom: 1px solid #DED6CC;
            background: #F1ECE4;
            color: #756E69;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .3px;
            white-space: nowrap;
        }

        .manager-table td {
            padding: 13px 15px;
            border-bottom: 1px solid #f0ece4;
            color: #343a35;
            font-size: 10px;
            vertical-align: middle;
        }

        .manager-table tbody tr:last-child td { border-bottom: 0; }
        .manager-table tbody tr:hover { background: #fdfcf9; }
        .row-number { width: 48px; color: #27302a; font-weight: 800; text-align: center; }

        .account-cell {
            display: flex;
            align-items: center;
            gap: 11px;
            min-width: 225px;
        }

        .account-avatar {
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #eee5d9;
            border-radius: 50%;
            background: #faf7ee;
            color: #353a32;
            font-size: 11px;
            font-weight: 800;
        }

        .account-name {
            display: block;
            color: #222820;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
        }
        .account-name:hover { color: #803e2f; }

        .account-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 5px;
            color: #89908a;
            font-size: 8px;
        }

        .nis-label {
            padding: 3px 6px;
            border: 1px solid #eee5d9;
            border-radius: 4px;
            background: #faf7f0;
            color: #60655c;
            font-weight: 700;
        }

        .class-cell { min-width: 135px; }
        .class-badge {
            display: inline-flex;
            padding: 5px 8px;
            border: 1px solid #D8C7A8;
            border-radius: 6px;
            background: #F1ECE4;
            color: #803E2F;
            font-size: 8px;
            font-weight: 800;
            white-space: nowrap;
        }

        .class-sub {
            display: block;
            margin-top: 5px;
            color: #92958b;
            font-size: 8px;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 8px;
            border: 1px solid transparent;
            border-radius: 20px;
            font-size: 8px;
            font-weight: 800;
            white-space: nowrap;
        }
        .status.aktif { border-color: #cce9b4; background: #eef9e6; color: #387222; }
        .status.nonaktif { border-color: #f0dfc7; background: #fff5e8; color: #96521b; }
        .status.unknown { border-color: #e4e3df; background: #f5f4f1; color: #6d6c66; }
        .status i { font-size: 6px; }

        .actions-cell { min-width: 370px; text-align: right; }
        .actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            flex-wrap: nowrap;
        }
        .actions form { margin: 0; }

        .btn-action {
            min-height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 9px;
            border: 1px solid #e2dbcf;
            border-radius: 8px;
            background: #fff;
            color: #31362f;
            font: inherit;
            font-size: 9px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-action:hover { background: #faf8f3; }
        .btn-toggle { border-color: #D8C7A8; background: #F8F4EE; color: #803E2F; }
        .btn-toggle:hover { background: #F1ECE4; }
        .btn-delete { border-color: #f3c7c7; background: #fff5f5; color: #ad3636; }
        .btn-delete:hover { background: #ffebeb; }

        .manager-empty {
            padding: 45px 20px;
            color: #85877e;
            font-size: 10px;
            line-height: 1.7;
            text-align: center;
        }
        .manager-empty i {
            display: block;
            margin-bottom: 11px;
            color: #b5a16f;
            font-size: 24px;
        }
        .manager-empty strong { display: block; margin-bottom: 4px; color: #343a34; font-size: 12px; }

        .manager-alert {
            margin: 13px 20px 0;
            padding: 10px 12px;
            border: 1px solid #cde8d4;
            border-radius: 8px;
            background: #f0faf2;
            color: #3c7149;
            font-size: 10px;
        }
        .manager-alert.alert-danger { border-color: #f2d0d0; background: #fff5f5; color: #a13d3d; }

        .pagination-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 20px;
            border-top: 1px solid #f0ece4;
            color: #697066;
            font-size: 9px;
        }

        .pagination { display: flex; align-items: center; gap: 5px; }
        .pagination a,
        .pagination span {
            min-width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 9px;
            border: 1px solid #eee9df;
            border-radius: 9px;
            background: #fff;
            color: #676a61;
            font-size: 9px;
            font-weight: 700;
            text-decoration: none;
        }
        .pagination .current { border-color: #B59A63; background: #B59A63; color: #3E3D38; box-shadow: 0 4px 10px rgba(84, 37, 31, .12); }
        .pagination .disabled { color: #c6c7c1; pointer-events: none; }
        .pagination .ellipsis { border-color: transparent; background: transparent; }

        .footer {
            margin-top: 24px;
            color: #8b8b82;
            font-size: 9px;
            text-align: center;
        }

        @media (max-width: 700px) {
            .admin-strip { min-height: 56px; margin: -20px -15px 20px; padding: 0 15px; }
            .admin-identity > span:last-child { display: none; }
            .manager-heading h1 { font-size: 21px; }
            .manager-panel-header { align-items: flex-start; flex-direction: column; padding: 15px; }
            .manager-search { width: 100%; }
            .pagination-footer { align-items: flex-start; flex-direction: column; padding: 12px 15px; }
        }
    </style>
</head>

<body>

    @include('partials.sidebar-super-admin')

    <main class="main">
        <div class="admin-strip">
            <div class="admin-identity">
                <span class="admin-role">ADMINISTRATOR</span>
                <span>Pengaturan Sistem &amp; Hak Akses</span>
            </div>
            <div class="admin-actions">
                <span class="admin-icon" aria-hidden="true"><i class="fa-regular fa-bell"></i></span>
                <span class="admin-date">
                    <i class="fa-regular fa-calendar"></i>
                    {{ now()->translatedFormat('d M Y') }}
                </span>
            </div>
        </div>

        <header class="manager-heading">
            <h1>
                Master Bendahara Kelas
                <span class="manager-count">Total {{ number_format($totalBendahara, 0, ',', '.') }} Bendahara</span>
            </h1>
            <p>Manajemen data penugasan bendahara kelas. Anda dapat mengedit, menghapus, atau menonaktifkan akun bendahara.</p>
        </header>

        <section class="manager-panel">
            <div class="manager-panel-header">
                <div class="manager-panel-title">
                    <h2>Data Bendahara Kelas</h2>
                    <span class="panel-count">{{ number_format($bendahara->total(), 0, ',', '.') }} Bendahara</span>
                </div>

                <form action="{{ route('super-admin.bendahara.index') }}" method="GET" class="manager-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari bendahara / kelas..."
                        aria-label="Cari bendahara atau kelas"
                    >
                </form>
            </div>

            @if (session('success'))
                <div class="manager-alert">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="manager-alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="manager-table-wrap">
                <table class="manager-table">
                    <thead>
                        <tr>
                            <th class="row-number">NO</th>
                            <th>BENDAHARA</th>
                            <th>KELAS DIKELOLA</th>
                            <th>NO. TELEPON / WA</th>
                            <th>STATUS</th>
                            <th class="actions-cell">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bendahara as $item)
                            @php
                                $status = $item->user?->status ?? 'tidak diketahui';
                            @endphp
                            <tr>
                                <td class="row-number">{{ ($bendahara->firstItem() ?? 1) + $loop->index }}</td>
                                <td>
                                    <div class="account-cell">
                                        <span class="account-avatar">{{ mb_strtoupper(mb_substr($item->nama ?: 'B', 0, 1)) }}</span>
                                        <div>
                                            <a href="{{ route('super-admin.bendahara.show', $item->id) }}" class="account-name">
                                                {{ $item->nama }}
                                            </a>
                                            <div class="account-meta">
                                                @if($item->nis)
                                                    <span class="nis-label">NIS: {{ $item->nis }}</span>
                                                @endif
                                                <span>{{ $item->user?->email ?: 'Email belum tersedia' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="class-cell">
                                    @if($item->kelas)
                                        <span class="class-badge">{{ $item->kelas->kode_kelas }}</span>
                                        <span class="class-sub">Wali: {{ $item->kelas->waliKelas?->nama ?: 'Belum ditentukan' }}</span>
                                    @else
                                        <span class="class-sub">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td>{{ $item->no_hp ?: '-' }}</td>
                                <td>
                                    <span class="status {{ $status === 'aktif' ? 'aktif' : ($status === 'nonaktif' ? 'nonaktif' : 'unknown') }}">
                                        <i class="fa-solid fa-circle"></i>
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <div class="actions">
                                        @if ($item->user)
                                            <form
                                                action="{{ route('super-admin.bendahara.toggle-status', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin {{ $status === 'aktif' ? 'menonaktifkan' : 'mengaktifkan' }} akun Bendahara ini?')"
                                            >
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-action btn-toggle" aria-label="{{ $status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} {{ $item->nama }}">
                                                    <i class="fa-solid fa-ban"></i>
                                                    {{ $status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                        @endif

                                        <a
                                            href="{{ route('super-admin.bendahara.edit', $item->id) }}"
                                            class="btn-action"
                                            aria-label="Edit akun {{ $item->nama }}"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                            Edit Akun
                                        </a>

                                        <form
                                            action="{{ route('super-admin.bendahara.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Data Bendahara dan akunnya akan dihapus jika tidak memiliki riwayat transaksi. Lanjutkan?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" aria-label="Hapus {{ $item->nama }}">
                                                <i class="fa-regular fa-trash-can"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="manager-empty">
                                        <i class="fa-solid fa-users"></i>
                                        <strong>{{ $search !== '' ? 'Bendahara tidak ditemukan' : 'Belum ada data bendahara' }}</strong>
                                        {{ $search !== '' ? 'Coba kata kunci lain.' : 'Data akan muncul setelah akun bendahara dibuat.' }}
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-footer">
                <span>
                    Menampilkan {{ $bendahara->firstItem() ?? 0 }} s/d {{ $bendahara->lastItem() ?? 0 }}
                    dari {{ $bendahara->total() }} bendahara
                </span>
                @if($bendahara->hasPages())
                    @php
                        $startPage = max(1, $bendahara->currentPage() - 1);
                        $endPage = min($bendahara->lastPage(), $bendahara->currentPage() + 1);
                    @endphp
                    <nav class="pagination" aria-label="Halaman daftar bendahara">
                        @if($bendahara->onFirstPage())
                            <span class="disabled">Sebelum</span>
                        @else
                            <a href="{{ $bendahara->previousPageUrl() }}">Sebelum</a>
                        @endif

                        @if($startPage > 1)
                            <a href="{{ $bendahara->url(1) }}">1</a>
                            @if($startPage > 2)<span class="ellipsis">…</span>@endif
                        @endif

                        @for($page = $startPage; $page <= $endPage; $page++)
                            @if($page === $bendahara->currentPage())
                                <span class="current" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $bendahara->url($page) }}">{{ $page }}</a>
                            @endif
                        @endfor

                        @if($endPage < $bendahara->lastPage())
                            @if($endPage < $bendahara->lastPage() - 1)<span class="ellipsis">…</span>@endif
                            <a href="{{ $bendahara->url($bendahara->lastPage()) }}">{{ $bendahara->lastPage() }}</a>
                        @endif

                        @if($bendahara->hasMorePages())
                            <a href="{{ $bendahara->nextPageUrl() }}">Lanjut</a>
                        @else
                            <span class="disabled">Lanjut</span>
                        @endif
                    </nav>
                @else
                    <div class="pagination">
                        <span class="disabled">Sebelum</span>
                        <span class="current" aria-current="page">{{ $bendahara->currentPage() }}</span>
                        <span class="disabled">Lanjut</span>
                    </div>
                @endif
            </div>
        </section>

        <footer class="footer">
            MYCASH &copy; {{ date('Y') }} — Smart Class Finance
        </footer>

    </main>

    {{-- POP-UP JIKA PENGHAPUSAN DITOLAK --}}
    @if (session('delete_blocked'))
        <div class="modal-overlay" id="deleteBlockedModal">
            <div class="modal-box">

                <div class="modal-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>

                <h2>Tidak Dapat Dihapus</h2>

                <span class="modal-label">Data Terpilih</span>

                <div class="selected-name">
                    {{ session('delete_blocked.nama') }}
                </div>

                <div class="reason-title">Alasan Pembatalan:</div>

                <p class="reason-text">
                    Bendahara
                    <strong>{{ session('delete_blocked.nama') }}</strong>
                    tercatat pernah mencatat
                    <strong>{{ session('delete_blocked.jumlah') }} riwayat transaksi kas</strong>
                    di sistem.

                    <br><br>

                    Untuk menjaga integritas riwayat pembukuan kas,
                    data master yang masih terikat tidak dapat dihapus
                    sebelum data terkait diselesaikan.
                </p>

                <div class="modal-footer">
                    <button type="button"
                            class="btn-close-modal"
                            onclick="closeDeleteBlockedModal()">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    @endif

    <script>
        function closeDeleteBlockedModal() {
            const modal = document.getElementById('deleteBlockedModal');

            if (modal) {
                modal.style.display = 'none';
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDeleteBlockedModal();
            }
        });
    </script>

</body>
</html>
