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

class StudentController extends Controller
{
    public function __construct()
    {
        // Allow Student Parents to view student data
        $this->middleware('role:Super Admin|Admin|Guidance Counselor')->except(['index', 'show']);
        $this->middleware('role:Super Admin|Admin|Guidance Counselor|Student|Student Parents')->only(['index', 'show']);
    }

    public function index(Request $request)
{
    $search = $request->input('search');
    $classFilter = $request->input('class_filter');

    if (auth()->user()->hasRole('Student')) {
        $query = User::where('id', auth()->id());
    } else {
        $query = User::role('Student');

        if (auth()->user()->hasRole('Student Parents')) {
            $parentProfile = auth()->user()->parentProfile;

            if ($parentProfile) {
                $parentId = $parentProfile->id;

                $query->whereHas('student', function($q) use ($parentId) {
                    $q->where('student_parent_id', $parentId);
                });
            }
        }

        $query = $query->when($search, function($query) use ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhereHas('student', function($q) use ($search) {
                      $q->where('nisn', 'LIKE', "%{$search}%")
                        ->orWhere('class', 'LIKE', "%{$search}%");
                  });
            });
        });

        if ($classFilter) {
            $query->whereHas('student', function($q) use ($classFilter) {
                $q->where('class', 'LIKE', $classFilter . '%');
            });
        }
    }

    $students = $query
        ->with(['student.studentParent.user'])
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

    return view('student.index', compact('students'));
}

    

    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Student User Data
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'nisn' => ['required', 'string', 'max:20', 'unique:students'],
            'class' => ['required', 'string', 'max:50'],
            'gender' => ['required', 'in:L,P'],
            'birthdate' => ['nullable', 'date'],
            'birthplace' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            
            // Parent Data
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'parent_phone' => ['nullable', 'string', 'max:20'],
            'parent_address' => ['nullable', 'string'],
            'family_relation' => ['required', 'string', 'max:50']
        ]);

        // Generate random passwords
        $studentPassword = substr(str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&'), 0, 10);
        $parentPassword = substr(str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&'), 0, 10);

        DB::beginTransaction();
        try {
            // Create Student User
            $studentUser = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($studentPassword),
                'phone' => $validated['phone'] ?? '',
                'address' => $validated['address'] ?? '',
                'role' => 'Student'
            ]);
            $studentUser->assignRole('Student');

            // Create Student Profile
            $student = Student::create([
                'user_id' => $studentUser->id,
                'nisn' => $validated['nisn'],
                'class' => $validated['class'],
                'gender' => $validated['gender'],
                'birthdate' => $validated['birthdate'],
                'birthplace' => $validated['birthplace']
            ]);

            // Create Parent User
            $parentUser = User::create([
                'name' => $validated['parent_name'],
                'email' => $validated['parent_email'],
                'password' => Hash::make($parentPassword),
                'phone' => $validated['parent_phone'] ?? '',
                'address' => $validated['parent_address'] ?? '',
                'role' => 'Student Parents'
            ]);
            $parentUser->assignRole('Student Parents');

            // Create Parent Profile
            $studentParent = StudentParent::create([
                'user_id' => $parentUser->id,
                'family_relation' => $validated['family_relation']
            ]);

            // Update student with parent relationship
            $student->update([
                'student_parent_id' => $studentParent->id
            ]);

            // Send email to student
            $details = [
                'name' => $validated['name'],
                'password' => $studentPassword,
                'url' => env('APP_URL'),
            ];

            Mail::to($validated['email'])->send(
                new TestMail('Pembuatan akun CounselLink baru', 'email.user.create', $details)
            );

            // Send email to student parent
            $details = [
                'name' => $validated['parent_name'],
                'password' => $parentPassword,
                'url' => env('APP_URL'),
            ];

            Mail::to($validated['parent_email'])->send(
                new TestMail('Pembuatan akun CounselLink baru', 'email.user.create', $details)
            );

            DB::commit();

            return redirect()->route('students.index')
                ->with('success', "Data siswa berhasil ditambahkan.");

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error creating student: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $query = User::role('Student')
            ->with([
                'student.studentParent.user',
                'student.achievements' => function($query) {
                    $query->orderBy('date', 'desc');
                },
                'student.misconducts' => function($query) {
                    $query->orderBy('date', 'desc');
                }
            ]);

        // If user is a Student Parent, verify they can access this student
        if (auth()->user()->hasRole('Student Parents')) {
            $parentId = auth()->user()->parentProfile->id;
            $query->whereHas('student', function($q) use ($parentId) {
                $q->where('student_parent_id', $parentId);
            });
        }

        $student = $query->findOrFail($id);

        return view('student.show', compact('student'));
    }

    public function edit($id)
    {
        $student = User::role('Student')->with(['student.studentParent.user'])->findOrFail($id);
        return view('student.edit', compact('student'));
    }

    public function update(Request $request, $id)
{
        $student = User::role('Student')->with(['student.studentParent.user'])->findOrFail($id);
        
        $validated = $request->validate([
            // Student User Data
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $student->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'nisn' => ['required', 'string', 'max:20', 'unique:students,nisn,' . $student->student->id],
            'class' => ['required', 'string', 'max:50'],
            'gender' => ['required', 'in:L,P'],
            'birthdate' => ['nullable', 'date'],
            'birthplace' => ['nullable', 'string', 'max:255'],
            
            // Parent Data
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . optional(optional($student->student->studentParent)->user)->id],
            'parent_phone' => ['nullable', 'string', 'max:20'],
            'parent_address' => ['nullable', 'string'],
            'family_relation' => ['required', 'string', 'max:50']
        ]);

        DB::beginTransaction();
        try {
            // Update Student User
            $student->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address']
            ]);

            // Update Student Profile
            $student->student->update([
                'nisn' => $validated['nisn'],
                'class' => $validated['class'],
                'gender' => $validated['gender'],
                'birthdate' => $validated['birthdate'],
                'birthplace' => $validated['birthplace']
            ]);

            // Update Parent User
            if ($student->student->studentParent) {
                $student->student->studentParent->user->update([
                    'name' => $validated['parent_name'],
                    'email' => $validated['parent_email'],
                    'phone' => $validated['parent_phone'],
                    'address' => $validated['parent_address']
                ]);

                // Update Parent Profile
                $student->student->studentParent->update([
                    'family_relation' => $validated['family_relation']
                ]);
            }

            DB::commit();

            return redirect()->route('students.index')
                ->with('success', 'Data siswa berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error updating student: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $student = User::role('Student')->with(['student.studentParent.user'])->findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Delete Student Parent record if exists
            if ($student->student && $student->student->studentParent) {
                $parentUser = $student->student->studentParent->user;
                $student->student->studentParent->delete(); // Delete StudentParent record
                $parentUser->delete(); // Delete parent User record
            }

            // Delete Student record
            if ($student->student) {
                $student->student->delete();
            }
            
            // Delete Student User
            $student->delete();
            
            DB::commit();
            return redirect()->route('students.index')
                ->with('success', 'Data siswa berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error deleting student: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menghapus data siswa: ' . $e->getMessage()]);
        }
    }
}
