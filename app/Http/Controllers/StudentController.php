<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    // =====================================================
    // DATA SISWA BENDAHARA
    // =====================================================

    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $students = Student::with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('email', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students', 'search'));
    }

    // =====================================================
    // DATA SISWA WALI KELAS
    // =====================================================

    public function waliKelasIndex(Request $request)
    {
        $search = trim($request->input('search', ''));

        $students = Student::with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('email', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('wali-kelas.data-siswa', compact('students', 'search'));
    }

    // =====================================================
    // TAMBAH SISWA + MEMBUAT AKUN LOGIN
    // =====================================================

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'wali_kelas') {
            abort(403, 'Anda tidak memiliki akses untuk menambah data siswa.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:students,nis',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => strtoupper($validated['name']),
                'email' => strtolower($validated['email']),
                'password' => $validated['nis'],
                'role' => 'siswa',
                'status' => 'aktif',
            ]);

            Student::create([
                'user_id' => $user->id,
                'nis' => $validated['nis'],
                'name' => strtoupper($validated['name']),
                'gender' => $validated['gender'],
                'phone' => $validated['phone'] ?? null,
            ]);
        });

        return redirect()->back()->with(
            'success',
            'Data siswa dan akun login berhasil dibuat!'
        );
    }

    // =====================================================
    // UPDATE DATA SISWA + EMAIL AKUN
    // =====================================================

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'wali_kelas') {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data siswa.');
        }

        $student = Student::with('user')->findOrFail($id);

        $emailRule = Rule::unique('users', 'email');

        if ($student->user_id) {
            $emailRule->ignore($student->user_id);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => [
                'required',
                'string',
                'max:50',
                Rule::unique('students', 'nis')->ignore($student->id),
            ],
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                $emailRule,
            ],
        ]);

        DB::transaction(function () use ($student, $validated) {
            $student->update([
                'nis' => $validated['nis'],
                'name' => strtoupper($validated['name']),
                'gender' => $validated['gender'],
                'phone' => $validated['phone'] ?? null,
            ]);

            if ($student->user) {
                $student->user->update([
                    'name' => strtoupper($validated['name']),
                    'email' => strtolower($validated['email']),
                ]);
            }
        });

        return redirect()->back()->with(
            'success',
            'Data siswa dan email akun berhasil diperbarui!'
        );
    }

    // =====================================================
    // HAPUS DATA SISWA
    // =====================================================

    public function destroy($id)
    {
        if (auth()->user()->role !== 'wali_kelas') {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data siswa.');
        }

        $student = Student::findOrFail($id);

        $student->delete();

        return redirect()->back()->with(
            'success',
            'Data siswa berhasil dihapus!'
        );
    }
}
