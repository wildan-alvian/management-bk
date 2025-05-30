<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CounselorsImport;

class GuruBkController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Admin|Admin')->except(['index', 'show']);
        $this->middleware('role:Super Admin|Admin|Guidance Counselor')->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $counselors = User::role('Guidance Counselor')
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('id_number', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('counselor.index', compact('counselors'));
    }

    public function create()
    {
        return view('counselor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'id_number' => ['required', 'string', 'max:50', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        // Generate random password
        $password = substr(str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&'), 0, 10);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($password),
                'id_number' => $validated['id_number'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'role' => 'Guidance Counselor'
            ]);

            $user->assignRole('Guidance Counselor');
            
            DB::commit();

            $details = [
                'name' => $validated['name'],
                'password' => $password,
                'url' => env('APP_URL'),
            ];

            Mail::to($validated['email'])->send(
                new TestMail('Pembuatan akun CounselLink baru', 'email.user.create', $details)
            );

            return redirect()->route('counselors.index')
                ->with('success', "Guru BK berhasil ditambahkan.");
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error creating Guru BK: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $counselor = User::role('Guidance Counselor')->findOrFail($id);
        return view('counselor.show', compact('counselor'));
    }

    public function update(Request $request, $id)
    {
        $counselor = User::role('Guidance Counselor')->findOrFail($id);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'id_number' => ['required', 'string', 'max:50', 'unique:users,id_number,' . $id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        try {
            $counselor->update($validated);
            return redirect()->route('counselors.show', $counselor->id)
                ->with('success', 'Data Guru BK berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data Guru BK.');
        }
    }

    public function destroy($id)
    {
        $counselor = User::role('Guidance Counselor')->findOrFail($id);
        
        try {
            $counselor->delete();
            return redirect()->route('counselors.index')
                ->with('success', 'Data Guru BK berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data Guru BK.');
        }
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv'
    ]);

    try {
        Excel::import(new CounselorsImport, $request->file('file'));
        return redirect()->route('counselors.index')
            ->with('success', 'Data Guru BK berhasil diimport.');
    } catch (\Exception $e) {
        \Log::error('Import error: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan saat mengimport data: ' . $e->getMessage());
    }
}
}