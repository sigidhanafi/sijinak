<?php

namespace App\Http\Controllers;

use App\Models\Adminlogs;
use Illuminate\Http\Request;

class AdminlogsController extends Controller
{   
    public function index()
    {
        $logs = Adminlogs::with('user')->paginate(20); // 15 items per page
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
        $query = Adminlogs::query();

        if (!empty($search)) {
    $query->where(function($q) use ($search) {
        $q->where('activity_type', 'LIKE', '%' . str_replace(['%', '_'], ['\%', '\_'], $search) . '%')
          ->orWhere('created_at', 'LIKE', '%' . str_replace(['%', '_'], ['\%', '\_'], $search) . '%')
          ->orWhereHas('user', function ($userQuery) use ($search) {
              $userQuery->where('name', 'LIKE', '%' . str_replace(['%', '_'], ['\%', '\_'], $search) . '%');
          });
    });
}

        $logs = $query->paginate(20);

        if ($request->ajax()) {
            return $logs->count() > 0 
                ? view('adminlogs.partials.searchres', compact('logs'))->render()
                : view('adminlogs.partials.empty_state', compact('search', 'logs'))->render();
        }

        return view('adminlogs.index', compact('logs', 'search'));
    }
}
