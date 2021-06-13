<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->view = "pages.home.";
    }

    function index()
    {
        try {
            $data = [
                'heading' => "Home",
                "title" => "Home"
            ];
            return view($this->view . "index", $data);
        } catch (\Throwable $err) {
            return redirect()->back()->with("error", $err->getMessage());
        }
    }
}
