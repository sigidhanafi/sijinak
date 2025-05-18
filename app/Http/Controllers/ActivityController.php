<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityCollection;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;

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

        return redirect('/activities');
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
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * TO DO: Amel
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * TO DO: Ilham
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
