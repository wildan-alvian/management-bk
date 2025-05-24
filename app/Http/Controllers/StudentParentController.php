<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentParent;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentParentController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
{
    $user = auth()->user();
    $search = $request->input('search');

    // Jika Student Parents, tampilkan data diri sendiri dengan pagination (meskipun 1 item)
    if ($user->hasRole('Student Parents')) {
        $studentParents = User::role('Student Parents')
            ->where('id', $user->id)
            ->paginate(1);

        return view('student_parent.index', compact('studentParents'));
    }

    // Jika Student, tampilkan wali murid dengan paginator manual
    if ($user->hasRole('Student')) {
        $student = $user->student;

        if (!$student || !$student->studentParent) {
            // kosong tapi harus paginator agar kompatibel dengan view
            $studentParents = new LengthAwarePaginator([], 0, 10);
            return view('student_parent.index', compact('studentParents'));
        }

        $parentUser = $student->studentParent->user;
        $items = collect([$parentUser]);

        $perPage = 10;
        $page = Paginator::resolveCurrentPage('page');
        $itemsForCurrentPage = $items->slice(($page - 1) * $perPage, $perPage)->values();

        $studentParents = new LengthAwarePaginator(
            $itemsForCurrentPage,
            $items->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('student_parent.index', compact('studentParents'));
    }

    // Role lain: tampilkan semua wali murid dengan search dan pagination
    $query = User::role('Student Parents');
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('id_number', 'LIKE', "%{$search}%");
        });
    }

    $studentParents = $query->orderBy('name')->paginate(10)->withQueryString();

    return view('student_parent.index', compact('studentParents'));
}

    public function create()
    {
        return view('student_parent.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_number' => ['required', 'string', 'max:20', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'family_relation' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
        ]);

        $password = substr(str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&'), 0, 10);

        DB::beginTransaction();
        try {
            $user = User::create([
                'id_number' => $validated['id_number'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($password),
                'phone' => $validated['phone'] ?? '',
                'address' => $validated['address'] ?? '',
                'role' => 'Student Parents'
            ]);
            $user->assignRole('Student Parents');

            $studentParent = StudentParent::create([
                'user_id' => $user->id,
                'family_relation' => $validated['family_relation']
            ]);

            Mail::to($validated['email'])->send(
                new TestMail('Pembuatan akun CounselLink baru', 'email.user.create', [
                    'name' => $validated['name'],
                    'password' => $password,
                    'url' => env('APP_URL'),
                ])
            );

            DB::commit();

            return redirect()->route('student-parents.index')
                ->with('success', "Data wali murid berhasil ditambahkan.");

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error creating student parent: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
{
    $user = auth()->user();

    if ($user->hasRole('Student Parents') && $user->id != $id) {
        abort(403, 'Tidak diizinkan melihat data orang tua lain.');
    }

    if ($user->hasRole('Student')) {
        $student = $user->student;

        if (!$student || !$student->studentParent || $student->studentParent->user_id != $id) {
            abort(403, 'Tidak diizinkan melihat data orang tua lain.');
        }
    }

    $studentParent = User::role('Student Parents')
        ->with([
            'studentParent.students.user' => function ($query) {
                $query->orderBy('name', 'desc');
            },
        ])
        ->findOrFail($id);

    return view('student_parent.show', compact('studentParent'));
}

    public function update(Request $request, $id)
    {
        $studentParent = User::role('Student Parents')->findOrFail($id);

        $validated = $request->validate([
            'id_number' => ['required', 'string', 'max:20', 'unique:users,id_number,' . $id],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone' => ['nullable', 'string', 'max:20'],
            'family_relation' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
        ]);
        
        DB::beginTransaction();
        try {
            $studentParent->update([
                'id_number' => $validated['id_number'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
            ]);

            $studentParent->studentParent->update([
                'family_relation' => $validated['family_relation'],
            ]);

            DB::commit();

            return redirect()->route('student-parents.show', $studentParent->id)
                ->with('success', 'Data Wali Murid berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data Wali Murid.');
        }
    }

    public function destroy($id)
    {
        $studentParent = User::role('Student Parents')->with(['studentParent.students.user'])->findOrFail($id);

        DB::beginTransaction();
        try {
            foreach ($studentParent->studentParent->students as $student) {
                $student->delete();

                if ($student->user) {
                    $student->user->delete();
                }
            }

            if ($studentParent->studentParent) {
                $studentParent->studentParent->delete();
            }

            $studentParent->delete();

            DB::commit();
            return redirect()->route('student-parents.index')
                ->with('success', 'Data wali murid berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error deleting student parent: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menghapus data wali murid: ' . $e->getMessage()]);
        }
    }
}
