<?php

namespace App\Http\Controllers\Convenios;


use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\EfiIndexModel;
use App\ConveniosModel;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class CuotasConveniosController extends ApiController
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

         $resp = EfiIndexModel::where('rut',$rut)->get();

         $idcliente=$resp[0]->idcliente;

        } else {
        
        $valor = explode('-',request()->select_campa);
        $idcliente = trim($valor[0]);
        $idcampania = trim($valor[1]);

        }
        
// Inicio Buscar Ultimo Numero de  Convenio del Cliente
$nro = ConveniosModel::where('rut',$rut)
            ->where('idcliente_origen',$idcliente)
            ->orderBy('id','desc')
            ->max('nro_convenio');


  if($nro != null) {    
     
 //Ejecutamos el PL que genera el estado de las cuotas
DB::select("select efi_pagos_cuotas(:id,:id2,:id3)",['id'=>$idcliente,'id2'=>$rut,'id3'=>$nro]);


// Obtenemos las Cuotas
$cuotas= DB::table('efi_pagos_cuotas as c')
             ->select('c.id as id','c.estado as estado','c.monto as monto','c.saldo as saldo','c.fecha_vcto as fecha_vcto','c.vencida as vencida')
             ->orderBy('id','asc')->get(); 

return $this->showAll($cuotas);

  } else {
    // Obtenemos las Cuotas Vacio
    $cuotas= DB::table('efi_pagos_cuotas as c')
             ->select('c.id as id','c.estado as estado','c.monto as monto','c.saldo as saldo','c.fecha_vcto as fecha_vcto','c.vencida as vencida')
             ->where('c.estado','vacio')
             ->orderBy('id','asc')->get(); 

        return $this->showAll($cuotas);
    // return $this->errorResponse('Rut sin convenio', 409);

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
