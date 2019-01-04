<?php

namespace App\Http\Controllers\Cliente;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\EfiIndexModel;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ClienteController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($rut)
    {

       
    if (request()->select_campa == 'vacio') {

    $count = EfiIndexModel::where('rut',$rut)->count();

    if ($count > 1 ) {

    $resp = DB::select("SELECT distinct a.idcliente as idcliente,a.idcampania as idcampania,a.rut as rut, a.id as id,a.idregistro as idregistro,b.nombre || '-' || c.nombre as nombre_cli_campa FROM efi_index a, cliente b, campania c WHERE a.rut = :id and c.id = a.idcampania and b.id = a.idcliente and c.idcliente = b.id", [ 'id' => $rut]);

       return $resp;

    }else{
 
    $resp = EfiIndexModel::where('rut',$rut)->get();


    if($resp->isEmpty())
     
     {
     
     return $this->errorResponse('Rut no existe en La Base de Datos', 409);

     } else{
    
    $idcliente=$resp[0]->idcliente;

    $idcampania=$resp[0]->idcampania;


    $tabla= sprintf("a%03d%03d001",$idcliente,$idcampania);
    $tabla=(string)$tabla;

    // Seleccionamos el nombre del Cliente
    $respuesta = DB::select("select nombre from cliente where id = :id and estado='true'",['id' => $idcliente]);

    $nombre_cliente = $respuesta[0]->nombre;

    if ($idcliente == '84' || $idcliente == '83' || $idcliente == '68' || $idcliente == '60'){

    $resultado = DB::select("SELECT id,rut,nombre,montodeuda,deuda_original, efi_tramo, dicom,estado_compromiso,estado_fono,q_gestiones,'".$nombre_cliente."' as cliente,'".$idcliente."' as idcliente,'".$idcampania."' as idcampania FROM ".$tabla." WHERE rut = :id limit 1", [ 'id' => $rut]);
        }
        else {
       $resultado = DB::select("SELECT id,rut,nombre,'0' as montodeuda, '0' as deuda_original, efi_tramo,'' as dicom,'' as estado_compromiso,'' as estado_fono,q_gestiones,'".$nombre_cliente."' as cliente,'".$idcliente."' as idcliente,'".$idcampania."' as idcampania FROM ".$tabla." WHERE rut = :id limit 1", [ 'id' => $rut]);
        }
    return $resultado;

    }
    }







} else {

    $valor = explode('-',request()->select_campa);
    $idcliente = trim($valor[0]);
    $idcampania = trim($valor[1]);

    $tabla= sprintf("a%03d%03d001",$idcliente,$idcampania);
    $tabla=(string)$tabla;

    // Seleccionamos el nombre del Cliente
    $respuesta = DB::select("select nombre from cliente where id = :id and estado='true'",['id' => $idcliente]);

    $nombre_cliente = $respuesta[0]->nombre;

    if ($idcliente == '84' || $idcliente == '83' || $idcliente == '68' || $idcliente == '60'){

    $resultado = DB::select("SELECT id,rut,nombre,montodeuda,deuda_original, efi_tramo, dicom,estado_compromiso,estado_fono,q_gestiones,'".$nombre_cliente."' as cliente,'".$idcliente."' as idcliente,'".$idcampania."' as idcampania FROM ".$tabla." WHERE rut = :id limit 1", [ 'id' => $rut]);
        }
        else {
       $resultado = DB::select("SELECT id,rut,nombre,'0' as montodeuda, '0' as deuda_original, efi_tramo,'' as dicom,'' as estado_compromiso,'' as estado_fono,q_gestiones,'".$nombre_cliente."' as cliente,'".$idcliente."' as idcliente,'".$idcampania."' as idcampania FROM ".$tabla." WHERE rut = :id limit 1", [ 'id' => $rut]);
        }
    return $resultado;

    }




    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
