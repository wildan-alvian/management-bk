<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Admin|Admin');
    }

    public function index(Request $request) 
    {
        $search = $request->get('search');

        $admins = User::role('Admin')
            ->when($search, function ($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('nip', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(10)
            ->withQueryString();

        if ($search && $admins->isEmpty()) {
            session()->flash('error', 'Tidak ada admin yang ditemukan dengan kata kunci: ' . $search);
        }

        return view('admin.index', compact('admins', 'search'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nip' => ['required', 'string', 'max:50', 'unique:users'],
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
                'nip' => $validated['nip'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'role' => 'Admin'
            ]);

            $user->assignRole('Admin');
            
            DB::commit();
            return redirect()->route('admin.index')
                ->with('success', "Admin berhasil ditambahkan! Password: $password");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menambahkan admin. ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(User $admin)
    {
        return view('admin.show', compact('admin'));
    }

    public function edit(User $admin)
    {
        if ($admin->hasRole('Super Admin')) {
            abort(403, 'Tidak dapat mengedit Super Admin');
        }
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {


        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $admin->id],
            'nip' => ['required', 'string', 'max:50', 'unique:users,nip,' . $admin->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ];

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            $admin->update($validated);
            DB::commit();

            return redirect()->route('admin.index', $admin)
                ->with('success', 'Data admin berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data admin.')
                ->withInput();
        }
    }

    public function destroy(User $admin)
    {
        if ($admin->hasRole('Super Admin')) {
            abort(403, 'Tidak dapat menghapus Super Admin');
        }

        if (auth()->id() === $admin->id) {
            abort(403, 'Tidak dapat menghapus akun sendiri');
        }

        DB::beginTransaction();
        try {
            $admin->removeRole('Admin');
            $admin->delete();
            DB::commit();

            return redirect()->route('admin.index')
                ->with('success', 'Data admin berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menghapus data admin.');
        }
    }
}
