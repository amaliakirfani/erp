<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('frontend.frontend');
    }

    public function checkId()
    {

        $check_rfid = DB::table('log_attendance as l')
            ->leftjoin("master_karyawan as mk","mk.rfid","l.rfid")
            ->leftJoin("master_divisi as ma",'ma.id','mk.division_id')
            ->leftJoin("master_jabatan as mj","mj.id","mk.position_id")
            ->select('*','l.id as id','mj.name as jabatan','ma.name as divisi')
            ->orderBy('l.id', 'DESC')
            ->first();
//        dd($check_rfid);

        $getCache = Cache::get('log_attendance');
        $id=$getCache->id ?? null;
        $rfidId=$check_rfid->id ?? null;
//        dd($id);
        if ($id == $rfidId) {
            return response()->json([
                "code" => 400,
                "message" => 'not yet ready'
            ]);
        }

        if ($check_rfid->status == 1) {
            $message = 'Kamu Berhasil Absen Masuk';
        } elseif ($check_rfid->status == 2) {
            $message = "Kamu Berhasil Absen Keluar";
        } elseif ($check_rfid->status == 3) {
            $message = "Hmm...Kamu Sudah Absen Loh";
        } elseif ($check_rfid->status == 0) {
            $message = "ID Kamu Tidak Terdaftar";
        }

        Cache::put('log_attendance', $check_rfid);
        return response()->json([
            "code" => 200,
            "message" => $message,
            "status" =>$check_rfid->status,
            "data" => $check_rfid,
        ]);
    }
}
