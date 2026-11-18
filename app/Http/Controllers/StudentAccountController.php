<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Bendahara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentAccountController extends Controller
{
    private function authorizeWaliKelas()
    {
        abort_unless(
            auth()->user()?->role === 'wali_kelas',
            403,
            'Anda tidak memiliki akses.'
        );
    }

    /**
     * Menampilkan halaman manajemen akun siswa.
     */
    public function index()
    {
        $this->authorizeWaliKelas();

        $students = Student::with('user')
            ->orderBy('name', 'asc')
            ->get();

        $studentsWithAccount = $students
            ->filter(fn ($student) => $student->user !== null)
            ->values();

        $studentsWithoutAccount = $students
            ->filter(fn ($student) => $student->user === null)
            ->values();

        return view('wali-kelas.akun-siswa', compact(
            'students',
            'studentsWithAccount',
            'studentsWithoutAccount'
        ));
    }

    /**
     * Membuat akun siswa melalui input manual.
     */
    public function store(Request $request)
    {
        $this->authorizeWaliKelas();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:students,nis',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama siswa wajib diisi.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'siswa',
                'status' => 'aktif',
            ]);

            $user->syncRoles(['siswa']);

            Student::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'nis' => $validated['nis'],
            ]);
        });

        return back()->with(
            'success',
            'Akun siswa berhasil ditambahkan.'
        );
    }

    /**
     * Mengedit email akun.
     */
    public function update(Request $request, $studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        if (!$student->user) {
            return back()->with('error', 'Siswa belum memiliki akun.');
        }

        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $student->user->id,
            ],
        ]);

        $student->user->update([
            'email' => $validated['email'],
        ]);

        return back()->with('success', 'Email akun berhasil diperbarui.');
    }

    /**
     * Reset password menggunakan NIS.
     */
    public function resetPassword($studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        if (!$student->user || empty($student->nis)) {
            return back()->with('error', 'Akun atau NIS siswa tidak tersedia.');
        }

        $student->user->update([
            'password' => Hash::make((string) $student->nis),
        ]);

        return back()->with('success', 'Password berhasil di-reset menggunakan NIS.');
    }

    /**
     * Mengubah Siswa menjadi Bendahara.
     */
    public function promoteToBendahara($studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        if (!$student->user || $student->user->role !== 'siswa') {
            return back()->with('error', 'Akun siswa tidak dapat dipromosikan.');
        }

        DB::transaction(function () use ($student) {
            $user = $student->user;

            $user->update(['role' => 'bendahara']);
            $user->syncRoles(['bendahara']);

            Bendahara::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => $student->name,
                    'nis' => $student->nis,
                    'no_hp' => $student->phone,
                    'kelas_id' => null,
                ]
            );
        });

        return back()->with('success', $student->name . ' berhasil menjadi Bendahara.');
    }

    /**
     * Mengembalikan Bendahara menjadi Siswa.
     */
    public function demoteToSiswa($studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        if (!$student->user || $student->user->role !== 'bendahara') {
            return back()->with('error', 'Akun tersebut bukan Bendahara.');
        }

        DB::transaction(function () use ($student) {
            $user = $student->user;

            $user->update(['role' => 'siswa']);
            $user->syncRoles(['siswa']);

            Bendahara::where('user_id', $user->id)->delete();
        });

        return back()->with('success', 'Akun berhasil dikembalikan menjadi Siswa.');
    }

    /**
     * Menonaktifkan akun.
     */
    public function deactivateAccount($studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        if (
            !$student->user ||
            !in_array($student->user->role, ['siswa', 'bendahara'])
        ) {
            return back()->with('error', 'Akun tidak dapat dinonaktifkan.');
        }

        if ($student->user->status === 'nonaktif') {
            return back()->with('error', 'Akun sudah nonaktif.');
        }

        DB::transaction(function () use ($student) {
            $student->user->update(['status' => 'nonaktif']);
            $student->user->tokens()->delete();
        });

        return back()->with('success', 'Akun berhasil dinonaktifkan.');
    }

    /**
     * Mengaktifkan kembali akun.
     */
    public function activateAccount($studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        if (
            !$student->user ||
            !in_array($student->user->role, ['siswa', 'bendahara'])
        ) {
            return back()->with('error', 'Akun tidak dapat diaktifkan.');
        }

        if ($student->user->status === 'aktif') {
            return back()->with('error', 'Akun sudah aktif.');
        }

        $student->user->update(['status' => 'aktif']);

        return back()->with('success', 'Akun berhasil diaktifkan kembali.');
    }
}
