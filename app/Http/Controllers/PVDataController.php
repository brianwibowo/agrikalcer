<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PVDataController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'pV' => 'nullable|numeric',
            'pI' => 'nullable|numeric',
            'pP' => 'nullable|numeric',
            'bV' => 'nullable|numeric',
            'bI' => 'nullable|numeric',
            'bP' => 'nullable|numeric',
            'lV' => 'nullable|numeric',
            'lI' => 'nullable|numeric',
            'lP' => 'nullable|numeric',
        ]);

        // Menyimpan data ke dalam tabel
        DB::table('data_pv_now')
            ->insert([
                'pV' => $validated['pV'],
                'pI' => $validated['pI'],
                'pP' => $validated['pP'],
                'bV' => $validated['bV'],
                'bI' => $validated['bI'],
                'bP' => $validated['bP'],
                'lV' => $validated['lV'],
                'lI' => $validated['lI'],
                'lP' => $validated['lP'],
                'created_at' => now(),
            ]);

        return response()->json(['message' => 'Data processed successfully'], 200);
    }
}
