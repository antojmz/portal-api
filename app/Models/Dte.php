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

class Dte extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'dtes_api';
    
    protected $primaryKey = 'IdDTE';
    
    //Desactica campos created_at y updated_at
    public $timestamps = false;
    
    protected $fillable = [
        'TipoDTE', 'FolioDTE', 'IdProveedor', 'RUTEmisor', 'IdCliente', 'RUTReceptor', 'MontoNetoCLP', 'MontoExentoCLP', 'MontoIVACLP', 'MontoTotalCLP', 'MontoNetoOM', 'MontoExentoOM', 'MontoIVAOM', 'MontoTotalOM', 'EstadoDTECliente', 'EstadoDTESII', 'EstadoPagoDTE', 'DocumentoContable', 'EntradaMercaderia', 'OrdenDeCompra', 'auUsuarioModificacion', 'auUsuarioCreacion', 'PdfDTE', 'XmlDTE', 'TipoAcuse', 'ExistenciaSII', 'ExistenciaPaperles'
    ];


    protected $dates = [
        'FechaVencimiento','FechaAutorizacionSII','FechaOC','FechaPago','auFechaModificacion','auFechaCreacion','FechaRecepcion','FechaEmision','FechaRecepcionSII'
    ];


    public function getAll(){
        $result = DB::table('dtes_api')->get();  
        return $result;            
    }  

    public function regDtes($datos){
        $result = [];
        $count = 1;
        $idUser = Auth::id();
        foreach ($datos as $key => $value) {    
            try {
                $sql= "select f_registro_dtes_api(0,".$value['TipoDTE'].",
                '".$value['FolioDTE']."',
                '".$value['FechaRecepcion']."',
                '".$value['FechaEmision']."',
                '".$value['FechaRecepcionSII']."',
                ".$value['IdProveedor'].",
                '".$value['RUTEmisor']."',
                ".$value['IdCliente'].",
                '".$value['RUTReceptor']."',
                '".$value['MontoNetoCLP']."',
                '".$value['MontoExentoCLP']."',
                '".$value['MontoIVACLP']."',
                '".$value['MontoTotalCLP']."',
                '".$value['MontoNetoOM']."',
                '".$value['MontoExentoOM']."',
                '".$value['MontoIVAOM']."',
                '".$value['MontoTotalOM']."',
                '".$value['EstadoDTECliente']."',
                '".$value['EstadoDTESII']."',
                '".$value['EstadoPagoDTE']."',
                '".$value['DocumentoContable']."',
                '".$value['EntradaMercaderia']."',
                '".$value['OrdenDeCompra']."',
                '".$value['PdfDTE']."',
                '".$value['XmlDTE']."',
                ".$value['FechaAutorizacionSII'].",
                ".$value['FechaOC'].",
                ".$value['FechaPago'].",
                ".$value['FechaVencimiento'].",
                ".$value['TipoAcuse'].",
                ".$value['ExistenciaSII'].",
                ".$value['ExistenciaPaperles'].",
                ".$idUser.");";
                $execute=DB::select($sql);
                foreach ($execute[0] as $key => $value) {
                    $res=$value;
                }
                $res = json_decode($res,true);
                $json['IdDte']=$res['IdDte'];
                $json['code']=$res['code'];
                $json['status']=$res['status'];
                $respuesta = json_encode($json);
                $result[$count] = $respuesta;
                $count++;
            }catch (Exception $e) {
                $json['code']="500";
                $json['status']=$e->getMessage();
                $respuesta = json_encode($json);
                $result[$count] = $respuesta;
            }
        }
        return $result;
    }
    
}