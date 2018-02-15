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
                $value['ExistenciaPaperles'] == null ? $sql.="null," : $sql.= $value['ExistenciaPaperles'].",";
                $sql .=$idUser.");";
                $execute=DB::select($sql);
                foreach ($execute[0] as $key => $value) { $res=$value; }
                $res = json_decode($res,true);
                $result[$count]['code']=$res['code'];
                $result[$count]['status']=$res['status'];
                $result[$count]['IdDte']=$res['IdDte'];
                // $respuesta = json_encode($json);
                // $result[$count] = $respuesta;
                $count++;
            }catch (Exception $e) {
                $result[$count]['code']="500";
                $result[$count]['status']=$e->getMessage();
                // $respuesta = json_encode($json);
                // $result[$count] = $respuesta;
            }
        }
        return $result;
    }

    public function updateDtes($datos){
        $result = [];
        $count = 1;
        $idUser = Auth::id();
        foreach ($datos as $key => $value) {
            try {
            if (isset($value['IdDTE'])){
                if ($value['IdDTE'] <>null){
                    $IdDTE = $value['IdDTE'];
                    unset($value['IdDTE']);
                    $var="";
                    if (isset($value['TipoDTE'])){$var.= "TipoDTE=".$value['TipoDTE'].",";}
                    if (isset($value['FolioDTE'])){$var.= "FolioDTE='".$value['FolioDTE']."',";}
                    if (isset($value['FechaRecepcion'])){$var.= "FechaRecepcion='".$value['FechaRecepcion']."',";}
                    if (isset($value['FechaEmision'])){$var.= "FechaEmision='".$value['FechaEmision']."',";}
                    if (isset($value['FechaRecepcionSII'])){$var.= "FechaRecepcionSII='".$value['FechaRecepcionSII']."',";}
                    if (isset($value['IdProveedor'])){$var.= "IdProveedor=".$value['IdProveedor'].",";}                
                    if (isset($value['RUTEmisor'])){$var.= "RUTEmisor='".$value['RUTEmisor']."',";}
                    if (isset($value['IdCliente'])){$var.= "IdCliente=".$value['IdCliente'].",";}                
                    if (isset($value['RUTReceptor'])){$var.= "RUTReceptor='".$value['RUTReceptor']."',";}
                    if (isset($value['MontoNetoCLP'])){$var.= "MontoNetoCLP=".$value['MontoNetoCLP'].",";}                
                    if (isset($value['MontoExentoCLP'])){$var.= "MontoExentoCLP=".$value['MontoExentoCLP'].",";}
                    if (isset($value['MontoIVACLP'])){$var.= "MontoIVACLP=".$value['MontoIVACLP'].",";}
                    if (isset($value['MontoTotalCLP'])){$var.= "MontoTotalCLP=".$value['MontoTotalCLP'].",";}
                    if (isset($value['MontoNetoOM'])){$var.= "MontoNetoOM".$value['MontoNetoOM'].",";}
                    if (isset($value['MontoExentoOM'])){$var.= "MontoExentoOM=".$value['MontoExentoOM'].",";}
                    if (isset($value['MontoIVAOM'])){$var.= "MontoIVAOM=".$value['MontoIVAOM'].",";}
                    if (isset($value['MontoTotalOM'])){$var.= "MontoTotalOM=".$value['MontoTotalOM'].",";}    
                    if (isset($value['EstadoDTECliente'])){$var.= "EstadoDTECliente='".$value['EstadoDTECliente']."',";} 
                    if (isset($value['EstadoDTESII'])){$var.= "EstadoDTESII='".$value['EstadoDTESII']."',";} 
                    if (isset($value['EstadoPagoDTE'])){$var.= "EstadoPagoDTE='".$value['EstadoPagoDTE']."',";}  
                    if (isset($value['EntradaMercaderia'])){$var.= "EntradaMercaderia='".$value['EntradaMercaderia']."',";}
                    if (isset($value['PdfDTE'])){$var.= "PdfDTE='".$value['PdfDTE']."',";}
                    if (isset($value['XmlDTE'])){$var.= "XmlDTE='".$value['XmlDTE']."',";}
                    if (isset($value['FechaAutorizacionSII'])){$var.= "FechaAutorizacionSII='".$value['FechaAutorizacionSII']."',";}
                    if (isset($value['FechaOC'])){$var.= "FechaOC='".$value['FechaOC']."',";}    
                    if (isset($value['FechaPago'])){$var.= "FechaPago='".$value['FechaPago']."',";}
                    if (isset($value['FechaVencimiento'])){$var.= "FechaVencimiento='".$value['FechaVencimiento']."',";}
                    if (isset($value['TipoAcuse'])){$var.= "TipoAcuse=".$value['TipoAcuse'].",";}
                    if (isset($value['ExistenciaSII'])){$var.= "ExistenciaSII=".$value['ExistenciaSII'].",";}
                    $sql = 'call f_actualizacion_dte('.$IdDTE.',"'.$var.'",'.$idUser.',@sqlupdate);';
                    $execute=DB::select($sql);
                    $var = DB::select("select @sqlupdate;");
                    foreach ($var[0] as $key => $value) {$res=$value;}
                    $res = json_decode($res,true);
                    $result[$count]['code']=$res['code'];
                    $result[$count]['status']=$res['status'];
                    $result[$count]['IdDte']=$res['IdDte'];
                    // $respuesta = json_encode($json);
                    // $result[$count] = $respuesta;
                }else{
                    $result[$count]['code']="500";
                    $result[$count]['status']="Indefinido index idDte";
                }
            }else{
                $result[$count]['code']="500";
                $result[$count]['status']="Indefinido index idDte";
            }
        $count++;
        }catch (Exception $e) {
                $result[$count]['code']="500";
                $result[$count]['status']=$e->getMessage();
                // $respuesta = json_encode($json);
                // $result[$count] = $respuesta;
            }
        }
        return $result;
    } 
}