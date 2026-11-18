@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('super-admin.bendahara.index') }}"
           class="text-decoration-none text-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <h2 class="mt-3 fw-bold" style="color: #4d0710;">
            Edit Data Bendahara
        </h2>
        <p class="text-muted">
            Perbarui informasi Bendahara MyCash.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum berhasil disimpan.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('super-admin.bendahara.update', $bendahara->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Bendahara</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="{{ old('nama', $bendahara->nama) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">NIS</label>
                    <input type="text"
                           name="nis"
                           class="form-control"
                           value="{{ old('nis', $bendahara->nis) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nomor Telepon / WhatsApp</label>
                    <input type="text"
                           name="no_hp"
                           class="form-control"
                           value="{{ old('no_hp', $bendahara->no_hp) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Akun</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $bendahara->user?->email) }}"
                           required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Kelas</label>
                    <select name="kelas_id" class="form-select">
                        <option value="">-- Pilih Kelas --</option>

                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}"
                                {{ (string) old('kelas_id', $bendahara->kelas_id) === (string) $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('super-admin.bendahara.index') }}"
                       class="btn btn-light border">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn text-white"
                            style="background: #4d0710;">
                        <i class="fa-solid fa-save me-1"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
