<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ScanQRController extends Controller
{
    public function index(): View
    {
        return view('activities/scan-qr');
    }
    
    public function scan(Request $request)
    {
        // Handle the QR code scanning logic here
        // You can use a library like "Simple QrCode" to decode the QR code
        // and process the data as needed.

        return response()->json(['message' => 'QR code scanned successfully!']);
    }
}
