<?php

namespace App\Http\Controllers;

use App\Models\Counseling;
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
    $counselings = Counseling::query()
    ->when($search, function ($query, $search) {
        return $query->where('title', 'like', "%$search%")
                     ->orWhere('counseling_type', 'like', "%$search%");
    })
    ->orderBy('created_at', 'desc')
    ->paginate(10);

    return view('counseling.index', compact('counselings', 'search'));
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
    ]);

    Counseling::create([
        'scheduled_at' => $request->scheduled_at,
        'submitted_by' => $user->name,
        'submitted_by_id' => $user->id,
        'counseling_type' => $request->counseling_type,
        'title' => $request->title,
        'status' => 'new', 
    ]);

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

    Mail::to('anyemailrequest@gmail.com')->send( // TODO: ubah ke semua guru bk
        new TestMail('Ada pengajuan konseling baru', 'email.counseling.create', $details)
    );

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
            'status' => ['nullable', 'string', 'in:new,approved,rejected'],
        ]);

        try {
            $counseling->update($validated);

            $user = User::findOrFail($counseling->submitted_by_id);

            $scheduled_at = Carbon::parse($request->scheduled_at)->format('d M Y H:i');
            $content = "Konseling $request->title pada $scheduled_at telah $request->status";
            Notification::create([
                'user_id' => $counseling->submitted_by_id,
                'type' => $user->role,
                'content' => $content,
                'status' => false,
            ]);

            $details = [
                'title' => $request->title,
                'scheduled_at' => $scheduled_at,
                'status' => $request->status,
                'url' => env('APP_URL') . '/counseling/'
            ];

            Mail::to($user->email)->send(
                new TestMail("Perubahan status konseling", 'email.counseling.update', $details)
            );

            return redirect()->route('counseling.index')
                ->with('success', 'Data konseling berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data konseling.');
        }
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
}