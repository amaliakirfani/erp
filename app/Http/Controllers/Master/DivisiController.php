<?php

namespace App\Http\Controllers\Master;

use App\Helpers\CodeRepo;
use App\Http\Controllers\Controller;
use App\Models\Master\Divisi;
use Illuminate\Http\Request;
use DataTables;

class DivisiController extends Controller
{
    function __construct()
    {
        $this->view = 'pages.master.divisi.';
    }

    function index()
    {
        try {
            $data = [
                "heading" => "Master Divisi",
                "title" => "Master Divisi",
            ];
            return view($this->view . 'index', $data);
        } catch (\Throwable $err) {
            return redirect()->back()->with("error", $err->getMessage());
        }
    }

    function indexJson()
    {
        try {
            $model = Divisi::get();
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
            $data = $request->except(["_token"]);
            $code = CodeRepo::masterDivisiCode();
            $data['kode_divisi'] = $code;
            Divisi::create($data);

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
            $data = Divisi::where("id", $id)->first();
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

            Divisi::where("id", $request->id)->update($data);

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
            Divisi::where("id", $id)->delete();

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
