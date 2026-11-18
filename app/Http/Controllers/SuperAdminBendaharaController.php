<?php

namespace App\Http\Controllers;

use App\Models\Bendahara;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SuperAdminBendaharaController extends Controller
{
    public function index()
    {
        $bendahara = Bendahara::with(['user', 'kelas'])
            ->withCount('transactions')
            ->orderBy('nama', 'asc')
            ->get();

        return view('super-admin.bendahara.index', compact('bendahara'));
    }

    public function show($id)
    {
        $bendahara = Bendahara::with(['user', 'kelas'])
            ->withCount('transactions')
            ->findOrFail($id);

        return view('super-admin.bendahara.show', compact('bendahara'));
    }

    public function edit($id)
    {
        $bendahara = Bendahara::with('user')->findOrFail($id);
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('super-admin.bendahara.edit', compact('bendahara', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $bendahara = Bendahara::with('user')->findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['nullable', 'string', 'max:50'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'kelas_id' => ['nullable', 'exists:kelas,id'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($bendahara->user_id),
            ],
        ]);

        DB::transaction(function () use ($bendahara, $validated) {
            $bendahara->update([
                'nama' => $validated['nama'],
                'nis' => $validated['nis'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'kelas_id' => $validated['kelas_id'] ?? null,
            ]);

            if ($bendahara->user) {
                $bendahara->user->update([
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                ]);
            }
        });

        return redirect()
            ->route('super-admin.bendahara.index')
            ->with('success', 'Data Bendahara berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $bendahara = Bendahara::with('user')->findOrFail($id);

        if (!$bendahara->user) {
            return back()->with('error', 'Akun pengguna Bendahara tidak ditemukan.');
        }

        $statusBaru = $bendahara->user->status === 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $bendahara->user->update(['status' => $statusBaru]);

        $pesan = $statusBaru === 'aktif'
            ? 'Akun Bendahara berhasil diaktifkan.'
            : 'Akun Bendahara berhasil dinonaktifkan.';

        return back()->with('success', $pesan);
    }

    public function destroy($id)
    {
        $bendahara = Bendahara::with('user')->findOrFail($id);

        $jumlahTransaksi = $bendahara->transactions()->count();

        if ($jumlahTransaksi > 0) {
            return redirect()
                ->route('super-admin.bendahara.index')
                ->with('delete_blocked', [
                    'nama' => $bendahara->nama,
                    'jumlah' => $jumlahTransaksi,
                ]);
        }

        DB::transaction(function () use ($bendahara) {
            if ($bendahara->user) {
                $bendahara->user->delete();
            } else {
                $bendahara->delete();
            }
        });

        return redirect()
            ->route('super-admin.bendahara.index')
            ->with('success', 'Data Bendahara berhasil dihapus.');
    }
}
