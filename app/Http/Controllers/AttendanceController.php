<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Master\Karyawan;
use App\Models\Attendance;
use Illuminate\Http\Request;
use DataTables;

class AttendanceController extends Controller
{
    function __construct()
    {
        $this->view = 'pages.attendance.';
    }

    function index()
    {
        $karyawan = Karyawan::get();
        try {
            $data = [
                "heading" => "Absensi Karyawan",
                "title" => "Absensi Karyawan",
                "karyawan" => $karyawan,
            ];
            return view($this->view . 'index', $data);
        } catch (\Throwable $err) {
            return redirect()->back()->with("error", $err->getMessage());
        }
    }

    function indexJson()
    {
        try {
            $model = Attendance::join('master_karyawan','attendance.employee_code', '=', 'master_karyawan.employee_code')
            ->select('attendance.*','master_karyawan.*')
            ->get();
            $data = DataTables::of($model)
                ->addIndexColumn()
                ->make(true);
            return $data;
        } catch (\Throwable $err) {
            return response()->json([
                "code" => 5500,
                "message" => $err->getMessage()
            ]);
        }
    }

    function createJson(Request $request)
    {
        try {
            $employee_code = $request->input('employee_code');

            $time_in = $request->input('time_in');
            $time_in = strtotime($time_in);

            $time_out = $request->input('time_out');
            $time_out = strtotime($time_out);

            $date = $request->input('date');
            $date =  date('Y-m-d', strtotime($request->date));

            Attendance::create(
                ['employee_code' => $employee_code,
                'time_in' => $time_in,
                'time_out' => $time_out,
                'date' => $date]
            );

            return response()->json([
                "code" => 2200,
                "message" => "Berhasil Tambah Data"
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "code" => 5500,
                "message" => $err->getMessage()
            ]);
        }
    }
}
