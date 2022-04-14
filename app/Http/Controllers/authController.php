<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class authController extends Controller
{
    public function registerUser(Request $request){
        
        $rules = [
            'name' => 'required|string|max:255',      
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];

        $messages =[
            'required' => "данное поле обязательно",
            'max' => "данное поле слишком длинное",
            'min' => "данное поле слишком короткое",
            'unique' => "данное поле не уникально"
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json($validator->errors(), 200);
        }

        $user = new User();
        $user->name = $request->all()['name'];
        $user->email = $request->all()['email'];
        $user->password = $request->all()['password'];
        $user->save();

        $token = $user->createToken('auth_token');  

        dd($token);

        return response()->json(["access_token"=>$token,
                                "token_type" => "Bearer"
                                ]);
    }
}
