<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mainPageController extends Controller
{
    public function index(){
        $content = [
            "content" => "Главная страница"
            ];
        return response()->json($content, 200);

    }
}
