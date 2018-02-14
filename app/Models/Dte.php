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
                $sql= "select f_registro_dtes_api(0, ";
                $value['TipoDTE'] == null ? $sql.="null," : $sql.= $value['TipoDTE'].",";
                $value['FolioDTE'] == null ? $sql.="null," : $sql.= "'".$value['FolioDTE']."',";
                $value['FechaRecepcion'] == null ? $sql.="null," : $sql.= "'".$value['FechaRecepcion']."',";
                $value['FechaEmision'] == null ? $sql.="null," : $sql.= "'".$value['FechaEmision']."',";
                $value['FechaRecepcionSII'] == null ? $sql.="null," : $sql.= "'".$value['FechaRecepcionSII']."',";
                $value['IdProveedor'] == null ? $sql.="null," : $sql.= $value['IdProveedor'].",";
                $value['RUTEmisor'] == null ? $sql.="null," : $sql.= "'".$value['RUTEmisor']."',";
                $value['IdCliente'] == null ? $sql.="null," : $sql.= $value['IdCliente'].",";
                $value['RUTReceptor'] == null ? $sql.="null," : $sql.= "'".$value['RUTReceptor']."',";
                $value['MontoNetoCLP'] == null ? $sql.="null," : $sql.= $value['MontoNetoCLP'].",";
                $value['MontoExentoCLP'] == null ? $sql.="null," : $sql.= $value['MontoExentoCLP'].",";
                $value['MontoIVACLP'] == null ? $sql.="null," : $sql.= $value['MontoIVACLP'].",";
                $value['MontoTotalCLP'] == null ? $sql.="null," : $sql.= $value['MontoTotalCLP'].",";
                $value['MontoNetoOM'] == null ? $sql.="null," : $sql.= $value['MontoNetoOM'].",";
                $value['MontoExentoOM'] == null ? $sql.="null," : $sql.= $value['MontoExentoOM'].",";
                $value['MontoIVAOM'] == null ? $sql.="null," : $sql.= $value['MontoIVAOM'].",";
                $value['MontoTotalOM'] == null ? $sql.="null," : $sql.= $value['MontoTotalOM'].",";
                $value['EstadoDTECliente'] == null ? $sql.="null," : $sql.= "'".$value['EstadoDTECliente']."',";
                $value['EstadoDTESII'] == null ? $sql.="null," : $sql.= "'".$value['EstadoDTESII']."',";
                $value['EstadoPagoDTE'] == null ? $sql.="null," : $sql.= "'".$value['EstadoPagoDTE']."',";
                $value['DocumentoContable'] == null ? $sql.="null," : $sql.= "'".$value['DocumentoContable']."',";
                $value['EntradaMercaderia'] == null ? $sql.="null," : $sql.= "'".$value['EntradaMercaderia']."',";
                $value['OrdenDeCompra'] == null ? $sql.="null," : $sql.= "'".$value['OrdenDeCompra']."',";
                $value['PdfDTE'] == null ? $sql.="null," : $sql.= "'".$value['PdfDTE']."',";
                $value['XmlDTE'] == null ? $sql.="null," : $sql.= "'".$value['XmlDTE']."',";
                $value['FechaAutorizacionSII'] == null ? $sql.="null," : $sql.= "'".$value['FechaAutorizacionSII']."',";
                $value['FechaOC'] == null ? $sql.="null," : $sql.= "'".$value['FechaOC']."',";
                $value['FechaPago'] == null ? $sql.="null," : $sql.= "'".$value['FechaPago']."',";
                $value['FechaVencimiento'] == null ? $sql.="null," : $sql.= "'".$value['FechaVencimiento']."',";
                $value['TipoAcuse'] == null ? $sql.="null," : $sql.= $value['TipoAcuse'].",";
                $value['ExistenciaSII'] == null ? $sql.="null," : $sql.= $value['ExistenciaSII'].",";
                $value['ExistenciaPaperles'] == null ? $sql.="null," : $sql.= $value['TipoAcuse'].",";
                $sql .=$idUser.");";
                $execute=DB::select($sql);
                foreach ($execute[0] as $key => $value) { $res=$value; }
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