@extends('layouts.wali-kelas')

@section('title', 'Profil Wali Kelas - MyCash')

@section('content')

<style>
    /* PROFILE PAGE */
    .profile-page {
        max-width: 1100px;
        margin: 0 auto;
    }

    .profile-topbar {
        margin-bottom: 28px;
    }

    .profile-topbar h2 {
        font-family: "Playfair Display", serif;
        font-size: 30px;
        color: #3E3D38;
    }

    .profile-topbar p {
        margin-top: 8px;
        color: #756E69;
        font-size: 13px;
    }

    .profile-line {
        width: 50px;
        height: 3px;
        margin-top: 18px;
        border-radius: 20px;
        background: linear-gradient(90deg, #B59A63, #D8D0C5);
    }

    /* PROFILE SUMMARY */
    .profile-summary {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 22px;
        padding: 26px;
        margin-bottom: 22px;
        border-radius: 16px;
        color: white;
        background: linear-gradient(
            135deg,
            #803E2F 0%,
            #54251F 58%,
            #2B2222 100%
        );
        border: 1px solid rgba(181,154,99,.42);
        box-shadow: 0 12px 28px rgba(84,37,31,.15);
    }

    .profile-summary::after {
        content: "";
        position: absolute;
        width: 190px;
        height: 190px;
        right: -65px;
        top: -85px;
        border: 1px solid rgba(216,208,197,.18);
        border-radius: 50%;
        pointer-events: none;
    }

    .profile-avatar-large {
        width: 76px;
        height: 76px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #D8C7A8, #B59A63);
        color: #54251F;
        font-family: "Playfair Display", serif;
        font-size: 30px;
        font-weight: 700;
        border: 3px solid rgba(255,255,255,.2);
    }

    .profile-summary-content {
        position: relative;
        z-index: 1;
    }

    .profile-summary h2 {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        font-family: "Playfair Display", serif;
        font-size: 23px;
    }

    .profile-summary p {
        margin-top: 8px;
        color: #D8D0C5;
        font-size: 11px;
        line-height: 1.7;
    }

    .profile-summary p strong {
        color: #FFFEFC;
    }

    .active-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 11px;
        border: 1px solid rgba(216,208,197,.3);
        border-radius: 20px;
        background: rgba(181,154,99,.18);
        color: #E6D4A9;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 9px;
        font-weight: 600;
    }

    /* FORM CARD */
    .profile-card {
        padding: 24px;
        margin-bottom: 18px;
        background: #FFFEFC;
        border: 1px solid #DED6CC;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(45,28,20,.045);
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        padding-bottom: 17px;
        margin-bottom: 22px;
        border-bottom: 1px solid #EEE7DD;
    }

    .section-icon {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #F1ECE4;
        color: #803E2F;
        font-size: 17px;
    }

    .section-heading h3 {
        font-family: "Playfair Display", serif;
        font-size: 18px;
        color: #54251F;
    }

    .section-heading p {
        margin-top: 5px;
        color: #756E69;
        font-size: 11px;
    }

    /* FORM */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 0;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        color: #54251F;
        font-size: 12px;
        font-weight: 700;
    }

    .form-control {
        width: 100%;
        min-height: 44px;
        padding: 12px 14px;
        border: 1px solid #DED6CC;
        border-radius: 9px;
        outline: none;
        background: #FFFEFC;
        color: #3E3D38;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 12px;
        transition: .2s;
    }

    .form-control::placeholder {
        color: #B0A49B;
    }

    .form-control:focus {
        border-color: #B59A63;
        box-shadow: 0 0 0 3px rgba(181,154,99,.12);
    }

    textarea.form-control {
        min-height: 105px;
        resize: vertical;
        line-height: 1.6;
    }

    .field-note {
        margin-top: 14px;
        color: #756E69;
        font-size: 10px;
        line-height: 1.6;
    }

    .field-note i {
        color: #B59A63;
        margin-right: 5px;
    }

    .error-text {
        color: #B42318;
        font-size: 11px;
    }

    /* ALERT */
    .success-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        margin-bottom: 20px;
        border: 1px solid #B7DFBA;
        border-radius: 10px;
        background: #E8F5E9;
        color: #27632A;
        font-size: 12px;
    }

    /* SAVE BUTTON */
    .save-area {
        display: flex;
        justify-content: flex-end;
        margin-top: 24px;
        margin-bottom: 15px;
    }

    .save-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 13px 22px;
        border: 1px solid rgba(181,154,99,.4);
        border-radius: 10px;
        background: linear-gradient(135deg, #803E2F, #54251F);
        color: #FFFEFC;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
        box-shadow: 0 6px 16px rgba(84,37,31,.13);
    }

    .save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 9px 20px rgba(84,37,31,.2);
    }

    /* RESPONSIVE */
    @media (max-width: 700px) {
        .profile-topbar h2 {
            font-size: 25px;
        }

        .profile-summary {
            align-items: flex-start;
            padding: 20px;
            gap: 15px;
        }

        .profile-avatar-large {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }

        .profile-summary h2 {
            font-size: 18px;
        }

        .profile-card {
            padding: 18px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .save-area {
            justify-content: stretch;
        }

        .save-btn {
            width: 100%;
        }
    }

    @media (max-width: 380px) {
        .profile-summary {
            flex-direction: column;
        }
    }
</style>

<div class="profile-page">

    <!-- PAGE HEADING -->
    <header class="profile-topbar">
        <h2>Profil Wali Kelas</h2>

        <p>
            Perbarui data diri, kontak, dan kata sandi pembimbing kelas.
        </p>

        <div class="profile-line"></div>
    </header>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="success-alert">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- VALIDATION MESSAGE -->
    @if($errors->any())
        <div class="success-alert" style="background:#FFF1F0;color:#B42318;border-color:#F2C5C1;">
            <i class="fa-solid fa-circle-exclamation"></i>
            Periksa kembali data yang kamu masukkan.
        </div>
    @endif

    <!-- PROFILE SUMMARY -->
    <section class="profile-summary">

        <div class="profile-avatar-large">
            {{ strtoupper(substr($waliKelas->nama ?: $user->name, 0, 1)) }}
        </div>

        <div class="profile-summary-content">

            <h2>
                {{ $waliKelas->nama ?: $user->name }}

                <span class="active-status">
                    <i class="fa-solid fa-circle-check"></i>
                    Aktif
                </span>
            </h2>

            <p>
                NIP:
                <strong>{{ $waliKelas->nip ?: '-' }}</strong>
                &nbsp;•&nbsp;
                Wali Kelas XII RPL 1
            </p>

            <p>
                <i class="fa-solid fa-graduation-cap"></i>
                Kelas Binaan: XII RPL 1 (T.A 2026/2027)
            </p>

        </div>

    </section>

    <form action="{{ route('wali-kelas.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- IDENTITAS -->
        <section class="profile-card">

            <div class="section-heading">
                <div class="section-icon">
                    <i class="fa-solid fa-id-card"></i>
                </div>

                <div>
                    <h3>Data Identitas Wali Kelas</h3>
                    <p>Informasi utama akun guru wali kelas.</p>
                </div>
            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label for="nama">Nama Lengkap & Gelar</label>

                    <input
                        id="nama"
                        type="text"
                        name="nama"
                        class="form-control"
                        value="{{ old('nama', $waliKelas->nama ?: $user->name) }}"
                        placeholder="Masukkan nama lengkap"
                        required
                    >

                    @error('nama')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nip">Nomor Induk Pegawai (NIP)</label>

                    <input
                        id="nip"
                        type="text"
                        name="nip"
                        class="form-control"
                        value="{{ old('nip', $waliKelas->nip) }}"
                        placeholder="Masukkan NIP"
                    >

                    @error('nip')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="email">Alamat Email</label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $user->email) }}"
                        placeholder="nama@email.com"
                        required
                    >

                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

            </div>

        </section>

        <!-- KONTAK -->
        <section class="profile-card">

            <div class="section-heading">
                <div class="section-icon">
                    <i class="fa-solid fa-address-book"></i>
                </div>

                <div>
                    <h3>Kontak & Domisili</h3>
                    <p>Informasi kontak yang dapat dihubungi.</p>
                </div>
            </div>

            <div class="form-grid">

                <div class="form-group full">
                    <label for="no_hp">Nomor Handphone / WhatsApp</label>

                    <input
                        id="no_hp"
                        type="text"
                        name="no_hp"
                        class="form-control"
                        value="{{ old('no_hp', $waliKelas->no_hp) }}"
                        placeholder="Contoh: 081234567890"
                    >

                    @error('no_hp')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="alamat">Alamat Tempat Tinggal</label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        class="form-control"
                        placeholder="Masukkan alamat tempat tinggal"
                    >{{ old('alamat', $waliKelas->alamat) }}</textarea>

                    @error('alamat')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

            </div>

        </section>

        <!-- PASSWORD -->
        <section class="profile-card">

            <div class="section-heading">
                <div class="section-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>

                <div>
                    <h3>Keamanan Akun</h3>
                    <p>Perbarui kata sandi login jika diperlukan.</p>
                </div>
            </div>

            <div class="form-grid">

                <div class="form-group full">
                    <label for="password_sekarang">Kata Sandi Saat Ini</label>

                    <input
                        id="password_sekarang"
                        type="password"
                        name="password_sekarang"
                        class="form-control"
                        placeholder="Masukkan kata sandi saat ini"
                        autocomplete="current-password"
                    >

                    @error('password_sekarang')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_baru">Kata Sandi Baru</label>

                    <input
                        id="password_baru"
                        type="password"
                        name="password_baru"
                        class="form-control"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                    >

                    @error('password_baru')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_baru_confirmation">Konfirmasi Sandi Baru</label>

                    <input
                        id="password_baru_confirmation"
                        type="password"
                        name="password_baru_confirmation"
                        class="form-control"
                        placeholder="Ulangi kata sandi baru"
                        autocomplete="new-password"
                    >
                </div>

            </div>

            <p class="field-note">
                <i class="fa-solid fa-circle-info"></i>
                Kosongkan semua kolom kata sandi jika tidak ingin menggantinya.
                Kata sandi baru minimal 8 karakter.
            </p>

        </section>

        <!-- SAVE -->
        <div class="save-area">
            <button type="submit" class="save-btn">
                <i class="fa-solid fa-floppy-disk"></i>
                Simpan Perubahan Profil
            </button>
        </div>

    </form>

</div>

@endsection
