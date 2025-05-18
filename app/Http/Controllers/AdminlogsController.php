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

// TODO finish filter using start and end date
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
// validasi input tanggal TODO: query 
    public function filter(Request $request){

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $logs = Adminlogs::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return view('adminlogs.partials.filter_date', compact('filtered'))->render();
    }

    public function filter_dummy(Request $request){
    $validated = $request->validate([
        'start_date' => [
            'required', 
            'date',
            'before_or_equal:end_date',
            'before_or_equal:today'
        ],
        'end_date' => [
            'required', 
            'date',
            'after_or_equal:start_date',
            'after_or_equal:today'
        ],
    ],[
        'start_date.required' => 'Tanggal mulai wajib diisi',
        'start_date.date'=> 'Format tanggal mulai tidak valid',
        'start_date.before_or_equal'=> 'Tanggal mulai harus sebelum atau sama dengan tanggal akhir',
        'end_date.required'=> 'Tanggal akhir wajib diisi',
        'end_date.date'=> 'format tanggal akhir tidak valid',
        'end_date.after_or_equal'=> 'tanggal akhir harus setelah atau sama dengan tanggal mulai'
    ]);

    $startDate = $validated['start_date'];
    $endDate = $validated['end_date'];

    try {
        // Parsing tanggal pakai DateTime native
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        // Hitung selisih hari
        $diff = $start->diff($end)->days;
        if ($diff > 365) {
            return response()->json([
                'error' => 'Date range cannot exceed 1 year'
            ], 422);
        }

        // Set waktu start dan end untuk filter full day
        $start->setTime(0, 0, 0);
        $end->setTime(23, 59, 59);

        // Query dengan whereBetween
        $logs = Adminlogs::with('user')
            ->whereBetween('created_at', [$start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s')])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($logs->isEmpty()) {
            return response()->json([
                'message' => 'No data found for selected date range'
            ]);
        }

        return view('adminlogs.partials.filter_date', compact('logs'))->render();


        //TODO ganti ini pake menu toast biar makin rapi sama gapake halaman lagi 
    } catch (\Exception $e) {
        \Log::error('Filter logs error: ' . $e->getMessage());

        return response()->json([
            'error' => 'Terjadi kesalahan saat memfilter data'
        ], 500);
    }
}

}
