<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class WaliKelasProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $waliKelas = $user->waliKelas()->firstOrCreate(
            ['user_id' => $user->id],
            ['nama' => $user->name]
        );

        return view('wali-kelas.profile', compact(
            'user',
            'waliKelas'
        ));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $waliKelas = $user->waliKelas()->firstOrCreate(
            ['user_id' => $user->id],
            ['nama' => $user->name]
        );

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],

            'nip' => ['nullable', 'string', 'max:50'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'no_hp' => ['nullable', 'string', 'max:20'],

            'alamat' => ['nullable', 'string', 'max:1000'],

            'password_sekarang' => [
                'nullable',
                'required_with:password_baru',
                'string',
            ],

            'password_baru' => [
                'nullable',
                'required_with:password_sekarang',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'password_sekarang.required_with' => 'Masukkan password saat ini.',
            'password_baru.required_with' => 'Masukkan password baru.',
            'password_baru.min' => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!empty($validated['password_baru'])) {
            if (!Hash::check(
                $validated['password_sekarang'],
                $user->password
            )) {
                throw ValidationException::withMessages([
                    'password_sekarang' => 'Password saat ini tidak sesuai.',
                ]);
            }

            $user->password = $validated['password_baru'];
        }

        $user->name = $validated['nama'];
        $user->email = $validated['email'];
        $user->save();

        $waliKelas->update([
            'nama' => $validated['nama'],
            'nip' => $validated['nip'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
        ]);

        return redirect()
            ->route('wali-kelas.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}