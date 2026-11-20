@extends('layouts.wali-kelas')

@section('content')

<style>
    .account-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #3d2525;
    }

    .account-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .account-header h2 {
        color: #4d0710;
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .account-header p {
        color: #8b7772;
        font-size: 13px;
        margin: 0;
    }

    .account-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #eee5dc;
        border-radius: 15px;
        padding: 21px;
        box-shadow: 0 5px 20px rgba(77, 7, 16, .04);
    }

    .stat-card span {
        display: block;
        color: #927d75;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .stat-card strong {
        color: #4d0710;
        font-size: 27px;
        font-weight: 800;
    }

    .account-card {
        background: #fff;
        border: 1px solid #eee5dc;
        border-radius: 16px;
        padding: 22px;
        margin-bottom: 22px;
        box-shadow: 0 5px 20px rgba(77, 7, 16, .04);
    }

    .account-card h3 {
        color: #4d0710;
        font-size: 16px;
        font-weight: 800;
        margin: 0 0 18px;
    }

    .account-note {
        background: #faf5e9;
        border: 1px solid #eadbb8;
        color: #765c2b;
        padding: 15px 17px;
        border-radius: 11px;
        font-size: 12px;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .account-button {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border: none;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: .2s;
    }

    .account-button:hover {
        opacity: .85;
        transform: translateY(-1px);
    }

    .account-button:disabled {
        opacity: .5;
        cursor: not-allowed;
        transform: none;
    }

    .button-primary {
        background: linear-gradient(135deg, #4d0710, #781c28);
        color: #fff;
    }

    .button-gold {
        background: #e6c875;
        color: #4d0710;
    }

    .button-light {
        background: #f4eee8;
        color: #654747;
    }

    .account-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .account-search {
        width: 270px;
        max-width: 100%;
        border: 1px solid #e8ddd5;
        border-radius: 9px;
        padding: 10px 13px;
        font-size: 12px;
        outline: none;
    }

    .account-search:focus {
        border-color: #a27d35;
        box-shadow: 0 0 0 3px rgba(230, 200, 117, .15);
    }

    .account-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .account-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .account-table th {
        background: #faf6f1;
        color: #80645a;
        text-align: left;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 14px 12px;
        border-bottom: 1px solid #eee5dc;
    }

    .account-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #f1ebe5;
        font-size: 12px;
        vertical-align: middle;
    }

    .student-name {
        color: #4d0710;
        font-weight: 800;
    }

    .student-email {
        color: #806e67;
        word-break: break-word;
    }

    .account-status {
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-active {
        background: #e9f1ec;
        color: #56856c;
    }

    .status-inactive {
        background: #f8eaea;
        color: #9a4e4e;
    }

    .status-pending {
        background: #faf3df;
        color: #a27d35;
    }

    .role-badge {
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        background: #f1ece4;
        color: #803e2f;
    }

    .action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .action-group form {
        display: inline-flex;
    }

    .action-group .account-button {
        padding: 7px 9px;
        font-size: 10px;
    }

    .action-activate {
        background: #e9f1ec;
        color: #56856c;
    }

    .action-deactivate {
        background: #f8eaea;
        color: #9a4e4e;
    }

    .action-demote {
        background: #f7f1e7;
        color: #a27d35;
    }

    .empty-state {
        text-align: center;
        color: #9a8982;
        padding: 30px !important;
    }

    .alert {
        border-radius: 10px;
        padding: 13px 16px;
        margin-bottom: 18px;
        font-size: 12px;
        line-height: 1.6;
    }

    .alert-success {
        background: #e9f1ec;
        color: #47785c;
        border: 1px solid #d2e5d8;
    }

    .alert-error {
        background: #f8eaea;
        color: #984747;
        border: 1px solid #efd4d4;
    }

    .account-footer {
        color: #9a8982;
        font-size: 11px;
        margin-top: 15px;
    }

    @media (max-width: 768px) {
        .account-stats {
            grid-template-columns: 1fr;
        }

        .account-card {
            padding: 15px;
        }

        .account-header {
            align-items: flex-start;
        }

        .account-search {
            width: 100%;
        }
    }
</style>

@php
    $totalStudents = $students->count();

    $totalAccounts = $studentsWithAccount->count();

    $totalWithoutAccount = $studentsWithoutAccount->count();
@endphp

<div class="account-page">

    {{-- HEADER --}}
    <div class="account-header">
        <div>
            <h2>Manajemen Akun Siswa</h2>
            <p>Kelola akses login seluruh siswa XII RPL 1.</p>
        </div>

        <form method="POST"
            action="{{ route('wali-kelas.akun-siswa.buat-semua') }}"
            onsubmit="return confirm('Buat akun untuk seluruh siswa yang belum memiliki akun? Akun yang sudah ada tidak akan dibuat ulang.')">

            @csrf

            <button type="submit"
                class="account-button button-primary"
                {{ $totalWithoutAccount === 0 ? 'disabled' : '' }}>

                + Buat Akun Seluruh Siswa

            </button>
        </form>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- STATISTIK --}}
    <div class="account-stats">

        <div class="stat-card">
            <span>Total Siswa</span>
            <strong>{{ $totalStudents }}</strong>
        </div>

        <div class="stat-card">
            <span>Sudah Memiliki Akun</span>
            <strong>{{ $totalAccounts }}</strong>
        </div>

        <div class="stat-card">
            <span>Belum Memiliki Akun</span>
            <strong>{{ $totalWithoutAccount }}</strong>
        </div>

    </div>

    {{-- INFORMASI --}}
    <div class="account-note">
        <strong>Informasi Akun Siswa</strong><br>

        Akun baru dibuat dengan alias login NIS@mycash.com dan
        password awal menggunakan NIS masing-masing siswa.
        Setelah berhasil login, siswa sebaiknya mengganti password
        awal dengan password pribadi yang lebih aman.

        <br><br>

        Akun yang sudah tersedia tidak akan dibuat ulang atau
        ditimpa oleh proses pembuatan akun massal.
    </div>

    {{-- DAFTAR SISWA --}}
    <div class="account-card">

        <h3>Daftar Akun Siswa</h3>

        <div class="account-toolbar">
            <span style="color:#8b7772; font-size:12px;">
                Daftar seluruh siswa dan status akun login.
            </span>

            <input type="text"
                id="searchStudent"
                class="account-search"
                placeholder="Cari nama, NIS, atau email...">
        </div>

        <div class="account-table-wrap">

            <table class="account-table" id="studentTable">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Email Login</th>
                        <th>Role</th>
                        <th>Status Akun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($students as $student)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="student-name">
                                    {{ $student->name }}
                                </span>
                            </td>

                            <td>{{ $student->nis ?? '-' }}</td>

                            <td class="student-email">
                                @if($student->user)
                                    {{ $student->user->email }}
                                @else
                                    <span style="color:#b19e94;">
                                        Belum tersedia
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($student->user)
                                    <span class="role-badge">
                                        {{ ucfirst($student->user->role) }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if(!$student->user)

                                    <span class="account-status status-pending">
                                        Belum Dibuat
                                    </span>

                                @elseif($student->user->status === 'aktif')

                                    <span class="account-status status-active">
                                        Aktif
                                    </span>

                                @else

                                    <span class="account-status status-inactive">
                                        Nonaktif
                                    </span>

                                @endif
                            </td>

                            <td>
                                @if($student->user)

                                    <div class="action-group">

                                        {{-- RESET PASSWORD --}}
                                        @if(!empty($student->nis))
                                            <form method="POST"
                                                action="{{ route('wali-kelas.akun-siswa.reset-password', $student->id) }}"
                                                onsubmit="return confirm('Reset password akun {{ addslashes($student->name) }} menggunakan NIS?')">

                                                @csrf

                                                <button type="submit"
                                                    class="account-button button-gold">
                                                    Reset Password
                                                </button>
                                            </form>
                                        @endif

                                        {{-- PROMOSI BENDAHARA --}}
                                        @if($student->user->role === 'siswa')

                                            <form method="POST"
                                                action="{{ route('wali-kelas.akun-siswa.promote', $student->id) }}"
                                                onsubmit="return confirm('Jadikan {{ addslashes($student->name) }} sebagai Bendahara?')">

                                                @csrf

                                                <button type="submit"
                                                    class="account-button button-light">
                                                    Jadikan Bendahara
                                                </button>
                                            </form>

                                        @elseif($student->user->role === 'bendahara')

                                            <form method="POST"
                                                action="{{ route('wali-kelas.akun-siswa.demote', $student->id) }}"
                                                onsubmit="return confirm('Kembalikan {{ addslashes($student->name) }} menjadi Siswa?')">

                                                @csrf

                                                <button type="submit"
                                                    class="account-button action-demote">
                                                    Kembalikan ke Siswa
                                                </button>
                                            </form>

                                        @endif

                                        {{-- AKTIF / NONAKTIF --}}
                                        @if($student->user->status === 'aktif')

                                            <form method="POST"
                                                action="{{ route('wali-kelas.akun-siswa.deactivate', $student->id) }}"
                                                onsubmit="return confirm('Nonaktifkan akun {{ addslashes($student->name) }}?')">

                                                @csrf

                                                <button type="submit"
                                                    class="account-button action-deactivate">
                                                    Nonaktifkan
                                                </button>
                                            </form>

                                        @else

                                            <form method="POST"
                                                action="{{ route('wali-kelas.akun-siswa.activate', $student->id) }}"
                                                onsubmit="return confirm('Aktifkan kembali akun {{ addslashes($student->name) }}?')">

                                                @csrf

                                                <button type="submit"
                                                    class="account-button action-activate">
                                                    Aktifkan
                                                </button>
                                            </form>

                                        @endif

                                    </div>

                                @else

                                    <span style="color:#b19e94; font-size:11px;">
                                        Menunggu pembuatan akun
                                    </span>

                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="empty-state">
                                Belum ada data siswa.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

        <div class="account-footer">
            Total {{ $totalStudents }} siswa terdaftar dalam sistem MyCash.
        </div>

    </div>

</div>

<script>
    // PENCARIAN SISWA

    document.getElementById('searchStudent').addEventListener('input', function () {

        const keyword = this.value.toLowerCase();

        const rows = document.querySelectorAll('#studentTable tbody tr');

        rows.forEach(function (row) {

            const content = row.textContent.toLowerCase();

            row.style.display = content.includes(keyword) ? '' : 'none';

        });

    });
</script>

@endsection
