<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentMisconduct;
use App\Models\Lanjutan;
use App\Models\Notification;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        'followup_notes' => 'nullable|string',
        'followup_file' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $data = $request->only(['student_id', 'name', 'category', 'date', 'detail']);

        // Simpan file pelanggaran jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = uniqid('misconduct_') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/misconducts', $filename);
            $data['file'] = 'misconducts/' . $filename;
        }

        $misconduct = StudentMisconduct::create($data);

        // Simpan tindak lanjut jika ada
        if ($request->filled('followup_notes') || $request->hasFile('followup_file')) {
            $followUpData = [
                'misconduct_id' => $misconduct->id,
                'note' => $request->followup_notes,
            ];

            if ($request->hasFile('followup_file')) {
                $followFile = $request->file('followup_file');
                $followName = uniqid('followup_') . '.' . $followFile->getClientOriginalExtension();
                $followFile->storeAs('public/followups', $followName);
                $followUpData['file'] = 'followups/' . $followName;
            }

            Lanjutan::create($followUpData);
        }

        // Kirim notifikasi & email
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
                'url' => route('students.show', $studentUser->id),
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
            'data' => $misconduct->load('followUp'),
            'message' => 'Pelanggaran berhasil ditambahkan'
        ]);
    } catch (\Exception $e) {
        // return response()->json([
        //     'success' => false,
        //     'message' => 'Terjadi kesalahan saat menyimpan data',
        //     'error_detail' => $e->getMessage()
        // ], 500);
        return back()->with('error', 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage())
            ->withInput();
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
        'followup_notes' => 'nullable|string',
        'followup_file' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
        'remove_old_file' => 'nullable|boolean'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $misconduct = StudentMisconduct::findOrFail($id);

        $data = $request->only(['name', 'category', 'date', 'detail']);

        // Jika file pelanggaran diunggah ulang
        if ($request->hasFile('file')) {
            if ($misconduct->file && Storage::disk('public')->exists($misconduct->file)) {
                Storage::disk('public')->delete($misconduct->file);
            }

            $file = $request->file('file');
            $filename = uniqid('misconduct_') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/misconducts', $filename);
            $data['file'] = 'misconducts/' . $filename;
        }

        $misconduct->update($data);

        // Update atau buat tindak lanjut
        if ($request->filled('followup_notes') || $request->hasFile('followup_file')) {
            $followUpData = ['note' => $request->followup_notes];

            if ($request->hasFile('followup_file')) {
                // Hapus lampiran lama jika ada
                if ($misconduct->followUp && $misconduct->followUp->file && Storage::disk('public')->exists($misconduct->followUp->file)) {
                    Storage::disk('public')->delete($misconduct->followUp->file);
                }

                $file = $request->file('followup_file');
                $filename = uniqid('followup_') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/followups', $filename);
                $followUpData['file'] = 'followups/' . $filename;
            }

            $misconduct->followUp()->updateOrCreate(
                ['misconduct_id' => $misconduct->id],
                $followUpData
            );
        }

        return response()->json([
            'success' => true,
            'data' => $misconduct->load('followUp'),
            'message' => 'Pelanggaran berhasil diperbarui'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat memperbarui data',
            'error_detail' => $e->getMessage()
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

    public function show($id)
{
    $misconduct = StudentMisconduct::with('followUp')->findOrFail($id);
    return view('student.misconduct-show', compact('misconduct'));
}

}
