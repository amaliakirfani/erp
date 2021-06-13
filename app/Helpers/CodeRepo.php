<?php


namespace App\Helpers;

use App\Models\Master\Divisi;

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
            $code = explode("MDIV", $code->kode_barang);

            $code = (int)($code[1]+1);
            $code = 'MDIV'.sprintf('%05d', $code);
            return $code;
        }
    }
}
