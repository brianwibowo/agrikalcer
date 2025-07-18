<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckAIController extends Controller
{
    public function index()
    {
        $data = DB::table('check_ai')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.check_ai', compact('data'));
    }
}
