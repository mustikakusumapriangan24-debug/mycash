@extends('layouts.wali-kelas')

@section('title', 'Data Siswa - MyCash')

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

    /* =========================
       MODAL
    ========================= */

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
</style>


<!-- HEADER -->

<div class="page-header">

    <div class="page-title">

        <h1>
            Data Siswa
        </h1>

        <p>
            Kelola data siswa kelas XI RPL 1.
        </p>

    </div>

    <button
        class="btn btn-primary"
        onclick="openModal('addModal')"
    >
        <i class="fa-solid fa-plus"></i>
        Tambah Siswa
    </button>

</div>


<!-- SUCCESS ALERT -->

@if(session('success'))

    <div class="alert">

        <i class="fa-solid fa-circle-check"></i>

        &nbsp;

        {{ session('success') }}

    </div>

@endif


<!-- DATA SISWA -->

<div class="students-card">

    <div class="card-header">

        <div>

            <h2>
                Daftar Siswa
            </h2>

            <p>
                Data siswa aktif kelas XI RPL 1
            </p>

        </div>

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

                    <th width="12%" style="text-align:center;">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($students as $index => $student)

                    <tr>

                        <td class="number">
                            {{ $index + 1 }}
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

                        <td>

                            <div class="action-buttons">

                                <!-- EDIT -->

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


                                <!-- HAPUS -->

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

                    </tr>

                @empty

                    <tr>

                        <td colspan="6">

                            <div class="empty-state">

                                <i class="fa-solid fa-users"></i>

                                <p>
                                    Belum ada data siswa.
                                </p>

                                <p style="margin-top:5px;">
                                    Silakan klik "Tambah Siswa" untuk menambahkan data.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<!-- MODAL TAMBAH -->

<div
    class="modal"
    id="addModal"
>

    <div class="modal-content">

        <div class="modal-header">

            <h3>
                Tambah Data Siswa
            </h3>

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
                >

            </div>


            <div class="form-group">

                <label>
                    Nama Lengkap Siswa
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Masukkan nama lengkap"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Jenis Kelamin
                </label>

                <select
                    name="gender"
                    class="form-control"
                    required
                >

                    <option value="L">
                        Laki-laki
                    </option>

                    <option value="P">
                        Perempuan
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    No HP / WA
                </label>

                <input
                    type="text"
                    name="phone"
                    class="form-control"
                    placeholder="Masukkan nomor HP / WhatsApp"
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


<!-- MODAL EDIT -->

<div
    class="modal"
    id="editModal"
>

    <div class="modal-content">

        <div class="modal-header">

            <h3>
                Edit Data Siswa
            </h3>

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
                >

            </div>


            <div class="form-group">

                <label>
                    Nama Lengkap Siswa
                </label>

                <input
                    type="text"
                    name="name"
                    id="edit_name"
                    class="form-control"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Jenis Kelamin
                </label>

                <select
                    name="gender"
                    id="edit_gender"
                    class="form-control"
                    required
                >

                    <option value="L">
                        Laki-laki
                    </option>

                    <option value="P">
                        Perempuan
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    No HP / WA
                </label>

                <input
                    type="text"
                    name="phone"
                    id="edit_phone"
                    class="form-control"
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