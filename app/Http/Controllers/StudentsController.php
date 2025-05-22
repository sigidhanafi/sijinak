<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Students;
use App\Models\User;
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
            $search = strtolower($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhereHas('classes', function ($q) use ($search) {
                        $q->whereRaw('LOWER(className) LIKE ?', ["%{$search}%"]);
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
        $emailValidator = Validator::make($request->only('email'), [
            'email' => [
                'required',
                'email',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                'unique:users,email',
            ],
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Format email tidak valid.',
        ]);

        if ($emailValidator->fails()) {
            return redirect()->back()
                ->withErrors($emailValidator)
                ->withInput()
                ->with('error_source', 'create');
        }

        $otherValidator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                "regex:/^[\pL\s\-\'\.,]+$/u",
            ],
            'nisn' => [
                'required',
                'string',
                'regex:/^\d+$/',
                'unique:students,nisn',
            ],
            'classId' => 'required|exists:classes,id',
        ], [
            'name.max' => 'Nama siswa tidak boleh lebih dari 255 karakter.',
            'name.regex' => 'Nama siswa mengandung karakter yang tidak diperbolehkan.',
            'nisn.regex' => 'NISN hanya boleh berupa angka.',
            'nisn.unique' => 'NISN ini sudah terdaftar.',
        ]);

        if ($otherValidator->fails()) {
            return redirect()->back()
                ->withErrors($otherValidator)
                ->withInput()
                ->with('error_source', 'create');
        }

        $validated = array_merge(
            $emailValidator->validated(),
            $otherValidator->validated()
        );

        $user = User::create([
            'email'    => $validated['email'],
            'password' => bcrypt('12345678'),
            'role'     => 'student',
        ]);

        Students::create([
            'name'     => $validated['name'],
            'nisn'     => $validated['nisn'],
            'classId'  => $validated['classId'],
            'user_id'  => $user->id,
        ]);

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

    public function showInClass(Classes $class, Students $student)
    {
        return view('students.show-in-class', compact('class', 'student'));
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
            'name' => [
                'required',
                'string',
                'max:255',
                "regex:/^[\pL\s\-\'\.,]+$/u",
            ],
            'email' => [
                'required',
                'email',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                Rule::unique('users', 'email')->ignore($student->user_id),
            ],
            'nisn' => [
                'required',
                'string',
                'regex:/^\d+$/',
                Rule::unique('students', 'nisn')->ignore($student->id),
            ],
            'classId' => 'required|exists:classes,id',
        ], [
            'name.max' => 'Nama siswa tidak boleh lebih dari 255 karakter.',
            'name.regex' => 'Nama siswa mengandung karakter yang tidak diperbolehkan.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Format email tidak valid.',
            'nisn.regex' => 'NISN hanya boleh berupa angka.',
            'nisn.unique' => 'NISN ini sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $student->id);
        }

        $validated = $validator->validated();

        $student->update([
            'name'     => $validated['name'],
            'nisn'     => $validated['nisn'],
            'classId'  => $validated['classId'],
        ]);

        if ($student->user) {
            $student->user->update([
                'email' => $validated['email'],
            ]);
        }

        return redirect()->back()
            ->with('edit_success', true)
            ->with('edited_id', $student->id)
            ->with('message', 'Siswa berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Students $student)
    {
        if ($student->user) {
            $student->user->delete();
        }
        $student->delete();
        return redirect()->back()->with('delete', 'Siswa berhasil dihapus.');
    }
}
