<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citizen;

class AuthController extends Controller
{
    function login(Request $request){
        $citizen = Citizen::where('username',$request->username)->where('registration_code',$request->registration_code)->first();

        if(!$citizen){
            return response()->json(['message' => "Invalid login"],401);
        }
        else
        {
            $citizen->login_token = md5($citizen->username);
            $citizen->save();
            return $citizen;
        }
    }
    function logout(Request $request){
        $citizen = Citizen::where('login_token',$request->token)->first();
        if(!$citizen){
            return response()->json(['message' => "Invalid token"],401);
        }
        else
        {
            $citizen->login_token = null;
            $citizen->save();
            return response()->json(['message' => "Logout success"]);
        }
    }
}
