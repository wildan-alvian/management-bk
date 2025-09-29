<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PresensiExport implements FromView
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
}
