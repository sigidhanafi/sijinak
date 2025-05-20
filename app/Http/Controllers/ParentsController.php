<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'email' => 'required|email|unique:users,email',
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'create');
        }

        $validated = $validator->validated();

        $student = Students::whereRaw('LOWER(name) = ?', [strtolower($validated['student_name'])])->first();

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

        $user = User::create([
            'email'    => $validated['email'],
            'password' => bcrypt('12345678'), // Default password
            'role'     => 'parent',
        ]);

        $parent = Parents::create([
            'name'   => $validated['parent_name'],
            'user_id' => $user->id,
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
            'parent_name'  => 'required|string|max:255',
            'student_name' => 'required|string|max:255',
            'email'        => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($parent->user_id),
            ],
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $parent->id);
        }

        $validated = $validator->validated();

        $student = Students::whereRaw('LOWER(name) = ?', [strtolower($validated['student_name'])])->first();

        if (!$student) {
            return redirect()->back()
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $parent->id)
                ->withErrors(['student_name' => 'Nama siswa tidak ditemukan.']);
        }

        if ($student->parent && $student->parent->id !== $parent->id) {
            return redirect()->back()
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $parent->id)
                ->withErrors(['student_name' => 'Siswa ini sudah memiliki wali yang terdaftar.']);
        }

        $parent->name = $validated['parent_name'];
        $parent->save();

        if ($parent->user) {
            $parent->user->email = $validated['email'];
            $parent->user->save();
        }

        if (!$parent->students->contains($student->id)) {
            foreach ($parent->students as $existingStudent) {
                $existingStudent->parent()->dissociate();
                $existingStudent->save();
            }

            $student->parent()->associate($parent);
            $student->save();
        }

        return redirect()->back()
            ->with('edit_success', true)
            ->with('edited_id', $parent->id)
            ->with('message', 'Wali siswa berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parents $parent)
    {
        $parent->delete();
        return redirect()->back()->with('delete', 'Wali siswa berhasil dihapus.');
    }
}
