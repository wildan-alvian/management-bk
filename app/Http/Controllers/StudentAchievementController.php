<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentAchievementController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'detail' => 'nullable|string',
            'file' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = uniqid('achievement_') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/achievements', $filename);
                $data['file'] = $filename;
            }
            $achievement = StudentAchievement::create($data);

            // Load the student relationship
            $achievement->load('student');

            return response()->json([
                'success' => true,
                'data' => $achievement,
                'message' => 'Prestasi berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'detail' => 'nullable|string',
            'file' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $achievement = StudentAchievement::findOrFail($id);
            $data = $request->all();
            // Hapus file lama jika user klik hapus file
            if ($request->has('remove_old_file')) {
                if ($achievement->file && \Storage::disk('public')->exists('achievements/' . $achievement->file)) {
                    \Storage::disk('public')->delete('achievements/' . $achievement->file);
                }
                $data['file'] = null;
            }
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($achievement->file && \Storage::disk('public')->exists('achievements/' . $achievement->file)) {
                    \Storage::disk('public')->delete('achievements/' . $achievement->file);
                }
                $file = $request->file('file');
                $filename = uniqid('achievement_') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/achievements', $filename);
                $data['file'] = $filename;
            }
            $achievement->update($data);

            // Load the student relationship
            $achievement->load('student');

            return response()->json([
                'success' => true,
                'data' => $achievement,
                'message' => 'Prestasi berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $achievement = StudentAchievement::findOrFail($id);
            $achievement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data'
            ], 500);
        }
    }
}
