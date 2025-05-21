<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activities;
use App\Models\Users;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ActivityQrCache;
use Illuminate\Http\JsonResponse;

class ActivitiesController extends Controller
{
    // Show the Blade view (if you have one)
    public function index(): View
    {
        return view('activities/generate-qr'); // You might need to create this view
    }

    /**
     * Generate a new QR code for an activity.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(Request $request): JsonResponse
    {
        // Get the currently logged-in user's ID.  If no user is logged in,
        // use the default teacher for testing purposes.
        $teacherId = Auth::id();
        if (!$teacherId) {
            $teacher = Users::where('username', 'teacherTest')->first();
            if (!$teacher) {
                return response()->json(['error' => 'Default teacher user not found.  Please log in, or create the default teacher.'], 500);
            }
            $teacherId = $teacher->id;
        }

        // Get the activity name from the request, or use a default.
        $activityName = $request->input('activityName', 'attendance @' . now()->format('H:i'));

        // Create the activity in the database.
        $activity = Activities::create([
            'activityName' => $activityName,
            'qrCode' => (string) Str::uuid(), // Generate a unique QR code value
            'createdBy' => $teacherId,
        ]);

        // Return a JSON response with the generated QR code and activity ID.
        return response()->json([
            'success' => true,
            'activityId' => $activity->id,
            'qrCode' => $activity->qrCode, // Include the QR code value in the response
        ]);
    }

    /**
     * Display the QR code SVG for a given activity ID.
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showQrSvg(int $id): Response
    {
        $cache = \App\Models\ActivityQrCache::where('activity_id', $id)->first();

        if (!$cache) {
            return response('QR code cache not found', 404);
        }

        $svg = QrCode::format('svg')
            ->size(300)
            ->generate($cache->qr_code);

        return response($svg, Response::HTTP_OK)
            ->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Get the QR code data (JSON) for a given activity ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQrData(int $id): JsonResponse
    {
        $activity = Activities::find($id);

        if (!$activity) {
            return response()->json(['error' => 'Activity not found'], 404);
        }

        return response()->json([
            'activityId' => $activity->id,
            'activityName' => $activity->activityName,
            'qrCode' => $activity->qrCode,
            //'createdBy' => $activity->createdBy, //  Don't expose user ID unless needed.
        ]);
    }
    public function refreshQrCode(int $activityId): JsonResponse
    {
        $activity = Activities::find($activityId);

        if (!$activity) {
            return response()->json(['error' => 'Activity not found'], 404);
        }

        $newQr = (string) Str::uuid();

        $cache = ActivityQrCache::create([
            'activity_id' => $activityId,
            'qr_code' => $newQr,
        ]);

        return response()->json([
            'success' => true,
            'activityId' => $activityId,
            'qrCode' => $newQr,
            'cacheId' => $cache->id,
        ]);
    }
}
