<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class contentController extends Controller
{
    public function index(){
        $content = [
            "content" => "Защищённая страница"
        ];
        return response()->json($content, 200);

    }
}
