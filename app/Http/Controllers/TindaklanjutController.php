<?php

namespace App\Http\Controllers;

use App\Models\Tindaklanjut;
use App\Models\Counseling;
use Illuminate\Http\Request;

class TindaklanjutController extends Controller
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

        $tindaklanjut = tindaklanjut::findOrFail($id);
        $tindaklanjut->description = $request->description;
        $tindaklanjut->tanggal = $request->tanggal;
        $tindaklanjut->save();

        return redirect()->back()->with('success', 'Tindak lanjut berhasil diperbarui');
    }

    public function destroy(tindaklanjut $tindaklanjut)
    {
        $tindaklanjut->delete();
        return redirect()->back()->with('success', 'Tindak lanjut berhasil dihapus.');
    }
}
