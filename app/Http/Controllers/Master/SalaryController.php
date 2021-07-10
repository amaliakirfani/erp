<?php

namespace App\Http\Controllers\Master;

use App\Helpers\CodeRepo;
use App\Http\Controllers\Controller;
use App\Models\Master\Salary;
use App\Models\Master\Jabatan;
use App\Models\Master\Divisi;
use Illuminate\Http\Request;
use DataTables;

class SalaryController extends Controller
{
    function __construct()
    {
        $this->view = 'pages.master.salary.';
    }

    function index()
    {
        $jabatan = Jabatan::get();
        $divisi = Divisi::get();
        try {
            $data = [
                "heading" => "Master Gaji",
                "title" => "Master Gaji",
                "jabatan" => $jabatan,
                "divisi" => $divisi,
            ];
            return view($this->view . 'index', $data);
        } catch (\Throwable $err) {
            return redirect()->back()->with("error", $err->getMessage());
        }
    }

    function indexJson()
    {
        try {
            $model = Salary::join('master_jabatan','master_salary.position_id', '=', 'master_jabatan.id')
            ->join('master_divisi','master_salary.division_id', '=', 'master_divisi.id')
            ->select('master_salary.*','master_jabatan.name as jabatan_name', 'master_divisi.name as divisi_name')
            ->get();
            $data = DataTables::of($model)
                ->addIndexColumn()
                ->editColumn('jumlah', function($row) {
                    return 'Rp '.number_format($row->sallary_per_hour);
                })
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
            $salary_per_hour = $request->input('sallary_per_hour');
            $salary_overtime = $request->input('sallary_overtime');
            $allowance = $request->input('allowance');
            $division_id = $request->input('division_id');
            $position_id = $request->input('position_id');

            $cek = Salary::where('division_id',$division_id)
                ->where('position_id',$position_id)
                ->first();

            if (!empty($cek)){
                return response()->json([
                        'code' => '4400',
                        'message' => "Divisi dan Jabatan Sudah Ada!"
                    ]);
            }

            Salary::create(
                ['sallary_per_hour' => $salary_per_hour,
                'sallary_overtime' => $salary_overtime,
                'allowance' => $allowance,
                'division_id' => $division_id,
                'position_id' => $position_id]
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

    function editJson($id)
    {
        try {
            $data = Salary::where("id", $id)->first();
            return response()->json([
                "code" => 2200,
                "message" => 'success',
                'data' => $data
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "code" => 5500,
                "message" => $err->getMessage()
            ]);
        }
    }

    function updateJson(Request $request)
    {
        try {
            $data = $request->except(["_token", "id"]);

            Salary::where("id", $request->id)->update($data);

            return response()->json([
                "code" => 2200,
                "message" => "Berhasil Update Data"
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "code" => 5500,
                "message" => $err->getMessage()
            ]);
        }
    }

    function deleteJson($id)
    {
        try {
            Salary::where("id", $id)->delete();

            return response()->json([
                "code" => 2200,
                "message" => "Berhasil Delete Data"
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "code" => 5500,
                "message" => $err->getMessage()
            ]);
        }
    }
}
