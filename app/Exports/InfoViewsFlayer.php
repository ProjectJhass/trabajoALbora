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
        return ModelInfoFlayer::select(['id', 'cedula', 'nombre', 'fecha', 'estado'])
            ->whereDate('created_at', '>=', $this->month . '-01')
            ->whereDate('created_at', '<=', $this->month . '-31')
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
