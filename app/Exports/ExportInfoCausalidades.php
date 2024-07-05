<?php

namespace App\Exports;

use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportInfoCausalidades implements FromCollection, WithHeadings, WithColumnWidths
{

    public function collection()
    {
        $data_ = ModelNuevaSolicitud::select('id_st', 'causales')
            ->whereNotNull('causales')
            ->where('causales', '!=', '')
            ->get();
        $causales = collect();

        foreach ($data_ as $value) {
            if (str_contains($value->causales, ',')) {
                $causalesExploded = explode(',', $value->causales);
                foreach ($causalesExploded as $causal) {
                    $causales[] = ['causales' => $causal];
                }
            } else {
                $causales[] = ['causales' => $value->causales];
            }
        }
        // $causales = $causales->groupBy('causales');
        $causales = $causales->groupBy('causales')->map(function ($group) {
            return $group->count();
        });
        $res = collect();
        foreach ($causales as $key => $value) {
            $res[] = ['causales' => $key, 'cantidad' => $value];
        }
        $a = collect();
        foreach ($res as $r) {
            $a[] = collect([$r]);
        }
        $sortedCollection = $a->sortByDesc(function ($item) {
            return $item[0]['cantidad'];
        });
        return $sortedCollection;
    }

    public function headings(): array
    {
        return [
            'causalidad',
            'cantidad'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 10,
        ];
    }
}
