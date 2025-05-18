<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Students::with('classes');

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

        $perPage = $request->input('paginate', 10);
        if (!in_array($perPage, [10, 50, 100, 500])) {
            $perPage = 10;
        }

        $students = $query->orderBy('nisn')->paginate($perPage);

        $classes = Classes::orderBy('className')->get();

        return view('students.index', compact('students', 'classes'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|unique:students,nisn',
            'classId' => 'required|exists:classes,id',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'create'); // ini kunci untuk tahu bahwa ini error dari "Tambah"
        }

        Students::create($validator->validated());

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Students $student)
    {
        $student->load(['classes', 'parent']);
        return view('students.show', compact('student'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Students $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Students $student)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nisn' => [
                'required',
                'string',
                Rule::unique('students', 'nisn')->ignore($student->id),
            ],
            'classId' => 'required|exists:classes,id',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $student->id);
        }

        $student->update($validator->validated());

        return redirect()->back()
            ->with('edit_success', true)
            ->with('edited_id', $student->id)
            ->with('message', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Students $student)
    {
        $student->delete();
        return redirect()->back();
    }
}
