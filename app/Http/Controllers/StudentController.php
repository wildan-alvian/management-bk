<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $students = Student::query()
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', '%' . $search . '%');
            })
            ->orderBy('nama_lengkap')
            ->paginate(10); // pakai pagination supaya links() tidak error

        return view('student.index', compact('students', 'search'));
    }

    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|unique:students,nisn|max:20',
            'nama_lengkap' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
            'email_siswa' => 'nullable|email',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'alamat_siswa' => 'required|string|max:255',
            'telepon_siswa' => 'nullable|string|max:15',

            'hubungan_wali' => 'required|string',
            'nama_wali' => 'required|string|max:100',
            'telepon_wali' => 'nullable|string|max:15',
            'email_wali' => 'nullable|email',
            'alamat_wali' => 'required|string|max:255',

            'prestasi_date' => 'nullable|date',
            'prestasi_name' => 'nullable|string|max:100',
            'prestasi_category' => 'nullable|string|max:50',
            'prestasi_detail' => 'nullable|string|max:255',

            'pelanggaran_date' => 'nullable|date',
            'pelanggaran_name' => 'nullable|string|max:100',
            'pelanggaran_category' => 'nullable|string|max:50',
            'pelanggaran_detail' => 'nullable|string|max:255',
        ]);

        $student = Student::create($validated);

        // Simpan Prestasi
        if ($request->filled('prestasi_name')) {
            $student->achievements()->create([
                'name' => $validated['prestasi_name'],
                'category' => $validated['prestasi_category'],
                'date' => $validated['prestasi_date'],
                'detail' => $validated['prestasi_detail'],
            ]);
        }

        // Simpan Pelanggaran
        if ($request->filled('pelanggaran_name')) {
            $student->misconducts()->create([
                'name' => $validated['pelanggaran_name'],
                'category' => $validated['pelanggaran_category'],
                'date' => $validated['pelanggaran_date'],
                'detail' => $validated['pelanggaran_detail'],
            ]);
        }

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil disimpan.');
    }

    public function show(Student $student)
    {
        return view('student.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
    public function update(Request $request, $id)
{
    $student = Student::find($id);

    // Validasi data siswa
    $validatedData = $request->validate([
        'nisn' => 'required|string|unique:students,nisn,' . $id . '|max:20',
        'nama_lengkap' => 'required|string|max:100',
        'kelas' => 'required|string|max:10',
        'email_siswa' => 'nullable|email',
        'tempat_lahir' => 'required|string|max:50',
        'tanggal_lahir' => 'required|date',
        'alamat_siswa' => 'required|string|max:255',
        'telepon_siswa' => 'nullable|string|max:15',
        'hubungan_wali' => 'required|string',
        'nama_wali' => 'required|string|max:100',
        'telepon_wali' => 'nullable|string|max:15',
        'email_wali' => 'nullable|email',
        'alamat_wali' => 'required|string|max:255',
    ]);

    // Update data siswa
    $student->update($validatedData);

    // Response untuk AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'student' => $student
        ]);
    }

    // Redirect jika bukan AJAX
    return redirect()->route('students.show', $student->id)->with('success', 'Data berhasil diupdate');

}

}
