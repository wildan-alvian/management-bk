<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuruBk;

class GuruBkController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:Super Admin|Admin');
    //     $this->middleware('role:Guidance Counselor')->only('index');
    // }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $counselor = GuruBk::query()
            ->when($search, function($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();
        return view('counselor.index', compact('counselor'));
    }

    public function create()
    {
        return view('counselor.create'); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:gurubks,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:gurubks,email',
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        try {
            GuruBk::create($validated);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])
                ->withInput();
        }
        return redirect()->route('counselors.index')->with('success', 'Data berhasil ditambahkan');

    }
    public function show($id)
{
    $guru = GuruBK::findOrFail($id); // Mendapatkan data berdasarkan ID
    return view('counselor.show', compact('guru')); // Menampilkan view
}



    public function destroy($id)
{
    $counselor = GuruBk::findOrFail($id);
    $counselor->delete();

    return redirect()->route('counselors.index')->with('success', 'Data admin berhasil dihapus.');
}


public function update(Request $request, $id)
{
    $guru = GuruBk::findOrFail($id);
    $guru->update($request->all());

    return redirect()->route('counselors.show', $guru->id)->with('success', 'Data berhasil diperbarui.');
}



}