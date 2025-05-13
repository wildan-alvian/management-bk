<?php

namespace App\Http\Controllers;

use App\Models\Counseling;
use App\Models\User;
use App\Models\Notification;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
    $request->validate([
        'scheduled_at' => 'nullable|date',
        'submitted_by' => 'required|string|max:255',
        'counseling_type' => 'required|in:siswa,wali_murid',
        'title' => 'required|string|max:255',
    ]);

    Counseling::create([
        'scheduled_at' => $request->scheduled_at,
        'submitted_by' => $request->submitted_by,
        'counseling_type' => $request->counseling_type,
        'title' => $request->title,
        'status' => 'new', 
    ]);

    $content = "$request->submitted_by mengajukan konseling $request->title pada $request->scheduled_at";
    Notification::create([
        'user_id' => 3, // TODO: ke semua guru bk
        'content' => $content,
        'status' => false,
    ]);

    $details = [
        'title' => 'Permintaan konseling',
        'body' => $content,
    ];

    Mail::to('anyemailrequest@gmail.com')->send( // TODO: ubah ke semua guru bk
        new TestMail('Ada pengajuan konseling baru', 'email.counseling.new', $details)
    );

    return redirect()->route('counseling.index')->with('success', 'Data konseling berhasil ditambahkan.');
}
}