<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Bendahara - MyCash</title>

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

        /* MAIN CONTENT */
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

        /* TABLE PANEL */
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
        }

        th {
            padding: 16px 22px;
            background: #fcf8f2;
            color: #78666b;
            font-size: 11px;
            white-space: nowrap;
        }

        td {
            padding: 17px 22px;
            border-top: 1px solid #f1ece6;
            font-size: 12px;
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

        .btn-detail {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            background: var(--maroon);
            color: white;
            text-decoration: none;
            font-size: 10px;
            font-weight: 700;
        }

        .btn-detail:hover {
            background: #6b101c;
            color: var(--gold);
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

        /* RESPONSIVE */
        @media (max-width: 700px) {
            .main {
                margin-left: 0;
                padding: 20px 15px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR BERSAMA --}}
    @include('partials.sidebar-super-admin')

    <main class="main">

        <header class="topbar">

            <div>
                <div class="eyebrow">Panel Administrasi Utama</div>
                <h1>Kelola Bendahara</h1>
                <p>
                    Lihat daftar dan informasi akun Bendahara
                    yang terdaftar di MyCash.
                </p>
            </div>

            <div class="role">
                <i class="fa-solid fa-user-shield"></i>
                SUPER ADMIN
            </div>

        </header>

        <section class="panel">

            <div class="panel-header">
                <h2>Daftar Bendahara</h2>
                <p>
                    Informasi bendahara, kelas yang dikelola,
                    nomor telepon, dan status akun.
                </p>
            </div>

            @if (session('success'))
                <div style="padding:15px 22px; color:#236c46; font-size:12px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-wrap">

                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Bendahara</th>
                            <th>Kelas Dikelola</th>
                            <th>No. Telepon / WA</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($bendahara as $item)

                            @php
                                $status = $item->user?->status ?? 'tidak diketahui';
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $item->nama }}</td>

                                <td>
                                    {{ $item->kelas?->kode_kelas ?? 'Belum ditentukan' }}
                                </td>

                                <td>{{ $item->no_hp ?? '-' }}</td>

                                <td>
                                    <span class="status {{ $status === 'aktif' ? 'aktif' : 'nonaktif' }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('super-admin.bendahara.show', $item->id) }}"
                                       class="btn-detail">
                                        <i class="fa-solid fa-eye"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="6">
                                    <div class="empty">
                                        <i class="fa-solid fa-users"></i>

                                        <h3>Belum Ada Data Bendahara</h3>

                                        <p>
                                            Data bendahara belum tersedia.<br>
                                            Data akan muncul setelah Wali Kelas membuat akun Bendahara.
                                        </p>
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>

        </section>

        <a href="{{ route('super-admin.dashboard') }}" class="back">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>

        <footer class="footer">
            MYCASH &copy; {{ date('Y') }} — Smart Class Finance
        </footer>

    </main>

</body>
</html>
