<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\PresensiExport;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
public function index(Request $request)
{
    $user = auth()->user(); // ini wajib, supaya $user tidak undefined
    $query = Presensi::with('user')->latest();

    // Jika role student → hanya presensi dirinya
    if ($user->hasRole('Student')) {
        $query->where('user_id', $user->id);
    }

    // Jika role student parent → hanya presensi anak-anaknya
if ($user->hasRole('Student Parents')) {
    $studentParent = $user->studentParent; // relasi 1-1 ke tabel student_parents
    if ($studentParent) {
        $parentId = $studentParent->id;

        $query->whereHas('user.student', function ($q) use ($parentId) {
            // tadinya hanya where, sekarang pakai whereIn agar bisa lebih dari 1 anak
            $q->whereIn('student_parent_id', [$parentId]);
        });
    }
}

    // Filter pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->whereHas('user', function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%");
            })
            ->orWhere('status', 'like', "%{$search}%");
        });
    }

    $presensi = $query->paginate(10);

    return view('presensi.index', compact('presensi'));
}


   public function store(Request $request)
{
    $data = $request->validate([
        'status' => 'required|string',
        'deskripsi' => 'nullable|string',
        'lampiran' => 'nullable|file|max:2048',
        'foto' => 'nullable|string', // base64
    ]);

    $data['user_id'] = Auth::id();
    $data['tanggal_waktu'] = now();

    // Cek jika status hadir, tetapi lewat dari jam 07:00
    if ($data['status'] === 'hadir') {
        $jamBatas = \Carbon\Carbon::createFromTime(7, 0, 0);
        if (now()->greaterThan($jamBatas)) {
            $data['status'] = 'terlambat';
        }
    }

    // Upload lampiran
    if ($request->hasFile('lampiran')) {
        $data['lampiran'] = $request->file('lampiran')->store('presensi', 'public');
    }

    // Upload foto base64
    if (!empty($request->foto)) {
        $image = preg_replace('/^data:image\/\w+;base64,/', '', $request->foto);
        $filename = 'presensi/' . uniqid() . '.png';
        Storage::disk('public')->put($filename, base64_decode($image));
        $data['foto'] = $filename;
    }

    Presensi::create($data);

    return redirect()->route('presensi.index')->with('success', 'Presensi berhasil ditambahkan');
}


    // ===============================
    // Edit Data Presensi
    // ===============================
    public function edit($id)
    {
        $presensi = Presensi::findOrFail($id);
        return view('presensi.edit', compact('presensi'));
    }

    // ===============================
    // Update Data Presensi
    // ===============================
    public function update(Request $request, $id)
    {
        $presensi = Presensi::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|string',
            'deskripsi' => 'nullable|string',
            'lampiran' => 'nullable|file|max:2048',
            'foto' => 'nullable|string', // base64
        ]);

        // Update lampiran kalau ada file baru
        if ($request->hasFile('lampiran')) {
            // hapus file lama kalau ada
            if ($presensi->lampiran && Storage::disk('public')->exists($presensi->lampiran)) {
                Storage::disk('public')->delete($presensi->lampiran);
            }
            $data['lampiran'] = $request->file('lampiran')->store('presensi', 'public');
        }

        // Update foto kalau ada upload baru
        if (!empty($request->foto)) {
            if ($presensi->foto && Storage::disk('public')->exists($presensi->foto)) {
                Storage::disk('public')->delete($presensi->foto);
            }
            $image = preg_replace('/^data:image\/\w+;base64,/', '', $request->foto);
            $filename = 'presensi/' . uniqid() . '.png';
            Storage::disk('public')->put($filename, base64_decode($image));
            $data['foto'] = $filename;
        }

        $presensi->update($data);

        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil diperbarui');
    }

    // ===============================
    // Delete Data Presensi
    // ===============================
    public function destroy($id)
    {
        $presensi = Presensi::findOrFail($id);

        // hapus file lampiran
        if ($presensi->lampiran && Storage::disk('public')->exists($presensi->lampiran)) {
            Storage::disk('public')->delete($presensi->lampiran);
        }

        // hapus foto
        if ($presensi->foto && Storage::disk('public')->exists($presensi->foto)) {
            Storage::disk('public')->delete($presensi->foto);
        }

        $presensi->delete();

        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil dihapus');
    }

    public function show($id)
{
    $presensi = Presensi::with('user')->findOrFail($id);
    return view('presensi.show', compact('presensi'));
}

public function export(Request $request)
{
    $query = Presensi::with('user')->latest();

    // Filter pencarian sama dengan index
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('user', function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%");
            })
            ->orWhere('status', 'like', "%{$search}%");
        });
    }

    $presensi = $query->get();

    return Excel::download(new PresensiExport($presensi), 'presensi.xlsx');
}
}
