<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index() {
        return view('frontend.frontend');
    }

    public function checkId() {

        $check_rfid = DB::table('log_attendance')
            ->select('*')
            ->orderBy('created_at', 'DESC')
            ->first();

            return response()->json([
                "code" => 200,
                "data" => $check_rfid,
            ]);
    }
}
