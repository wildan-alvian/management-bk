<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAchievement;
use Illuminate\Http\Request;

class StudentAchievementController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'achievements' => 'required|array',
        'achievements.*.name' => 'required|string|max:255',
        'achievements.*.category' => 'required|string|max:255',
        'achievements.*.date' => 'required|date',
        'achievements.*.detail' => 'nullable|string',
    ]);

    foreach ($request->achievements as $achievement) {
        StudentAchievement::create([
            'student_id' => $request->student_id,
            'name' => $achievement['name'],
            'category' => $achievement['category'],
            'date' => $achievement['date'],
            'detail' => $achievement['detail'] ?? null,
        ]);
    }

    return redirect()->route('student.show', $request->student_id)
                     ->with('success', 'Prestasi berhasil ditambahkan.');
}


    public function update(Request $request, $id)
    {
        $achievement = StudentAchievement::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'detail' => 'nullable|string',
        ]);

        $achievement->update($request->all());

        return redirect()->route('student.show', $achievement->student_id)
                         ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $achievement = StudentAchievement::findOrFail($id);
        $studentId = $achievement->student_id;
        $achievement->delete();

        return redirect()->route('student.show', $studentId)
                         ->with('success', 'Prestasi berhasil dihapus.');
    }
}
