<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kelas Baru - MyCash</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 35px 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8f5f1;
            color: #302329;
        }

        .container { max-width: 950px; margin: auto; }

        .back {
            display: inline-block;
            margin-bottom: 24px;
            color: #4d0710;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .eyebrow {
            color: #ad873f;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        h1 {
            margin: 8px 0;
            color: #4d0710;
            font-size: 27px;
        }

        .subtitle {
            margin: 0 0 28px;
            color: #81757a;
            font-size: 13px;
            line-height: 1.7;
        }

        .card {
            margin-bottom: 22px;
            padding: 28px;
            border: 1px solid #eee5d9;
            border-radius: 16px;
            background: white;
            box-shadow: 0 8px 28px rgba(57,19,27,.04);
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 25px;
        }

        .number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 11px;
            color: white;
            background: #4d0710;
            font-weight: 800;
        }

        .section-heading h2 {
            margin: 0 0 5px;
            color: #4d0710;
            font-size: 16px;
        }

        .section-heading p {
            margin: 0;
            color: #95888b;
            font-size: 11px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group { margin-bottom: 19px; }
        .full { grid-column: 1 / -1; }

        label {
            display: block;
            margin-bottom: 9px;
            color: #4d0710;
            font-size: 12px;
            font-weight: 700;
        }

        .required { color: #b42d36; }

        input, select, textarea {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #e8dfd6;
            border-radius: 9px;
            outline: none;
            background: #fffdfb;
            font-family: inherit;
            font-size: 12px;
        }

        textarea {
            min-height: 85px;
            resize: vertical;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #b48b42;
            box-shadow: 0 0 0 3px rgba(230,200,117,.15);
        }

        .hint {
            margin-top: 7px;
            color: #95888b;
            font-size: 10px;
            line-height: 1.6;
        }

        .info {
            display: flex;
            gap: 12px;
            padding: 17px;
            border: 1px solid #ead9aa;
            border-radius: 11px;
            background: #fffaf0;
            color: #705a2d;
            font-size: 11px;
            line-height: 1.7;
        }

        .info strong {
            display: block;
            margin-bottom: 4px;
            color: #604615;
        }

        .mode-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 22px;
        }

        .mode-option { position: relative; }

        .mode-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .mode-option label {
            display: block;
            height: 100%;
            margin: 0;
            padding: 17px 12px;
            border: 1px solid #e8dfd6;
            border-radius: 11px;
            background: #fffdfb;
            cursor: pointer;
            transition: .2s;
        }

        .mode-option input:checked + label {
            border: 1.5px solid #ad873f;
            background: #fffaf0;
            box-shadow: 0 0 0 2px rgba(230,200,117,.12);
        }

        .mode-option strong {
            display: block;
            margin-bottom: 6px;
            color: #4d0710;
            font-size: 11px;
        }

        .mode-option span {
            display: block;
            color: #95888b;
            font-size: 10px;
            font-weight: 400;
            line-height: 1.5;
        }

        .teacher-panel {
            padding: 20px;
            border: 1px solid #eee5d9;
            border-radius: 12px;
            background: #fffdfb;
        }

        .teacher-panel h3 {
            margin: 0 0 18px;
            color: #4d0710;
            font-size: 13px;
        }

        .hidden { display: none !important; }

        .error {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
            background: #fff0f0;
            color: #a12828;
            font-size: 12px;
        }

        .error ul { margin-bottom: 0; }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
        }

        .btn {
            padding: 13px 21px;
            border: none;
            border-radius: 9px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-cancel {
            color: #4d0710;
            background: #f4eee9;
        }

        .btn-save {
            color: white;
            background: #4d0710;
        }

        .btn-save:hover { background: #68101c; }

        @media(max-width:650px) {
            body { padding: 22px 13px; }
            .card { padding: 20px; }
            .form-grid { grid-template-columns: 1fr; gap: 0; }
            .full { grid-column: auto; }
            .mode-grid { grid-template-columns: 1fr; }
            .actions { flex-direction: column-reverse; }
            .btn { text-align: center; }
        }
    </style>
</head>

<body>
<div class="container">

    <a href="{{ route('super-admin.kelas.index') }}" class="back">
        ← Kembali ke Data Kelas
    </a>

    <div class="eyebrow">ADMINISTRATOR</div>
    <h1>Tambah Rombel Kelas Baru</h1>
    <p class="subtitle">
        Daftarkan identitas rombongan belajar kelas dan tentukan
        penugasan guru wali kelas pembina.
    </p>

    @if ($errors->any())
        <div class="error">
            <strong>Periksa kembali data yang kamu masukkan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('super-admin.kelas.store') }}" method="POST">
        @csrf

        <!-- IDENTITAS KELAS -->
        <div class="card">
            <div class="section-heading">
                <div class="number">1</div>
                <div>
                    <h2>Identitas Rombongan Belajar (Rombel)</h2>
                    <p>Data pokok kelas, kode referensi, dan tahun ajaran.</p>
                </div>
            </div>

            <div class="form-grid">

                <div class="form-group full">
                    <label for="nama_kelas">Nama Kelas <span class="required">*</span></label>
                    <input
                        type="text"
                        id="nama_kelas"
                        name="nama_kelas"
                        value="{{ old('nama_kelas') }}"
                        placeholder="Contoh: XII RPL 1, X DKV 2"
                        required
                    >
                    <p class="hint">Nama rombel resmi yang akan tampil di seluruh modul aplikasi.</p>
                </div>

                <div class="form-group">
                    <label for="kode_kelas">Kode Kelas (Opsional)</label>
                    <input
                        type="text"
                        id="kode_kelas"
                        name="kode_kelas"
                        value="{{ old('kode_kelas') }}"
                        placeholder="Contoh: XIIRPL1-2026"
                    >
                    <p class="hint">Otomatis dibuat jika dikosongkan.</p>
                </div>

                <div class="form-group">
                    <label for="tahun_ajaran">Tahun Ajaran <span class="required">*</span></label>
                    <input
                        type="text"
                        id="tahun_ajaran"
                        name="tahun_ajaran"
                        value="{{ old('tahun_ajaran', '2026/2027') }}"
                        placeholder="2026/2027"
                        required
                    >
                </div>

                <div class="form-group full">
                    <label for="keterangan">Keterangan / Program Keahlian (Opsional)</label>
                    <textarea
                        id="keterangan"
                        name="keterangan"
                        placeholder="Contoh: Rekayasa Perangkat Lunak"
                    >{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="info">
                <div>✓</div>
                <div>
                    <strong>Pengaturan Sistem Kas Kelas Dikelola Mandiri oleh Bendahara</strong>
                    Admin tidak perlu mengatur besaran tarif, jadwal, atau target iuran kas.
                    Setelah kelas dibentuk, Bendahara Kelas yang bertugas akan mengatur
                    aturan kas kelasnya secara mandiri pada modul Kelola Kas.
                </div>
            </div>
        </div>

        <!-- PENUGASAN WALI KELAS -->
        <div class="card">
            <div class="section-heading">
                <div class="number">2</div>
                <div>
                    <h2>Penugasan Wali Kelas / Guru Pembina</h2>
                    <p>Pilih guru yang sudah terdaftar atau lakukan penugasan nanti.</p>
                </div>
            </div>

            <div class="mode-grid">

                <div class="mode-option">
                    <input
                        type="radio"
                        id="mode_terdaftar"
                        name="mode_wali_kelas"
                        value="terdaftar"
                        {{ old('mode_wali_kelas', 'terdaftar') == 'terdaftar' ? 'checked' : '' }}
                    >
                    <label for="mode_terdaftar">
                        <strong>◉ Pilih Terdaftar</strong>
                        <span>Gunakan akun Wali Kelas yang sudah terdaftar.</span>
                    </label>
                </div>

                <div class="mode-option">
                    <input
                        type="radio"
                        id="mode_nanti"
                        name="mode_wali_kelas"
                        value="nanti"
                        {{ old('mode_wali_kelas') == 'nanti' ? 'checked' : '' }}
                    >
                    <label for="mode_nanti">
                        <strong>＋ Tugaskan Nanti</strong>
                        <span>Penugasan guru dilakukan kemudian.</span>
                    </label>
                </div>

            </div>

            <!-- PILIH GURU TERDAFTAR -->
            <div id="panel_terdaftar" class="teacher-panel">
                <h3>Pilih Wali Kelas Terdaftar</h3>

                <div class="form-group">
                    <label for="id_wali_kelas">Nama Guru <span class="required">*</span></label>

                    <select id="id_wali_kelas" name="id_wali_kelas">
                        <option value="">-- Pilih Wali Kelas --</option>

                        @foreach ($waliKelas as $wali)
                            <option
                                value="{{ $wali->id }}"
                                {{ old('id_wali_kelas') == $wali->id ? 'selected' : '' }}
                            >
                                {{ $wali->nama }}
                            </option>
                        @endforeach
                    </select>

                    @if ($waliKelas->isEmpty())
                        <p class="hint">
                            Belum ada data Wali Kelas aktif yang tersedia.
                            Pastikan akun Wali Kelas sudah memiliki profil.
                        </p>
                    @else
                        <p class="hint">
                            Pilih salah satu Wali Kelas yang sudah terdaftar di MyCash.
                            Sistem tidak akan membuat akun baru.
                        </p>
                    @endif
                </div>
            </div>

            <!-- TUGASKAN NANTI -->
            <div id="panel_nanti" class="teacher-panel hidden">
                <h3>Penugasan Ditunda</h3>
                <p class="hint">
                    Kelas akan dibuat tanpa Wali Kelas. Super Admin dapat melakukan
                    penugasan setelah data guru tersedia.
                </p>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('super-admin.kelas.index') }}" class="btn btn-cancel">
                Batal
            </a>

            <button type="submit" class="btn btn-save">
                Simpan Kelas
            </button>
        </div>

    </form>
</div>

<script>
    const radios = document.querySelectorAll(
        'input[name="mode_wali_kelas"]'
    );

    const panels = {
        terdaftar: document.getElementById('panel_terdaftar'),
        nanti: document.getElementById('panel_nanti')
    };

    const fields = {
        terdaftar: ['id_wali_kelas'],
        nanti: []
    };

    function updateMode() {
        const selected = document.querySelector(
            'input[name="mode_wali_kelas"]:checked'
        );

        const mode = selected ? selected.value : 'terdaftar';

        Object.keys(panels).forEach(key => {
            const active = key === mode;

            panels[key].classList.toggle('hidden', !active);

            fields[key].forEach(id => {
                const field = document.getElementById(id);

                if (field) {
                    field.disabled = !active;
                    field.required = active;
                }
            });
        });
    }

    radios.forEach(radio => {
        radio.addEventListener('change', updateMode);
    });

    updateMode();
</script>

</body>
</html>
