<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bendahara - MyCash</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #F7F4EF;
            color: #3E3D38;
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .main {
            margin-left: 250px;
            padding: 32px;
            min-height: 100vh;
        }

        .page-header { margin-bottom: 22px; }
        .eyebrow {
            color: #B59A63;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        h1 {
            margin: 8px 0;
            color: #803E2F;
            font-size: 25px;
        }

        .page-header p,
        .panel-header p {
            margin: 0;
            color: #756E69;
            font-size: 12px;
            line-height: 1.7;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            color: #803E2F;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
        }

        .panel {
            max-width: 850px;
            overflow: hidden;
            border: 1px solid #DED6CC;
            border-radius: 15px;
            background: #FFFEFC;
            box-shadow: 0 5px 20px rgba(84,37,31,.05);
        }

        .panel-header {
            padding: 22px 25px;
            border-bottom: 1px solid #DED6CC;
        }

        .panel-header h2 {
            margin: 0 0 6px;
            color: #803E2F;
            font-size: 14px;
        }

        .form-body { padding: 24px 25px; }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group { min-width: 0; }
        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #3E3D38;
            font-size: 11px;
            font-weight: 700;
        }

        .form-control,
        .form-select {
            width: 100%;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid #DED6CC;
            border-radius: 9px;
            background: #FFFEFC;
            color: #3E3D38;
            font: inherit;
            font-size: 12px;
        }

        .form-control:focus,
        .form-select:focus {
            outline: 2px solid rgba(181,154,99,.25);
            border-color: #B59A63;
        }

        .alert-error {
            margin: 20px 25px 0;
            padding: 13px 15px;
            border: 1px solid #f0c4c4;
            border-radius: 9px;
            background: #fff0f0;
            color: #9b3030;
            font-size: 11px;
            line-height: 1.7;
        }

        .alert-error ul { margin: 5px 0 0; padding-left: 18px; }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            margin-top: 24px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 40px;
            padding: 9px 14px;
            border: 0;
            border-radius: 9px;
            font: inherit;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .button-light {
            border: 1px solid #DED6CC;
            background: #F1ECE4;
            color: #3E3D38;
        }

        .button-primary {
            background: #803E2F;
            color: #FFFEFC;
        }

        @media (max-width: 700px) {
            .main { margin-left: 0; padding: 20px 15px; }
            .form-grid { grid-template-columns: 1fr; gap: 14px; }
            .form-body { padding: 20px 16px; }
            .panel-header { padding: 18px 16px; }
            .form-actions { flex-direction: column-reverse; }
            .button { width: 100%; }
        }
    </style>
</head>
<body>
    @include('partials.sidebar-super-admin')

    <main class="main">
        <a href="{{ route('super-admin.bendahara.index') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke daftar bendahara
        </a>

        <header class="page-header">
            <div class="eyebrow">Panel Administrasi Utama</div>
            <h1>Edit Data Bendahara</h1>
            <p>Perbarui informasi akun dan penugasan bendahara.</p>
        </header>

        <section class="panel">
            <div class="panel-header">
                <h2>Informasi Bendahara</h2>
                <p>Perubahan akan diterapkan pada profil bendahara terkait.</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <strong>Data belum berhasil disimpan.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('super-admin.bendahara.update', $bendahara->id) }}"
                method="POST"
                class="form-body"
            >
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama">Nama Bendahara</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            class="form-control"
                            value="{{ old('nama', $bendahara->nama) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input
                            type="text"
                            id="nis"
                            name="nis"
                            class="form-control"
                            value="{{ old('nis', $bendahara->nis) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="no_hp">Nomor Telepon / WhatsApp</label>
                        <input
                            type="text"
                            id="no_hp"
                            name="no_hp"
                            class="form-control"
                            value="{{ old('no_hp', $bendahara->no_hp) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">Email Akun</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $bendahara->user?->email) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="kelas_id">Kelas</label>
                        <select id="kelas_id" name="kelas_id" class="form-select">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $item)
                                <option
                                    value="{{ $item->id }}"
                                    {{ (string) old('kelas_id', $bendahara->kelas_id) === (string) $item->id ? 'selected' : '' }}
                                >
                                    {{ $item->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('super-admin.bendahara.index') }}" class="button button-light">
                        Batal
                    </a>
                    <button type="submit" class="button button-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
