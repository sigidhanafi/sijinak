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
        $activityMap = [
        '1' => 'Log In',
        '2' => 'Create QR', 
        '3' => 'Reject Student Request',
        '4' => 'Accept Student Request',
        'none' => null,
        ];
        $search = $request->input('search');
    $aksiinput = $request->input('aksifilter');
    $aksifilter = isset($activityMap[$aksiinput]) ? $activityMap[$aksiinput] : null;

    $query = Adminlogs::query();
    
    // Jika ada aksi filter, filter berdasarkan activity_type yang spesifik
    if (!empty($aksifilter)) {
        $query->where('activity_type', $aksifilter);
    }
    
    // Jika ada search term, tambahkan filter untuk kolom lain (kecuali activity_type jika aksifilter sudah diterapkan)
    if (!empty($search)) {
        $query->where(function($q) use ($search, $aksifilter) {
            // Jika tidak ada aksifilter, cari juga di activity_type
            if (empty($aksifilter)) {
                $q->where('activity_type', 'LIKE', '%' . str_replace(['%', '_'], ['\%', '\_'], $search) . '%');
                $q->orWhere('created_at', 'LIKE', '%' . str_replace(['%', '_'], ['\%', '\_'], $search) . '%');
                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'LIKE', '%' . str_replace(['%', '_'], ['\%', '\_'], $search) . '%');
                });
            } else {
                // Jika ada aksifilter, cari hanya di created_at dan user.name
                $q->where('created_at', 'LIKE', '%' . str_replace(['%', '_'], ['\%', '\_'], $search) . '%');
                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'LIKE', '%' . str_replace(['%', '_'], ['\%', '\_'], $search) . '%');
                });
            }
        });
    }
        // if (!empty($aksifilter)) {
        // $query->where('activity_type', $aksifilter);
        // }
        $logs = $query->with('user')->paginate(20);

        if ($request->ajax()) {
            return $logs->count() > 0 
                ? view('adminlogs.partials.searchres', compact('logs'))->render()
                : view('adminlogs.partials.empty_state', compact('search', 'logs'))->render();
        }

        return view('adminlogs.index', compact('logs', 'search'));
    }
}
