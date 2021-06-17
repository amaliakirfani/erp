<?php


namespace App\Helpers;

use App\Models\Master\Divisi;
use App\Models\Master\Jabatan;
use App\Models\Master\Karyawan;

class CodeRepo
{
    public static function masterDivisiCode()
    {
        $code = new Divisi;
        $code = $code->orderBy('id','DESC');

        if($code->count() == 0){
            $code = $code->count();
            $code = $code + 1;
            $code = 'MDIV'.sprintf('%05d', $code);
            return $code;
        }
        else{
            $code = $code->get()[0];
            $code = explode("MDIV", $code->kode_divisi);

            $code = (int)($code[1]+1);
            $code = 'MDIV'.sprintf('%05d', $code);
            return $code;
        }
    }

    public static function masterJabatanCode()
    {
        $code = new Jabatan;
        $code = $code->orderBy('id','DESC');

        if($code->count() == 0){
            $code = $code->count();
            $code = $code + 1;
            $code = 'MJBT'.sprintf('%05d', $code);
            return $code;
        }
        else{
            $code = $code->get()[0];
            $code = explode("MJBT", $code->kode_jabatan);

            $code = (int)($code[1]+1);
            $code = 'MJBT'.sprintf('%05d', $code);
            return $code;
        }
    }

    public static function masterKaryawanCode()
    {
        $code = new Karyawan;
        $code = $code->orderBy('id','DESC');

        if($code->count() == 0){
            $code = $code->count();
            $code = $code + 1;
            $code = 'MKRY'.sprintf('%05d', $code);
            return $code;
        }
        else{
            $code = $code->get()[0];
            $code = explode("MKRY", $code->employee_code);

            $code = (int)($code[1]+1);
            $code = 'MKRY'.sprintf('%05d', $code);
            return $code;
        }
    }
}
