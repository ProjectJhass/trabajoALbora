<?php

namespace App\Exports;

use App\Models\apps\intranet\ModelInfoFlayer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InfoViewsFlayer implements FromCollection, WithHeadings
{
    protected $month;

    public function __construct(string $month)
    {
        $this->month = $month;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $year = date("Y", strtotime($this->month));
        $month = date("m", strtotime($this->month));

        return ModelInfoFlayer::select(['id', 'cedula', 'nombre', 'fecha', 'estado'])
        ->whereYear("created_at", $year)
        ->whereMonth("created_at", $month)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Consecutivo',
            'Cédula',
            'Nombre',
            'Fecha',
            'Estado'
        ];
    }
}
