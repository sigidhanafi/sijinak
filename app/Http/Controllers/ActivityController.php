<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityCollection;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Notifications\Action;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * This is a flag to determine if the user is an admin or not.
     * In a real application, you would check the user's role or permissions.
     * For this example, we will assume the user is an admin.
     *
     * @var bool
     */
    private $isAdmin = false;

    /**
     * Display a listing of the resource.
     * TO DO: Hafiz (tapi udah keburu kelar)
     */
    public function index()
{
    $activities = Activity::all(); // Ambil data untuk semua user dan admin

    if ($this->isAdmin) {
        return view('activity-log.admin.index', compact('activities'));
    }

    return view('activity-log.user.index', compact('activities')); // <- kirim ke view user juga
}


    /**
     * Show the form for creating a new resource.
     * TO DO: Devin
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     * TO DO: Devin
     */
    public function store(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $validated = $request->validate([
            'studentId' => 'required|integer',
            'activityId' => 'required|integer',
        ]);

        Activity::create([
            'student_id' => $validated['studentId'],
            'activity_id' => $validated['activityId'],
        ]);

        Alert::success('Success', 'Data successfully added!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     * TO DO: Hafiz
     */
    public function show(Activity $activity)
    {
        //
        return view('activity-log.user.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     * TO DO: Devin
     */
    public function edit(Activity $activity)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     * TO DO: Amel
     */
    public function update(Request $request, Activity $activity): RedirectResponse
    {
        // Validate the data
        $validated = $request->validate([
            'studentId' => 'required|integer',
            'activityId' => 'required|integer',
        ]);

        // Update the current activity
        $activity->update([
            'student_id' => $validated['studentId'],
            'activity_id' => $validated['activityId'],
        ]);

        Alert::success('Success', 'Data successfully updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * TO DO: Ilham
     */
    public function destroy($id): RedirectResponse
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        Alert::success('Success', 'Activity successfully deleted!');
        return redirect()->route('activities.index');
    }
}
