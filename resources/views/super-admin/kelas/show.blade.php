<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas - MyCash</title>

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
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .eyebrow {
            color: #987b42;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        h1 {
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

        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
            padding-bottom: 17px;
            border-bottom: 1px solid var(--border);
        }

        .card-header h2 {
            color: var(--maroon);
            font-size: 15px;
        }

        .card-header p {
            color: var(--muted);
            font-size: 11px;
            margin-top: 6px;
        }

        .class-heading {
            display: flex;
            align-items: center;
            gap: 17px;
        }

        .class-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: #f8f1e3;
            color: var(--maroon);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .class-heading h2 {
            color: var(--maroon);
            font-size: 20px;
        }

        .class-heading p {
            margin-top: 6px;
            color: var(--muted);
            font-size: 12px;
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
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

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .info-item {
            padding: 15px;
            background: #fcfaf7;
            border: 1px solid #f0eae2;
            border-radius: 10px;
        }

        .info-item label {
            display: block;
            margin-bottom: 9px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .info-item p {
            color: var(--text);
            font-size: 13px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .description {
            margin-top: 20px;
        }

        .description label {
            display: block;
            margin-bottom: 9px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .description p {
            padding: 15px;
            background: #fcfaf7;
            border: 1px solid #f0eae2;
            border-radius: 10px;
            font-size: 12px;
            line-height: 1.8;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 17px;
            border-radius: 9px;
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            transition: .2s;
        }

        .btn-edit {
            background: var(--maroon);
            color: white;
        }

        .btn-edit:hover {
            background: #6b101c;
            color: var(--gold);
        }

        .btn-back {
            background: #f5f0e5;
            color: #80652b;
            border: 1px solid #e9ddc1;
        }

        .btn-back:hover {
            background: #eadbb7;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: var(--muted);
            font-size: 10px;
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

            .info-grid {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 18px;
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
            <h1>Detail Kelas</h1>
            <p>Informasi lengkap kelas yang terdaftar di MyCash.</p>
        </div>

        <div class="role">
            <i class="fa-solid fa-user-shield"></i>
            SUPER ADMIN
        </div>
    </header>

    <section class="card">

        <div class="class-heading">
            <div class="class-icon">
                <i class="fa-solid fa-school"></i>
            </div>

            <div>
                <h2>{{ $kelas->nama_kelas }}</h2>
                <p>{{ $kelas->kode_kelas }}</p>
            </div>
        </div>

    </section>

    <section class="card">

        <div class="card-header">
            <div>
                <h2><i class="fa-solid fa-circle-info"></i> Informasi Kelas</h2>
                <p>Informasi identitas dan konfigurasi kelas.</p>
            </div>

            <span class="status {{ $kelas->status === 'aktif' ? 'aktif' : 'nonaktif' }}">
                {{ ucfirst($kelas->status) }}
            </span>
        </div>

        <div class="info-grid">

            <div class="info-item">
                <label>Nama Kelas</label>
                <p>{{ $kelas->nama_kelas }}</p>
            </div>

            <div class="info-item">
                <label>Kode Kelas</label>
                <p>{{ $kelas->kode_kelas }}</p>
            </div>

            <div class="info-item">
                <label>Tahun Ajaran</label>
                <p>{{ $kelas->tahun_ajaran }}</p>
            </div>

            <div class="info-item">
                <label>Wali Kelas</label>
                <p>{{ $kelas->waliKelas?->nama ?? 'Belum ditentukan' }}</p>
            </div>

            <div class="info-item">
                <label>Tipe Periode</label>
                <p>{{ $kelas->tipe_periode }}</p>
            </div>

            <div class="info-item">
                <label>Nominal Standar</label>
                <p>Rp {{ number_format($kelas->nominal_standar, 0, ',', '.') }}</p>
            </div>

        </div>

        <div class="description">
            <label>Keterangan</label>
            <p>
                {{ $kelas->keterangan ?: 'Belum ada keterangan untuk kelas ini.' }}
            </p>
        </div>

        <div class="actions">

            <a
                href="{{ route('super-admin.kelas.edit', $kelas->id) }}"
                class="btn btn-edit"
            >
                <i class="fa-solid fa-pen-to-square"></i>
                Edit Kelas
            </a>

            <a
                href="{{ route('super-admin.kelas.index') }}"
                class="btn btn-back"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Daftar Kelas
            </a>

        </div>

    </section>

    <footer class="footer">
        MYCASH &copy; {{ date('Y') }} — Smart Class Finance
    </footer>

</main>

</body>
</html>
