<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Classes::with('students');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('className', 'like', "%{$search}%");
        }

        $classes = $query->orderBy('className')->get();

        $students = Students::all();

        return view('classes.index', compact('classes', 'students'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'className' => 'required|string|max:255|unique:classes,className',
            'teacherId' => 'nullable|string|max:255|unique:classes,teacherId',
        ], [
            'className.unique' => 'Nama kelas ini sudah terdaftar.',
            'teacherId.unique' => 'NIP ini sudah terdaftar.',
        ]);

        Classes::create($validated);

        return redirect()->route('classes.create')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Classes $class)
    {
        $search = $request->input('search');

        $studentsQuery = $class->students()->orderBy('nisn');

        if ($search) {
            $studentsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $students = $studentsQuery->get();

        return view('classes.show', compact('class', 'students', 'search'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classes $class)
    {
        return view('classes.edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'className' => [
                'required',
                'string',
                'max:255',
                Rule::unique('classes', 'className')->ignore($class->id),
            ],
            'teacherId' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('classes', 'teacherId')->ignore($class->id),
            ],
        ], [
            'className.unique' => 'Nama kelas ini sudah terdaftar.',
            'teacherId.unique' => 'NIP ini sudah terdaftar.',
        ]);

        $class->update($validated);

        return redirect()->route('classes.edit', $class->id)->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->students()->update(['classId' => null]);
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted successfully');
    }
}
