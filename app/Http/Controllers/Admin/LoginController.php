<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        # code...
        $request->validate([
            'email'=>['required','email'],
            'password'=>['required']
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user||!Hash::check($request->password,$user->password)){
            $message = [
                'msg'=>'用户名或密码不正确',
                'result'=>false
            ];
            return response($message);
        }
        $token = $user->createToken('Auth Token')->accessToken;
        $message = [
            'user'=>$user,
            'result'=>true,
            'token'=>$token
        ];
        return response($message);
    }

    public function logout(){
        Auth::logout();
    }
}
