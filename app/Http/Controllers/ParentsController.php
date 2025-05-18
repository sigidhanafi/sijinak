<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Students;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Parents::with('students');

        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('students', function ($studentQuery) use ($search) {
                        $studentQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $perPage = $request->input('paginate', 10);
        if (!in_array($perPage, [10, 50, 100, 500])) {
            $perPage = 10;
        }

        $parents = $query->orderBy('name')->paginate($perPage);

        return view('parents.index', compact('parents'));
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
            'parent_name'  => 'required|string|max:255',
            'student_name' => 'required|string|max:255',
        ], [
            'parent_name.required'  => 'Nama orang tua harus diisi.',
            'student_name.required' => 'Nama siswa harus diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'create');
        }

        $student = Students::whereRaw('LOWER(name) = ?', [strtolower($validator->validated()['student_name'])])->first();

        if (!$student) {
            return redirect()->back()
                ->withErrors(['student_name' => 'Nama siswa tidak ditemukan.'])
                ->withInput()
                ->with('error_source', 'create');
        }

        if ($student->parent) {
            return redirect()->back()
                ->withErrors(['student_name' => 'Siswa sudah memiliki orang tua yang terdaftar.'])
                ->withInput()
                ->with('error_source', 'create');
        }

        $parent = Parents::create([
            'name' => $validator->validated()['parent_name'],
        ]);

        $student->parent()->associate($parent);
        $student->save();

        return redirect()->back()->with('success', 'Wali siswa berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Parents $parent)
    {
        $parent->load('students.classes');  // only load students
        return view('parents.show', compact('parent'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parents $parents)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parents $parent)
    {
        $validator = Validator::make($request->all(), [
            'parent_name' => 'required|string|max:255',
        ], [
            'parent_name.required' => 'Nama orang tua harus diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $parent->id);
        }

        $parent->name = $validator->validated()['parent_name'];
        $parent->save();

        return redirect()->back()
            ->with('edit_success', true)
            ->with('edited_id', $parent->id)
            ->with('message', 'Data wali siswa berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parents $parent)
    {
        $parent->delete();
        return redirect()->back();
    }
}
