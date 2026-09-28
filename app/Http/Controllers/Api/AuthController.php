<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // API Login untuk Android / Postman
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 200);
    }

    // Login untuk Web Browser
    public function webLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {

            $request->session()->regenerate();

            $user = auth()->user();

            switch ($user->role) {

                case 'super_admin':
                    $redirect = '/admin';
                    break;

                case 'bendahara':
                    $redirect = '/dashboard';
                    break;

                case 'wali_kelas':
                    $redirect = '/wali-kelas';
                    break;

                case 'siswa':
                    $redirect = '/siswa';
                    break;

                default:

                    auth()->logout();

                    return response()->json([
                        'success' => false,
                        'message' => 'Role pengguna tidak dikenali.',
                    ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil!',
                'user' => $user,
                'redirect' => $redirect,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah!'
        ], 401);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout',
        ], 200);
    }
}
