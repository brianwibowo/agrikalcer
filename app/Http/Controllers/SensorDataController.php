<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'node' => 'required|integer',
            'n' => 'nullable|numeric',
            'p' => 'nullable|numeric',
            'k' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'ph' => 'nullable|numeric',
            'humidity' => 'nullable|numeric',
        ]);

        // Update data berdasarkan node
        DB::table('data_sensor_now')
            ->updateOrInsert(
                ['node' => $validated['node']], // Kondisi untuk update
                [
                    'n' => $validated['n'],
                    'p' => $validated['p'],
                    'k' => $validated['k'],
                    'temperature' => $validated['temperature'],
                    'ph' => $validated['ph'],
                    'humidity' => $validated['humidity'],
                    'created_at' => now(),
                ]
            );

        return response()->json(['message' => 'Data processed successfully'], 200);
    }
}
