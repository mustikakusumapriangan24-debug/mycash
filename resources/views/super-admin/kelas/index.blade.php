<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas - MyCash</title>

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
            min-width: 1050px;
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
            gap: 7px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 10px;
            border-radius: 7px;
            font-family: inherit;
            font-size: 10px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s;
            cursor: pointer;
        }

        .btn-detail {
            background: #f5f0e5;
            color: #80652b;
            border: 1px solid #e9ddc1;
        }

        .btn-detail:hover {
            background: #eadbb7;
        }

        .btn-edit {
            background: var(--maroon);
            color: white;
            border: 1px solid var(--maroon);
        }

        .btn-edit:hover {
            background: #6b101c;
            color: var(--gold);
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

    <header class="topbar">
        <div>
            <div class="eyebrow">Panel Administrasi Utama</div>
            <h1>Data Kelas</h1>
            <p>Kelola dan pantau data kelas yang terdaftar di MyCash.</p>
        </div>

        <div class="role">
            <i class="fa-solid fa-user-shield"></i>
            SUPER ADMIN
        </div>
    </header>

    <section class="panel">

        <div class="panel-header">
            <div>
                <h2>Daftar Kelas</h2>
                <p>Informasi kelas, wali kelas, periode, dan status kelas.</p>
            </div>

            <a href="{{ route('super-admin.kelas.create') }}" class="btn-add">
                <i class="fa-solid fa-plus"></i>
                Tambah Kelas
            </a>
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
                        <th>Kode Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Tipe Periode</th>
                        <th>Nominal Standar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($kelas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="class-code">
                                {{ $item->kode_kelas }}
                            </td>

                            <td>
                                {{ $item->waliKelas?->nama ?? 'Belum ditentukan' }}
                            </td>

                            <td>
                                {{ $item->tipe_periode }}
                            </td>

                            <td>
                                Rp {{ number_format($item->nominal_standar, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="status {{ $item->status === 'aktif' ? 'aktif' : 'nonaktif' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="actions">

                                    <a
                                        href="{{ route('super-admin.kelas.show', $item->id) }}"
                                        class="btn-action btn-detail"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                        Detail
                                    </a>

                                    <a
                                        href="{{ route('super-admin.kelas.edit', $item->id) }}"
                                        class="btn-action btn-edit"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        class="btn-action btn-delete"
                                        onclick="confirmDelete('{{ $item->id }}', @js($item->nama_kelas))"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                        Hapus
                                    </button>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="fa-solid fa-school"></i>
                                    </div>

                                    <h3>Belum Ada Data Kelas</h3>

                                    <p>
                                        Data kelas belum tersedia.<br>
                                        Klik tombol Tambah Kelas untuk mulai mendaftarkan kelas.
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
