<style>
    .sidebar,
    .sidebar * {
        box-sizing: border-box;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 250px;
        min-width: 250px;
        height: 100vh;
        background: linear-gradient(180deg, #4d0710, #1e0307);
        color: white;
        padding: 28px 18px;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        z-index: 100;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .sidebar .brand {
        padding: 0 12px 30px;
        border-bottom: 1px solid rgba(230,200,117,.2);
        flex-shrink: 0;
    }

    .sidebar .brand h2 {
        margin: 0;
        color: #e6c875;
        font-family: inherit;
        font-size: 23px;
        font-weight: 800;
        line-height: 1.3;
        letter-spacing: 2px;
    }

    .sidebar .brand p {
        margin: 7px 0 0;
        color: #d9c7c7;
        font-size: 11px;
        line-height: 1.5;
    }

    .sidebar .menu-label {
        margin: 28px 12px 12px;
        color: #c5a7a9;
        font-size: 10px;
        font-weight: 700;
        line-height: 1.4;
        letter-spacing: 1.5px;
        flex-shrink: 0;
    }

    .sidebar .nav-link {
        display: flex;
        align-items: center;
        gap: 13px;
        width: 100%;
        min-height: 43px;
        padding: 13px 14px;
        margin: 0 0 7px;
        border-radius: 10px;
        text-decoration: none;
        color: #eadfe0;
        font-size: 12px;
        font-weight: 500;
        line-height: 1.4;
        transition: .2s;
        flex-shrink: 0;
    }

    .sidebar .nav-link i {
        width: 18px;
        min-width: 18px;
        text-align: center;
        font-size: 14px;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
        background: rgba(230,200,117,.13);
        color: #e6c875;
    }

    .sidebar .sidebar-bottom {
        margin-top: auto;
        padding-top: 18px;
        border-top: 1px solid rgba(230,200,117,.2);
        flex-shrink: 0;
    }

    /* PROFIL PENGGUNA */
    .sidebar .profile-link {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 11px 10px;
        margin-bottom: 10px;
        border-radius: 12px;
        text-decoration: none;
        color: white;
        transition: .2s;
    }

    .sidebar .profile-link:hover,
    .sidebar .profile-link.active {
        background: rgba(230,200,117,.13);
    }

    .sidebar .profile-icon {
        width: 39px;
        height: 39px;
        min-width: 39px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(230,200,117,.18);
        border: 1px solid rgba(230,200,117,.5);
        color: #e6c875;
        font-size: 16px;
    }

    .sidebar .profile-info {
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .sidebar .profile-name {
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 145px;
    }

    .sidebar .profile-role {
        color: #c5a7a9;
        font-size: 10px;
    }

    .sidebar .profile-arrow {
        margin-left: auto;
        color: #c5a7a9;
        font-size: 11px;
    }

    .sidebar .logout-button {
        display: block;
        width: 100%;
        min-height: 43px;
        border: 0;
        background: rgba(255,255,255,.08);
        color: white;
        border-radius: 10px;
        padding: 12px;
        cursor: pointer;
        font-family: inherit;
        font-size: 12px;
        font-weight: 500;
        line-height: 1.4;
        text-align: left;
        transition: .2s;
    }

    .sidebar .logout-button:hover {
        background: rgba(255,255,255,.15);
        color: #e6c875;
    }

    :root {
        --maroon: #803E2F;
        --dark-maroon: #54251F;
        --gold: #B59A63;
        --background: #F7F4EF;
        --white: #FFFEFC;
        --text: #3E3D38;
        --muted: #756E69;
        --border: #DED6CC;
    }

    body {
        margin-left: 0 !important;
        background: #F7F4EF !important;
        color: #3E3D38 !important;
        font-family: "Plus Jakarta Sans", sans-serif !important;
    }

    .main {
        margin-left: 220px !important;
        padding: 32px !important;
        min-height: 100vh;
    }

    body.super-admin-create {
        padding: 32px 32px 32px 252px !important;
    }

    .super-admin-create .container {
        max-width: 950px;
        margin: 0 auto;
    }

    .sidebar {
        width: 220px;
        min-width: 220px;
        z-index: 1000;
        background: linear-gradient(180deg, #803E2F 0%, #54251F 100%);
        padding: 28px 16px;
    }

    .sidebar .brand {
        padding: 0 8px 20px;
        margin-bottom: 18px;
        text-align: center;
    }

    .sidebar .brand h2 {
        color: #F1ECE4;
        font-family: "Playfair Display", Georgia, serif;
        font-size: 22px;
        letter-spacing: 2px;
    }

    .sidebar .brand p {
        color: #D8D0C5;
        font-size: 9px;
    }

    .sidebar .menu-label {
        color: #D8D0C5;
        margin: 18px 10px 10px;
        letter-spacing: 1px;
    }

    .sidebar .nav-link {
        min-height: 43px;
        padding: 12px 13px;
        color: #F1ECE4;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
        background: linear-gradient(135deg, #D8C7A8, #B59A63);
        color: #3E3D38;
        box-shadow: 0 8px 20px rgba(181,154,99,.18);
    }

    .sidebar .profile-link.active,
    .sidebar .profile-link:hover {
        background: rgba(255,255,255,.08);
    }

    .sidebar .profile-role,
    .sidebar .profile-arrow {
        color: #D8D0C5;
    }

    .sidebar .logout-button {
        background: rgba(255,255,255,.08);
        color: #F1ECE4;
    }

    .topbar h1,
    .page-header h1,
    .header h2,
    .panel h2,
    .panel-header h2,
    .section-heading h2,
    .container > h1 {
        color: #803E2F !important;
    }

    .eyebrow,
    .page-header .eyebrow {
        color: #B59A63 !important;
    }

    .panel,
    .card,
    .stat-card,
    .profile-card {
        border-color: #DED6CC !important;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(84,37,31,.05);
    }

    .welcome,
    .profile-banner {
        background: linear-gradient(115deg, #803E2F, #54251F) !important;
    }

    .welcome-label {
        border-color: rgba(216,208,197,.45) !important;
        color: #D8D0C5 !important;
    }

    th {
        background: #F1ECE4 !important;
        color: #756E69 !important;
    }

    .btn-add,
    .btn-save,
    .btn-submit,
    .modal-button,
    .button-primary {
        background: #803E2F !important;
        color: #FFFEFC !important;
    }

    .btn-add:hover,
    .btn-save:hover,
    .btn-submit:hover,
    .modal-button:hover,
    .button-primary:hover {
        background: #54251F !important;
        color: #F1ECE4 !important;
    }

    @media (max-width: 700px) {
        body {
            padding: 0 !important;
        }

        .sidebar {
            position: relative;
            width: 100%;
            min-width: 100%;
            height: auto;
            min-height: auto;
        }

        .main {
            margin-left: 0 !important;
            padding: 20px 15px !important;
        }

        body.super-admin-create {
            padding: 20px 15px !important;
        }
    }
</style>

<aside class="sidebar">
    <div class="brand">
        <h2>MYCASH</h2>
        <p>Smart Class Finance</p>
    </div>

    <div class="menu-label">MENU UTAMA</div>

    <a href="{{ route('super-admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-pie"></i>
        Dashboard
    </a>

    <div class="menu-label">PENGELOLAAN SISTEM</div>

    <a href="{{ route('super-admin.kelas.index') }}"
       class="nav-link {{ request()->routeIs('super-admin.kelas.*') ? 'active' : '' }}">
        <i class="fa-solid fa-school"></i>
        Kelola Kelas
    </a>

    <a href="{{ route('super-admin.bendahara.index') }}"
       class="nav-link {{ request()->routeIs('super-admin.bendahara.*') ? 'active' : '' }}">
        <i class="fa-solid fa-user-tie"></i>
        Kelola Bendahara
    </a>

    <a href="{{ route('super-admin.dashboard') }}#wali-kelas"
       class="nav-link">
        <i class="fa-solid fa-chalkboard-user"></i>
        Kelola Wali Kelas
    </a>

    <div class="sidebar-bottom">

        <!-- PROFIL SUPER ADMIN -->
        <a href="{{ route('super-admin.profile') }}"
           class="profile-link {{ request()->routeIs('super-admin.profile') ? 'active' : '' }}">

            <div class="profile-icon">
                <i class="fa-solid fa-user"></i>
            </div>

            <div class="profile-info">
                <span class="profile-name">
                    {{ auth()->user()->name }}
                </span>

                <span class="profile-role">
                    Super Admin
                </span>
            </div>

            <i class="fa-solid fa-chevron-right profile-arrow"></i>
        </a>

        <!-- TOMBOL KELUAR -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="logout-button">
                <i class="fa-solid fa-right-from-bracket"></i>
                &nbsp; Keluar
            </button>
        </form>

    </div>
</aside>
