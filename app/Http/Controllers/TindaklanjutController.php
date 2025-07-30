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
    
        Tindaklanjut::create([
            'counseling_id' => $request->counseling_id,
            'description' => $request->description,
            'tanggal' => $request->tanggal, // ✔️ simpan ke kolom `tanggal`
        ]);
        
    
        return redirect()->back()->with('success', 'Tindak lanjut berhasil ditambahkan.');
    }
    

    public function update(Request $request, $id)
{
    $request->validate([
        'description' => 'required|string',
        'tanggal' => 'required|date',
    ]);

    $Tindaklanjut = Tindaklanjut::findOrFail($id);
    $Tindaklanjut->description = $request->description;
    $Tindaklanjut->tanggal = $request->tanggal; // ✅ tambahkan baris ini
    $Tindaklanjut->save();

    return redirect()->back()->with('success', 'Tindak lanjut berhasil diperbarui');
}


    public function destroy(Tindaklanjut $Tindaklanjut)
    {
        $Tindaklanjut->delete();
        return redirect()->back()->with('success', 'Tindak lanjut berhasil dihapus.');
    }

}
