<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\Classes;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Students::with('classes'); // Memuat relasi kelas

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhereHas('classes', function ($q) use ($search) {
                        $q->where('className', 'like', "%{$search}%");
                    });
            });
        }

        $students = $query->orderBy('nisn')->get(); // Urutkan berdasarkan nisn

        return view('students.index', compact('students'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classes::get();
        return view('students.create', compact('classes'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|unique:students,nisn',
            'classId' => 'required|exists:classes,id',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar.', // Pesan validasi untuk NISN yang duplikat
        ]);

        // Simpan data mahasiswa
        Students::create($validated);

        // Redirect ke halaman create dengan pesan sukses
        return redirect()->route('students.create')->with('success', 'Siswa berhasil ditambahkan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Students $students)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Students $students)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Students $students)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Students $student)
    {
        $student->delete();

        $redirectTo = $request->input('redirect_to');
        return redirect($redirectTo ?? route('students.index'))
            ->with('success', 'Siswa berhasil dihapus.');
    }
}
