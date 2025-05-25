<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentMisconduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentMisconductController extends Controller
{
    // Menyimpan data pelanggaran baru
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
                $filename = uniqid('misconduct_') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/misconducts', $filename);
                $data['file'] = $filename;
            }
            $misconduct = StudentMisconduct::create($data);

            // Load the student relationship
            $misconduct->load('student');

            return response()->json([
                'success' => true,
                'data' => $misconduct,
                'message' => 'Pelanggaran berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data'
            ], 500);
        }
    }

    // Memperbarui data pelanggaran
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
            $misconduct = StudentMisconduct::findOrFail($id);
            $data = $request->all();
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($misconduct->file && \Storage::disk('public')->exists('misconducts/' . $misconduct->file)) {
                    \Storage::disk('public')->delete('misconducts/' . $misconduct->file);
                }
                $file = $request->file('file');
                $filename = uniqid('misconduct_') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/misconducts', $filename);
                $data['file'] = $filename;
            }
            $misconduct->update($data);

            // Load the student relationship
            $misconduct->load('student');

            return response()->json([
                'success' => true,
                'data' => $misconduct,
                'message' => 'Pelanggaran berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data'
            ], 500);
        }
    }

    // Menghapus data pelanggaran
    public function destroy($id)
    {
        try {
            $misconduct = StudentMisconduct::findOrFail($id);
            $misconduct->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pelanggaran berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data'
            ], 500);
        }
    }
}
