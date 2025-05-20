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
    private $isAdmin = true;

    /**
     * Display a listing of the resource.
     * TO DO: Hafiz (tapi udah keburu kelar)
     */
    public function index()
    {
        //
        if ($this->isAdmin) {
            $activities = Activity::all();

            return view(
                'activity-log.admin.index',
                compact('activities')
            );
        }

        return view('activity-log.user.index');
    }

    /**
     * Show the form for creating a new resource.
     * TO DO: Devin
     */
    public function create()
    {
        //show the form to
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
    }

    /**
     * Show the form for editing the specified resource.
     * TO DO: Devin
     */
    public function edit(Activity $activity): View
    {
        //show the form to edit activity
        //get all activities
        $activities = Activity::all();
        //render view with activities
        return view('activity-log.admin.edit', compact('activities', 'activity'));
    }

    /**
     * Update the specified resource in storage.
     * TO DO: Amel
     */
    public function update(Request $request, Activity $activity): RedirectResponse
    {
        // validate
        $validated = $request->validate([
            'student_id' => 'required|integer',
            'activity_id' => 'required|string',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:20480'
        ]);
        //check if file is uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            //add origin file name on local storage
            $originalName = $file->getClientOriginalName();
            //clear the name of file so it won't be duplicated
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $safeName = \Illuminate\Support\Str::slug($filename)
                . '_' . time()
                . '.' . $extension;
            //delete old file
            Storage::delete('public/activities/' . $activity->file);
            //upload new file
            $file = $request->file('file');
            $file->storeAs('public/activities', $safeName);
            //update activity with new file
            $activity->update([
                'student_id' => $validated['student_id'],
                'activity_id' => $validated['activity_id'],
                'file' => $safeName,
            ]);
        } else {
            //update activity without new file
            $activity->update([
                'student_id' => $validated['student_id'],
                'activity_id' => $validated['activity_id'],
            ]);
        }
        Alert::success('Success', 'Data successfully updated!');
        return redirect()->route('activities.index')->with(['success', 'Data Berhasil Diubah!']);
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
