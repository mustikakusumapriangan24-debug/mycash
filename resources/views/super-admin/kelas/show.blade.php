<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail {{ $kelas->nama_kelas }} - MyCash</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --maroon: #4d0710;
            --gold: #e6c875;
            --background: #f7f5f2;
            --text: #292329;
            --muted: #8b8285;
            --border: #eee7e5;
            --green: #587b42;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .main {
            min-height: 100vh;
            margin-left: 250px;
            padding: 32px;
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
            background: #f1ece4;
            color: var(--maroon);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        .admin-date {
            padding: 8px 11px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: #fff;
        }

        .page-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 21px;
        }

        .page-heading h1 {
            margin: 0;
            color: var(--text);
            font-size: 24px;
            font-weight: 800;
        }

        .page-heading p {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 11px;
        }

        .heading-meta,
        .heading-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .heading-meta { margin-top: 9px; }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 9px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: #fff;
            color: #746b66;
            font-size: 9px;
            font-weight: 700;
        }

        .pill.status-active {
            border-color: #dcebd3;
            background: #eef6e9;
            color: #52723d;
        }

        .pill.status-inactive {
            border-color: #f0dfcf;
            background: #fff3e8;
            color: #8a4c28;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 36px;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: #51484a;
            font: inherit;
            font-size: 10px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
            transition: .18s ease;
        }

        .button:hover { transform: translateY(-1px); }
        .button-primary { border-color: var(--maroon); background: var(--maroon); color: #fff; }
        .button-primary:hover { background: #6b101c; }
        .button-light { background: #faf7f0; }
        .button-danger { border-color: #f0dfdf; background: #fff7f7; color: #a13e3e; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-card,
        .panel {
            border: 1px solid #eee5dc;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 5px 20px rgba(77, 7, 16, .035);
        }

        .stat-card { min-width: 0; padding: 17px; }

        .stat-top,
        .stat-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .stat-label,
        .stat-bottom-label {
            color: #8b9683;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .35px;
        }

        .stat-icon {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #eee7da;
            border-radius: 7px;
            background: #fbf8f1;
            color: #75816d;
            font-size: 11px;
        }

        .stat-value {
            display: block;
            margin: 10px 0 11px;
            color: #171719;
            font-size: 21px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .stat-value.expense { color: #d83a2e; }

        .stat-bottom {
            padding-top: 9px;
            border-top: 1px solid #f1ece4;
            color: #77756e;
            font-size: 9px;
        }

        .stat-bottom strong { color: #686962; font-size: 9px; }

        .detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(280px, 1fr);
            align-items: start;
            gap: 18px;
        }

        .panel { overflow: hidden; }
        .panel + .panel { margin-top: 18px; }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 17px;
            border-bottom: 1px solid #eee7dc;
        }

        .panel-header h2 {
            margin: 0;
            color: #292329;
            font-size: 13px;
            font-weight: 800;
        }

        .panel-header p {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .panel-content { padding: 16px; }

        .assignment-form {
            display: flex;
            gap: 7px;
            margin-bottom: 14px;
        }

        .assignment-form select,
        .search-form input {
            min-width: 0;
            min-height: 36px;
            border: 1px solid #e8e1d7;
            border-radius: 8px;
            background: #fff;
            color: var(--text);
            font: inherit;
            font-size: 10px;
        }

        .assignment-form select {
            flex: 1;
            padding: 8px 10px;
        }

        .assignment-form .button { min-height: 36px; }

        .student-tools {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }

        .student-tools > span {
            color: var(--muted);
            font-size: 9px;
        }

        .search-form {
            position: relative;
            width: min(220px, 100%);
        }

        .search-form i {
            position: absolute;
            top: 50%;
            left: 11px;
            transform: translateY(-50%);
            color: #9a9690;
            font-size: 10px;
        }

        .search-form input {
            width: 100%;
            padding: 8px 10px 8px 29px;
        }

        .assignment-form select:focus,
        .search-form input:focus {
            outline: 2px solid rgba(181, 154, 99, .2);
            border-color: #c9ad6b;
        }

        .table-wrap { width: 100%; overflow-x: auto; }
        .student-table { width: 100%; min-width: 620px; border-collapse: collapse; }

        .student-table th {
            padding: 11px 9px;
            border-bottom: 1px solid #eee7dc;
            background: #faf7f0;
            color: #77786f;
            font-size: 8px;
            font-weight: 800;
            letter-spacing: .35px;
            text-align: left;
            white-space: nowrap;
        }

        .student-table td {
            padding: 10px 9px;
            border-bottom: 1px solid #f1ece4;
            color: #5f625e;
            font-size: 9px;
            vertical-align: middle;
        }

        .student-table tbody tr:last-child td { border-bottom: 0; }
        .student-table tbody tr:hover { background: #fdfbf7; }
        .student-number { width: 36px; color: #77786f; text-align: center; }
        .student-nis { color: #313432; font-weight: 700; white-space: nowrap; }
        .student-name { color: #282b29; font-weight: 800; }
        .gender-badge {
            display: inline-flex;
            min-width: 19px;
            align-items: center;
            justify-content: center;
            padding: 4px 5px;
            border-radius: 4px;
            background: #eaf5e2;
            color: #55793d;
            font-size: 8px;
            font-weight: 800;
        }

        .gender-badge.female { background: #fff0ef; color: #a55358; }
        .contact-cell { max-width: 170px; overflow-wrap: anywhere; }
        .contact-cell small { display: block; margin-top: 3px; color: #92918b; font-size: 8px; }

        .remove-form { margin: 0; }
        .remove-button {
            width: 26px;
            height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #8b9384;
            cursor: pointer;
        }
        .remove-button:hover { background: #fff0f0; color: #b94141; }

        .empty-state {
            padding: 30px 14px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.7;
            text-align: center;
        }

        .empty-state i {
            display: block;
            margin-bottom: 9px;
            color: #b8ad97;
            font-size: 22px;
        }

        .pagination-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 13px 16px;
            border-top: 1px solid #f1ece4;
            color: var(--muted);
            font-size: 9px;
        }

        .pagination { display: flex; align-items: center; gap: 4px; }
        .pagination a,
        .pagination span {
            min-width: 27px;
            min-height: 27px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 7px;
            border: 1px solid #eee7dc;
            border-radius: 6px;
            background: #fff;
            color: #625e59;
            font-size: 9px;
            text-decoration: none;
        }
        .pagination .current { border-color: var(--gold); background: var(--gold); color: #3e3d38; font-weight: 800; }
        .pagination .disabled { color: #b5ada5; pointer-events: none; }
        .pagination .ellipsis { border-color: transparent; background: transparent; }

        .alert {
            margin: 14px 16px 0;
            padding: 10px 12px;
            border: 1px solid #b9e5c9;
            border-radius: 8px;
            background: #e9f7ef;
            color: #236c46;
            font-size: 10px;
            line-height: 1.6;
        }
        .alert-error {
            border-color: #f0caca;
            background: #fff4f4;
            color: #9b3535;
        }
        .alert ul { margin: 5px 0 0 17px; }

        .teacher-row {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .avatar {
            width: 39px;
            height: 39px;
            flex: 0 0 39px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #eee5d9;
            border-radius: 11px;
            background: #faf6ed;
            color: var(--maroon);
            font-size: 13px;
            font-weight: 800;
        }

        .person-info { min-width: 0; }
        .person-info strong {
            display: block;
            color: #30312f;
            font-size: 10px;
            font-weight: 800;
        }
        .person-info small {
            display: block;
            margin-top: 4px;
            color: #8a8c84;
            font-size: 8px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .teacher-status {
            padding: 5px 7px;
            border-radius: 5px;
            background: #eef6e9;
            color: #52723d;
            font-size: 8px;
            font-weight: 800;
            white-space: nowrap;
        }

        .cashier-list { display: grid; gap: 8px; }
        .cashier-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px;
            border: 1px solid #eee5d9;
            border-radius: 8px;
            background: #fcfaf6;
        }
        .cashier-number {
            width: 20px;
            height: 20px;
            flex: 0 0 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: #20231d;
            color: #d6eb28;
            font-size: 8px;
            font-weight: 800;
        }
        .cashier-manage {
            min-height: 29px;
            padding: 6px 9px;
            font-size: 9px;
        }

        .config-list { display: grid; gap: 0; }
        .config-item {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 9px 0;
            border-bottom: 1px solid #f0ebe3;
            font-size: 9px;
        }
        .config-item:last-child { border-bottom: 0; }
        .config-item span { color: #84867e; }
        .config-item strong { color: #383a36; text-align: right; }
        .config-item strong.emphasis { color: var(--green); }
        .config-description {
            margin-top: 8px;
            padding: 10px;
            border: 1px solid #f0ebe3;
            border-radius: 7px;
            background: #fcfaf6;
            color: #74756e;
            font-size: 9px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .footer {
            margin: 24px 0 4px;
            color: var(--muted);
            font-size: 9px;
            text-align: center;
        }

        @media (max-width: 1100px) {
            .detail-grid { grid-template-columns: minmax(0, 1.2fr) minmax(260px, 1fr); }
            .main { padding: 25px; }
            .admin-strip { margin: -25px -25px 24px; padding: 0 25px; }
        }

        @media (max-width: 850px) {
            .detail-grid { grid-template-columns: 1fr; }
            .right-column { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
            .right-column .panel + .panel { margin-top: 0; }
            .right-column .panel:last-child { grid-column: 1 / -1; }
        }

        @media (max-width: 700px) {
            .main { margin-left: 0; padding: 20px 15px; }
            .admin-strip { margin: -20px -15px 20px; padding: 0 15px; }
            .page-heading { flex-direction: column; }
            .page-heading h1 { font-size: 21px; }
            .heading-actions { width: 100%; }
            .stats-grid { grid-template-columns: 1fr; gap: 9px; }
            .stat-card { padding: 14px; }
            .right-column { grid-template-columns: 1fr; }
            .right-column .panel:last-child { grid-column: auto; }
            .panel-header { align-items: flex-start; }
            .assignment-form { align-items: stretch; flex-direction: column; }
            .assignment-form .button { width: 100%; }
            .student-tools { align-items: flex-start; flex-direction: column; }
            .search-form { width: 100%; }
            .pagination-footer { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>

<body>
@include('partials.sidebar-super-admin')

<main class="main">
    @php
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $periodUnit = match ($kelas->tipe_periode) {
            'Mingguan' => 'minggu',
            'Tahunan' => 'tahun',
            default => 'bulan',
        };
        $periodRange = $kelas->tipe_periode === 'Tahunan'
            ? 'Setiap tahun'
            : ($monthNames[(int) ($kelas->bulan_mulai ?? 7)] ?? 'Juli')
                . ' – '
                . ($monthNames[(int) ($kelas->bulan_akhir ?? 6)] ?? 'Juni');
    @endphp

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

    <header class="page-heading">
        <div>
            <h1>{{ $kelas->nama_kelas }}</h1>
            <div class="heading-meta">
                <span class="pill">{{ $kelas->kode_kelas }}</span>
                <span class="pill {{ $kelas->status === 'aktif' ? 'status-active' : 'status-inactive' }}">
                    {{ ucfirst($kelas->status) }}
                </span>
            </div>
            <p>Tahun Ajaran: <strong>{{ $kelas->tahun_ajaran ?: '-' }}</strong></p>
        </div>
        <div class="heading-actions">
            <a href="{{ route('super-admin.kelas.index') }}" class="button button-light">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Kelas
            </a>
            <a href="{{ route('super-admin.kelas.edit', $kelas->id) }}" class="button">
                <i class="fa-solid fa-pen"></i>
                Edit Kelas
            </a>
        </div>
    </header>

    @if (session('success'))
        <div class="alert"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
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

    <section class="stats-grid" aria-label="Ringkasan kelas">
        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-label">TOTAL SISWA</span>
                <span class="stat-icon"><i class="fa-solid fa-users"></i></span>
            </div>
            <strong class="stat-value">{{ number_format($kelas->students_count, 0, ',', '.') }} <small style="font-size:10px;font-weight:600">Siswa</small></strong>
            <div class="stat-bottom">
                <span>{{ number_format($kelas->male_students_count, 0, ',', '.') }} Laki-laki</span>
                <strong>{{ number_format($kelas->female_students_count, 0, ',', '.') }} Perempuan</strong>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-label">TOTAL PEMASUKAN</span>
                <span class="stat-icon"><i class="fa-solid fa-arrow-up"></i></span>
            </div>
            <strong class="stat-value">Rp {{ number_format((float) $totalPemasukan, 0, ',', '.') }}</strong>
            <div class="stat-bottom">
                <span class="stat-bottom-label">TARIF</span>
                <strong>
                    @if($kelas->nominal_standar !== null)
                        Rp {{ number_format((float) $kelas->nominal_standar, 0, ',', '.') }}/{{ $periodUnit }}
                    @else
                        Belum ditentukan
                    @endif
                </strong>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-label">TOTAL PENGELUARAN</span>
                <span class="stat-icon" style="color:#d83a2e"><i class="fa-solid fa-arrow-down"></i></span>
            </div>
            <strong class="stat-value expense">Rp {{ number_format((float) $totalPengeluaran, 0, ',', '.') }}</strong>
            <div class="stat-bottom">
                <span class="stat-bottom-label">MUTASI</span>
                <strong>{{ number_format($totalTransaksiPengeluaran, 0, ',', '.') }} Transaksi</strong>
            </div>
        </article>
    </section>

    <div class="detail-grid">
        <section class="panel">
            <div class="panel-header">
                <div>
                    <h2>Data Siswa Terdaftar</h2>
                    <p>Daftar siswa resmi yang berada di rombel {{ $kelas->nama_kelas }}.</p>
                </div>
            </div>

            <div class="panel-content">
                @if($unassignedStudents->isNotEmpty())
                    <form
                        action="{{ route('super-admin.kelas.students.store', $kelas->id) }}"
                        method="POST"
                        class="assignment-form"
                    >
                        @csrf
                        <select name="student_id" required aria-label="Pilih siswa yang akan ditempatkan">
                            <option value="">Pilih siswa yang belum ditempatkan...</option>
                            @foreach($unassignedStudents as $unassignedStudent)
                                <option value="{{ $unassignedStudent->id }}" @selected(old('student_id') == $unassignedStudent->id)>
                                    {{ $unassignedStudent->name }}{{ $unassignedStudent->nis ? ' · ' . $unassignedStudent->nis : '' }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="button button-primary">
                            <i class="fa-solid fa-plus"></i>
                            Tempatkan Siswa
                        </button>
                    </form>
                @else
                    <div class="empty-state" style="padding:10px;margin-bottom:12px;border:1px solid #eee7dc;border-radius:8px">
                        Semua data siswa sudah ditempatkan di kelas atau belum tersedia.
                    </div>
                @endif

                <div class="student-tools">
                    <span>Menampilkan {{ $students->firstItem() ?? 0 }}–{{ $students->lastItem() ?? 0 }} dari {{ $students->total() }} siswa</span>
                    <form action="{{ route('super-admin.kelas.show', $kelas->id) }}" method="GET" class="search-form">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input
                            type="search"
                            name="student_search"
                            value="{{ $studentSearch }}"
                            placeholder="Cari nama, NIS, kontak..."
                            aria-label="Cari siswa di kelas"
                        >
                    </form>
                </div>

                <div class="table-wrap">
                    <table class="student-table">
                        <thead>
                            <tr>
                                <th class="student-number">NO</th>
                                <th>NIS</th>
                                <th>NAMA LENGKAP</th>
                                <th>L/P</th>
                                <th>KONTAK / EMAIL</th>
                                <th aria-label="Aksi"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td class="student-number">{{ ($students->firstItem() ?? 1) + $loop->index }}</td>
                                    <td class="student-nis">{{ $student->nis ?: '-' }}</td>
                                    <td class="student-name">{{ $student->name }}</td>
                                    <td>
                                        <span class="gender-badge {{ $student->gender === 'P' ? 'female' : '' }}">
                                            {{ $student->gender ?: '-' }}
                                        </span>
                                    </td>
                                    <td class="contact-cell">
                                        {{ $student->phone ?: ($student->user?->email ?: '-') }}
                                        @if($student->phone && $student->user?->email)
                                            <small>{{ $student->user->email }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <form
                                            action="{{ route('super-admin.kelas.students.destroy', [$kelas->id, $student->id]) }}"
                                            method="POST"
                                            class="remove-form"
                                            onsubmit="return confirm('Lepaskan siswa ini dari kelas?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="student_search" value="{{ $studentSearch }}">
                                            <button type="submit" class="remove-button" title="Lepaskan dari kelas" aria-label="Lepaskan {{ $student->name }} dari kelas">
                                                <i class="fa-solid fa-link-slash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fa-solid fa-user-graduate"></i>
                                            {{ $studentSearch !== '' ? 'Tidak ada siswa yang cocok dengan pencarian.' : 'Belum ada siswa yang ditempatkan di kelas ini.' }}
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($students->hasPages())
                @php
                    $startPage = max(1, $students->currentPage() - 1);
                    $endPage = min($students->lastPage(), $students->currentPage() + 1);
                @endphp
                <div class="pagination-footer">
                    <span>Halaman {{ $students->currentPage() }} dari {{ $students->lastPage() }}</span>
                    <nav class="pagination" aria-label="Halaman daftar siswa">
                        @if($students->onFirstPage())
                            <span class="disabled" aria-disabled="true">‹</span>
                        @else
                            <a href="{{ $students->previousPageUrl() }}" aria-label="Halaman sebelumnya">‹</a>
                        @endif

                        @if($startPage > 1)
                            <a href="{{ $students->url(1) }}">1</a>
                            @if($startPage > 2)
                                <span class="ellipsis">…</span>
                            @endif
                        @endif

                        @for($page = $startPage; $page <= $endPage; $page++)
                            @if($page === $students->currentPage())
                                <span class="current" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $students->url($page) }}">{{ $page }}</a>
                            @endif
                        @endfor

                        @if($endPage < $students->lastPage())
                            @if($endPage < $students->lastPage() - 1)
                                <span class="ellipsis">…</span>
                            @endif
                            <a href="{{ $students->url($students->lastPage()) }}">{{ $students->lastPage() }}</a>
                        @endif

                        @if($students->hasMorePages())
                            <a href="{{ $students->nextPageUrl() }}" aria-label="Halaman berikutnya">›</a>
                        @else
                            <span class="disabled" aria-disabled="true">›</span>
                        @endif
                    </nav>
                </div>
            @endif
        </section>

        <aside class="right-column">
            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Wali Kelas Pembina</h2>
                    </div>
                    @if($kelas->waliKelas)
                        <span class="teacher-status">Ditugaskan</span>
                    @endif
                    <a href="{{ route('super-admin.kelas.edit', $kelas->id) }}" class="button button-light" style="min-height:29px;padding:6px 8px;font-size:9px">
                        Ganti Wali
                    </a>
                </div>
                <div class="panel-content">
                    @if($kelas->waliKelas)
                        <div class="teacher-row">
                            <span class="avatar">{{ mb_strtoupper(mb_substr($kelas->waliKelas->nama, 0, 1)) }}</span>
                            <div class="person-info">
                                <strong>{{ $kelas->waliKelas->nama }}</strong>
                                <small>NIP: {{ $kelas->waliKelas->nip ?: '-' }}</small>
                                @if($kelas->waliKelas->no_hp)
                                    <small><i class="fa-solid fa-phone"></i> {{ $kelas->waliKelas->no_hp }}</small>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="empty-state" style="padding:8px">Belum ada wali kelas yang ditugaskan.</div>
                    @endif
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Bendahara Kas Kelas</h2>
                        <p>{{ $kelas->bendahara->count() }} bendahara penanggung jawab</p>
                    </div>
                    <a href="{{ route('super-admin.bendahara.index') }}" class="button button-primary cashier-manage">
                        <i class="fa-solid fa-gear"></i>
                        Kelola
                    </a>
                </div>
                <div class="panel-content">
                    @if($kelas->bendahara->isNotEmpty())
                        <div class="cashier-list">
                            @foreach($kelas->bendahara as $bendahara)
                                <div class="cashier-item">
                                    <span class="cashier-number">{{ $loop->iteration }}</span>
                                    <div class="person-info">
                                        <strong>{{ $bendahara->nama }}</strong>
                                        <small>{{ $bendahara->user?->email ?: ($bendahara->nis ?: 'Email/NIS belum tersedia') }}</small>
                                        @if($bendahara->user?->email && $bendahara->nis)
                                            <small>NIS: {{ $bendahara->nis }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state" style="padding:8px">Belum ada bendahara yang ditugaskan.</div>
                    @endif
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Konfigurasi Kelas</h2>
                        <p>Pengaturan rombel dan periode pembayaran.</p>
                    </div>
                </div>
                <div class="panel-content">
                    <div class="config-list">
                        <div class="config-item">
                            <span>Tahun Ajaran</span>
                            <strong>{{ $kelas->tahun_ajaran ?: '-' }}</strong>
                        </div>
                        <div class="config-item">
                            <span>Tarif Iuran Standar</span>
                            <strong class="{{ $kelas->nominal_standar !== null ? 'emphasis' : '' }}">
                                {{ $kelas->nominal_standar !== null ? 'Rp ' . number_format((float) $kelas->nominal_standar, 0, ',', '.') : 'Belum ditentukan' }}
                            </strong>
                        </div>
                        <div class="config-item">
                            <span>Tipe Periode</span>
                            <strong>{{ $kelas->tipe_periode }}</strong>
                        </div>
                        <div class="config-item">
                            <span>Periode Pembayaran</span>
                            <strong>{{ $periodRange }}</strong>
                        </div>
                        <div class="config-item">
                            <span>Status Kelas</span>
                            <strong>{{ ucfirst($kelas->status) }}</strong>
                        </div>
                    </div>
                    @if($kelas->keterangan)
                        <div class="config-description">{{ $kelas->keterangan }}</div>
                    @endif
                </div>
            </section>
        </aside>
    </div>

    <footer class="footer">MYCASH &copy; {{ date('Y') }} — Smart Class Finance</footer>
</main>
</body>
</html>
