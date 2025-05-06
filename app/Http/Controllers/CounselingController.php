<?php

namespace App\Http\Controllers;

use App\Models\Counseling;
use App\Models\User;
use Illuminate\Http\Request;

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
    

    return redirect()->route('counseling.index')->with('success', 'Data konseling berhasil ditambahkan.');
}
}