<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\Dte;
use Log;

class DteController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    
    public function getAll(){
        try{
        	$result = Api::all();
            return $result;
        }catch(JWTException $e){
            log::info("Error Controlado: ".$e->getMessage());
            return $e->getMessage();

        }
    }

    public function postAdd(Request $request){
        $datos = $request->all();   
        $model= new Dte();
        $result = $model->regDtes($datos);
        return $result;
    }

    public function postUpdate(Request $request){
        $datos = $request->all();   
        $model= new Dte();
        $result = $model->updateDtes($datos);
        return $result;
    }

    // public function getOne($id){
    // 	$result = Api::find($id);
    // 	return $result;
    // }

    // public function edit($id,Request $request){
    // 	$result = $this->getOne($id);
    // 	$result->fill($request->all())->save();
    // 	return $result;
    // }

    // public function delete($id){
    // 	$result = $this->getOne($id);
    // 	$result->delete();
    // 	return $result;
    // }

}
