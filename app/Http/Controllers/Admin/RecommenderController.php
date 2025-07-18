<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PredictionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\CheckAI;
use Illuminate\Support\Facades\Http;

class RecommenderController extends Controller
{
    public function index()
    {
        // Ambil semua hasil prediksi yang telah disimpan
        $data = CheckAI::all();
        
        // Ambil data untuk dropdown node dan tanggal
        // Sesuaikan dengan data yang perlu ditampilkan di dropdown
        $nodes = ['Node 1', 'Node 2', 'Node 3']; // Contoh
        $dates = CheckAI::select('created_at')->distinct()->get();

        return view('admin.recommender', compact('data', 'nodes', 'dates'));
    }
    
    public function predict(Request $request)
    {
        // Ambil data dari input pengguna (sensor data)
        $inputData = $request->all();

        // Kirim data ke API AI untuk mendapatkan hasil prediksi
        $aiResult = $this->callAI($inputData);

        // Simpan hasil prediksi ke tabel check_ai_results
        $checkAI = CheckAI::create([
            'crop' => $aiResult['predicted_crop'],
            'n_value' => $inputData['n'],
            'p_value' => $inputData['p'],
            'k_value' => $inputData['k'],
            'temperature' => $inputData['temperature'],
            'ph' => $inputData['ph'],
            'humidity' => $inputData['humidity'],
            'status' => $aiResult['status'],
        ]);

        // Format hasil prediksi untuk ditampilkan
        $prediction = [
            'Crop' => $aiResult['predicted_crop'],
            'Parameters' => $aiResult['parameters']
        ];

        // Menyimpan hasil prediksi dalam session
        session(['prediction' => $prediction]);

        // Tampilkan hasil prediksi
        return view('admin.recommender.result', compact('prediction'));
    }

    private function callAI($inputData)
    {
        // Simulasi pemanggilan API AI yang sudah ada (FastAPI)
        $response = Http::post('http://10.2.16.100:4430/predict/', [
            'n' => $inputData['n'],
            'p' => $inputData['p'],
            'k' => $inputData['k'],
            'temperature' => $inputData['temperature'],
            'ph' => $inputData['ph'],
            'humidity' => $inputData['humidity'],
        ]);

        // Ambil data hasil prediksi dari response
        $data = $response->json();

        return [
            'predicted_crop' => $data['crop'],
            'parameters' => [
                'N' => ['value' => $data['n'], 'mean' => 5.0, 'status' => 'Optimal'],
                'P' => ['value' => $data['p'], 'mean' => 4.5, 'status' => 'Warning'],
                'K' => ['value' => $data['k'], 'mean' => 4.8, 'status' => 'Optimal'],
                'Temperature' => ['value' => $data['temperature'], 'mean' => 22.0, 'status' => 'Optimal'],
                'pH' => ['value' => $data['ph'], 'mean' => 6.5, 'status' => 'Optimal'],
                'Humidity' => ['value' => $data['humidity'], 'mean' => 60.0, 'status' => 'Optimal'],
            ],
            'status' => $data['status'],
        ];
    }

    public function generateReport()
    {
        // Ambil hasil prediksi
        $prediction = session('prediction');

        if (!$prediction) {
            return redirect()->route('admin.recommender')->with('error', 'No prediction data available.');
        }

        // Download Excel
        return Excel::download(new PredictionExport($prediction), 'prediction_results.xlsx');
    }

    public function downloadImage()
    {
        // Buat gambar dari hasil prediksi (misalnya berupa chart)
        $image = Image::canvas(800, 600, '#fff')
                      ->text('Predicted Crop: ' . session('prediction')['Crop'], 100, 100, function($font) {
                          $font->size(48);
                          $font->color('#000');
                          $font->align('center');
                          $font->valign('middle');
                      });

        // Simpan gambar sementara
        $path = storage_path('app/public/prediction_image.jpg');
        $image->save($path);

        // Return file download
        return response()->download($path)->deleteFileAfterSend(true);
    }
}
