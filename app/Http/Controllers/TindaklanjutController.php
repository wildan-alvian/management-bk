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
            'counseling_id' => 'nullable|exists:counselings,id',
            'description' => 'required|string',
            'tanggal' => 'required|date',
        ]);
        
        // Support counseling_id from either hidden input or route param `{id}`
        $counselingId = $request->input('counseling_id') ?? $request->route('id');

        Tindaklanjut::create([
            'counseling_id' => $counselingId,
            'description' => $request->input('description'),
            'tanggal' => $request->input('tanggal'),
        ]);
        
        // Redirect to the counseling show page so the controller reloads the latest tindaklanjuts
        // Use the counseling id we determined above (from input or route)
        return redirect()->route('counseling.show', $counselingId)->with('success', 'Tindak lanjut berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $tindaklanjut = Tindaklanjut::findOrFail($id);
        $tindaklanjut->description = $request->description;
        $tindaklanjut->tanggal = $request->tanggal;
        $tindaklanjut->save();

        // After updating, redirect to the counseling show page to ensure the list is refreshed
        return redirect()->route('counseling.show', $tindaklanjut->counseling_id)->with('success', 'Tindak lanjut berhasil diperbarui');
    }

    public function destroy(Tindaklanjut $tindaklanjut)
    {
        $tindaklanjut->delete();
        return redirect()->back()->with('success', 'Tindak lanjut berhasil dihapus.');
    }
}
