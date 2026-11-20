@extends('layouts.wali-kelas')

@section('content')

@php
    $search = request('search');

    $students = \App\Models\Student::with('user')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('gender', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('email', 'like', "%{$search}%");
                  });
            });
        })
        ->orderBy('name', 'asc')
        ->paginate(10)
        ->withQueryString();

    $totalStudents = \App\Models\Student::count();

    $totalAccounts = \App\Models\Student::whereNotNull('user_id')->count();

    $studentsWithoutAccount = $totalStudents - $totalAccounts;
@endphp

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

    .account-header-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
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

    .stat-card,
    .account-card {
        background: #fff;
        border: 1px solid #eee5dc;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(77, 7, 16, .04);
    }

    .stat-card {
        padding: 20px;
    }

    .stat-card span {
        display: block;
        color: #927d75;
        font-size: 12px;
        margin-bottom: 9px;
    }

    .stat-card strong {
        color: #4d0710;
        font-size: 25px;
        font-weight: 800;
    }

    .account-card {
        padding: 22px;
        margin-bottom: 22px;
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
        padding: 13px 16px;
        border-radius: 10px;
        font-size: 12px;
        margin-bottom: 20px;
        line-height: 1.7;
    }

    .account-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 8px;
        padding: 9px 12px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: .2s;
        white-space: nowrap;
    }

    .account-button:hover {
        opacity: .85;
        transform: translateY(-1px);
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

    .button-green {
        background: #e9f1ec;
        color: #56856c;
    }

    .button-delete {
        background: #f8eaea;
        color: #a13e3e;
    }

    .account-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
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
    }

    .account-search input:focus,
    .form-control:focus {
        border-color: #a27d35;
        box-shadow: 0 0 0 3px rgba(230, 200, 117, .15);
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

    .account-role.no-account {
        background: #f1f1f1;
        color: #777;
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
        flex-wrap: nowrap;
        gap: 6px;
        min-width: 330px;
        align-items: center;
    }

    .account-action-slot {
        display: flex;
        flex: 0 0 auto;
    }

    .account-action-slot form {
        display: flex;
        margin: 0;
    }

    .account-actions .account-button,
    .account-action-slot .account-button {
        box-sizing: border-box;
        width: auto;
        padding: 7px 9px;
        font-size: 10px;
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

    .form-hint {
        color: #9a8982;
        font-size: 11px;
        margin-top: 6px;
    }

    .account-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .edit-account-modal .modal-content {
        max-height: calc(100vh - 40px);
        overflow-y: auto;
    }

    .empty-state {
        text-align: center;
        color: #9a8982;
        padding: 30px !important;
    }

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

    .pagination-links .active {
        background: #4d0710;
        color: #fff;
        border-color: #4d0710;
    }

    .pagination-links .disabled {
        color: #bdb5ab;
        background: #f8f6f2;
    }

    .account-modal,
    .feedback-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(30, 3, 7, .68);
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow-y: auto;
    }

    .account-modal.show,
    .feedback-modal.show {
        display: flex;
    }

    .modal-content {
        background: #fff;
        width: 100%;
        max-width: 600px;
        border-radius: 16px;
        padding: 25px;
        margin: auto;
        box-shadow: 0 15px 50px rgba(0, 0, 0, .2);
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

    .feedback-content {
        background: #fff;
        width: 100%;
        max-width: 440px;
        border-radius: 18px;
        padding: 30px 25px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
        margin: auto;
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
        white-space: pre-line;
    }

    .feedback-actions {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
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
            <h2>Data Siswa & Bendahara</h2>
            <p>Kelola data siswa dan akun login kelas XII RPL 1.</p>
        </div>

        <div class="account-header-actions">
            @if($studentsWithoutAccount > 0)
                <form method="POST"
                    action="{{ route('wali-kelas.akun-siswa.buat-semua') }}"
                    onsubmit="return confirmAction(event, 'Buat Akun Seluruh Siswa?', 'Akun akan dibuat untuk semua siswa yang belum memiliki akun. Email login menggunakan NIS@mycash.com dan password awal menggunakan NIS.')">

                    @csrf

                    <button type="submit"
                        class="account-button button-gold">
                        Buat Akun Seluruh Siswa
                    </button>
                </form>
            @endif

            <button type="button"
                class="account-button button-primary"
                onclick="openAddAccountModal()">
                + Tambah Siswa Baru
            </button>
        </div>
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

        <div class="stat-card">
            <span>Belum Memiliki Akun</span>
            <strong>{{ $studentsWithoutAccount }}</strong>
        </div>
    </div>

    <div class="account-note">
        <strong>Informasi Akun:</strong>
        Akun siswa menggunakan alias login NIS@mycash.com dan password awal NIS.
        Akun yang sudah ada tidak diubah.
        Password disimpan dalam bentuk terenkripsi.
    </div>

    {{-- MODAL TAMBAH SISWA BARU / BUAT AKUN --}}
    <div class="account-modal" id="addAccountModal">
        <div class="modal-content">

            <div class="modal-header">
                <h3 id="addModalTitle">Tambah Siswa Baru</h3>

                <button type="button"
                    class="modal-close"
                    onclick="closeAddAccountModal()">
                    &times;
                </button>
            </div>

            <form method="POST"
                action="{{ route('wali-kelas.akun-siswa.store') }}"
                id="addStudentForm">

                @csrf

                <div class="account-form-grid">

                    <div class="form-group">
                        <label>Nama Lengkap Siswa</label>
                        <input type="text"
                            name="name"
                            id="newStudentName"
                            class="form-control"
                            placeholder="Masukkan nama lengkap"
                            required>
                    </div>

                    <div class="form-group">
                        <label>NIS</label>
                        <input type="text"
                            name="nis"
                            id="newStudentNis"
                            class="form-control"
                            placeholder="Masukkan NIS siswa"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="gender"
                            id="newStudentGender"
                            class="form-control"
                            required>
                            <option value="">Pilih jenis kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                </div>

                <div class="account-note" id="addModalNote">
                    Email login dan password awal akun akan otomatis menggunakan NIS siswa.
                </div>

                <div class="modal-footer">
                    <button type="button"
                        class="account-button button-light"
                        onclick="closeAddAccountModal()">
                        Batal
                    </button>

                    <button type="submit"
                        class="account-button button-primary"
                        id="addSubmitButton">
                        Simpan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL DATA SISWA --}}
    <div class="account-card">

        <h3>Daftar Data Siswa & Bendahara</h3>

        <div class="account-toolbar">
            <div style="color:#8b7772; font-size:12px;">
                Menampilkan seluruh siswa, termasuk yang belum memiliki akun.
            </div>

            <form method="GET"
                action="{{ url()->current() }}"
                class="account-search">

                <input type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama, NIS, atau email...">

                <button type="submit"
                    class="account-button button-primary">
                    Cari
                </button>

                @if($search)
                    <a href="{{ url()->current() }}"
                        class="account-button button-light">
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
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Gender</th>
                        <th>Peran</th>
                        <th>Email Login</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($students as $student)

                        <tr>
                            <td>
                                {{ $students->firstItem() + $loop->index }}
                            </td>

                            <td>{{ $student->nis ?? '-' }}</td>

                            <td>
                                <span class="student-name">
                                    {{ $student->name }}
                                </span>
                            </td>

                            <td>
                                @if(in_array(strtolower((string) $student->gender), ['l', 'laki-laki', 'laki laki']))
                                    Laki-laki
                                @elseif(in_array(strtolower((string) $student->gender), ['p', 'perempuan']))
                                    Perempuan
                                @else
                                    {{ $student->gender ?? '-' }}
                                @endif
                            </td>

                            <td>
                                @if(!$student->user)
                                    <span class="account-role no-account">
                                        Belum Ada Akun
                                    </span>
                                @elseif($student->user->role === 'bendahara')
                                    <span class="account-role bendahara">
                                        Bendahara
                                    </span>
                                @else
                                    <span class="account-role siswa">
                                        Siswa
                                    </span>
                                @endif
                            </td>

                            <td class="student-email">
                                {{ $student->user?->email ?? '-' }}

                                @if($student->user && $student->user->status === 'nonaktif')
                                    <div style="margin-top:5px;">
                                        <span class="account-status inactive">
                                            Nonaktif
                                        </span>
                                    </div>
                                @elseif($student->user)
                                    <div style="margin-top:5px;">
                                        <span class="account-status active">
                                            Aktif
                                        </span>
                                    </div>
                                @endif
                            </td>

                            <td>
                                <div class="account-actions">

                                    @if(!$student->user)

                                        <div class="account-action-slot">
                                            <button type="button"
                                                class="account-button button-light"
                                                onclick="toggleEditForm({{ $student->id }})">
                                                Edit Data
                                            </button>
                                        </div>

                                        <div class="account-action-slot">
                                            <button type="button"
                                                class="account-button button-primary"
                                                onclick="openExistingStudentAccount(
                                                    {{ Js::from($student->name) }},
                                                    {{ Js::from($student->nis) }},
                                                    {{ Js::from($student->gender) }}
                                                )">
                                                Buat Akun
                                            </button>
                                        </div>

                                    @else

                                        <div class="account-action-slot">
                                            <button type="button"
                                                class="account-button button-light"
                                                onclick="toggleEditForm({{ $student->id }})">
                                                Edit Data
                                            </button>
                                        </div>

                                        {{-- RESET PASSWORD --}}
                                        <div class="account-action-slot">
                                            <form method="POST"
                                                action="{{ route('wali-kelas.akun-siswa.reset-password', $student->id) }}"
                                                onsubmit="return confirmAction(event, 'Reset Password?', 'Password {{ $student->name }} akan dikembalikan menggunakan NIS siswa.')">

                                                @csrf

                                                <button type="submit"
                                                    class="account-button button-gold">
                                                    Reset Password
                                                </button>
                                            </form>
                                        </div>

                                        {{-- PROMOSI / DEMOSI --}}
                                        @if($student->user->role === 'siswa')

                                            <div class="account-action-slot">
                                                <form method="POST"
                                                    action="{{ route('wali-kelas.akun-siswa.promote', $student->id) }}"
                                                    onsubmit="return confirmAction(event, 'Tetapkan Bendahara?', 'Apakah Anda yakin ingin menetapkan {{ $student->name }} sebagai Bendahara Kelas?')">

                                                    @csrf

                                                    <button type="submit"
                                                        class="account-button button-green">
                                                        Jadikan Bendahara
                                                    </button>
                                                </form>
                                            </div>

                                        @elseif($student->user->role === 'bendahara')

                                            <div class="account-action-slot">
                                                <form method="POST"
                                                    action="{{ route('wali-kelas.akun-siswa.demote', $student->id) }}"
                                                    onsubmit="return confirmAction(event, 'Kembalikan Menjadi Siswa?', 'Apakah Anda yakin ingin mengembalikan {{ $student->name }} menjadi Siswa?')">

                                                    @csrf

                                                    <button type="submit"
                                                        class="account-button button-gold">
                                                        Kembalikan ke Siswa
                                                    </button>
                                                </form>
                                            </div>

                                        @endif

                                    @endif

                                    {{-- HAPUS DATA --}}
                                    <div class="account-action-slot">
                                        <form method="POST"
                                            action="{{ route('wali-kelas.akun-siswa.destroy', $student->id) }}"
                                            onsubmit="return confirmAction(event, 'Hapus Data Siswa?', 'Apakah Anda yakin ingin menghapus data {{ $student->name }}? Penghapusan dibatalkan jika masih ada riwayat pembayaran.')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="account-button button-delete">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>

                                </div>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="empty-state">
                                @if($search)
                                    Data siswa tidak ditemukan.
                                @else
                                    Belum ada data siswa.
                                @endif
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- MODAL EDIT DATA SISWA --}}
        @foreach($students as $student)
            <div class="account-modal edit-account-modal"
                id="editForm{{ $student->id }}">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3>Edit Data Siswa</h3>

                        <button type="button"
                            class="modal-close"
                            aria-label="Tutup"
                            onclick="closeEditForm({{ $student->id }})">
                            &times;
                        </button>
                    </div>

                    <form method="POST"
                        action="{{ route('wali-kelas.akun-siswa.update', $student->id) }}">

                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Lengkap Siswa</label>
                            <input type="text"
                                name="name"
                                class="form-control"
                                value="{{ $student->name }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text"
                                name="nis"
                                class="form-control"
                                value="{{ $student->nis }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender"
                                class="form-control"
                                required>
                                <option value="L"
                                    {{ in_array(strtolower((string) $student->gender), ['l', 'laki-laki', 'laki laki']) ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P"
                                    {{ in_array(strtolower((string) $student->gender), ['p', 'perempuan']) ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Email Login</label>
                            <input type="email"
                                name="email"
                                class="form-control"
                                value="{{ $student->user?->email }}"
                                {{ $student->user ? '' : 'disabled' }}
                                placeholder="Email akun siswa">
                        </div>

                        @if($student->user)
                            <div class="form-group">
                                <label>Password Baru (Opsional)</label>
                                <input type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Kosongkan jika tidak ingin mengubah password">
                            </div>
                        @endif

                        <div class="modal-footer">
                            <button type="button"
                                class="account-button button-light"
                                onclick="closeEditForm({{ $student->id }})">
                                Batal
                            </button>

                            <button type="submit"
                                class="account-button button-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- PAGINATION --}}
        @if($students->total() > 0)

            <div class="account-pagination">

                <div class="pagination-info">
                    Menampilkan
                    <strong>{{ $students->firstItem() }}</strong>
                    -
                    <strong>{{ $students->lastItem() }}</strong>
                    dari
                    <strong>{{ $students->total() }}</strong>
                    siswa
                </div>

                <div class="pagination-links">

                    @if($students->onFirstPage())
                        <span class="disabled">‹</span>
                    @else
                        <a href="{{ $students->previousPageUrl() }}">‹</a>
                    @endif

                    @foreach($students->getUrlRange(1, $students->lastPage()) as $page => $url)

                        @if($page == $students->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif

                    @endforeach

                    @if($students->hasMorePages())
                        <a href="{{ $students->nextPageUrl() }}">›</a>
                    @else
                        <span class="disabled">›</span>
                    @endif

                </div>

            </div>

        @endif

    </div>
</div>


{{-- MODAL NOTIFIKASI --}}
<div class="feedback-modal" id="noticeModal">
    <div class="feedback-content">

        <div class="feedback-icon" id="noticeIcon">!</div>

        <h3 id="noticeTitle">Informasi</h3>

        <p id="noticeMessage"></p>

        <div class="feedback-actions">
            <button type="button"
                class="account-button button-primary"
                onclick="closeNoticeModal()">
                Tutup
            </button>
        </div>

    </div>
</div>


{{-- MODAL KONFIRMASI --}}
<div class="feedback-modal" id="confirmModal">
    <div class="feedback-content">

        <div class="feedback-icon warning">!</div>

        <h3 id="confirmTitle">Konfirmasi</h3>

        <p id="confirmMessage"></p>

        <div class="feedback-actions">

            <button type="button"
                class="account-button button-light"
                onclick="closeConfirmModal()">
                Batal
            </button>

            <button type="button"
                class="account-button button-primary"
                onclick="submitConfirmedForm()">
                Ya, Lanjutkan
            </button>

        </div>

    </div>
</div>


{{-- MODAL DATA TIDAK DAPAT DIHAPUS --}}
<div class="feedback-modal" id="deleteBlockedModal">
    <div class="feedback-content">

        <div class="feedback-icon error">!</div>

        <h3>Tidak Dapat Dihapus</h3>

        <p id="deleteBlockedMessage"></p>

        <div class="feedback-actions">
            <button type="button"
                class="account-button button-primary"
                onclick="closeDeleteBlockedModal()">
                Tutup
            </button>
        </div>

    </div>
</div>


<script>
    // MODAL TAMBAH SISWA BARU

    function openAddAccountModal() {
        const form = document.getElementById('addStudentForm');

        form.reset();

        document.getElementById('addModalTitle').textContent =
            'Tambah Siswa Baru';

        document.getElementById('addSubmitButton').textContent =
            'Simpan Siswa';

        document.getElementById('addModalNote').textContent =
            'Email login dibuat dari NIS dengan format NIS@mycash.com. Password awal menggunakan NIS siswa.';

        document.getElementById('addAccountModal').classList.add('show');
    }

    // MODAL BUAT AKUN UNTUK SISWA YANG SUDAH ADA

    function openExistingStudentAccount(name, nis, gender) {
        const form = document.getElementById('addStudentForm');

        form.reset();

        document.getElementById('newStudentName').value = name ?? '';
        document.getElementById('newStudentNis').value = nis ?? '';
        document.getElementById('newStudentGender').value = gender ?? '';

        document.getElementById('addModalTitle').textContent =
            'Buat Akun Siswa';

        document.getElementById('addSubmitButton').textContent =
            'Buat Akun';

        document.getElementById('addModalNote').textContent =
            'Data siswa yang sudah ada akan digunakan. Email login dan password awal dibuat menggunakan NIS siswa.';

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


    // EDIT DATA

    function toggleEditForm(studentId) {
        const modal = document.getElementById('editForm' + studentId);

        if (modal) {
            modal.classList.add('show');
        }
    }

    function closeEditForm(studentId) {
        const modal = document.getElementById('editForm' + studentId);

        if (modal) {
            modal.classList.remove('show');
        }
    }

    document.querySelectorAll('.edit-account-modal').forEach(function(modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('show');
            }
        });
    });


    // MODAL NOTIFIKASI

    function showNotice(type, title, message) {
        const modal = document.getElementById('noticeModal');
        const icon = document.getElementById('noticeIcon');

        icon.className = 'feedback-icon ' + type;
        icon.textContent = type === 'success' ? '✓' : '!';

        document.getElementById('noticeTitle').textContent = title;
        document.getElementById('noticeMessage').textContent = message;

        modal.classList.add('show');
    }

    function closeNoticeModal() {
        document.getElementById('noticeModal').classList.remove('show');
    }


    // MODAL KONFIRMASI

    let pendingForm = null;

    function confirmAction(event, title, message) {
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
        if (!pendingForm) {
            return;
        }

        const form = pendingForm;
        pendingForm = null;

        document.getElementById('confirmModal').classList.remove('show');

        form.submit();
    }


    // MODAL PENGHAPUSAN DITOLAK

    function closeDeleteBlockedModal() {
        document.getElementById('deleteBlockedModal').classList.remove('show');
    }


    // TUTUP MODAL DENGAN KLIK AREA LUAR

    document.querySelectorAll('.feedback-modal').forEach(function(modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === this) {
                this.classList.remove('show');
                pendingForm = null;
            }
        });
    });


    // TUTUP MODAL DENGAN ESCAPE

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAddAccountModal();
            closeNoticeModal();
            closeConfirmModal();
            closeDeleteBlockedModal();
        }
    });


    // NOTIFIKASI DARI LARAVEL

    @if(session('success'))
        showNotice(
            'success',
            'Berhasil!',
            {{ Js::from(session('success')) }}
        );
    @elseif(session('error') && !session('delete_blocked'))
        showNotice(
            'error',
            'Terjadi Kesalahan',
            {{ Js::from(session('error')) }}
        );
    @elseif($errors->any())
        showNotice(
            'error',
            'Data Belum Sesuai',
            {{ Js::from($errors->first()) }}
        );
    @endif


    // MODAL JIKA DATA MASIH MEMILIKI RIWAYAT PEMBAYARAN

    @if(session('delete_blocked'))
        document.getElementById('deleteBlockedMessage').textContent =
            {{ Js::from(
                'Data siswa ' . session('delete_blocked.name') .
                ' masih memiliki ' . session('delete_blocked.count') .
                ' riwayat pembayaran. Data tidak dapat dihapus untuk menjaga riwayat pembukuan kas.'
            ) }};

        document.getElementById('deleteBlockedModal').classList.add('show');
    @endif

</script>

@endsection
