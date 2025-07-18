<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ComponentsController extends Controller
{
    public function fetchData(Request $request)
    {
        $date = $request->input('date');
        $sensor = $request->input('sensor');

        if (!$date || !$sensor) {
            return response()->json(['labels' => [], 'values' => []]);
        }

        // Validasi kolom sensor untuk mencegah SQL Injection
        $validSensors = [
            'pv_voltage', 'pv_current', 'pv_power',
            'battery_voltage', 'battery_current', 'battery_power',
            'load_voltage', 'load_current', 'load_power'
        ];

        if (!in_array($sensor, $validSensors)) {
            return response()->json(['labels' => [], 'values' => []], 400);
        }

        $data = DB::table('pvmart_daily')
            ->selectRaw("HOUR(created_at) as hour, ROUND(AVG($sensor), 2) as value")
            ->whereDate('created_at', $date)
            ->groupByRaw("HOUR(created_at)")
            ->orderByRaw("HOUR(created_at)")
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'labels' => [],
                'values' => [],
                'description' => "No data found for the selected filters."
            ]);
        }

        $labels = $data->pluck('hour')->map(function ($hour) {
            return $hour . ':00';
        })->toArray();
        $values = $data->pluck('value')->toArray();

        return response()->json([
            'labels' => $labels,
            'values' => $values,
            'description' => "Sensor {$sensor} for {$date}"
        ]);
    }

    public function index()
    {
        return view('admin.components');
    }
}
