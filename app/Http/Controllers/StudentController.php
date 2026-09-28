<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // =====================================================
    // DATA SISWA
    // =====================================================

    public function index()
    {
        $students = Student::orderBy('name', 'asc')->get();

        return view('students.index', compact('students'));
    }


    // =====================================================
    // DATA SISWA WALI KELAS
    // =====================================================

    public function waliKelasIndex()
    {
        $students = Student::orderBy('name', 'asc')->get();

        return view('wali-kelas.data-siswa', compact('students'));
    }


    // =====================================================
    // TAMBAH DATA SISWA
    // =====================================================

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'wali_kelas') {
            abort(403, 'Anda tidak memiliki akses untuk menambah data siswa.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'nullable|string|max:50',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:20',
        ]);

        Student::create([
            'nis' => $request->nis,
            'name' => strtoupper($request->name),
            'gender' => $request->gender,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with(
            'success',
            'Data siswa berhasil ditambahkan!'
        );
    }


    // =====================================================
    // UPDATE DATA SISWA
    // =====================================================

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'wali_kelas') {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data siswa.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'nullable|string|max:50',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:20',
        ]);

        $student = Student::findOrFail($id);

        $student->update([
            'nis' => $request->nis,
            'name' => strtoupper($request->name),
            'gender' => $request->gender,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with(
            'success',
            'Data siswa berhasil diperbarui!'
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