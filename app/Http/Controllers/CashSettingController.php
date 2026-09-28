<?php

namespace App\Http\Controllers;

use App\Models\CashSetting;
use Illuminate\Http\Request;

class CashSettingController extends Controller
{
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