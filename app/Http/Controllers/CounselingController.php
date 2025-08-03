<?php

namespace App\Http\Controllers;

use App\Models\Counseling;
use App\Models\TindakLanjut;
use App\Models\User;
use App\Models\Notification;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CounselingController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('role:Super Admin|Admin|Guidance Counselor');
    //     $this->middleware('role:Student|Student Parents')->only(['index', 'store', 'edit', 'update']);
    // }

    public function index(Request $request)
{
    $search = $request->input('search');
    $status = $request->input('status');
    $counselingType = $request->input('counseling_type');
    $user = Auth::user();

    $counselings = Counseling::query()
        // Jika role wali murid atau siswa, batasi query hanya untuk data milik mereka
        ->when($user->hasAnyRole(['Student', 'Student Parents']), function ($query) use ($user) {
            return $query->where('submitted_by_id', $user->id);
        })
        
        // Filter search
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('counseling_type', 'like', "%$search%");
            });
        })
        // Filter status
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        // Filter counseling type
        ->when($counselingType, function ($query, $counselingType) {
            return $query->where('counseling_type', $counselingType);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view('counseling.index', compact('counselings', 'search', 'status', 'counselingType'));
}



    public function create()
{
    $users = User::all();
    return view('counseling.create', compact('users'));
}

    public function store(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'scheduled_at' => 'nullable|date',
        'counseling_type' => 'required|in:siswa,wali_murid',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Counseling::create([
        'scheduled_at' => $request->scheduled_at,
        'submitted_by' => $user->name,
        'submitted_by_id' => $user->id,
        'counseling_type' => $request->counseling_type,
        'title' => $request->title,
        'description' => $request->description,
        'status' => $user->role == 'Student' || $user->role == 'Student Parents' ? 'new' : 'approved', 
    ]);

    if ($user->role == 'Student' || $user->role == 'Student Parents') {
        $scheduled_at = Carbon::parse($request->scheduled_at)->format('d M Y H:i');
        $content = "$user->name mengajukan konseling $request->title pada $scheduled_at";
        Notification::create([
            'type' => 'Guidance Counselor',
            'content' => $content,
            'status' => false,
        ]);

        $details = [
            'name' => $user->name,
            'title' => $request->title,
            'scheduled_at' => $scheduled_at,
            'url' => env('APP_URL') . '/counseling/'
        ];

        $guidanceCounselors = User::role('Guidance Counselor')->get();
        foreach ($guidanceCounselors as $guidanceCounselor) {
            Mail::to($guidanceCounselor->email)->send(
                new TestMail('Ada pengajuan konseling baru', 'email.counseling.create', $details)
            );
        }
    }

    return redirect()->route('counseling.index')->with('success', 'Data konseling berhasil ditambahkan.');
}

    public function update(Request $request, $id)
    {
        $counseling = Counseling::findOrFail($id);
        
        $validated = $request->validate([
            'scheduled_at' => ['nullable', 'date'],
            'submitted_by' => ['required', 'string', 'max:255'],
            'counseling_type' => ['required', 'string', 'max:50', 'in:siswa,wali_murid'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:new,approved,rejected,canceled'],
        ]);

        $counseling->update($validated);

        return redirect()->route('counseling.index')
            ->with('success', 'Data konseling berhasil diperbarui.');
    }

    /**
     * Remove the specified counseling from storage.
     *
     * @param  \App\Models\Counseling  $counseling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Counseling $counseling)
    {
        try {
            // Check if user has permission to delete
            if (!auth()->user()->hasRole(['Super Admin', 'Admin', 'Guidance Counselor'])) {
                return redirect()->route('counseling.index')
                    ->with('error', 'Anda tidak memiliki izin untuk menghapus data konseling.');
            }

            $counseling->delete();

            return redirect()->route('counseling.index')
                ->with('success', 'Data konseling berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('counseling.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data konseling.');
        }
    }


    public function show($id)
    {
        $counseling = Counseling::findOrFail($id);
        $tindaklanjuts = TindakLanjut::where('counseling_id', $id)->get();
    
        return view('counseling.show', compact('counseling', 'tindaklanjuts'));
    }    


    public function approve(Request $request, Counseling $counseling)
    {
        // Check if user is Guidance Counselor
        if (!auth()->user()->hasRole('Guidance Counselor')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menyetujui konseling.');
        }

        // Check if counseling status is new
        if ($counseling->status !== 'new') {
            return redirect()->back()->with('error', 'Status konseling tidak valid untuk disetujui.');
        }

        try {
            $counseling->update([
                'status' => 'approved',
                'notes' => $request->notes
            ]);

            $user = User::findOrFail($counseling->submitted_by_id);

            // Check if scheduled_at exists before formatting
            $scheduled_at = $counseling->scheduled_at ? Carbon::parse($counseling->scheduled_at)->format('d M Y H:i') : 'Belum dijadwalkan';
            $content = "Konseling {$counseling->title} pada {$scheduled_at} telah disetujui";
            
            // Create notification with proper error handling
            try {
                $notificationData = [
                    'user_id' => $counseling->submitted_by_id,
                    'content' => $content,
                    'status' => false,
                ];
                
                // Only add type if user has roles
                if ($user->roles && $user->roles->first()) {
                    $notificationData['type'] = $user->roles->first()->name;
                }
                
                Notification::create($notificationData);
            } catch (\Exception $notificationError) {
                // Log notification error but don't fail the whole process
                \Log::error('Notification creation failed: ' . $notificationError->getMessage());
            }

            $contents = [
                'name' => $user->name,
                'title' => $counseling->title,
                'scheduled_at' => $scheduled_at,
                'notes' => $request->notes,
                'url' => env('APP_URL') . '/counseling/' . $counseling->id
            ];

            // Send email with proper error handling
            try {
                Mail::to($user->email)->send(
                    new TestMail("Konseling {$counseling->title} telah disetujui", 'email.counseling.approved', $contents)
                );
            } catch (\Exception $emailError) {
                // Log email error but don't fail the whole process
                \Log::error('Email sending failed: ' . $emailError->getMessage());
            }

            return redirect()->route('counseling.show', $counseling)
                ->with('success', 'Konseling berhasil disetujui.');
        } catch (\Exception $e) {
            \Log::error('Counseling approval failed: ' . $e->getMessage());
            return redirect()
                ->route('counseling.show', $counseling)
                ->with('error', 'Terjadi kesalahan saat menyetujui data konseling: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, Counseling $counseling)
    {
        // Check if user is Guidance Counselor
        if (!auth()->user()->hasRole('Guidance Counselor')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menolak konseling.');
        }

        // Check if counseling status is new
        if ($counseling->status !== 'new') {
            return redirect()->back()->with('error', 'Status konseling tidak valid untuk ditolak.');
        }

        try {
            $counseling->update([
                'status' => 'rejected',
                'notes' => $request->notes
            ]);

            $user = User::findOrFail($counseling->submitted_by_id);

            // Check if scheduled_at exists before formatting
            $scheduled_at = $counseling->scheduled_at ? Carbon::parse($counseling->scheduled_at)->format('d M Y H:i') : 'Belum dijadwalkan';
            $content = "Konseling {$counseling->title} pada {$scheduled_at} ditolak";
            
            // Create notification with proper error handling
            try {
                $notificationData = [
                    'user_id' => $counseling->submitted_by_id,
                    'content' => $content,
                    'status' => false,
                ];
                
                // Only add type if user has roles
                if ($user->roles && $user->roles->first()) {
                    $notificationData['type'] = $user->roles->first()->name;
                }
                
                Notification::create($notificationData);
            } catch (\Exception $notificationError) {
                // Log notification error but don't fail the whole process
                \Log::error('Notification creation failed: ' . $notificationError->getMessage());
            }

            $contents = [
                'name' => $user->name,
                'title' => $counseling->title,
                'scheduled_at' => $scheduled_at,
                'notes' => $request->notes,
                'url' => env('APP_URL') . '/counseling/' . $counseling->id
            ];

            // Send email with proper error handling
            try {
                Mail::to($user->email)->send(
                    new TestMail("Konseling {$counseling->title} Ditolak", 'email.counseling.rejected', $contents)
                );
            } catch (\Exception $emailError) {
                // Log email error but don't fail the whole process
                \Log::error('Email sending failed: ' . $emailError->getMessage());
            }

            return redirect()->route('counseling.show', $counseling)
                ->with('success', 'Konseling berhasil ditolak.');
        } catch (\Exception $e) {
            \Log::error('Counseling rejection failed: ' . $e->getMessage());
            return redirect()
                ->route('counseling.show', $counseling)
                ->with('error', 'Terjadi kesalahan saat menolak data konseling: ' . $e->getMessage());
        }
    }

    public function cancel(Request $request, Counseling $counseling) {
        // Check if user is Guidance Counselor
        if (!auth()->user()->hasRole('Guidance Counselor')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk membatalkan konseling.');
        }

        // Check if counseling status is new
        if ($counseling->status === 'canceled') {
            return redirect()->back()->with('error', 'Status konseling tidak valid untuk dibatalkan.');
        }

        try {
            $counseling->update([
                'status' => 'canceled',
                'notes' => $request->notes
            ]);

            $user = User::findOrFail($counseling->submitted_by_id);

            // Check if scheduled_at exists before formatting
            $scheduled_at = $counseling->scheduled_at ? Carbon::parse($counseling->scheduled_at)->format('d M Y H:i') : 'Belum dijadwalkan';
            $content = "Konseling {$counseling->title} pada {$scheduled_at} dibatalkan";
            
            // Create notification with proper error handling
            try {
                $notificationData = [
                    'user_id' => $counseling->submitted_by_id,
                    'content' => $content,
                    'status' => false,
                ];
                
                // Only add type if user has roles
                if ($user->roles && $user->roles->first()) {
                    $notificationData['type'] = $user->roles->first()->name;
                }
                
                Notification::create($notificationData);
            } catch (\Exception $notificationError) {
                // Log notification error but don't fail the whole process
                \Log::error('Notification creation failed: ' . $notificationError->getMessage());
            }

            $contents = [
                'name' => $user->name,
                'title' => $counseling->title,
                'scheduled_at' => $scheduled_at,
                'notes' => $request->notes,
                'url' => env('APP_URL') . '/counseling/' . $counseling->id
            ];

            // Send email with proper error handling
            try {
                Mail::to($user->email)->send(
                    new TestMail("Konseling {$counseling->title} Dibatalkan", 'email.counseling.canceled', $contents)
                );
            } catch (\Exception $emailError) {
                // Log email error but don't fail the whole process
                \Log::error('Email sending failed: ' . $emailError->getMessage());
            }

            return redirect()->route('counseling.index')
                ->with('success', 'Konseling berhasil dibatalkan.');
        } catch (\Exception $e) {
            \Log::error('Counseling cancellation failed: ' . $e->getMessage());
            return redirect()
                ->route('counseling.show', $counseling)
                ->with('error', 'Terjadi kesalahan saat membatalkan data konseling: ' . $e->getMessage());
        }
    }

    public function reschedule(Request $request, Counseling $counseling) {
        // Check if user is authorized to reschedule this counseling
        if (!auth()->user()->hasAnyRole(['Student', 'Student Parents']) || 
            $counseling->submitted_by_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mereschedule konseling ini.');
        }

        // Check if counseling status allows rescheduling
        if (!in_array($counseling->status, ['approved', 'new']) || $counseling->status === 'canceled') {
            return redirect()->back()->with('error', 'Status konseling tidak memungkinkan untuk direschedule.');
        }

        // Validate request
        $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'reschedule_reason' => 'nullable|string|max:500',
        ], [
            'scheduled_at.required' => 'Jadwal baru harus diisi.',
            'scheduled_at.date' => 'Format jadwal tidak valid.',
            'scheduled_at.after' => 'Jadwal baru harus setelah waktu sekarang.',
            'reschedule_reason.max' => 'Alasan reschedule maksimal 500 karakter.',
        ]);

        try {
            $oldScheduledAt = $counseling->scheduled_at;
            
            $counseling->update([
                'status' => 'new',
                'scheduled_at' => $request->scheduled_at,
                'old_date' => $oldScheduledAt ?: null,
                'reschedule_note' => $request->reschedule_reason
            ]);

            $user = User::findOrFail($counseling->submitted_by_id);

            $oldScheduledFormatted = $oldScheduledAt ? Carbon::parse($oldScheduledAt)->format('d M Y H:i') : 'Belum dijadwalkan';
            $newScheduledFormatted = Carbon::parse($request->scheduled_at)->format('d M Y H:i');
            
            $content = ($oldScheduledAt && $oldScheduledAt != 'Belum dijadwalkan') 
                ? "$user->name mengajukan penjadwalan ulang Konseling {$counseling->title} dari {$oldScheduledFormatted} menjadi {$newScheduledFormatted}"
                : "$user->name mengajukan jadwal baru untuk Konseling {$counseling->title} pada {$newScheduledFormatted}";
            
            // Create notification for guidance counselors
            Notification::create([
                'type' => 'Guidance Counselor',
                'content' => $content,
                'status' => false,
            ]);

            $details = [
                'name' => $user->name,
                'title' => $counseling->title,
                'old_scheduled_at' => $oldScheduledFormatted,
                'new_scheduled_at' => $newScheduledFormatted,
                'reschedule_reason' => $request->reschedule_reason,
                'url' => env('APP_URL') . '/counseling/' . $counseling->id
            ];

            // Send email to all guidance counselors
            $emailSubject = ($oldScheduledAt && $oldScheduledAt != 'Belum dijadwalkan') 
                ? 'Ada pengajuan penjadwalan ulang konseling'
                : 'Ada pengajuan jadwal baru konseling';
                
            $guidanceCounselors = User::role('Guidance Counselor')->get();
            foreach ($guidanceCounselors as $guidanceCounselor) {
                Mail::to($guidanceCounselor->email)->send(
                    new TestMail($emailSubject, 'email.counseling.reschedule', $details)
                );
            }

            $successMessage = ($oldScheduledAt && $oldScheduledAt != 'Belum dijadwalkan') 
                ? 'Pengajuan penjadwalan ulang konseling berhasil dikirim. Tim konseling akan meninjau permintaan Anda.'
                : 'Pengajuan jadwal baru konseling berhasil dikirim. Tim konseling akan meninjau permintaan Anda.';
                
            return redirect()->route('counseling.index')
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            return redirect()
                ->route('counseling.index')
                ->with('error', 'Terjadi kesalahan saat mengajukan penjadwalan ulang konseling: ' . $e->getMessage());
        }
    }
}