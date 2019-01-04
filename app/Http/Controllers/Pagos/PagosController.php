<?php

namespace App\Http\Controllers\Pagos;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\EfiIndexModel;
use App\PagosModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PagosController extends ApiController
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

  // Identificar el Cliente para el Rut
         if (request()->select_campa == 'vacio') {

         $resp = EfiIndexModel::where('rut',$rut)->get();

         $idcliente=$resp[0]->idcliente;

        } else {
        
        $valor = explode('-',request()->select_campa);
        $idcliente = trim($valor[0]);
        $idcampania = trim($valor[1]);

        }

if ($idcliente == '84' || $idcliente == '83' || $idcliente == '68' || $idcliente == '60'){
// Inicio Buscar Pagos del Cliente
$pagos = DB::table('j_base_pagos_eficaz')
              ->select(DB::raw('distinct monto,
                                to_char(fecha_pago::date, \'DD-MM-YYYY\') as fecha_pago2
                                ,fecha_pago::date'
                                ))
              ->where('rut',$rut)
              ->where('idcliente',$idcliente)
              ->orderBy(DB::raw('fecha_pago::date'),'desc')
              ->get();
}else {
    $pagos = DB::table('j_base_pagos_eficaz')
              ->select(DB::raw('distinct monto,
                                to_char(fecha_pago::date, \'DD-MM-YYYY\') as fecha_pago2
                                ,fecha_pago::date'
                                ))
              ->where('rut',$rut)
              ->where('idcliente',$idcliente)
              ->where('idcampania',$idcampania)
              ->orderBy(DB::raw('fecha_pago::date'),'desc')
              ->get();
}

 return $this->showAll($pagos);
// Fin Buscar Pagos del Cliente
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
