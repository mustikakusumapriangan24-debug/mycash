<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class SuperAdminKelasController extends Controller
{
    // Menampilkan daftar kelas.
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $query = Kelas::with(['waliKelas', 'bendahara'])
            ->withCount('students');

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('nama_kelas', 'like', "%{$search}%")
                    ->orWhere('kode_kelas', 'like', "%{$search}%")
                    ->orWhere('tahun_ajaran', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('waliKelas', function ($waliQuery) use ($search) {
                        $waliQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%");
                    })
                    ->orWhereHas('bendahara', function ($bendaharaQuery) use ($search) {
                        $bendaharaQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%");
                    });
            });
        }

        $kelas = $query
            ->orderBy('nama_kelas', 'asc')
            ->paginate(10)
            ->withQueryString();
        $totalKelas = Kelas::count();

        return view('super-admin.kelas.index', compact(
            'kelas',
            'totalKelas',
            'search'
        ));
    }

    // Menampilkan detail kelas.
    public function show(Request $request, $id)
    {
        $kelas = Kelas::with(['waliKelas', 'bendahara.user'])
            ->withCount([
                'students',
                'students as male_students_count' => fn ($query) => $query->where('gender', 'L'),
                'students as female_students_count' => fn ($query) => $query->where('gender', 'P'),
            ])
            ->findOrFail($id);

        $studentSearch = trim($request->query('student_search', ''));
        $students = $kelas->students()
            ->with('user')
            ->when($studentSearch !== '', function ($query) use ($studentSearch) {
                $query->where(function ($studentQuery) use ($studentSearch) {
                    $studentQuery->where('name', 'like', "%{$studentSearch}%")
                        ->orWhere('nis', 'like', "%{$studentSearch}%")
                        ->orWhere('phone', 'like', "%{$studentSearch}%")
                        ->orWhereHas('user', function ($userQuery) use ($studentSearch) {
                            $userQuery->where('email', 'like', "%{$studentSearch}%");
                        });
                });
            })
            ->orderBy('name')
            ->paginate(10, ['*'], 'student_page')
            ->withQueryString();

        $unassignedStudents = Student::whereNull('kelas_id')
            ->orderBy('name')
            ->get(['id', 'name', 'nis']);

        $cashierIds = $kelas->bendahara->pluck('id');
        $transactions = Transaction::whereIn('bendahara_id', $cashierIds);
        $totalPemasukan = (clone $transactions)->where('type', 'in')->sum('amount');
        $totalPengeluaran = (clone $transactions)->where('type', 'out')->sum('amount');
        $totalTransaksiPengeluaran = (clone $transactions)->where('type', 'out')->count();

        return view('super-admin.kelas.show', compact(
            'kelas',
            'students',
            'studentSearch',
            'unassignedStudents',
            'totalPemasukan',
            'totalPengeluaran',
            'totalTransaksiPengeluaran'
        ));
    }

    public function assignStudent(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $validated = $request->validate([
            'student_id' => [
                'required',
                'integer',
                Rule::exists('students', 'id')
                    ->whereNull('kelas_id')
                    ->whereNull('deleted_at'),
            ],
        ], [
            'student_id.exists' => 'Siswa sudah ditugaskan ke kelas lain atau tidak tersedia.',
        ]);

        DB::transaction(function () use ($validated, $kelas) {
            $student = Student::lockForUpdate()->findOrFail($validated['student_id']);

            if ($student->kelas_id !== null) {
                throw ValidationException::withMessages([
                    'student_id' => 'Siswa sudah ditugaskan ke kelas lain.',
                ]);
            }

            $student->update(['kelas_id' => $kelas->id]);
        });

        return redirect()
            ->route('super-admin.kelas.show', $kelas->id)
            ->with('success', 'Siswa berhasil ditambahkan ke kelas.');
    }

    public function removeStudent(Request $request, $id, $studentId)
    {
        $kelas = Kelas::findOrFail($id);
        $student = $kelas->students()->findOrFail($studentId);
        $student->update(['kelas_id' => null]);

        $query = $request->filled('student_search')
            ? ['student_search' => $request->input('student_search')]
            : [];

        return redirect()
            ->route('super-admin.kelas.show', array_merge(['id' => $kelas->id], $query))
            ->with('success', 'Siswa berhasil dilepaskan dari kelas.');
    }

    // Menampilkan form tambah kelas.
    public function create()
    {
        $waliKelas = WaliKelas::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'wali_kelas')
                    ->where('status', 'aktif');
            })
            ->orderBy('nama', 'asc')
            ->get();

        return view('super-admin.kelas.create', compact('waliKelas'));
    }

    // Menyimpan kelas baru.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255'],
            'kode_kelas' => ['nullable', 'string', 'max:255', 'unique:kelas,kode_kelas'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'keterangan' => ['nullable', 'string'],
            'mode_wali_kelas' => ['required', Rule::in(['terdaftar', 'nanti'])],
            'id_wali_kelas' => [
                'required_if:mode_wali_kelas,terdaftar',
                'nullable',
                'integer',
                'exists:wali_kelas,id',
            ],
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'mode_wali_kelas.required' => 'Pilih metode penugasan wali kelas.',
            'id_wali_kelas.required_if' => 'Pilih wali kelas yang sudah terdaftar.',
        ]);

        DB::transaction(function () use ($validated) {
            $idWaliKelas = null;

            if ($validated['mode_wali_kelas'] === 'terdaftar') {
                $wali = WaliKelas::where('id', $validated['id_wali_kelas'])
                    ->whereHas('user', function ($query) {
                        $query->where('role', 'wali_kelas')
                            ->where('status', 'aktif');
                    })
                    ->firstOrFail();

                $idWaliKelas = $wali->id;
            }

            $kodeKelas = $validated['kode_kelas']
                ?? strtoupper(
                    Str::slug($validated['nama_kelas'], '')
                    . '-'
                    . str_replace('/', '', $validated['tahun_ajaran'])
                );

            $kodeDasar = $kodeKelas;
            $nomor = 1;

            while (Kelas::where('kode_kelas', $kodeKelas)->exists()) {
                $kodeKelas = $kodeDasar . '-' . $nomor;
                $nomor++;
            }

            Kelas::create([
                'nama_kelas' => $validated['nama_kelas'],
                'kode_kelas' => $kodeKelas,
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'keterangan' => $validated['keterangan'] ?? null,
                'id_wali_kelas' => $idWaliKelas,
                'tipe_periode' => 'Bulanan',
                'nominal_standar' => null,
                'status' => 'aktif',
            ]);
        });

        return redirect()
            ->route('super-admin.kelas.index')
            ->with('success', 'Kelas baru berhasil ditambahkan.');
    }

    // Menampilkan form edit kelas.
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);

        $waliKelas = WaliKelas::with('user')
            ->whereHas('user', function ($query) use ($kelas) {
                $query->where('role', 'wali_kelas')
                    ->where(function ($subQuery) use ($kelas) {
                        $subQuery->where('status', 'aktif');

                        if ($kelas->id_wali_kelas) {
                            $subQuery->orWhere('id', $kelas->id_wali_kelas);
                        }
                    });
            })
            ->orderBy('nama', 'asc')
            ->get();

        return view('super-admin.kelas.edit', compact('kelas', 'waliKelas'));
    }

    // Memperbarui data kelas.
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255'],
            'kode_kelas' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kelas', 'kode_kelas')->ignore($kelas->id),
            ],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'id_wali_kelas' => ['nullable', 'integer', 'exists:wali_kelas,id'],
            'tipe_periode' => ['required', Rule::in(['Bulanan', 'Mingguan', 'Tahunan'])],
            'nominal_standar' => ['nullable', 'numeric', 'min:1'],
            'keterangan' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'kode_kelas.required' => 'Kode kelas wajib diisi.',
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'tipe_periode.required' => 'Tipe periode wajib dipilih.',
            'nominal_standar.numeric' => 'Nominal harus berupa angka.',
            'status.required' => 'Status kelas wajib dipilih.',
        ]);

        DB::transaction(function () use ($kelas, $validated) {
            if (!empty($validated['id_wali_kelas'])) {
                $wali = WaliKelas::where('id', $validated['id_wali_kelas'])
                    ->whereHas('user', function ($query) use ($kelas, $validated) {
                        $query->where('role', 'wali_kelas')
                            ->where(function ($subQuery) use ($kelas, $validated) {
                                $subQuery->where('status', 'aktif')
                                    ->orWhere(function ($currentQuery) use ($kelas, $validated) {
                                        $currentQuery
                                            ->where('id', $kelas->id_wali_kelas)
                                            ->where('id', $validated['id_wali_kelas']);
                                    });
                            });
                    })
                    ->firstOrFail();

                $idWaliKelas = $wali->id;
            } else {
                $idWaliKelas = null;
            }

            $kelas->update([
                'nama_kelas' => $validated['nama_kelas'],
                'kode_kelas' => $validated['kode_kelas'],
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'id_wali_kelas' => $idWaliKelas,
                'tipe_periode' => $validated['tipe_periode'],
                'nominal_standar' => array_key_exists('nominal_standar', $validated)
                    ? $validated['nominal_standar']
                    : $kelas->nominal_standar,
                'keterangan' => $validated['keterangan'] ?? null,
                'status' => $validated['status'],
            ]);
        });

        return redirect()
            ->route('super-admin.kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    // Memeriksa apakah tabel memiliki hubungan langsung dengan kelas.
    private function hasRelatedData($table, $kelasId)
    {
        if (!Schema::hasTable($table)) {
            return false;
        }

        foreach (['kelas_id', 'class_id'] as $column) {
            if (Schema::hasColumn($table, $column)) {
                return DB::table($table)
                    ->where($column, $kelasId)
                    ->exists();
            }
        }

        return false;
    }

    // Menghapus kelas dengan perlindungan data terkait.
    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {

            $kelas = Kelas::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $alasan = [];

            // Periksa penugasan wali kelas.
            if ($kelas->id_wali_kelas !== null) {
                $alasan[] = 'Kelas ' . $kelas->nama_kelas
                    . ' masih memiliki penugasan Wali Kelas. '
                    . 'Lepaskan penugasan wali kelas terlebih dahulu.';
            }

            // Periksa data bendahara.
            if ($this->hasRelatedData('bendahara', $kelas->id)) {
                $alasan[] = 'Kelas masih memiliki data Bendahara. '
                    . 'Selesaikan atau pindahkan penugasan Bendahara terlebih dahulu.';
            }

            // Periksa data siswa.
            if ($this->hasRelatedData('students', $kelas->id)) {
                $alasan[] = 'Kelas masih memiliki data Siswa. '
                    . 'Selesaikan atau pindahkan data siswa terlebih dahulu.';
            }

            // Periksa tabel transaksi jika memiliki hubungan langsung ke kelas.
            $tabelKeuangan = [
                'transactions',
                'student_payments',
                'payments',
            ];

            foreach ($tabelKeuangan as $table) {
                if ($this->hasRelatedData($table, $kelas->id)) {
                    $alasan[] = 'Kelas masih memiliki riwayat transaksi atau pembayaran. '
                        . 'Riwayat keuangan harus dipertahankan.';
                    break;
                }
            }

            // Jika masih ada hubungan, batalkan penghapusan.
            if (!empty($alasan)) {
                return redirect()
                    ->route('super-admin.kelas.index')
                    ->with('delete_blocked', [
                        'nama_kelas' => $kelas->nama_kelas,
                        'alasan' => implode(' ', $alasan),
                    ]);
            }

            // Hapus hanya jika pemeriksaan di atas tidak menemukan hubungan.
            $namaKelas = $kelas->nama_kelas;

            $kelas->delete();

            return redirect()
                ->route('super-admin.kelas.index')
                ->with('success', 'Data kelas ' . $namaKelas . ' berhasil dihapus.');
        });
    }
}
