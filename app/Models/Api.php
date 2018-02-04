<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\QueryException;
use App\Exceptions\Handler;
use Illuminate\Mail\Mailable;
    
use DB;
use Crypt;
use Hash;
use Log;
use DateTime;
use Session;
use Mail;
use Storage;
use Exception;
use Auth;

class Api extends Authenticatable implements JWTSubject {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'usuarios_api';
    
    protected $primaryKey = 'idUser';
    
    //Desactica campos created_at y updated_at
    public $timestamps = false;
    
    protected $fillable = [
        'auCreadoPor','auModificadoPor','idPerfil','usrEstado','usrNombreFull','usrUserName','usrEmail','usrUrlimage'
    ];

    protected $hidden = ['usrPassInit','usrPassword', 'remember_token'];

    protected $dates = [
        'auCreadoEl','auModificadoEl','usrUltimaVisita'
    ];




    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey(); // Eloquent Model method
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }






    public function getAll(){
        $result = DB::table('usuarios_api')->get();  
        return $result;            
    }

    public function verificarUsuarioApi($data){
        try{
            $data['usrUserName'] = $this->LimpiarRut($data['usrUserName']);
            $user = DB::table('usuarios_api')->where('usrUserName',$data['usrUserName'])->get();
            if (isset($user[0]->idUser)){
                if ($user[0]->usrEstado>0){
                        if(isset($user[0]->usrPassword) && Hash::check($data['usrPassword'],$user[0]->usrPassword)){
                                $result = Api::find($user[0]->idUser);
                                return $result;
                        }
                }
            }
        }catch (Exception $e){
            log::info("Error de autenticacion de API: ".$e->getMessage());
        }
    }

    public function LimpiarRut($rut){
        return str_replace(".","",$rut);
    }
}