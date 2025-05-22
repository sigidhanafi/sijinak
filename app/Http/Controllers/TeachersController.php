<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Teachers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Teachers::with('class');

        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($request->filled('filter')) {
            if ($request->filter === 'wali') {
                $query->whereHas('class');
            } elseif ($request->filter === 'duty') {
                $query->where('is_on_duty', true);
            }
        }

        $perPage = $request->input('paginate', 10);
        if (!in_array($perPage, [10, 50, 100, 500])) {
            $perPage = 10;
        }

        $teachers = $query->orderBy('nip')->paginate($perPage);

        $classes = Classes::orderBy('className')->get();

        return view('teachers.index', compact('teachers', 'classes'));
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
                "regex:/^[\pL\s\-\'\.]+$/u",
            ],
            'nip' => [
                'required',
                'string',
                'regex:/^\d+$/',
                'unique:teachers,nip',
            ],
            'is_on_duty' => 'nullable|boolean',
        ], [
            'name.regex' => 'Nama guru mengandung karakter yang tidak diperbolehkan.',
            'nip.regex' => 'NIP hanya boleh berupa angka.',
            'nip.unique' => 'NIP ini sudah terdaftar.',
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
            'role'     => 'teacher',
        ]);

        Teachers::create([
            'user_id'    => $user->id,
            'name'       => $validated['name'],
            'nip'        => $validated['nip'],
            'is_on_duty' => $validated['is_on_duty'] ?? false,
        ]);

        return redirect()->back()->with('success', 'Guru berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Teachers $teacher)
    {
        $teacher->load('class');
        return view('teachers.show', compact('teacher'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teachers $teachers)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teachers $teacher)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                "regex:/^[\pL\s\-\'\.]+$/u",
            ],
            'email' => [
                'required',
                'email',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                Rule::unique('users', 'email')->ignore($teacher->user_id),
            ],
            'nip' => [
                'required',
                'string',
                'regex:/^\d+$/',
                Rule::unique('teachers', 'nip')->ignore($teacher->id),
            ],
            'is_on_duty' => 'nullable|boolean',
        ], [
            'name.regex' => 'Nama guru mengandung karakter yang tidak diperbolehkan.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Format email tidak valid.',
            'nip.regex' => 'NIP hanya boleh berupa angka.',
            'nip.unique' => 'NIP ini sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $teacher->id);
        }

        $validated = $validator->validated();

        if ($teacher->class && ($validated['is_on_duty'] ?? false) == true) {
            return redirect()->back()
                ->withErrors(['is_on_duty' => 'Status guru sudah menjadi wali kelas.'])
                ->withInput()
                ->with('error_source', 'update')
                ->with('edited_id', $teacher->id);
        }

        $teacher->update([
            'name' => $validated['name'],
            'nip' => $validated['nip'],
            'is_on_duty' => $validated['is_on_duty'] ?? false,
        ]);

        if ($teacher->user) {
            $teacher->user->update([
                'email' => $validated['email'],
            ]);
        }

        return redirect()->back()
            ->with('edit_success', true)
            ->with('edited_id', $teacher->id)
            ->with('message', 'Guru berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teachers $teacher)
    {
        if ($teacher->user) {
            $teacher->user->delete();
        }
        $teacher->delete();
        return redirect()->back()->with('delete', 'Guru berhasil dihapus.');
    }
}
