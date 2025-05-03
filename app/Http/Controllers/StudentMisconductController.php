<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentMisconduct;
use Illuminate\Http\Request;

class StudentMisconductController extends Controller
{
    // Menyimpan data pelanggaran baru
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'misconducts' => 'required|array',
            'misconducts.*.name' => 'required|string|max:255',
            'misconducts.*.category' => 'required|string|max:255',
            'misconducts.*.date' => 'required|date',
            'misconducts.*.detail' => 'nullable|string',
        ]);

        foreach ($request->misconducts as $misconduct) {
            StudentMisconduct::create([
                'student_id' => $request->student_id,
                'name' => $misconduct['name'],
                'category' => $misconduct['category'],
                'date' => $misconduct['date'],
                'detail' => $misconduct['detail'] ?? null,
            ]);
        }

        return redirect()->route('student.show', $request->student_id)
                         ->with('success', 'Pelanggaran berhasil ditambahkan.');
    }

    // Memperbarui data pelanggaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'detail' => 'nullable|string',
        ]);

        $misconduct = StudentMisconduct::findOrFail($id);
        $misconduct->update([
            'name' => $request->name,
            'category' => $request->category,
            'date' => $request->date,
            'detail' => $request->detail,
        ]);

        return redirect()->back()->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    // Menghapus data pelanggaran
    public function destroy($id)
    {
        $misconduct = StudentMisconduct::findOrFail($id);
        $studentId = $misconduct->student_id;
        $misconduct->delete();

        return redirect()->route('student.show', $studentId)
                         ->with('success', 'Pelanggaran berhasil dihapus.');
    }
}
