<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Parents::with(['students' => function ($q) {
            $q->orderBy('nisn');
        }]);

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
            'student_name' => 'required|string',
            'email'        => 'required|email',
        ], [
            'email.email' => 'Format email tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'create');
        }

        $validated = $validator->validated();
        $studentNames = array_filter(array_map('trim', explode(',', $validated['student_name'])));

        if (empty($studentNames)) {
            return redirect()->back()
                ->withErrors(['student_name' => 'Nama siswa tidak boleh kosong.'])
                ->withInput()
                ->with('error_source', 'create');
        }

        $errors = [];
        $studentsToAssociate = [];

        foreach ($studentNames as $name) {
            $student = Students::where('name', $name)->first();

            if (!$student) {
                $errors[] = "Siswa '$name' tidak ditemukan.";
                continue;
            }

            if ($student->parent) {
                $errors[] = "Siswa '$name' sudah memiliki wali.";
                continue;
            }

            $studentsToAssociate[] = $student;
        }

        if (!empty($errors)) {
            return redirect()->back()
                ->withErrors(['student_name' => implode(' ', $errors)])
                ->withInput()
                ->with('error_source', 'create');
        }

        DB::beginTransaction();

        try {
            $user = User::where('email', $validated['email'])->first();

            if ($user) {
                $parent = Parents::where('user_id', $user->id)->first();

                if (!$parent) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withErrors(['email' => 'Email ini sudah terdaftar.'])
                        ->withInput()
                        ->with('error_source', 'create');
                }

                if ($parent->name !== $validated['parent_name']) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withErrors(['parent_name' => 'Nama wali tidak sesuai dengan data yang terdaftar.'])
                        ->withInput()
                        ->with('error_source', 'create');
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'email' => 'required|email|unique:users,email',
                ], [
                    'email.unique' => 'Email ini sudah terdaftar.',
                ]);

                if ($validator->fails()) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error_source', 'create');
                }

                $user = User::create([
                    'email'    => $validated['email'],
                    'password' => bcrypt('12345678'),
                    'role'     => 'parent',
                ]);

                $parent = Parents::create([
                    'name'    => $validated['parent_name'],
                    'user_id' => $user->id,
                ]);
            }

            foreach ($studentsToAssociate as $student) {
                $student->parent()->associate($parent);
                $student->save();
            }

            DB::commit();

            return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke wali.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])
                ->withInput()
                ->with('error_source', 'create');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Parents $parent)
    {
        $parent->load(['students' => function ($q) {
            $q->orderBy('nisn');
        }, 'students.classes']);

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
            'student_name' => 'required|string',
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
        $studentNames = array_filter(array_map('trim', explode(',', $validated['student_name'])));

        if (empty($studentNames)) {
            return redirect()->back()
                ->withErrors(['student_name' => 'Nama siswa tidak boleh kosong.'])
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $parent->id);
        }

        if (count($studentNames) !== count(array_unique($studentNames))) {
            return redirect()->back()
                ->withErrors(['student_name' => 'Nama siswa tidak boleh duplikat.'])
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $parent->id);
        }

        $errors = [];
        $validStudents = [];

        foreach ($studentNames as $name) {
            $student = Students::where('name', $name)->first();

            if (!$student) {
                $errors[] = "Siswa '$name' tidak ditemukan.";
                continue;
            }

            if ($student->parent && $student->parent->id !== $parent->id) {
                $errors[] = "Siswa '$name' sudah memiliki wali yang terdaftar.";
                continue;
            }

            $validStudents[] = $student;
        }

        if (!empty($errors)) {
            return redirect()->back()
                ->withErrors(['student_name' => implode(' ', $errors)])
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $parent->id);
        }

        $parent->name = $validated['parent_name'];
        $parent->save();

        if ($parent->user) {
            $parent->user->update(['email' => $validated['email']]);
        }

        $oldStudentNames = $parent->students->pluck('name')->toArray();

        foreach ($parent->students as $oldStudent) {
            if (!in_array($oldStudent->name, $studentNames)) {
                $oldStudent->parent()->dissociate();
                $oldStudent->save();
            }
        }

        foreach ($validStudents as $student) {
            if (!in_array($student->name, $oldStudentNames)) {
                $student->parent()->associate($parent);
                $student->save();
            }
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
        if ($parent->user) {
            $parent->user->delete();
        }
        $parent->delete();
        return redirect()->back()->with('delete', 'Wali siswa berhasil dihapus.');
    }
}
