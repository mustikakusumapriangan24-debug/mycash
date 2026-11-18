<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SuperAdminProfileController extends Controller
{
    /**
     * Menampilkan halaman profil administrator.
     */
    public function index()
    {
        $user = Auth::user();

        return view('super-admin.profile', compact('user'));
    }

    /**
     * Memperbarui nama dan email administrator.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return back()->with(
            'success',
            'Informasi akun berhasil diperbarui.'
        );
    }

    /**
     * Memperbarui kata sandi administrator.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ], [
            'current_password.required' =>
                'Kata sandi saat ini wajib diisi.',

            'password.required' =>
                'Kata sandi baru wajib diisi.',

            'password.min' =>
                'Kata sandi baru minimal 6 karakter.',

            'password.confirmed' =>
                'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check(
            $request->current_password,
            $user->password
        )) {
            return back()
                ->withErrors([
                    'current_password' =>
                        'Kata sandi saat ini tidak benar.',
                ])
                ->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with(
            'success',
            'Kata sandi berhasil diperbarui.'
        );
    }
}
