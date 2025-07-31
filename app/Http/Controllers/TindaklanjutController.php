<?php

namespace App\Http\Controllers;

use App\Models\TindakLanjut;
use App\Models\Counseling;
use Illuminate\Http\Request;

class TindakLanjutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'counseling_id' => 'required|exists:counselings,id',
            'description' => 'required|string',
            'tanggal' => 'required|date',
        ]);
    
        tindaklanjut::create([
            'counseling_id' => $request->counseling_id,
            'description' => $request->description,
            'tanggal' => $request->tanggal,
        ]);
        
        return redirect()->back()->with('success', 'Tindak lanjut berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $tindakLanjut = TindakLanjut::findOrFail($id);
        $tindakLanjut->description = $request->description;
        $tindakLanjut->tanggal = $request->tanggal;
        $tindakLanjut->save();

        return redirect()->back()->with('success', 'Tindak lanjut berhasil diperbarui');
    }

    public function destroy(tindaklanjut $tindakLanjut)
    {
        $tindakLanjut->delete();
        return redirect()->back()->with('success', 'Tindak lanjut berhasil dihapus.');
    }
}
