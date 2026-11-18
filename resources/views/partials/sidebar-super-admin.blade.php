<style>
    /* RESET KHUSUS SIDEBAR */
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
        padding: 0;
        color: #e6c875;
        font-family: inherit;
        font-size: 23px;
        font-weight: 800;
        line-height: 1.3;
        letter-spacing: 2px;
    }

    .sidebar .brand p {
        margin: 7px 0 0;
        padding: 0;
        color: #d9c7c7;
        font-family: inherit;
        font-size: 11px;
        font-weight: 400;
        line-height: 1.5;
    }

    .sidebar .menu-label {
        margin: 28px 12px 12px;
        padding: 0;
        color: #c5a7a9;
        font-family: inherit;
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
        font-family: inherit;
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
        padding-top: 20px;
        border-top: 1px solid rgba(230,200,117,.2);
        flex-shrink: 0;
    }

    .sidebar .sidebar-bottom .menu-label {
        margin-top: 0;
    }

    .sidebar .sidebar-bottom form {
        margin: 10px 0 0;
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
    }

    @media (max-width: 700px) {
        .sidebar {
            position: relative;
            width: 100%;
            min-width: 100%;
            height: auto;
            min-height: auto;
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

    <a href="{{ route('super-admin.dashboard') }}#data-pengguna"
       class="nav-link">
        <i class="fa-solid fa-users"></i>
        Data Pengguna
    </a>

    <a href="{{ route('super-admin.kelas.index') }}"
       class="nav-link {{ request()->routeIs('super-admin.kelas.*') ? 'active' : '' }}">
        <i class="fa-solid fa-school"></i>
        Data Kelas
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

    <a href="{{ route('super-admin.dashboard') }}#pengawasan"
       class="nav-link">
        <i class="fa-solid fa-eye"></i>
        Pengawasan Kas
    </a>

    <a href="{{ route('super-admin.dashboard') }}#hak-akses"
       class="nav-link">
        <i class="fa-solid fa-shield-halved"></i>
        Hak Akses
    </a>

    <div class="sidebar-bottom">
        <div class="menu-label">AKUN</div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">
                <i class="fa-solid fa-right-from-bracket"></i>
                &nbsp; Keluar
            </button>
        </form>
    </div>
</aside>
