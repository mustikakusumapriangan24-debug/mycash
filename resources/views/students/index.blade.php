@php
    $layout = auth()->user()->role === 'wali_kelas'
        ? 'layouts.wali-kelas'
        : 'layouts.bendahara';

    $canManageStudents = auth()->user()->role === 'wali_kelas';
@endphp

@extends($layout)

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
    }

    .page-title h1 {
        font-family: "Playfair Display", serif;
        font-size: 30px;
        color: var(--maroon-deep);
    }

    .page-title p {
        margin-top: 7px;
        font-size: 12px;
        color: var(--text-soft);
    }

    .btn {
        padding: 11px 17px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: .2s;
    }

    .btn-primary {
        background: linear-gradient(
            135deg,
            var(--maroon),
            var(--maroon-dark)
        );
        color: white;
        box-shadow: 0 7px 18px rgba(84, 37, 31, .15);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(84, 37, 31, .20);
    }

    .btn-warning {
        background: #B59A63;
        color: white;
    }

    .btn-danger {
        background: #9B5750;
        color: white;
    }

    .btn-cancel {
        background: #E7E0D8;
        color: var(--text);
    }

    .alert {
        padding: 13px 17px;
        border-radius: 11px;
        margin-bottom: 20px;
        font-size: 12px;
        background: #E9F1EC;
        color: var(--green);
        border: 1px solid #CBDDD2;
    }

    .students-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(45, 28, 20, .055);
    }

    .card-header {
        padding: 20px 22px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h2 {
        font-family: "Playfair Display", serif;
        font-size: 18px;
        color: var(--maroon-dark);
    }

    .card-header p {
        margin-top: 4px;
        font-size: 10px;
        color: var(--text-soft);
    }

    .table-toolbar {
        padding: 16px 22px;
        display: flex;
        justify-content: flex-end;
        border-bottom: 1px solid var(--border);
    }

    .search-form {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 280px;
    }

    .search-input {
        width: 100%;
        padding: 10px 13px;
        border: 1px solid var(--border);
        border-radius: 9px;
        outline: none;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 11px;
        color: var(--text);
        background: #FFFEFC;
    }

    .search-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(181, 154, 99, .10);
    }

    .search-btn {
        padding: 10px 13px;
        border: none;
        border-radius: 9px;
        background: var(--maroon);
        color: white;
        cursor: pointer;
        transition: .2s;
    }

    .search-btn:hover {
        background: var(--maroon-dark);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        padding: 13px 18px;
        text-align: left;
        background: #FAF8F4;
        border-bottom: 1px solid var(--border);
        color: var(--text-soft);
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: .7px;
    }

    td {
        padding: 15px 18px;
        border-bottom: 1px solid #EEE8E0;
        font-size: 11px;
        color: var(--text);
    }

    tbody tr:hover {
        background: #FCFAF7;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .number {
        color: var(--text-soft);
        width: 50px;
    }

    .nis {
        color: var(--text-soft);
    }

    .student-name {
        font-weight: 700;
        color: var(--maroon-deep);
    }

    .gender-badge {
        display: inline-flex;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
    }

    .gender-l {
        background: #EEE8E0;
        color: var(--maroon-dark);
    }

    .gender-p {
        background: #F1ECE4;
        color: #8C6C61;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 6px;
    }

    .action-buttons .btn {
        padding: 7px 9px;
        font-size: 11px;
    }

    .empty-state {
        text-align: center;
        padding: 55px 20px;
        color: var(--text-soft);
    }

    .empty-state i {
        font-size: 28px;
        color: var(--gold);
        margin-bottom: 12px;
    }

    .empty-state p {
        font-size: 12px;
    }

    /* PAGINATION PANAH */
    .pagination-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 22px;
        border-top: 1px solid var(--border);
    }

    .pagination-info {
        font-size: 10px;
        color: var(--text-soft);
    }

    .pagination-arrows {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .pagination-arrows a,
    .pagination-arrows span {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--maroon);
        text-decoration: none;
        font-size: 12px;
        background: white;
        transition: .2s;
    }

    .pagination-arrows a:hover {
        background: var(--maroon);
        color: white;
        border-color: var(--maroon);
    }

    .pagination-arrows .disabled {
        opacity: .35;
        cursor: not-allowed;
    }

    .modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(31, 29, 32, .55);
        align-items: center;
        justify-content: center;
        z-index: 2000;
        padding: 20px;
    }

    .modal-content {
        width: 100%;
        max-width: 500px;
        background: var(--white);
        border-radius: 17px;
        padding: 25px;
        box-shadow: 0 20px 50px rgba(31, 29, 32, .20);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
    }

    .modal-header h3 {
        font-family: "Playfair Display", serif;
        font-size: 20px;
        color: var(--maroon-dark);
    }

    .close-btn {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        background: #F1ECE4;
        color: var(--text-soft);
        cursor: pointer;
        font-size: 20px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 11px;
        font-weight: 700;
        color: var(--text);
    }

    .form-control {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: #FFFEFC;
        color: var(--text);
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 12px;
        outline: none;
        transition: .2s;
    }

    .form-control:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(181, 154, 99, .10);
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 22px;
    }

    @media (max-width: 700px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .page-header .btn {
            width: 100%;
            justify-content: center;
        }

        .card-header {
            align-items: flex-start;
        }
    }

    @media (max-width: 500px) {
        .table-toolbar {
            justify-content: stretch;
        }

        .search-form {
            width: 100%;
        }

        .pagination-footer {
            gap: 10px;
            flex-wrap: wrap;
        }
    }
</style>

<div class="page-header">
    <div class="page-title">
        <h1>Data Siswa</h1>

        <p>
            @if($canManageStudents)
                Kelola data siswa kelas XI RPL 1.
            @else
                Data siswa kelas XI RPL 1.
            @endif
        </p>
    </div>

    @if($canManageStudents)
        <button
            class="btn btn-primary"
            onclick="openModal('addModal')"
        >
            <i class="fa-solid fa-plus"></i>
            Tambah Siswa
        </button>
    @endif
</div>

@if(session('success'))
    <div class="alert">
        <i class="fa-solid fa-circle-check"></i>
        &nbsp;
        {{ session('success') }}
    </div>
@endif

<div class="students-card">

    <div class="card-header">
        <div>
            <h2>Daftar Siswa</h2>

            <p>
                Data siswa aktif kelas XI RPL 1
            </p>
        </div>
    </div>

    {{-- FORM PENCARIAN --}}
    <div class="table-toolbar">
        <form
            action="{{ url()->current() }}"
            method="GET"
            class="search-form"
        >
            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="Cari nama, NIS, atau nomor HP..."
                value="{{ $search ?? '' }}"
            >

            <button
                type="submit"
                class="search-btn"
                title="Cari"
            >
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th width="6%">No</th>
                    <th width="15%">NIS</th>
                    <th width="34%">Nama Lengkap</th>
                    <th width="15%">Jenis Kelamin</th>
                    <th width="18%">No HP / WA</th>

                    @if($canManageStudents)
                        <th width="12%" style="text-align:center;">
                            Aksi
                        </th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse($students as $index => $student)
                    <tr>
                        <td class="number">
                            {{ $students->firstItem() + $index }}
                        </td>

                        <td class="nis">
                            {{ $student->nis ?? '-' }}
                        </td>

                        <td>
                            <div class="student-name">
                                {{ $student->name }}
                            </div>
                        </td>

                        <td>
                            @if($student->gender === 'L')
                                <span class="gender-badge gender-l">
                                    Laki-laki
                                </span>
                            @else
                                <span class="gender-badge gender-p">
                                    Perempuan
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $student->phone ?? '-' }}
                        </td>

                        @if($canManageStudents)
                            <td>
                                <div class="action-buttons">
                                    <button
                                        type="button"
                                        class="btn btn-warning"
                                        onclick="openEditModal(
                                            {{ $student->id }},
                                            @js($student->nis),
                                            @js($student->name),
                                            @js($student->gender),
                                            @js($student->phone)
                                        )"
                                        title="Edit"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </button>

                                    <form
                                        action="{{ route('students.destroy', $student->id) }}"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus siswa ini?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                            title="Hapus"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $canManageStudents ? 6 : 5 }}">
                            <div class="empty-state">
                                <i class="fa-solid fa-users"></i>

                                @if(!empty($search))
                                    <p>
                                        Data siswa dengan kata kunci
                                        "{{ $search }}" tidak ditemukan.
                                    </p>
                                @else
                                    <p>
                                        Belum ada data siswa.
                                    </p>

                                    @if($canManageStudents)
                                        <p style="margin-top:5px;">
                                            Silakan klik "Tambah Siswa"
                                            untuk menambahkan data.
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION PANAH --}}
    <div class="pagination-footer">

        <div class="pagination-info">
            @if($students->total() > 0)
                Menampilkan {{ $students->firstItem() }}
                - {{ $students->lastItem() }}
                dari {{ $students->total() }} siswa
            @else
                Tidak ada data siswa
            @endif
        </div>

        <div class="pagination-arrows">

            @if($students->onFirstPage())
                <span class="disabled" title="Halaman sebelumnya">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a
                    href="{{ $students->previousPageUrl() }}"
                    title="Halaman sebelumnya"
                >
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            @if($students->hasMorePages())
                <a
                    href="{{ $students->nextPageUrl() }}"
                    title="Halaman berikutnya"
                >
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="disabled" title="Halaman berikutnya">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif

        </div>
    </div>

</div>


{{-- ========================================================= --}}
{{-- MODAL TAMBAH SISWA - HANYA UNTUK WALI KELAS --}}
{{-- ========================================================= --}}

@if($canManageStudents)

<div class="modal" id="addModal">
    <div class="modal-content">

        <div class="modal-header">
            <h3>Tambah Data Siswa</h3>

            <button
                type="button"
                class="close-btn"
                onclick="closeModal('addModal')"
            >
                &times;
            </button>
        </div>

        <form
            action="{{ route('students.store') }}"
            method="POST"
        >
            @csrf

            <div class="form-group">
                <label>NIS</label>

                <input
                    type="text"
                    name="nis"
                    class="form-control"
                    placeholder="Masukkan NIS"
                    required
                >
            </div>

            <div class="form-group">
                <label>Nama Lengkap Siswa</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Masukkan nama lengkap"
                    required
                >
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>

                <select
                    name="gender"
                    class="form-control"
                    required
                >
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label>No HP / WA</label>

                <input
                    type="text"
                    name="phone"
                    class="form-control"
                    placeholder="Masukkan nomor HP / WhatsApp"
                >
            </div>

            <div class="form-group">
                <label>Email Akun Siswa</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Masukkan email siswa"
                    required
                >
            </div>

            <div class="modal-actions">
                <button
                    type="button"
                    class="btn btn-cancel"
                    onclick="closeModal('addModal')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Siswa
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ========================================================= --}}
{{-- MODAL EDIT SISWA - HANYA UNTUK WALI KELAS --}}
{{-- ========================================================= --}}

<div class="modal" id="editModal">
    <div class="modal-content">

        <div class="modal-header">
            <h3>Edit Data Siswa</h3>

            <button
                type="button"
                class="close-btn"
                onclick="closeModal('editModal')"
            >
                &times;
            </button>
        </div>

        <form
            id="editForm"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>NIS</label>

                <input
                    type="text"
                    name="nis"
                    id="edit_nis"
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group">
                <label>Nama Lengkap Siswa</label>

                <input
                    type="text"
                    name="name"
                    id="edit_name"
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>

                <select
                    name="gender"
                    id="edit_gender"
                    class="form-control"
                    required
                >
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label>No HP / WA</label>

                <input
                    type="text"
                    name="phone"
                    id="edit_phone"
                    class="form-control"
                >
            </div>

            <div class="form-group">
                <label>Email Akun Siswa</label>

                <input
                    type="email"
                    name="email"
                    id="edit_email"
                    class="form-control"
                    required
                >
            </div>

            <div class="modal-actions">
                <button
                    type="button"
                    class="btn btn-cancel"
                    onclick="closeModal('editModal')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fa-solid fa-floppy-disk"></i>
                    Perbarui Siswa
                </button>
            </div>
        </form>
    </div>
</div>

@endif


<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function openEditModal(
        id,
        nis,
        name,
        gender,
        phone
    ) {
        document.getElementById('editForm').action =
            '/students/' + id;

        document.getElementById('edit_nis').value =
            nis ?? '';

        document.getElementById('edit_name').value =
            name ?? '';

        document.getElementById('edit_gender').value =
            gender ?? 'L';

        document.getElementById('edit_phone').value =
            phone ?? '';

        openModal('editModal');
    }

    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });
</script>

@endsection
