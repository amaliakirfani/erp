<?php

namespace App\Http\Controllers\Master;

use App\Helpers\CodeRepo;
use App\Http\Controllers\Controller;
use App\Models\Master\Karyawan;
use App\Models\Master\Jabatan;
use App\Models\Master\Divisi;
use App\Models\Master\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class KaryawanController extends Controller
{
    function __construct()
    {
        $this->view = 'pages.master.karyawan.';
    }

    function index()
    {
        $jabatan = Jabatan::get();
        $divisi = Divisi::get();
        try {
            $data = [
                "heading" => "Master Karyawan",
                "title" => "Master Karyawan",
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
            $model = Karyawan::join('master_jabatan','master_karyawan.position_id', '=', 'master_jabatan.id')
                    ->join('master_divisi','master_karyawan.division_id', '=', 'master_divisi.id')
                    ->select('master_karyawan.*','master_jabatan.name as jabatan_name', 'master_divisi.name as divisi_name')
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
            $code = CodeRepo::masterKaryawanCode();
            $employee_name = $request->input('employee_name');
            $division_id = $request->input('division_id');
            $position_id = $request->input('position_id');

            $cek_data = Salary::select('*')
            ->where('division_id', '=', $division_id)
            ->where('position_id', '=', $position_id)
            ->first();
            if($cek_data == null ) {
                return response()->json([
                    "code"=>400,
                    'message'=> "master salary tidak tersedia"
                ]);
            }

            Karyawan::create(
                ['employee_code' => $code,
                'employee_name' => $employee_name,
                'division_id' => $division_id,
                'position_id' => $position_id,
                'master_salary_id' => $cek_data->id]
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
            $data = Karyawan::where("id", $id)->first();
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

            Karyawan::where("id", $request->id)->update($data);

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
            Karyawan::where("id", $id)->delete();

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
