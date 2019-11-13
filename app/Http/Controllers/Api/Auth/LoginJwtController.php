<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginJwtController extends Controller
{   
    public function login(Request $request){

    $credentials = $request->all(['email', 'password']);

    	if(!$token = auth('api')->attempt($credentials)) {

    	   $message = [
    	   	'msg' =>'Unauthorized',
    	   	'erro' => 401
    	   ];

           return response()->json($message);
    	}	

    	return response()->json([
    		'token' => $token
        ]);
    }
}
