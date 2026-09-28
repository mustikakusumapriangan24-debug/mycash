<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - MyCash Class Finance</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        rel="stylesheet"
    >

    <style>

        /* =========================================================
           PALET WARNA MYCASH
           ========================================================= */

        :root {
            --maroon-main: #400A0F;
            --maroon-dark: #26050B;
            --maroon-deep: #1A0307;

            --beige: #BFAB93;
            --cream: #F2DCC2;
            --brown: #8C6C61;

            --white: #FFFFFF;
            --soft-white: #F8F3EE;

            --text-muted: #75676A;

            --border-light: rgba(191, 171, 147, 0.30);
            --border-dark: rgba(242, 220, 194, 0.16);
        }


        /* =========================================================
           RESET
           ========================================================= */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;

            font-family:
                'Plus Jakarta Sans',
                sans-serif;
        }


        html,
        body {
            width: 100%;
            min-height: 100%;
        }


        body {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            position: relative;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at 15% 15%,
                    rgba(140, 108, 97, 0.38) 0%,
                    rgba(140, 108, 97, 0.08) 28%,
                    transparent 52%
                ),

                radial-gradient(
                    circle at 85% 85%,
                    rgba(64, 10, 15, 0.65) 0%,
                    transparent 45%
                ),

                linear-gradient(
                    135deg,
                    #400A0F 0%,
                    #26050B 48%,
                    #1A0307 100%
                );

            color: var(--white);
        }


        /* =========================================================
           BACKGROUND AMBIENCE
           ========================================================= */

        .ambient-1 {
            position: absolute;

            width: 520px;
            height: 520px;

            top: -260px;
            left: -180px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(191, 171, 147, 0.17) 0%,
                    rgba(191, 171, 147, 0.05) 42%,
                    transparent 72%
                );

            filter: blur(45px);

            pointer-events: none;

            animation:
                ambientFloat1 12s ease-in-out infinite alternate;
        }


        .ambient-2 {
            position: absolute;

            width: 620px;
            height: 620px;

            right: -300px;
            bottom: -320px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(140, 108, 97, 0.18) 0%,
                    rgba(64, 10, 15, 0.08) 45%,
                    transparent 72%
                );

            filter: blur(55px);

            pointer-events: none;

            animation:
                ambientFloat2 15s ease-in-out infinite alternate;
        }


        @keyframes ambientFloat1 {

            0% {
                transform:
                    translate3d(0, 0, 0)
                    scale(1);
            }

            100% {
                transform:
                    translate3d(45px, 30px, 0)
                    scale(1.08);
            }

        }


        @keyframes ambientFloat2 {

            0% {
                transform:
                    translate3d(0, 0, 0)
                    scale(1);
            }

            100% {
                transform:
                    translate3d(-35px, -25px, 0)
                    scale(1.10);
            }

        }


        /* =========================================================
           LOGIN CARD
           ========================================================= */

        .login-card {
            position: relative;

            z-index: 10;

            width: 980px;
            max-width: 92%;

            min-height: 570px;

            display: flex;

            overflow: hidden;

            border-radius: 26px;

            background:
                rgba(38, 5, 11, 0.94);

            border:
                1px solid rgba(191, 171, 147, 0.28);

            box-shadow:
                0 35px 80px rgba(0, 0, 0, 0.55),
                0 0 0 1px rgba(242, 220, 194, 0.03);

            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);

            animation:
                cardEntrance 0.9s cubic-bezier(0.22, 1, 0.36, 1)
                both;
        }


        @keyframes cardEntrance {

            0% {
                opacity: 0;

                transform:
                    translateY(35px)
                    scale(0.97);

                filter: blur(8px);
            }

            100% {
                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);

                filter: blur(0);
            }

        }


        /* =========================================================
           LEFT SIDE
           ========================================================= */

        .banner-side {
            width: 46%;

            padding: 48px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            position: relative;

            background:
                linear-gradient(
                    145deg,
                    #400A0F 0%,
                    #35070C 48%,
                    #26050B 100%
                );

            border-right:
                1px solid var(--border-dark);

            animation:
                leftPanelEntrance 0.9s 0.15s
                cubic-bezier(0.22, 1, 0.36, 1)
                both;
        }


        @keyframes leftPanelEntrance {

            0% {
                opacity: 0;

                transform:
                    translateX(-25px);
            }

            100% {
                opacity: 1;

                transform:
                    translateX(0);
            }

        }


        /* =========================================================
           SUBTLE LEFT HIGHLIGHT
           ========================================================= */

        .banner-side::before {
            content: "";

            position: absolute;

            width: 300px;
            height: 300px;

            top: -150px;
            left: -120px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(191, 171, 147, 0.12),
                    transparent 70%
                );

            pointer-events: none;

            animation:
                highlightPulse 8s ease-in-out infinite alternate;
        }


        @keyframes highlightPulse {

            0% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }

        }


        /* =========================================================
           BRAND
           ========================================================= */

        .brand-header {
            display: flex;

            align-items: center;

            gap: 14px;

            position: relative;

            z-index: 2;

            animation:
                brandEntrance 0.8s 0.35s
                cubic-bezier(0.22, 1, 0.36, 1)
                both;
        }


        @keyframes brandEntrance {

            0% {
                opacity: 0;

                transform:
                    translateY(-12px);
            }

            100% {
                opacity: 1;

                transform:
                    translateY(0);
            }

        }


        .brand-logo-badge {
            width: 48px;
            height: 48px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 7px;

            background: var(--soft-white);

            border-radius: 13px;

            box-shadow:
                0 8px 20px rgba(0, 0, 0, 0.28);

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }


        .brand-logo-badge:hover {
            transform:
                translateY(-2px)
                rotate(-2deg);

            box-shadow:
                0 12px 26px rgba(0, 0, 0, 0.35);
        }


        .brand-logo-badge img {
            width: 100%;
            height: 100%;

            object-fit: contain;
        }


        .brand-title h1 {
            color: var(--white);

            font-size: 20px;

            font-weight: 800;

            letter-spacing: 2px;
        }


        .brand-title span {
            display: block;

            margin-top: 2px;

            color: var(--cream);

            font-size: 9px;

            font-weight: 600;

            letter-spacing: 2px;

            text-transform: uppercase;
        }


        /* =========================================================
           HERO LEFT
           ========================================================= */

        .banner-hero {
            position: relative;

            z-index: 2;

            margin: 35px 0;

            animation:
                heroEntrance 0.9s 0.45s
                cubic-bezier(0.22, 1, 0.36, 1)
                both;
        }


        @keyframes heroEntrance {

            0% {
                opacity: 0;

                transform:
                    translateY(18px);
            }

            100% {
                opacity: 1;

                transform:
                    translateY(0);
            }

        }


        .badge-tag {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 7px 13px;

            margin-bottom: 20px;

            color: var(--cream);

            background:
                rgba(191, 171, 147, 0.10);

            border:
                1px solid rgba(191, 171, 147, 0.32);

            border-radius: 30px;

            font-size: 11px;

            font-weight: 600;

            transition:
                background 0.3s ease,
                border-color 0.3s ease,
                transform 0.3s ease;
        }


        .badge-tag:hover {
            background:
                rgba(191, 171, 147, 0.16);

            border-color:
                rgba(191, 171, 147, 0.45);

            transform:
                translateY(-2px);
        }


        .badge-tag i {
            color: var(--beige);

            font-size: 10px;

            animation:
                crownFloat 3s ease-in-out infinite;
        }


        @keyframes crownFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-2px);
            }

        }


        .banner-hero h2 {
            max-width: 390px;

            margin-bottom: 15px;

            color: var(--white);

            font-size: 29px;

            line-height: 1.32;

            font-weight: 800;

            letter-spacing: -0.7px;
        }


        .banner-hero p {
            max-width: 385px;

            color: rgba(242, 220, 194, 0.70);

            font-size: 13px;

            line-height: 1.7;

            font-weight: 400;
        }


        /* =========================================================
           FOOTER
           ========================================================= */

        .banner-footer {
            position: relative;

            z-index: 2;

            color:
                rgba(242, 220, 194, 0.48);

            font-size: 11px;

            animation:
                footerEntrance 0.8s 0.6s
                ease both;
        }


        @keyframes footerEntrance {

            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }

        }


        /* =========================================================
           RIGHT FORM SIDE
           ========================================================= */

        .form-side {
            width: 54%;

            padding: 48px 44px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            background:
                linear-gradient(
                    145deg,
                    rgba(38, 5, 11, 0.98),
                    rgba(26, 3, 7, 0.98)
                );

            animation:
                formPanelEntrance 0.9s 0.2s
                cubic-bezier(0.22, 1, 0.36, 1)
                both;
        }


        @keyframes formPanelEntrance {

            0% {
                opacity: 0;

                transform:
                    translateX(25px);
            }

            100% {
                opacity: 1;

                transform:
                    translateX(0);
            }

        }


        /* =========================================================
           FORM HEADER
           ========================================================= */

        .form-header {
            margin-bottom: 30px;

            animation:
                formContentEntrance 0.8s 0.45s
                cubic-bezier(0.22, 1, 0.36, 1)
                both;
        }


        .form-header h2 {
            color: var(--soft-white);

            font-size: 26px;

            font-weight: 700;

            letter-spacing: -0.6px;
        }


        .form-header p {
            margin-top: 7px;

            color:
                rgba(242, 220, 194, 0.55);

            font-size: 13px;

            line-height: 1.5;
        }


        @keyframes formContentEntrance {

            0% {
                opacity: 0;

                transform:
                    translateY(15px);
            }

            100% {
                opacity: 1;

                transform:
                    translateY(0);
            }

        }


        /* =========================================================
           FORM GROUP
           ========================================================= */

        .form-group {
            margin-bottom: 21px;

            animation:
                formContentEntrance 0.8s
                cubic-bezier(0.22, 1, 0.36, 1)
                both;
        }


        .form-group:nth-child(1) {
            animation-delay: 0.55s;
        }


        .form-group:nth-child(2) {
            animation-delay: 0.65s;
        }


        .form-group label {
            display: block;

            margin-bottom: 8px;

            color:
                rgba(242, 220, 194, 0.82);

            font-size: 11px;

            font-weight: 700;

            letter-spacing: 0.8px;

            text-transform: uppercase;
        }


        /* =========================================================
           INPUT
           ========================================================= */

        .input-wrapper {
            position: relative;

            display: flex;

            align-items: center;
        }


        .input-wrapper i.field-icon {
            position: absolute;

            left: 17px;

            color:
                rgba(191, 171, 147, 0.55);

            font-size: 14px;

            transition:
                color 0.25s ease,
                transform 0.25s ease;
        }


        .input-wrapper input {
            width: 100%;

            padding:
                15px
                48px
                15px
                47px;

            color: var(--white);

            background:
                rgba(242, 220, 194, 0.055);

            border:
                1px solid rgba(191, 171, 147, 0.22);

            border-radius: 13px;

            outline: none;

            font-size: 13px;

            font-weight: 500;

            transition:
                border-color 0.3s ease,
                background 0.3s ease,
                box-shadow 0.3s ease,
                transform 0.3s ease;
        }


        .input-wrapper input::placeholder {
            color:
                rgba(242, 220, 194, 0.30);
        }


        .input-wrapper input:hover {
            border-color:
                rgba(191, 171, 147, 0.34);

            background:
                rgba(242, 220, 194, 0.07);
        }


        .input-wrapper input:focus {
            border-color:
                rgba(191, 171, 147, 0.65);

            background:
                rgba(242, 220, 194, 0.085);

            box-shadow:
                0 0 0 3px
                rgba(191, 171, 147, 0.07);

            transform:
                translateY(-1px);
        }


        .input-wrapper input:focus ~ .field-icon {
            color: var(--beige);

            transform:
                scale(1.08);
        }


        /* =========================================================
           PASSWORD TOGGLE
           ========================================================= */

        .toggle-pwd {
            position: absolute;

            right: 17px;

            cursor: pointer;

            color:
                rgba(191, 171, 147, 0.48);

            font-size: 14px;

            transition:
                color 0.25s ease,
                transform 0.25s ease;
        }


        .toggle-pwd:hover {
            color: var(--cream);

            transform:
                scale(1.08);
        }


        /* =========================================================
           LOGIN BUTTON
           ========================================================= */

        .btn-login {
            width: 100%;

            margin-top: 8px;

            padding: 15px 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 10px;

            cursor: pointer;

            color: var(--maroon-dark);

            background:
                linear-gradient(
                    135deg,
                    #F2DCC2 0%,
                    #BFAB93 100%
                );

            border:
                1px solid rgba(242, 220, 194, 0.70);

            border-radius: 13px;

            font-size: 13px;

            font-weight: 800;

            box-shadow:
                0 10px 24px rgba(0, 0, 0, 0.25);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                filter 0.25s ease;

            animation:
                buttonEntrance 0.8s 0.75s
                cubic-bezier(0.22, 1, 0.36, 1)
                both;
        }


        @keyframes buttonEntrance {

            0% {
                opacity: 0;

                transform:
                    translateY(15px);
            }

            100% {
                opacity: 1;

                transform:
                    translateY(0);
            }

        }


        .btn-login i {
            font-size: 12px;

            transition:
                transform 0.25s ease;
        }


        .btn-login:hover {
            transform:
                translateY(-2px);

            filter:
                brightness(1.04);

            box-shadow:
                0 14px 30px rgba(0, 0, 0, 0.35);
        }


        .btn-login:hover i {
            transform:
                translateX(4px);
        }


        .btn-login:active {
            transform:
                translateY(0);
        }


        .btn-login:disabled {
            opacity: 0.65;

            cursor: not-allowed;

            transform: none;

            filter: none;
        }


        /* =========================================================
           ALERT
           ========================================================= */

        #alert {
            display: none;

            margin-top: 18px;

            padding: 12px 14px;

            border-radius: 11px;

            font-size: 12px;

            font-weight: 600;

            line-height: 1.5;

            text-align: center;

            animation:
                alertEntrance 0.35s ease both;
        }


        @keyframes alertEntrance {

            0% {
                opacity: 0;

                transform:
                    translateY(-5px);
            }

            100% {
                opacity: 1;

                transform:
                    translateY(0);
            }

        }


        .success {
            color: #C7EBD9;

            background:
                rgba(50, 150, 105, 0.12);

            border:
                1px solid rgba(80, 180, 130, 0.22);
        }


        .error {
            color: #F1BFC3;

            background:
                rgba(160, 30, 45, 0.13);

            border:
                1px solid rgba(210, 70, 85, 0.24);
        }


        /* =========================================================
           ACCESSIBILITY
           ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;

                animation-iteration-count: 1 !important;

                transition-duration: 0.01ms !important;
            }

        }


        /* =========================================================
           RESPONSIVE
           ========================================================= */

        @media (max-width: 850px) {

            body {
                overflow-y: auto;

                padding: 25px 0;
            }


            .login-card {
                min-height: auto;

                max-width: 92%;
            }


            .banner-side {
                display: none;
            }


            .form-side {
                width: 100%;

                padding:
                    45px
                    30px;
            }

        }


        @media (max-width: 480px) {

            .login-card {
                max-width: 94%;

                border-radius: 20px;
            }


            .form-side {
                padding:
                    38px 24px;
            }


            .form-header h2 {
                font-size: 23px;
            }

        }

    </style>
</head>


<body>

    <!-- =========================================================
         BACKGROUND
         ========================================================= -->

    <div class="ambient-1"></div>

    <div class="ambient-2"></div>


    <!-- =========================================================
         LOGIN CARD
         ========================================================= -->

    <div class="login-card">


        <!-- =====================================================
             LEFT / BRANDING
             ===================================================== -->

        <div class="banner-side">


            <!-- BRAND -->
            <div class="brand-header">

                <div class="brand-logo-badge">

                    <img
                        src="{{ asset('images/logo_MYCASH.png') }}"
                        alt="Logo MyCash"
                    >

                </div>


                <div class="brand-title">

                    <h1>MYCASH</h1>

                    <span>
                        Smart Class Finance
                    </span>

                </div>

            </div>



            <!-- HERO -->
            <div class="banner-hero">

                <div class="badge-tag">

                    <i class="fa-solid fa-crown"></i>

                    Smart Class Finance

                </div>


                <h2>
                    Kelola Kas Kelas Lebih
                    Akurat & Transparan
                </h2>


                <p>
                    Platform terpadu untuk pencatatan iuran,
                    rekap pengeluaran, dan laporan real-time
                    bagi Bendahara, Wali Kelas, dan Siswa.
                </p>

            </div>



            <!-- FOOTER -->
            <div class="banner-footer">

                &copy; 2026 MyCash Platform.
                All rights reserved.

            </div>


        </div>



        <!-- =====================================================
             RIGHT / LOGIN
             ===================================================== -->

        <div class="form-side">


            <!-- FORM HEADER -->
            <div class="form-header">

                <h2>
                    Selamat Datang Kembali
                </h2>

                <p>
                    Silakan masuk ke akun Anda untuk melanjutkan.
                </p>

            </div>



            <!-- LOGIN FORM -->
            <form
                id="loginForm"
                method="POST"
                action="{{ route('web.login') }}"
            >

                @csrf


                <!-- EMAIL -->
                <div class="form-group">

                    <label for="email">
                        Alamat Email
                    </label>


                    <div class="input-wrapper">

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="bendahara@mycash.com"
                            placeholder="nama@email.com"
                            autocomplete="email"
                            required
                        >


                        <i
                            class="fa-regular fa-envelope field-icon"
                        ></i>

                    </div>

                </div>



                <!-- PASSWORD -->
                <div class="form-group">

                    <label for="password">
                        Kata Sandi
                    </label>


                    <div class="input-wrapper">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            value="password123"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >


                        <i
                            class="fa-solid fa-lock field-icon"
                        ></i>


                        <i
                            class="fa-regular fa-eye toggle-pwd"
                            id="togglePassword"
                        ></i>

                    </div>

                </div>



                <!-- LOGIN BUTTON -->
                <button
                    type="submit"
                    class="btn-login"
                    id="loginButton"
                >

                    <span id="loginButtonText">
                        Masuk ke Dashboard
                    </span>


                    <i
                        class="fa-solid fa-arrow-right"
                        id="loginButtonIcon"
                    ></i>

                </button>

            </form>



            <!-- ALERT -->
            <div id="alert"></div>


        </div>

    </div>



    <!-- =========================================================
         JAVASCRIPT
         ========================================================= -->

    <script>


        /* =====================================================
           TOGGLE PASSWORD
           ===================================================== */

        const togglePassword =
            document.getElementById('togglePassword');


        const passwordInput =
            document.getElementById('password');


        togglePassword.addEventListener(
            'click',
            function () {

                const isPassword =
                    passwordInput.type === 'password';


                passwordInput.type =
                    isPassword
                        ? 'text'
                        : 'password';


                this.classList.toggle(
                    'fa-eye'
                );


                this.classList.toggle(
                    'fa-eye-slash'
                );

            }
        );



        /* =====================================================
           LOGIN
           ===================================================== */

        const loginForm =
            document.getElementById('loginForm');


        const loginButton =
            document.getElementById('loginButton');


        const loginButtonText =
            document.getElementById('loginButtonText');


        const loginButtonIcon =
            document.getElementById('loginButtonIcon');


        const alertDiv =
            document.getElementById('alert');



        loginForm.addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();


                const email =
                    document
                        .getElementById('email')
                        .value
                        .trim();


                const password =
                    document
                        .getElementById('password')
                        .value;


                const csrfToken =
                    document
                        .querySelector(
                            'input[name="_token"]'
                        )
                        .value;



                /* BUTTON LOADING */

                loginButton.disabled =
                    true;


                loginButtonText.textContent =
                    'Memproses...';


                loginButtonIcon.className =
                    'fa-solid fa-spinner fa-spin';


                alertDiv.style.display =
                    'none';



                try {

                    const response =
                        await fetch(
                            "{{ route('web.login') }}",
                            {

                                method: 'POST',

                                credentials:
                                    'same-origin',

                                headers: {

                                    'Accept':
                                        'application/json',

                                    'Content-Type':
                                        'application/json',

                                    'X-Requested-With':
                                        'XMLHttpRequest',

                                    'X-CSRF-TOKEN':
                                        csrfToken

                                },

                                body:
                                    JSON.stringify({

                                        email:
                                            email,

                                        password:
                                            password

                                    })

                            }
                        );



                    console.log(
                        'HTTP Status:',
                        response.status
                    );


                    console.log(
                        'Content-Type:',
                        response.headers.get(
                            'content-type'
                        )
                    );



                    /* RESPONSE ERROR */

                    if (!response.ok) {

                        let errorResult =
                            null;


                        try {

                            errorResult =
                                await response.json();

                        }

                        catch (error) {

                            console.error(
                                'Error response bukan JSON:',
                                error
                            );

                        }


                        throw new Error(
                            errorResult?.message ||
                            'Login gagal. HTTP ' +
                            response.status
                        );

                    }



                    /* RESPONSE JSON */

                    const result =
                        await response.json();


                    console.log(
                        'Response JSON:',
                        result
                    );



                    /* LOGIN SUCCESS */

                    if (
                        result.success === true
                    ) {

                        alertDiv.style.display =
                            'block';


                        alertDiv.className =
                            'success';


                        alertDiv.innerHTML =
                            '<i class="fa-solid fa-circle-check"></i> ' +
                            (
                                result.message ||
                                'Login berhasil.'
                            ) +
                            ' (Role: <b>' +
                            (
                                result.user?.role ||
                                '-'
                            ) +
                            '</b>)';



                        const redirectUrl =
                            result.redirect ||
                            "{{ url('/dashboard') }}";



                        setTimeout(
                            function () {

                                window.location.href =
                                    redirectUrl;

                            },
                            500
                        );


                        return;

                    }



                    /* LOGIN FAILED */

                    alertDiv.style.display =
                        'block';


                    alertDiv.className =
                        'error';


                    alertDiv.innerHTML =
                        '<i class="fa-solid fa-triangle-exclamation"></i> ' +
                        (
                            result.message ||
                            'Email atau kata sandi salah.'
                        );

                }


                catch (error) {

                    console.error(
                        'Login Error:',
                        error
                    );


                    alertDiv.style.display =
                        'block';


                    alertDiv.className =
                        'error';


                    alertDiv.innerHTML =
                        '<i class="fa-solid fa-triangle-exclamation"></i> ' +
                        (
                            error.message ||
                            'Terjadi kesalahan saat login.'
                        );

                }


                finally {

                    loginButton.disabled =
                        false;


                    loginButtonText.textContent =
                        'Masuk ke Dashboard';


                    loginButtonIcon.className =
                        'fa-solid fa-arrow-right';

                }

            }
        );

    </script>

</body>
</html>