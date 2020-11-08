<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required','email'],
            'password' => ['required','min:8'],
        ]);
        $res = DB::table('users')->where('email',$request->email)->first();
        if($res===null){
            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);
            $message=[
                'result'=>true,
                'msg'=>'用户创建成功'
            ];
            return response($message);
        }else{
            $message = [
                'result'=>false,
                'msg'=>'用户已存在'
            ];
            return response($message);
        }
    }
}
