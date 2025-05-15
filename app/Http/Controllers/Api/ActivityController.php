<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\ActivityCollection;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // return Activity::all();
        // return Activity::paginate(10);
        // return Activity::simplePaginate(10);
        // return Activity::cursorPaginate(10);
        // return Activity::latest()->paginate(10);
        // return Activity::latest()->simplePaginate(10);
        // return Activity::latest()->cursorPaginate(10);
        //
        $length = $request->input('length', 10);
        return new ActivityCollection(Activity::paginate($length));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        //
        return new ActivityResource($activity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
