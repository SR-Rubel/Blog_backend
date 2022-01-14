<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        $credentials=$request->only(['email','password']);
        if(!auth()->attempt($credentials)){
            return $this->customResponse(['status'=>0,'msg'=>'invalid crediantials'],401);
        }
        $token=auth()->user()->createToken("access_token")->plainTextToken;
        return $this->customResponse(['status'=>1,'msg'=>'logged in!','token'=>$token]);
    }

    public function logout(){
        auth()->user()->currentAccessToken()->delete();
        // return response()->json(['msg'=>'logged out!!'],200);
        return $this->customResponse(['msg'=>'logged out!!']);
    }
}
