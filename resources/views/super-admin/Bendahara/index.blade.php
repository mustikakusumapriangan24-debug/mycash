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
    </style>
</head>

<body>

    @include('partials.sidebar-super-admin')

    <main class="main">

        <header class="topbar">
            <div>
                <div class="eyebrow">Panel Administrasi Utama</div>
                <h1>Kelola Bendahara</h1>
                <p>
                    Lihat dan kelola informasi akun Bendahara
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
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
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

                                <td>
                                    <strong>{{ $item->nama }}</strong>
                                </td>

                                <td>
                                    {{ $item->kelas?->kode_kelas ?? 'Belum ditentukan' }}
                                </td>

                                <td>{{ $item->no_hp ?? '-' }}</td>

                                <td>
                                    <span class="status
                                        {{ $status === 'aktif' ? 'aktif' : ($status === 'nonaktif' ? 'nonaktif' : 'unknown') }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="actions">

                                        <a href="{{ route('super-admin.bendahara.show', $item->id) }}"
                                           class="btn-action btn-detail">
                                            <i class="fa-solid fa-eye"></i>
                                            Detail
                                        </a>

                                        <a href="{{ route('super-admin.bendahara.edit', $item->id) }}"
                                           class="btn-action btn-edit">
                                            <i class="fa-solid fa-pen"></i>
                                            Edit
                                        </a>

                                        @if ($item->user)
                                            <form action="{{ route('super-admin.bendahara.toggle-status', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin mengubah status akun Bendahara ini?')">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="btn-action btn-toggle {{ $status === 'aktif' ? 'nonaktif-btn' : '' }}">
                                                    @if ($status === 'aktif')
                                                        <i class="fa-solid fa-ban"></i>
                                                        Nonaktifkan
                                                    @else
                                                        <i class="fa-solid fa-check"></i>
                                                        Aktifkan
                                                    @endif
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('super-admin.bendahara.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('PERINGATAN: Data Bendahara dan akun penggunanya akan dihapus jika tidak memiliki riwayat transaksi. Yakin ingin melanjutkan?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-action btn-delete">
                                                <i class="fa-solid fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
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
