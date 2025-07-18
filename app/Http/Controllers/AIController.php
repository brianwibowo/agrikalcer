<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class AIController extends Controller
{
    public function fetchAiData(Request $request)
    {
        // Query data dari tabel ai_data
        $aiData = DB::table('ai_data')->get();

        // Return data dalam format JSON
        return response()->json($aiData);
    }
}

