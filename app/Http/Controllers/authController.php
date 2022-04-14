<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $user->password = Hash::make($request->all()['password']);
        $user->save();

        $token = $user->createToken('auth_token');
        
        return response()->json(["access_token"=>$token,
                                "token_type" => "Bearer"
                                ]);
    }

    public function loginUser(Request $request){

        $hash_password = Hash::make($request->all()['password']);
        $email = $request->all()["email"];

        $all_data = [
            "email" => $email,
            "password" => $hash_password
        ];

        // dd($request->only('email', 'password'));

        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'message' => 'Неверный логин или пароль'
            ], 401);
        }

        $user = User::where('email', $request->all()["email"])->first();
        
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function me(Request $request){
        return $request->user();
    }
}
