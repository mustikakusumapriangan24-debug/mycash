<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelola Kelas - MyCash</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome untuk ikon sidebar --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 35px 30px;
            background: #f8f5f1;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #33252a;
        }

        .main {
            margin-left: 250px;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h2 {
            color: #4d0710;
            margin: 0;
            font-size: 25px;
            font-weight: 800;
        }

        .header p {
            color: #887b76;
            font-size: 14px;
            margin-top: 8px;
        }

        .card {
            background: white;
            padding: 30px;
            border: 1px solid #eadfce;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(77, 7, 16, 0.05);
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 9px;
            color: #4d0710;
        }

        .required {
            color: #b42318;
        }

        input, select, textarea {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #e1d8ce;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
            color: #33252a;
            background: #fff;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #a77b35;
            box-shadow: 0 0 0 3px rgba(230, 200, 117, 0.15);
        }

        .info-box {
            display: flex;
            gap: 12px;
            padding: 16px;
            background: #fff9e9;
            border: 1px solid #f0dfb5;
            border-radius: 9px;
            margin-bottom: 24px;
            color: #75551c;
            font-size: 12px;
            line-height: 1.7;
        }

        .info-icon {
            font-size: 19px;
        }

        .error-box {
            background: #fce8e8;
            color: #8b1e1e;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 23px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }

        .btn-cancel {
            background: #f1ede8;
            color: #665a55;
        }

        .btn-submit {
            background: #4d0710;
            color: #e6c875;
        }

        .btn-submit:hover {
            background: #650b18;
        }

        @media (max-width: 700px) {
            body {
                padding: 18px 12px;
            }

            .main {
                margin-left: 0;
            }

            .card {
                padding: 20px;
            }

            .actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR BERSAMA --}}
    @include('partials.sidebar-super-admin')

    <main class="main">
        <div class="container">

            <div class="header">
                <h2>Edit Kelas</h2>
                <p>Perbarui informasi rombel dan aturan kas</p>
            </div>

            <div class="card">

                @if ($errors->any())
                    <div class="error-box">
                        <strong>Terjadi kesalahan:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('super-admin.kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nama Kelas <span class="required">*</span></label>
                        <input
                            type="text"
                            name="nama_kelas"
                            value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Kode Kelas <span class="required">*</span></label>
                        <input
                            type="text"
                            name="kode_kelas"
                            value="{{ old('kode_kelas', $kelas->kode_kelas) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Tahun Ajaran <span class="required">*</span></label>
                        <input
                            type="text"
                            name="tahun_ajaran"
                            value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Wali Kelas Pembina</label>

                        <select name="id_wali_kelas">
                            <option value="">Belum Ditugaskan</option>

                            @foreach ($waliKelas as $wali)
                                <option
                                    value="{{ $wali->id }}"
                                    {{ (string) old('id_wali_kelas', $kelas->id_wali_kelas) === (string) $wali->id ? 'selected' : '' }}
                                >
                                    {{ $wali->nama }}

                                    @if ($wali->nip)
                                        (NIP: {{ $wali->nip }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="info-box">
                        <span class="info-icon">💡</span>
                        <div>
                            <strong>Sistem Kas Kelas:</strong>
                            Besaran tarif, jadwal iuran, dan pembukuan kas dikelola langsung secara mandiri oleh Bendahara Kelas.
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Keterangan / Jurusan</label>
                        <textarea
                            name="keterangan"
                            rows="4"
                            placeholder="Masukkan keterangan atau jurusan kelas..."
                        >{{ old('keterangan', $kelas->keterangan) }}</textarea>
                    </div>

                    {{-- Mempertahankan pengaturan kelas yang sudah tersimpan --}}
                    <input type="hidden" name="tipe_periode" value="{{ $kelas->tipe_periode }}">
                    <input type="hidden" name="nominal_standar" value="{{ $kelas->nominal_standar }}">
                    <input type="hidden" name="status" value="{{ $kelas->status }}">

                    <div class="actions">
                        <a
                            href="{{ route('super-admin.kelas.show', $kelas->id) }}"
                            class="btn btn-cancel"
                        >
                            Batal
                        </a>

                        <button type="submit" class="btn btn-submit">
                            Perbarui Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>

</body>
</html>
