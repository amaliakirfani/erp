<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Karyawan;
use App\Models\Master\Salary;
use App\Models\Attendance;
use DataTables;

class SalariesController extends Controller
{
    function __construct()
    {
        $this->view = 'pages.salaries.';
    }

    function index()
    {
        $karyawan = Karyawan::get();
        $attendance = Attendance::get();
        try {
            $data = [
                "heading" => "Penggajian Karyawan",
                "title" => "Penggajian Karyawan",
                "karyawan" => $karyawan,
                "attendance" => $attendance,
            ];
            return view($this->view . 'index', $data);
        } catch (\Throwable $err) {
            return redirect()->back()->with("error", $err->getMessage());
        }
    }

    function indexJson()
    {
        try {
            $month = $request->month;
            $year = $request->year;
            $model = Attendance::join('master_karyawan','attendance.employee_code', '=', 'master_karyawan.employee_code')
            ->join('master_salary','attendance.employee_code', '=', 'master_salary.employee_code')
            ->select('attendance.*','master_karyawan.employee_code', sum('master_salary.sallary_per_hour as total_gaji'))
            ->whereMonth('date', '=', $month)
            ->whereYear('date', '=', $year)
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
            $employee_name = $request->input('employee_name');
            $month = $request->input('month');
            $year = $request->input('year');
            $amount = $request->input('amount');

            Salary::create(
                ['employee_code' => $employee_code,
                'employee_name' => $employee_name,
                'month' => $month,
                'year' => $year,
                'amount' => $amount]
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
