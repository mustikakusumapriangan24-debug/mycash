<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Administrator - MyCash</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            margin-left: 250px;
            padding: 35px 30px;
            background: #f8f5f1;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #33252a;
        }

        .main {
            max-width: 1150px;
            margin: auto;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header .eyebrow {
            color: #9b777b;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.8px;
            margin-bottom: 9px;
        }

        .page-header h1 {
            margin: 0 0 8px;
            color: #4d0710;
            font-size: 25px;
            font-weight: 800;
        }

        .page-header p {
            margin: 0;
            color: #887b7d;
            font-size: 13px;
        }

        .date-label {
            margin-top: 12px;
            color: #8c7779;
            font-size: 11px;
        }

        .profile-card {
            background: white;
            border: 1px solid #eee5df;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(77, 7, 16, .04);
        }

        .profile-banner {
            height: 145px;
            background: linear-gradient(120deg, #4d0710, #781c29, #2b0309);
            position: relative;
            overflow: hidden;
        }

        .profile-banner::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border: 1px solid rgba(230,200,117,.25);
            border-radius: 50%;
            right: 55px;
            top: -110px;
        }

        .profile-content {
            padding: 0 35px 35px;
        }

        .profile-top {
            display: flex;
            align-items: flex-end;
            gap: 22px;
            margin-top: -55px;
            position: relative;
            margin-bottom: 25px;
        }

        .avatar {
            width: 110px;
            height: 110px;
            min-width: 110px;
            border-radius: 50%;
            background: #f5e9dc;
            border: 5px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4d0710;
            font-size: 40px;
            box-shadow: 0 3px 12px rgba(0,0,0,.08);
        }

        .profile-heading {
            padding-bottom: 10px;
        }

        .profile-heading h2 {
            margin: 0 0 7px;
            font-size: 20px;
            color: #4d0710;
            font-weight: 800;
        }

        .profile-heading .role-badge {
            display: inline-block;
            background: #f8eee0;
            color: #8a5d19;
            border-radius: 20px;
            padding: 6px 13px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .account-meta {
            margin-top: 12px;
            color: #8c7d7e;
            font-size: 11px;
            line-height: 1.8;
        }

        .section-title {
            color: #4d0710;
            font-size: 15px;
            font-weight: 800;
            margin: 27px 0 8px;
            padding-bottom: 13px;
            border-bottom: 1px solid #f0e8e3;
        }

        .section-description {
            color: #938487;
            font-size: 11px;
            margin: 0 0 20px;
            line-height: 1.7;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .form-group label {
            color: #655256;
            font-size: 11px;
            font-weight: 700;
        }

        .form-group input {
            width: 100%;
            min-height: 45px;
            padding: 12px 14px;
            border: 1px solid #e9ded9;
            border-radius: 10px;
            background: #fff;
            color: #3e252b;
            font-family: inherit;
            font-size: 12px;
            outline: none;
            transition: .2s;
        }

        .form-group input:focus {
            border-color: #9b5962;
            box-shadow: 0 0 0 3px rgba(77,7,16,.06);
        }

        .form-group input[readonly] {
            background: #f8f5f1;
            color: #8a7b7e;
            cursor: not-allowed;
        }

        .form-help {
            color: #a09293;
            font-size: 10px;
            line-height: 1.6;
        }

        .form-error {
            color: #bd3030;
            font-size: 10px;
        }

        .button-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 22px;
        }

        .primary-button {
            border: none;
            border-radius: 9px;
            padding: 13px 20px;
            background: linear-gradient(120deg, #4d0710, #781c29);
            color: white;
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .primary-button:hover {
            background: #2b0309;
            transform: translateY(-1px);
        }

        .primary-button i {
            margin-right: 7px;
        }

        .profile-note {
            margin-top: 22px;
            padding: 15px;
            background: #faf5e9;
            border: 1px solid #efe2c5;
            border-radius: 12px;
            color: #80652f;
            font-size: 11px;
            line-height: 1.7;
        }

        .profile-note i {
            margin-right: 7px;
        }

        .alert {
            padding: 13px 16px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 12px;
            line-height: 1.6;
        }

        .alert-success {
            background: #edf8f0;
            border: 1px solid #ccebd3;
            color: #287443;
        }

        .alert-error {
            background: #fff0f0;
            border: 1px solid #f2cccc;
            color: #a52c2c;
        }

        .alert ul {
            margin: 7px 0 0;
            padding-left: 20px;
        }

        .password-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .password-grid .full-width {
            grid-column: 1 / -1;
        }

        @media (max-width: 700px) {
            body {
                margin-left: 0;
                padding: 20px 14px;
            }

            .profile-content {
                padding: 0 18px 25px;
            }

            .info-grid,
            .password-grid {
                grid-template-columns: 1fr;
            }

            .password-grid .full-width {
                grid-column: auto;
            }

            .profile-top {
                gap: 13px;
            }

            .avatar {
                width: 85px;
                height: 85px;
                min-width: 85px;
                font-size: 30px;
            }

            .profile-heading h2 {
                font-size: 16px;
            }

            .button-row {
                justify-content: stretch;
            }

            .primary-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

@include('partials.sidebar-super-admin')

<main class="main">

    <div class="page-header">
        <div class="eyebrow">ADMINISTRATOR</div>
        <h1>Pengaturan Sistem & Hak Akses</h1>
        <p>Pengaturan Akun</p>
        <div class="date-label">
            <i class="fa-regular fa-calendar"></i>
            {{ now()->translatedFormat('d M Y') }}
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <strong><i class="fa-solid fa-circle-exclamation"></i> Periksa kembali data yang dimasukkan.</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="profile-card">

        <div class="profile-banner"></div>

        <div class="profile-content">

            <div class="profile-top">

                <div class="avatar">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="profile-heading">
                    <h2>{{ $user->name }}</h2>

                    <span class="role-badge">
                        <i class="fa-solid fa-shield-halved"></i>
                        ADMINISTRATOR
                    </span>

                    <div class="account-meta">
                        <i class="fa-regular fa-envelope"></i>
                        {{ $user->email }}
                        &nbsp;•&nbsp;
                        ID Akun: #{{ $user->id }}
                        <br>

                        <i class="fa-regular fa-calendar-check"></i>
                        Terdaftar sejak:
                        {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>

            </div>

            <h3 class="section-title">
                <i class="fa-regular fa-id-card"></i>
                Informasi Akun
            </h3>

            <p class="section-description">
                Perbarui nama tampilan dan alamat email administrator.
            </p>

            <form action="{{ route('super-admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="info-grid">

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Masukkan nama lengkap"
                            required
                        >

                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            placeholder="Masukkan alamat email"
                            required
                        >

                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nip">NIP / Identitas Pegawai</label>
                        <input
                            type="text"
                            id="nip"
                            value="1001"
                            readonly
                        >
                        <span class="form-help">
                            NIP/Identitas utama akun sistem ditetapkan default.
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="account_id">ID Akun</label>
                        <input
                            type="text"
                            id="account_id"
                            value="#{{ $user->id }}"
                            readonly
                        >
                    </div>

                </div>

                <div class="button-row">
                    <button type="submit" class="primary-button">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <div class="profile-note">
                <i class="fa-solid fa-circle-info"></i>
                Perubahan nama dan email akan langsung disimpan ke akun administrator yang sedang digunakan.
            </div>

            <h3 class="section-title">
                <i class="fa-solid fa-lock"></i>
                Keamanan & Kata Sandi
            </h3>

            <p class="section-description">
                Ubah kata sandi untuk mengamankan hak akses administrator.
            </p>

            <form action="{{ route('super-admin.profile.password') }}" method="POST">

                @csrf
                @method('PUT')

                <div class="password-grid">

                    <div class="form-group full-width">
                        <label for="current_password">
                            Kata Sandi Saat Ini
                        </label>

                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            placeholder="Masukkan kata sandi saat ini"
                            autocomplete="current-password"
                            required
                        >

                        @error('current_password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            Kata Sandi Baru
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimal 6 karakter"
                            autocomplete="new-password"
                            minlength="6"
                            required
                        >

                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">
                            Konfirmasi Kata Sandi Baru
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi kata sandi baru"
                            autocomplete="new-password"
                            minlength="6"
                            required
                        >
                    </div>

                </div>

                <div class="button-row">
                    <button type="submit" class="primary-button">
                        <i class="fa-solid fa-key"></i>
                        Perbarui Kata Sandi
                    </button>
                </div>

            </form>

        </div>
    </section>

</main>

</body>
</html>
