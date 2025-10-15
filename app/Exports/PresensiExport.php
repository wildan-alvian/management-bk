<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PresensiExport implements FromView, WithStyles
{
    protected $presensi;

    public function __construct($presensi)
    {
        $this->presensi = $presensi;
    }

    public function view(): View
    {
        return view('presensi.exports.excel', [
            'presensi' => $this->presensi
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(5);   // No
        $sheet->getColumnDimension('B')->setWidth(15);  // NISN
        $sheet->getColumnDimension('C')->setWidth(25);  // Nama
        $sheet->getColumnDimension('D')->setWidth(12);  // Kelas
        $sheet->getColumnDimension('E')->setWidth(25);  // Tanggal/Waktu
        $sheet->getColumnDimension('F')->setWidth(15);  // Status
        $sheet->getColumnDimension('G')->setWidth(30);  // Deskripsi
        $sheet->getColumnDimension('H')->setWidth(50);  // Lampiran/Foto (URL)
    }
}
