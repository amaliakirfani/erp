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

    function indexJson(Request $request )
    {
        try {
            $month = $request->month;
            $year = $request->year;
            // $month=06;
            // $year=2021;

            $model = Attendance::join('master_karyawan','attendance.employee_code', '=', 'master_karyawan.employee_code')
            ->join('master_salary','master_karyawan.master_salary_id', '=', 'master_salary.id')
            ->selectRaw("master_karyawan.employee_code,master_karyawan.employee_name, extract (month from attendance.date) as month,
            TO_CHAR(attendance.date, 'Month') AS month_name,
            extract (year from attendance.date) as year,
            SUM(extract (hour from (case when attendance.time_out >= '17:00:00' then '17:00:00' else attendance.time_out end -attendance.time_in))) as th,
            master_salary.sallary_per_hour,master_salary.sallary_overtime,master_salary.allowance,
            SUM(case when attendance.time_out > '17:00:00' then extract (hour from (attendance.time_out-'17:00:00')) end ) as th_overtime,
            COUNT(extract (month from date)) as t_days")
            ->whereMonth('attendance.date', '=', $month)
            ->whereYear('attendance.date', '=', $year)
            ->groupByRaw("1,2,3,4,5,7,8,9")
            ->get();
            foreach ($model as $v){
                $v->t_salary_per_hour=$v->th*$v->sallary_per_hour;
                $v->t_s_overtime=$v->th_overtime*$v->sallary_overtime;
                $v->t_allowance=$v->allowance*$v->t_days;
                $v->t_salary=$v->t_salary_per_hour+$v->t_s_overtime+$v->t_allowance;
                $v->th=$v->th-$v->t_days;
            }
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
