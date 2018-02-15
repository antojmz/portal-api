<?php

namespace App\Http\Controllers;

use App\Route;
use App\Legislature;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Log;
use App\Models\Api;

class AuthController extends Controller {

    public function authenticate(\Illuminate\Http\Request $request) { 
        $datos = $request->all();
        $model= new Api();
        $credentials = $model->verificarUsuarioApi($datos);
        try{
            if($credentials){
                $token = JWTAuth::fromUser($credentials);
                return response()->json(['token' => "$token"], 200);
            }else{
                return response()->json(['error' => 'invalid_credentials'], 401);
            }           
        }catch(JWTException $e){
            return response()->json(['error' => 'could_not_create_token'], 500); 
        }
    }
}