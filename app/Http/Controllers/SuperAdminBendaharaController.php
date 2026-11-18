<?php

namespace App\Http\Controllers;

use App\Models\Bendahara;

class SuperAdminBendaharaController extends Controller
{
    /**
     * Menampilkan daftar seluruh bendahara.
     */
    public function index()
    {
        $bendahara = Bendahara::with(['user', 'kelas'])
            ->orderBy('nama', 'asc')
            ->get();

        return view('super-admin.bendahara.index', compact('bendahara'));
    }

    /**
     * Menampilkan detail bendahara.
     */
    public function show($id)
    {
        $bendahara = Bendahara::with(['user', 'kelas'])
            ->findOrFail($id);

        return view('super-admin.bendahara.show', compact('bendahara'));
    }
}
