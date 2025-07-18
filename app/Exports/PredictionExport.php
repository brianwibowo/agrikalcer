<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class PredictionExport implements FromArray
{
    protected $prediction;

    public function __construct($prediction)
    {
        $this->prediction = $prediction;
    }

    public function array(): array
    {
        // Format data untuk Excel
        $parameters = [];
        foreach ($this->prediction['Parameters'] as $key => $param) {
            $parameters[] = [
                'Parameter' => $key,
                'Value' => $param['value'],
                'Mean' => $param['mean'],
                'Status' => $param['status']
            ];
        }

        return [
            ['Predicted Crop', $this->prediction['Crop']],
            [''],
            ['Parameter', 'Value', 'Mean', 'Status'],
        ];
    }
}
