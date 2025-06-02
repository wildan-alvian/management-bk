<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentMisconduct;
use App\Models\Notification;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

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

            $misconduct->load('student.user', 'student.studentParent.user');

            if ($misconduct->student && $misconduct->student->studentParent && $misconduct->student->studentParent->user) {
                $parentUser = $misconduct->student->studentParent->user;
                $studentUser = $misconduct->student->user;

                $notificationContent = "{$studentUser->name} melakukan pelanggaran {$misconduct->name} pada {$misconduct->created_at->format('d M Y')}";
                Notification::create([
                    'user_id' => $parentUser->id,
                    'type' => $parentUser->roles->first()->name ?? 'Student Parents',
                    'content' => $notificationContent,
                    'status' => false,
                    'url' => route('students.show', $misconduct->student_id),
                ]);

                $emailDetails = [
                    'parent_name' => $parentUser->name,
                    'student_name' => $studentUser->name,
                    'student_class' => $misconduct->student->class,
                    'student_nisn' => $misconduct->student->nisn,
                    'misconduct_name' => $misconduct->name,
                    'misconduct_date' => $misconduct->created_at->format('d M Y'),
                    'detail_url' => route('students.show', $misconduct->student_id),
                ];

                Mail::to($parentUser->email)->send(
                    new TestMail('Pemberitahuan Pelanggaran Siswa', 'email.misconduct.parent_notification', $emailDetails)
                );
            }

            return response()->json([
                'success' => true,
                'data' => $misconduct,
                'message' => 'Pelanggaran berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error_detail' => $e->getMessage()
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
