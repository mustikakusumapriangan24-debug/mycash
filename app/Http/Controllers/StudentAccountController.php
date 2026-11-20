<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Bendahara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
     * Menambahkan siswa baru sekaligus membuat akun.
     * Jika NIS sudah ada tetapi belum memiliki akun,
     * sistem hanya membuat akun dan menghubungkannya.
     */
    public function store(Request $request)
    {
        $this->authorizeWaliKelas();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:50',
            'gender' => 'required|in:L,P',
        ], [
            'name.required' => 'Nama siswa wajib diisi.',
            'nis.required' => 'NIS wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
        ]);

        $nis = trim($validated['nis']);
        $email = $this->loginEmailForNis($nis);

        $existingStudent = Student::where('nis', $nis)->first();

        if ($existingStudent && $existingStudent->user_id !== null) {
            return back()
                ->withInput()
                ->with('error', 'Siswa tersebut sudah memiliki akun login.');
        }

        if (User::where('email', $email)->exists()) {
            return back()
                ->withInput()
                ->with('error', 'Alias login dari NIS sudah digunakan akun lain.');
        }

        DB::transaction(function () use (
            $validated,
            $nis,
            $email,
            $existingStudent
        ) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $email,
                'password' => Hash::make($nis),
                'role' => 'siswa',
                'status' => 'aktif',
            ]);

            $user->syncRoles(['siswa']);

            if ($existingStudent) {
                // Hubungkan akun dengan data siswa lama.
                $existingStudent->update([
                    'name' => $validated['name'],
                    'gender' => $validated['gender'],
                    'user_id' => $user->id,
                ]);
            } else {
                // Jika belum ada, buat data siswa baru.
                Student::create([
                    'user_id' => $user->id,
                    'name' => $validated['name'],
                    'nis' => $nis,
                    'gender' => $validated['gender'],
                ]);
            }
        });

        return back()->with(
            'success',
            $existingStudent
                ? 'Akun siswa berhasil dibuat dan dihubungkan dengan data siswa yang sudah ada.'
                : 'Siswa baru dan akun login berhasil ditambahkan. Password awal menggunakan NIS.'
        );
    }

    /**
     * Membuat akun untuk semua siswa yang belum memiliki akun.
     */
    public function createAllMissingAccounts()
    {
        $this->authorizeWaliKelas();

        $createdCount = DB::transaction(function () {
            $students = Student::whereNull('user_id')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            $emails = [];

            foreach ($students as $student) {
                $nis = trim((string) $student->nis);
                $email = $this->loginEmailForNis($nis);

                if (isset($emails[$email])) {
                    throw ValidationException::withMessages([
                        'nis' => 'Ada NIS ganda. Perbaiki data NIS sebelum membuat akun.',
                    ]);
                }

                if (User::where('email', $email)->exists()) {
                    throw ValidationException::withMessages([
                        'nis' => 'Alias login ' . $email . ' sudah digunakan akun lain.',
                    ]);
                }

                $emails[$email] = $nis;
            }

            foreach ($students as $student) {
                $nis = trim((string) $student->nis);
                $user = User::create([
                    'name' => $student->name,
                    'email' => $this->loginEmailForNis($nis),
                    'password' => Hash::make($nis),
                    'role' => 'siswa',
                    'status' => 'aktif',
                ]);

                $user->syncRoles(['siswa']);
                $student->update(['user_id' => $user->id]);
            }

            return $students->count();
        });

        return back()->with(
            'success',
            $createdCount > 0
                ? $createdCount . ' akun siswa berhasil dibuat. Email login dan password awal menggunakan NIS.'
                : 'Semua siswa sudah memiliki akun.'
        );
    }

    private function loginEmailForNis(string $nis): string
    {
        if ($nis === '' || !preg_match('/^[A-Za-z0-9._+-]+$/', $nis)) {
            throw ValidationException::withMessages([
                'nis' => 'NIS harus diisi dan hanya boleh berisi huruf, angka, titik, garis bawah, plus, atau tanda hubung.',
            ]);
        }

        return strtolower($nis) . '@mycash.com';
    }

    /**
     * Mengedit data siswa dan akun login.
     */
    public function update(Request $request, $studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => [
                'required',
                'string',
                'max:50',
                Rule::unique('students', 'nis')->ignore($student->id),
            ],
            'gender' => 'required|in:L,P',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(
                    $student->user?->id
                ),
            ],
            'password' => 'nullable|string|min:6',
        ], [
            'name.required' => 'Nama siswa wajib diisi.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan siswa lain.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'password.min' => 'Password baru minimal 6 karakter.',
        ]);

        if (!$student->user && !empty($validated['email'])) {
            return back()->with(
                'error',
                'Siswa belum memiliki akun. Buat akun terlebih dahulu untuk mengatur email login.'
            );
        }

        $loginEmail = null;

        $currentNis = strtolower(trim((string) $student->nis));

        if (
            $student->user &&
            in_array($student->user->email, [
                $currentNis . '@mycash.local',
                $currentNis . '@mycash.com',
            ], true)
        ) {
            $loginEmail = $this->loginEmailForNis(trim($validated['nis']));

            if (
                User::where('email', $loginEmail)
                    ->where('id', '!=', $student->user->id)
                    ->exists()
            ) {
                return back()->with(
                    'error',
                    'Alias login dari NIS sudah digunakan akun lain.'
                );
            }
        }

        DB::transaction(function () use ($student, $validated, $loginEmail) {
            $student->update([
                'name' => $validated['name'],
                'nis' => $validated['nis'],
                'gender' => $validated['gender'],
            ]);

            if ($student->user) {
                $userData = [
                    'name' => $validated['name'],
                ];

                if ($loginEmail !== null) {
                    $userData['email'] = $loginEmail;
                }

                if ($loginEmail === null && !empty($validated['email'])) {
                    $userData['email'] = $validated['email'];
                }

                if (!empty($validated['password'])) {
                    $userData['password'] = Hash::make(
                        $validated['password']
                    );
                }

                $student->user->update($userData);
            }

            if ($student->user?->role === 'bendahara') {
                Bendahara::where('user_id', $student->user->id)
                    ->update([
                        'nama' => $student->name,
                        'nis' => $student->nis,
                        'no_hp' => $student->phone,
                    ]);
            }
        });

        return back()->with(
            'success',
            'Data siswa berhasil diperbarui.'
        );
    }

    /**
     * Reset password menggunakan NIS siswa.
     */
    public function resetPassword($studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        if (!$student->user || empty($student->nis)) {
            return back()->with(
                'error',
                'Akun atau NIS siswa tidak tersedia.'
            );
        }

        $student->user->update([
            'password' => Hash::make(trim((string) $student->nis)),
        ]);

        return back()->with(
            'success',
            'Password berhasil di-reset menggunakan NIS siswa.'
        );
    }

    /**
     * Mengubah Siswa menjadi Bendahara.
     */
    public function promoteToBendahara($studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        if (!$student->user || $student->user->role !== 'siswa') {
            return back()->with(
                'error',
                'Akun siswa tidak dapat dipromosikan.'
            );
        }

        DB::transaction(function () use ($student) {
            $user = $student->user;

            $user->update([
                'role' => 'bendahara',
            ]);

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

        return back()->with(
            'success',
            $student->name . ' berhasil menjadi Bendahara.'
        );
    }

    /**
     * Mengembalikan Bendahara menjadi Siswa.
     */
    public function demoteToSiswa($studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        if (!$student->user || $student->user->role !== 'bendahara') {
            return back()->with(
                'error',
                'Akun tersebut bukan Bendahara.'
            );
        }

        DB::transaction(function () use ($student) {
            $user = $student->user;

            $user->update([
                'role' => 'siswa',
            ]);

            $user->syncRoles(['siswa']);

            Bendahara::where('user_id', $user->id)->delete();
        });

        return back()->with(
            'success',
            'Akun berhasil dikembalikan menjadi Siswa.'
        );
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
            return back()->with(
                'error',
                'Akun tidak dapat dinonaktifkan.'
            );
        }

        if ($student->user->status === 'nonaktif') {
            return back()->with(
                'error',
                'Akun sudah nonaktif.'
            );
        }

        DB::transaction(function () use ($student) {
            $student->user->update([
                'status' => 'nonaktif',
            ]);

            $student->user->tokens()->delete();
        });

        return back()->with(
            'success',
            'Akun berhasil dinonaktifkan.'
        );
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
            return back()->with(
                'error',
                'Akun tidak dapat diaktifkan.'
            );
        }

        if ($student->user->status === 'aktif') {
            return back()->with(
                'error',
                'Akun sudah aktif.'
            );
        }

        $student->user->update([
            'status' => 'aktif',
        ]);

        return back()->with(
            'success',
            'Akun berhasil diaktifkan kembali.'
        );
    }

    /**
     * Menghapus data siswa.
     * Penghapusan diblokir jika masih ada riwayat pembayaran.
     */
    public function destroy($studentId)
    {
        $this->authorizeWaliKelas();

        $student = Student::with('user')->findOrFail($studentId);

        $paymentCount = DB::table('student_payments')
            ->where('student_id', $student->id)
            ->count();

        if ($paymentCount > 0) {
            return back()->with('delete_blocked', [
                'name' => $student->name,
                'count' => $paymentCount,
            ]);
        }

        DB::transaction(function () use ($student) {
            if ($student->user) {
                $user = $student->user;

                $user->tokens()->delete();

                Bendahara::where('user_id', $user->id)->delete();

                $user->syncRoles([]);

                $user->delete();
            }

            // Soft delete agar data tidak langsung hilang permanen.
            $student->delete();
        });

        return back()->with(
            'success',
            'Data siswa berhasil dihapus.'
        );
    }
}
