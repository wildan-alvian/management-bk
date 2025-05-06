<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Admin|Admin');
    }

    public function index(Request $request) 
    {
        $search = $request->input('search'); 
        $admins = Admin::query();

        if ($search) {
            $admins->where(function ($query) use ($search) {
                $query->where('nip', 'like', '%' . $search . '%')
                      ->orWhere('nama', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $admins = $admins->paginate(10);
        return view('admin.index', [
            'admins' => $admins,
            'search' => $search
        ]);
    }
    public function create()
    {
        return view('admin.create');
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'nip' => 'required|string|max:50|unique:admins,nip',
        'email' => 'required|email|unique:admins,email',
        'no_telepon' => 'nullable|string|max:20',
        'alamat' => 'nullable|string',
    ]);

    \App\Models\Admin::create($validated);

    return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan!');
}




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $admin = Admin::findOrFail($id);
    return view('admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, $id)
{
    $request->validate([
        'nip' => 'required',
        'nama' => 'required',
        'email' => 'required|email',
        'no_telepon' => 'required',
        'alamat' => 'required',
    ]);

    $admin = Admin::findOrFail($id);
    $admin->update($request->all());

    return redirect()->route('admin.show', $id)->with('success', 'Data admin berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $admin = Admin::findOrFail($id);
    $admin->delete();

    return redirect()->route('admin.index')->with('success', 'Data admin berhasil dihapus.');
}

}
