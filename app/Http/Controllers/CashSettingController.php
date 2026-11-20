<?php

namespace App\Http\Controllers;

use App\Models\CashSetting;
use App\Models\Kelas;
use Illuminate\Http\Request;

class CashSettingController extends Controller
{
    public function updateForBendahara(Request $request)
    {
        $kelas = $this->kelasBendahara($request);

        $validated = $request->validate([
            'tipe_periode' => 'required|in:Bulanan,Mingguan',
            'nominal_standar' => 'required|numeric|min:1|max:999999999',
            'bulan_mulai' => 'required|integer|between:1,12',
            'bulan_akhir' => 'required|integer|between:1,12',
        ]);

        $kelas->update($validated);

        return redirect()
            ->route('transactions.index', ['report_table' => 'payments'])
            ->with('success', 'Aturan kas kelas berhasil disimpan.');
    }

    public function resetForBendahara(Request $request)
    {
        $kelas = $this->kelasBendahara($request);
        $kelas->update([
            'tipe_periode' => 'Bulanan',
            'nominal_standar' => null,
            'bulan_mulai' => 7,
            'bulan_akhir' => 6,
        ]);

        return redirect()
            ->route('transactions.index', ['report_table' => 'payments'])
            ->with('success', 'Tarif kas dikosongkan dan periode dikembalikan ke Bulanan Juli–Juni. Data pembayaran tetap tersimpan.');
    }

    private function kelasBendahara(Request $request): Kelas
    {
        $kelas = $request->user()->bendahara?->kelas;

        abort_unless($kelas, 403, 'Akun bendahara belum terhubung dengan kelas.');

        return $kelas;
    }

    public function index()
    {
        $cashSettings = CashSetting::orderByDesc('effective_from')->get();

        $currentSetting = CashSetting::whereDate(
            'effective_from',
            '<=',
            now()
        )
        ->orderByDesc('effective_from')
        ->first();

        return view('cash-settings.index', compact(
            'cashSettings',
            'currentSetting'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        CashSetting::create([
            'amount' => $request->amount,
            'effective_from' => $request->effective_from,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('cash-settings.index')
            ->with('success', 'Pengaturan nominal kas berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $cashSetting = CashSetting::findOrFail($id);

        $cashSetting->update([
            'amount' => $request->amount,
            'effective_from' => $request->effective_from,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('cash-settings.index')
            ->with('success', 'Pengaturan nominal kas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $cashSetting = CashSetting::findOrFail($id);

        $cashSetting->delete();

        return redirect()
            ->route('cash-settings.index')
            ->with('success', 'Pengaturan nominal kas berhasil dihapus!');
    }
}