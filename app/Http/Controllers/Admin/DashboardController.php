<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
class DashboardController extends Controller
{
    public function fetchData(Request $request)
{
    $date = $request->input('date');
    $node = $request->input('node');
    $sensor = $request->input('sensor');

    // Pastikan sensor yang diminta valid
    $validSensors = ['n', 'p', 'k', 'temperature', 'ph', 'humidity'];
    if (!in_array($sensor, $validSensors)) {
        return response()->json(['error' => 'Invalid sensor selected'], 400);
    }

    // Ambil data dari database
    $data = DB::table('datamart_daily')
        ->whereDate('created_at', $date)
        ->where('node', $node)
        ->select('created_at', $sensor)
        ->orderBy('created_at')
        ->get();

    if ($data->isEmpty()) {
        return response()->json([
            'labels' => [],
            'values' => [],
            'description' => "No data found for the selected filters."
        ]);
    }

    // Format data untuk chart
    $labels = $data->pluck('created_at')->map(function ($date) {
        return Carbon::parse($date)->format('H:i');
    });
    $values = $data->pluck($sensor);

    return response()->json([
        'labels' => $labels,
        'values' => $values,
        'description' => "Sensor {$sensor} on Node {$node} for {$date}"
    ]);
}

    // Menampilkan halaman dashboard
    public function index()
    {
        return view('admin.dashboard');
    }
}
