<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Students;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Classes::with(['students', 'teacher']);

        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('className', 'like', "%{$search}%")
                    ->orWhereHas('teacher', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
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
        // 
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'className' => 'required|string|max:255|unique:classes,className',
            'teacherName' => 'nullable|string|max:255',
        ], [
            'className.unique' => 'Nama kelas ini sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'create');
        }

        $validated = $validator->validated();

        $teacherId = null;

        if (!empty($validated['teacherName'])) {
            $teacher = Teachers::where('name', $validated['teacherName'])->first();

            if (!$teacher) {
                return redirect()->back()
                    ->withErrors(['teacherName' => 'Guru dengan nama tersebut tidak ditemukan.'])
                    ->withInput()
                    ->with('error_source', 'create');
            }

            if ($teacher->is_on_duty) {
                return redirect()->back()
                    ->withErrors(['teacherName' => 'Guru piket tidak bisa menjadi wali kelas.'])
                    ->withInput()
                    ->with('error_source', 'create');
            }

            if ($teacher->class) {
                return redirect()->back()
                    ->withErrors(['teacherName' => 'Guru ini sudah menjadi wali kelas.'])
                    ->withInput()
                    ->with('error_source', 'create');
            }

            $teacherId = $teacher->id;
        }

        Classes::create([
            'className' => $validated['className'],
            'teacherId' => $teacherId,
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan.');
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

        $classes = Classes::orderBy('className')->get();

        return view('classes.show', compact('class', 'classes', 'students', 'search'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classes $class)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classes $class)
    {
        $validator = Validator::make($request->all(), [
            'className' => [
                'required',
                'string',
                'max:255',
                Rule::unique('classes', 'className')->ignore($class->id),
            ],
            'teacherName' => 'nullable|string|max:255',
        ], [
            'className.unique' => 'Nama kelas ini sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $class->id);
        }

        $validated = $validator->validated();

        $teacherId = null;

        if (!empty($validated['teacherName'])) {
            $teacher = Teachers::where('name', $validated['teacherName'])->first();

            if (!$teacher) {
                return redirect()->back()
                    ->withErrors(['teacherName' => 'Guru dengan nama tersebut tidak ditemukan.'])
                    ->withInput()
                    ->with('error_source', 'update')
                    ->with('edited_id', $class->id);
            }

            if ($teacher->is_on_duty) {
                return redirect()->back()
                    ->withErrors(['teacherName' => 'Guru piket tidak bisa menjadi wali kelas.'])
                    ->withInput()
                    ->with('error_source', 'update')
                    ->with('edited_id', $class->id);
            }

            if ($teacher->class && $teacher->class->id !== $class->id) {
                return redirect()->back()
                    ->withErrors(['teacherName' => 'Guru ini sudah menjadi wali kelas lain.'])
                    ->withInput()
                    ->with('error_source', 'update')
                    ->with('edited_id', $class->id);
            }

            $teacherId = $teacher->id;
        }

        $class->update([
            'className' => $validated['className'],
            'teacherId' => $teacherId,
        ]);

        return redirect()->back()
            ->with('edit_success', true)
            ->with('edited_id', $class->id)
            ->with('message', 'Kelas berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->students()->update(['classId' => null]);
        $class->delete();

        return redirect()->back()->with('delete', 'Kelas berhasil dihapus.');
    }
}
