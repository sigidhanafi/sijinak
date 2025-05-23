<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\ActivityQrCache;
use App\Models\Student_activities;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Students;
use App\Models\User;

class ScanQRController extends Controller
{
    public function index(): View
    {
        return view('activities/scan-qr');
    }

    public function scan(Request $request): JsonResponse
    {

        \Log::info('Scan method called');
        $request->validate([
            'qrCode' => 'required|string',
        ]);
        // Log the received QR code for debugging
        \Log::info("Scanned QR Code: " . $request->qrCode);

        // Get the logged-in user
        $user = Auth::user();
        $student = null;

        // Try to get student from logged-in user
        if ($user && $user->student) {
            $student = $user->student;
        }

        // Fallback to studentTest user if not logged in or no student
        if (!$student) {
            $fallbackUser = User::where('username', 'studentTest')->first();
            if (!$fallbackUser || !$fallbackUser->student) {
                return response()->json(['error' => 'Default student user not found. Please log in or create the default test student.'], 500);
            }
            $student = $fallbackUser->student;
        }

        // Find the matching QR code
        $qr = ActivityQrCache::where('qr_code', $request->qrCode)
            ->latest('updated_at') // Just in case multiple same QR codes exist
            ->first();

        if (!$qr) {
            return response()->json(['error' => 'QR code is invalid'], 404);
        }

        // Prevent duplicate scan
        $alreadyScanned = Student_activities::where([
            'studentId' => $student->id,
            'activityId' => $qr->activity_id,
        ])->exists();

        if ($alreadyScanned) {
            return response()->json(['error' => 'Already scanned'], 409);
        }

        // Log student attendance
        Student_activities::create([
            'studentId' => $student->id,
            'activityId' => $qr->activity_id,
        ]);

        return response()->json(['success' => true]);
    }
}
