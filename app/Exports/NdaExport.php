<?php

namespace App\Exports;

use App\Models\Nda;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NdaExport implements FromCollection, WithHeadings
{
    protected $ndas;

    public function __construct($ndas)
    {
        $this->ndas = $ndas;
    }

    public function collection()
    {
        return $this->ndas->map(function ($nda) {
            return [
                'ID' => str_pad($nda->id, 4, '0', STR_PAD_LEFT),
                'Nama Proyek' => $nda->project_name,
                'Tanggal Mulai' => $nda->start_date ? $nda->start_date->format('d/m/Y') : '-',
                'Tanggal Selesai' => $nda->end_date ? $nda->end_date->format('d/m/Y') : '-',
                'Durasi' => $nda->formatted_duration,
                'Tanggal TTD' => $nda->nda_signature_date ? $nda->nda_signature_date->format('d/m/Y') : '-',
                'Deskripsi' => $nda->description ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Proyek',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Durasi',
            'Tanggal TTD',
            'Deskripsi',
        ];
    }
}
