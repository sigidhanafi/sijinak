<?php

namespace App\Http\Controllers;

use App\Models\Adminlogs;
use Illuminate\Http\Request;

class AdminlogsController extends Controller
{
    // Display all logs
    public function index()
    {
        $logs = Adminlogs::with('user')->get();
        return view('adminlogs.index', compact('logs'));
    }

    // Insert new log
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity_type' => 'required|string'
        ]);

        Adminlogs::create($request->all());

        return redirect('/adminlogs')->with('success', 'Log added successfully!');
    }

    public function search(Request $request)
{
    $search = $request->input('search');

    // Fetch filtered logs
    $logs = Adminlogs::with('user')
        ->where('activity_type', 'LIKE', "%{$search}%")
        ->orwhere('created_at', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        })
        ->get();

    // Return the results as HTML (Blade partial)
    return view('adminlogs.partials.searchres', compact('logs'))->render();
}

}
