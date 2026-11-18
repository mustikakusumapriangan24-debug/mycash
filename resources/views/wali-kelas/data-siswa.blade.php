@extends('layouts.wali-kelas')

@section('content')

@php
    $search = request('search');

    $totalStudents = \App\Models\Student::count();

    $totalAccounts = \App\Models\Student::whereHas('user')->count();

    $studentsWithAccount = \App\Models\Student::with('user')
        ->whereHas('user', function ($query) use ($search) {
            if ($search) {
                $query->where('email', 'like', "%{$search}%");
            }
        })
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('email', 'like', "%{$search}%");
                  });
            });
        })
        ->orderBy('name', 'asc')
        ->paginate(10)
        ->withQueryString();
@endphp

<style>
    .account-page {
        color: #3d2525;
        font-family: 'Plus Jakarta Sans', sans-serif;
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

    .account-stats {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #eee5dc;
        border-radius: 14px;
        padding: 20px;
    }

    .stat-card span {
        color: #927d75;
        font-size: 12px;
        display: block;
        margin-bottom: 9px;
    }

    .stat-card strong {
        color: #4d0710;
        font-size: 25px;
        font-weight: 800;
    }

    .account-note {
        background: #faf5e9;
        border: 1px solid #eadbb8;
        color: #765c2b;
        padding: 13px 16px;
        border-radius: 10px;
        font-size: 12px;
        margin-bottom: 20px;
    }

    .account-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        color: #5b3535;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #e8ddd5;
        border-radius: 9px;
        padding: 11px 13px;
        font-size: 13px;
        color: #4d3030;
        background: #fff;
        outline: none;
    }

    .form-control:focus {
        border-color: #a27d35;
        box-shadow: 0 0 0 3px rgba(230, 200, 117, .15);
    }

    .form-hint {
        color: #9a8982;
        font-size: 11px;
        margin-top: 6px;
    }

    .account-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    /* PENCARIAN */

    .account-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .account-search {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .account-search input {
        width: 260px;
        max-width: 100%;
        border: 1px solid #e8ddd5;
        border-radius: 9px;
        padding: 10px 13px;
        font-size: 12px;
        outline: none;
        color: #4d3030;
    }

    .account-search input:focus {
        border-color: #a27d35;
        box-shadow: 0 0 0 3px rgba(230, 200, 117, .15);
    }

    .search-button {
        background: #4d0710;
        color: white;
    }

    .reset-button {
        background: #f4eee8;
        color: #654747;
    }

    .account-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .account-table {
        width: 100%;
        min-width: 1050px;
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

    .account-table tr:last-child td {
        border-bottom: none;
    }

    .student-name {
        color: #4d0710;
        font-weight: 800;
    }

    .student-email {
        color: #806e67;
    }

    .account-role,
    .account-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .account-role.siswa {
        background: #f1ece4;
        color: #803e2f;
    }

    .account-role.bendahara {
        background: #f7f1e7;
        color: #a27d35;
    }

    .account-status.active {
        background: #e9f1ec;
        color: #56856c;
    }

    .account-status.inactive {
        background: #f8eaea;
        color: #9a4e4e;
    }

    .account-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        min-width: 220px;
    }

    .account-actions .account-button {
        padding: 7px 9px;
        font-size: 10px;
    }

    .account-action-promote,
    .account-action-activate {
        background: #e9f1ec;
        color: #56856c;
    }

    .account-action-demote {
        background: #f7f1e7;
        color: #a27d35;
    }

    .account-action-deactivate {
        background: #f8eaea;
        color: #9a4e4e;
    }

    .edit-account-form {
        display: none;
        background: #fcfaf7;
        padding: 15px;
        border-radius: 10px;
        margin-top: 10px;
    }

    .edit-account-form.show {
        display: block;
    }

    .empty-state {
        text-align: center;
        color: #9a8982;
        padding: 30px !important;
    }

    /* PAGINATION */

    .account-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        border-top: 1px solid #eee5dc;
        padding-top: 18px;
        margin-top: 18px;
    }

    .pagination-info {
        color: #8b7772;
        font-size: 11px;
    }

    .pagination-links {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .pagination-links a,
    .pagination-links span {
        min-width: 32px;
        height: 32px;
        padding: 0 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #eee5dc;
        border-radius: 8px;
        background: #fff;
        color: #4d0710;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
    }

    .pagination-links a:hover {
        background: #faf5e9;
        border-color: #e6c875;
    }

    .pagination-links .active span {
        background: #4d0710;
        color: #fff;
        border-color: #4d0710;
    }

    .pagination-links .disabled span {
        color: #bdb5ab;
        background: #f8f6f2;
    }

    /* MODAL TAMBAH AKUN */

    .account-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(30, 3, 7, .65);
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow-y: auto;
    }

    .account-modal.show {
        display: flex;
    }

    .modal-content {
        background: #fff;
        width: 100%;
        max-width: 600px;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, .2);
        margin: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
    }

    .modal-header h3 {
        color: #4d0710;
        margin: 0;
        font-size: 18px;
        font-weight: 800;
    }

    .modal-close {
        border: none;
        background: #f4eee8;
        color: #4d0710;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 15px;
    }

    /* MODAL NOTIFIKASI DAN KONFIRMASI */

    .feedback-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 10010;
        background: rgba(30, 3, 7, .68);
        align-items: center;
        justify-content: center;
        padding: 20px;
        backdrop-filter: blur(4px);
    }

    .feedback-modal.show {
        display: flex;
    }

    .feedback-content {
        background: #fff;
        width: 100%;
        max-width: 420px;
        border-radius: 18px;
        padding: 30px 25px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
        animation: feedbackAppear .25s ease;
    }

    @keyframes feedbackAppear {
        from {
            opacity: 0;
            transform: translateY(15px) scale(.97);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .feedback-icon {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 17px;
        font-size: 30px;
        font-weight: 800;
    }

    .feedback-icon.success {
        background: #e9f1ec;
        color: #56856c;
    }

    .feedback-icon.error {
        background: #f8eaea;
        color: #a34d4d;
    }

    .feedback-icon.warning {
        background: #faf3df;
        color: #a27d35;
    }

    .feedback-content h3 {
        color: #4d0710;
        font-size: 19px;
        font-weight: 800;
        margin: 0 0 10px;
    }

    .feedback-content p {
        color: #806e67;
        font-size: 13px;
        line-height: 1.7;
        margin: 0 0 22px;
    }

    .feedback-errors {
        color: #9a4e4e;
        text-align: left;
        background: #fdf4f4;
        border: 1px solid #f0dada;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 12px;
        line-height: 1.7;
        margin: 0 0 20px;
    }

    .feedback-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .feedback-actions button {
        min-width: 105px;
    }

    @media (max-width: 768px) {
        .account-stats,
        .account-form-grid {
            grid-template-columns: 1fr;
        }

        .account-card {
            padding: 16px;
        }

        .modal-content {
            padding: 18px;
        }

        .feedback-content {
            padding: 25px 18px;
        }

        .account-search {
            width: 100%;
        }

        .account-search input {
            width: 100%;
        }

        .account-pagination {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="account-page">

    {{-- HEADER --}}
    <div class="account-header">
        <div>
            <h2>Manajemen Akun Siswa</h2>
            <p>Kelola akun login siswa kelas XII RPL 1.</p>
        </div>

        <button type="button"
            class="account-button button-primary"
            onclick="openAddAccountModal()">
            + Tambah Akun
        </button>
    </div>

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
    </div>

    <div class="account-note">
        <strong>Informasi:</strong>
        Password disimpan dalam bentuk terenkripsi dan tidak ditampilkan pada tabel akun.
    </div>

    {{-- MODAL TAMBAH AKUN --}}
    <div class="account-modal" id="addAccountModal">
        <div class="modal-content">

            <div class="modal-header">
                <h3>Tambah Akun Siswa</h3>

                <button type="button"
                    class="modal-close"
                    onclick="closeAddAccountModal()">
                    &times;
                </button>
            </div>

            <form method="POST"
                action="{{ route('wali-kelas.akun-siswa.store') }}">

                @csrf

                <div class="account-form-grid">

                    <div class="form-group">
                        <label for="name">Nama Lengkap Siswa</label>
                        <input type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text"
                            name="nis"
                            id="nis"
                            class="form-control"
                            value="{{ old('nis') }}"
                            placeholder="Masukkan NIS"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            placeholder="contoh@gmail.com"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Minimal 6 karakter"
                            required>
                        <div class="form-hint">
                            Password akan dienkripsi sebelum disimpan.
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                        class="account-button button-light"
                        onclick="closeAddAccountModal()">
                        Batal
                    </button>

                    <button type="submit"
                        class="account-button button-primary">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- DAFTAR AKUN --}}
    <div class="account-card">
        <h3>Daftar Akun Siswa</h3>

        {{-- PENCARIAN --}}
        <div class="account-toolbar">
            <div style="color:#8b7772; font-size:12px;">
                Cari akun berdasarkan nama, NIS, atau email.
            </div>

            <form method="GET"
                action="{{ url()->current() }}"
                class="account-search">

                <input type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama, NIS, atau email...">

                <button type="submit"
                    class="account-button search-button">
                    Cari
                </button>

                @if($search)
                    <a href="{{ url()->current() }}"
                        class="account-button reset-button">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="account-table-wrap">
            <table class="account-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Email Akun</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($studentsWithAccount as $student)
                        <tr>
                            <td>
                                {{ $studentsWithAccount->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <span class="student-name">
                                    {{ $student->name }}
                                </span>
                            </td>

                            <td>{{ $student->nis ?? '-' }}</td>

                            <td class="student-email">
                                {{ $student->user->email }}
                            </td>

                            <td>
                                <span style="color:#9a8982;">
                                    Tersimpan aman
                                </span>
                            </td>

                            <td>
                                @if($student->user->role === 'bendahara')
                                    <span class="account-role bendahara">
                                        Bendahara
                                    </span>
                                @else
                                    <span class="account-role siswa">
                                        Siswa
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($student->user->status === 'aktif')
                                    <span class="account-status active">
                                        Aktif
                                    </span>
                                @else
                                    <span class="account-status inactive">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="account-actions">

                                    <button type="button"
                                        class="account-button button-light"
                                        onclick="toggleEditForm({{ $student->id }})">
                                        Edit Email
                                    </button>

                                    <form method="POST"
                                        action="{{ url('/wali-kelas/akun-siswa/'.$student->id.'/reset-password') }}"
                                        onsubmit="return confirmResetPassword(event, {{ Js::from($student->name) }}, {{ $student->nis ? 'true' : 'false' }})">
                                        @csrf

                                        <button type="submit"
                                            class="account-button button-gold"
                                            {{ empty($student->nis) ? 'disabled' : '' }}>
                                            Reset Sandi
                                        </button>
                                    </form>

                                    @if($student->user->role === 'siswa')
                                        <form method="POST"
                                            action="{{ url('/wali-kelas/akun-siswa/'.$student->id.'/promote') }}"
                                            onsubmit="return showConfirm(event, 'Promosikan Akun?', 'Jadikan {{ addslashes($student->name) }} sebagai Bendahara?')">
                                            @csrf

                                            <button type="submit"
                                                class="account-button account-action-promote">
                                                Jadikan Bendahara
                                            </button>
                                        </form>
                                    @endif

                                    @if($student->user->role === 'bendahara')
                                        <form method="POST"
                                            action="{{ url('/wali-kelas/akun-siswa/'.$student->id.'/demote') }}"
                                            onsubmit="return showConfirm(event, 'Ubah Role Akun?', 'Kembalikan {{ addslashes($student->name) }} menjadi Siswa?')">
                                            @csrf

                                            <button type="submit"
                                                class="account-button account-action-demote">
                                                Kembalikan ke Siswa
                                            </button>
                                        </form>
                                    @endif

                                    @if($student->user->status === 'aktif')
                                        <form method="POST"
                                            action="{{ url('/wali-kelas/akun-siswa/'.$student->id.'/deactivate') }}"
                                            onsubmit="return showConfirm(event, 'Nonaktifkan Akun?', 'Akun {{ addslashes($student->name) }} tidak akan bisa digunakan untuk login selama dinonaktifkan.')">
                                            @csrf

                                            <button type="submit"
                                                class="account-button account-action-deactivate">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST"
                                            action="{{ url('/wali-kelas/akun-siswa/'.$student->id.'/activate') }}"
                                            onsubmit="return showConfirm(event, 'Aktifkan Akun?', 'Aktifkan kembali akun {{ addslashes($student->name) }}?')">
                                            @csrf

                                            <button type="submit"
                                                class="account-button account-action-activate">
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                </div>

                                {{-- EDIT EMAIL --}}
                                <div class="edit-account-form"
                                    id="editForm{{ $student->id }}">

                                    <form method="POST"
                                        action="{{ url('/wali-kelas/akun-siswa/'.$student->id) }}"
                                        onsubmit="return showConfirm(event, 'Simpan Perubahan?', 'Apakah kamu yakin ingin mengubah email akun ini?')">

                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label>Email Baru</label>

                                            <input type="email"
                                                name="email"
                                                class="form-control"
                                                value="{{ $student->user->email }}"
                                                required>
                                        </div>

                                        <button type="submit"
                                            class="account-button button-primary">
                                            Simpan Perubahan
                                        </button>

                                        <button type="button"
                                            class="account-button button-light"
                                            onclick="toggleEditForm({{ $student->id }})">
                                            Batal
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                @if($search)
                                    Akun siswa tidak ditemukan. Coba kata pencarian lain.
                                @else
                                    Belum ada akun siswa.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($studentsWithAccount->total() > 0)
            <div class="account-pagination">

                <div class="pagination-info">
                    Menampilkan
                    <strong>{{ $studentsWithAccount->firstItem() }}</strong>
                    -
                    <strong>{{ $studentsWithAccount->lastItem() }}</strong>
                    dari
                    <strong>{{ $studentsWithAccount->total() }}</strong>
                    akun
                </div>

                @if($studentsWithAccount->hasPages())
                    <div class="pagination-links">
                        @if($studentsWithAccount->onFirstPage())
                            <span class="disabled">‹</span>
                        @else
                            <a href="{{ $studentsWithAccount->previousPageUrl() }}">‹</a>
                        @endif

                        @foreach($studentsWithAccount->getUrlRange(1, $studentsWithAccount->lastPage()) as $page => $url)
                            @if($page == $studentsWithAccount->currentPage())
                                <span class="active"><span>{{ $page }}</span></span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($studentsWithAccount->hasMorePages())
                            <a href="{{ $studentsWithAccount->nextPageUrl() }}">›</a>
                        @else
                            <span class="disabled">›</span>
                        @endif
                    </div>
                @endif

            </div>
        @endif
    </div>
</div>

{{-- MODAL NOTIFIKASI --}}
<div class="feedback-modal" id="noticeModal">
    <div class="feedback-content">

        <div class="feedback-icon" id="noticeIcon">✓</div>

        <h3 id="noticeTitle">Berhasil</h3>

        <p id="noticeMessage"></p>

        <div class="feedback-errors" id="noticeErrors" style="display:none;"></div>

        <div class="feedback-actions">
            <button type="button"
                class="account-button button-primary"
                onclick="closeNoticeModal()">
                Mengerti
            </button>
        </div>

    </div>
</div>

{{-- MODAL KONFIRMASI --}}
<div class="feedback-modal" id="confirmModal">
    <div class="feedback-content">

        <div class="feedback-icon warning">!</div>

        <h3 id="confirmTitle">Konfirmasi Tindakan</h3>

        <p id="confirmMessage"></p>

        <div class="feedback-actions">
            <button type="button"
                class="account-button button-light"
                onclick="closeConfirmModal()">
                Batal
            </button>

            <button type="button"
                class="account-button button-primary"
                id="confirmSubmitButton"
                onclick="submitConfirmedForm()">
                Ya, Lanjutkan
            </button>
        </div>

    </div>
</div>

<script>
    // MODAL TAMBAH AKUN

    function openAddAccountModal() {
        document.getElementById('addAccountModal').classList.add('show');
    }

    function closeAddAccountModal() {
        document.getElementById('addAccountModal').classList.remove('show');
    }

    document.getElementById('addAccountModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeAddAccountModal();
        }
    });


    // MODAL NOTIFIKASI

    function showNotice(type, title, message, errors = []) {
        const modal = document.getElementById('noticeModal');
        const icon = document.getElementById('noticeIcon');
        const errorBox = document.getElementById('noticeErrors');

        icon.className = 'feedback-icon ' + type;

        if (type === 'success') {
            icon.textContent = '✓';
        } else {
            icon.textContent = '!';
        }

        document.getElementById('noticeTitle').textContent = title;
        document.getElementById('noticeMessage').textContent = message;

        if (errors.length > 0) {
            errorBox.style.display = 'block';
            errorBox.innerHTML = '';

            errors.forEach(function(error) {
                const item = document.createElement('div');
                item.textContent = '• ' + error;
                errorBox.appendChild(item);
            });
        } else {
            errorBox.style.display = 'none';
            errorBox.innerHTML = '';
        }

        modal.classList.add('show');
    }

    function closeNoticeModal() {
        document.getElementById('noticeModal').classList.remove('show');
    }


    // MODAL KONFIRMASI

    let pendingForm = null;

    function showConfirm(event, title, message) {
        event.preventDefault();

        pendingForm = event.currentTarget;

        document.getElementById('confirmTitle').textContent = title;
        document.getElementById('confirmMessage').textContent = message;

        document.getElementById('confirmModal').classList.add('show');

        return false;
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.remove('show');
        pendingForm = null;
    }

    function submitConfirmedForm() {
        if (pendingForm) {
            const form = pendingForm;
            pendingForm = null;

            document.getElementById('confirmModal').classList.remove('show');

            form.submit();
        }
    }


    // KONFIRMASI RESET PASSWORD

    function confirmResetPassword(event, name, hasNis) {
        event.preventDefault();

        if (!hasNis) {
            showNotice(
                'error',
                'Reset Tidak Dapat Dilakukan',
                'Siswa ini belum memiliki NIS. Password tidak dapat di-reset.'
            );

            return false;
        }

        return showConfirm(
            event,
            'Reset Password?',
            'Password akun ' + name + ' akan dikembalikan menggunakan NIS siswa. Lanjutkan?'
        );
    }


    // EDIT EMAIL

    function toggleEditForm(studentId) {
        const form = document.getElementById('editForm' + studentId);

        if (form) {
            form.classList.toggle('show');
        }
    }


    // TUTUP MODAL DENGAN KLIK AREA LUAR

    document.getElementById('noticeModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeNoticeModal();
        }
    });

    document.getElementById('confirmModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeConfirmModal();
        }
    });


    // TUTUP MODAL DENGAN ESCAPE

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAddAccountModal();
            closeNoticeModal();
            closeConfirmModal();
        }
    });


    // NOTIFIKASI DARI LARAVEL

    @if(session('success'))
        showNotice(
            'success',
            'Berhasil!',
            {{ Js::from(session('success')) }}
        );
    @elseif(session('error'))
        showNotice(
            'error',
            'Terjadi Kesalahan',
            {{ Js::from(session('error')) }}
        );
    @elseif($errors->any())
        showNotice(
            'error',
            'Data Belum Sesuai',
            'Periksa kembali data yang kamu masukkan.',
            {{ Js::from($errors->all()) }}
        );
    @endif
</script>

@endsection
