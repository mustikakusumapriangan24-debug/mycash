<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'MyCash - Wali Kelas')
    </title>

    <!-- Google Fonts -->
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >

    <style>

        :root {
            --maroon: #803E2F;
            --maroon-dark: #54251F;
            --maroon-deep: #1F1D20;

            --gold: #B59A63;
            --gold-soft: #D8D0C5;

            --cream: #F1ECE4;
            --white: #FFFEFC;

            --text: #3E3D38;
            --text-soft: #756E69;

            --border: #DED6CC;
            --border-gold: rgba(181, 154, 99, .38);

            --green: #56856c;
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family: "Plus Jakarta Sans", sans-serif;

            background: #F7F4EF;

            color: var(--text);

            min-height: 100vh;

        }


        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {

            width: 220px;

            position: fixed;

            left: 0;
            top: 0;
            bottom: 0;

            background:
                linear-gradient(
                    180deg,
                    #803E2F 0%,
                    #54251F 100%
                );

            padding: 28px 16px;

            display: flex;

            flex-direction: column;

            z-index: 1000;

        }


        /* =========================
           BRAND
        ========================= */

        .brand {

            text-align: center;

            margin-bottom: 18px;

        }


        .brand-logo {

            width: 58px;
            height: 58px;

            margin: 0 auto 10px;

            border-radius: 16px;

            overflow: hidden;

            background: rgba(255,255,255,.10);

            border: 1px solid rgba(216,208,197,.35);

            display: flex;

            align-items: center;
            justify-content: center;

        }


        .brand-logo img {

            width: 100%;
            height: 100%;

            object-fit: cover;

        }


        .brand h1 {

            font-family: "Playfair Display", serif;

            font-size: 22px;

            letter-spacing: 2px;

            color: #F1ECE4;

        }


        .brand p {

            margin-top: 3px;

            font-size: 9px;

            color: #D8D0C5;

            letter-spacing: .4px;

        }


        /* =========================
           MENU
        ========================= */

        .menu {

            margin-top: 18px;

        }


        .menu a {

            display: flex;

            align-items: center;

            gap: 15px;

            padding: 14px 16px;

            margin-bottom: 6px;

            border-radius: 10px;

            text-decoration: none;

            font-size: 12px;

            font-weight: 600;

            color: #F1ECE4;

            transition: .2s;

        }


        .menu a i {

            width: 18px;

            text-align: center;

            font-size: 14px;

        }


        .menu a:hover {

            background: rgba(255,255,255,.08);

            transform: translateX(2px);

        }


        .menu a.active {

            background:
                linear-gradient(
                    135deg,
                    #D8C7A8,
                    #B59A63
                );

            color: #3E3D38;

            box-shadow:
                0 8px 20px rgba(181,154,99,.18);

        }


        /* =========================
           SIDEBAR PROFILE
        ========================= */

        .sidebar-profile {

            margin-top: auto;

            padding-top: 20px;

            text-align: center;

            border-top: 1px solid rgba(255,255,255,.10);

        }


        .avatar {

            width: 68px;
            height: 68px;

            margin: 0 auto 10px;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #D8C7A8,
                    #8C6C61
                );

            display: flex;

            align-items: center;
            justify-content: center;

            color: #54251F;

            font-size: 25px;

            border: 3px solid rgba(255,255,255,.12);

        }


        .sidebar-profile strong {

            display: block;

            color: #F1ECE4;

            font-size: 12px;

            font-weight: 700;

        }


        .sidebar-profile span {

            display: block;

            margin-top: 3px;

            color: #D8D0C5;

            font-size: 9px;

        }


        .profile-class {

            margin-top: 2px;

            color: #D8C7A8 !important;

        }


        /* =========================
           LOGOUT
        ========================= */

        .logout-btn {

            width: 100%;

            margin-top: 13px;

            padding: 10px;

            border-radius: 9px;

            border: 1px solid rgba(216,208,197,.35);

            background: rgba(255,255,255,.08);

            color: #F1ECE4;

            font-family: "Plus Jakarta Sans", sans-serif;

            font-size: 10px;

            font-weight: 600;

            cursor: pointer;

            transition: .2s;

        }


        .logout-btn:hover {

            background: rgba(255,255,255,.14);

        }


        /* =========================
           MAIN CONTENT
        ========================= */

        .main-content {

            margin-left: 220px;

            min-height: 100vh;

            padding: 36px 40px;

        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .sidebar {

                width: 200px;

            }

            .main-content {

                margin-left: 200px;

                padding: 28px;

            }

        }


        @media (max-width: 700px) {

            .sidebar {

                position: relative;

                width: 100%;

                min-height: auto;

            }

            .main-content {

                margin-left: 0;

                padding: 24px 18px;

            }

            .sidebar-profile {

                margin-top: 20px;

            }

        }

    </style>

</head>


<body>


    <!-- =========================
         SIDEBAR
    ========================= -->

    <aside class="sidebar">


        <!-- BRAND -->

        <div class="brand">

            <div class="brand-logo">

                <img
                    src="{{ asset('images/logo_MYCASH.png') }}"
                    alt="MyCash"
                >

            </div>


            <h1>
                MYCASH
            </h1>


            <p>
                Smart Class Finance
            </p>

        </div>


        <!-- MENU -->

        <nav class="menu">


            <!-- DASHBOARD -->

            <a
                href="{{ route('wali-kelas.dashboard') }}"
                class="{{ request()->routeIs('wali-kelas.dashboard') ? 'active' : '' }}"
            >

                <i class="fa-solid fa-house"></i>

                <span>
                    Dashboard
                </span>

            </a>


            <!-- DATA SISWA -->

            <a
                href="{{ route('students.index') }}"
                class="{{ request()->routeIs('students.*') ? 'active' : '' }}"
            >

                <i class="fa-solid fa-users"></i>

                <span>
                    Data Siswa
                </span>

            </a>


            <!-- AKUN SISWA -->

            <a href="#">

                <i class="fa-solid fa-user-lock"></i>

                <span>
                    Akun Siswa
                </span>

            </a>


            <!-- PANTAU KAS -->

            <a
                href="{{ route('wali-kelas.kas') }}"
                class="{{ request()->routeIs('wali-kelas.kas') ? 'active' : '' }}"
            >

                <i class="fa-solid fa-wallet"></i>

                <span>
                    Pantau Kas
                </span>

            </a>


            <!-- LAPORAN -->

            <a href="#">

                <i class="fa-solid fa-file-lines"></i>

                <span>
                    Laporan
                </span>

            </a>


            <!-- PENGATURAN -->

            <a href="#">

                <i class="fa-solid fa-gear"></i>

                <span>
                    Pengaturan
                </span>

            </a>


        </nav>


        <!-- PROFILE -->

        <div class="sidebar-profile">


            <div class="avatar">

                <i class="fa-solid fa-chalkboard-user"></i>

            </div>


            <strong>

                {{ auth()->user()->name ?? 'Wali Kelas' }}

            </strong>


            <span>

                Wali Kelas

            </span>


            <span class="profile-class">

                XI RPL 1

            </span>


            <!-- LOGOUT -->

            <form
                action="{{ route('logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-btn"
                >

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </button>

            </form>


        </div>


    </aside>


    <!-- =========================
         MAIN CONTENT
    ========================= -->

    <main class="main-content">

        @yield('content')

    </main>


</body>

</html>