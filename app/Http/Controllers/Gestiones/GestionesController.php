<?php

namespace App\Http\Controllers\Gestiones;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\EfiIndexModel;
use App\Gestion2Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GestionesController extends ApiController
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
        //Inicio Buscar Gestiones del Cliente Conbranza
$gestiones = DB::table('gestion2 as g')
              ->select(DB::raw('distinct g.id,g.rut,
                                to_char(g.fecha::timestamp, \'DD-MM-YYYY hh24:mi:ss\')
                                        as fecha,
                                f.codarea ||\'-\'|| f.fono as fono,
                                u.nombre, a.descripcion,
                                g.observacion'
                                ))
               ->leftjoin('usuario as u', 'u.id', '=','g.idusuario')
               ->leftjoin('fono as f', function ($join) {
                      $join->on('f.idcliente','=','g.idcliente')
                           ->on('f.idcampania','=','g.idcampania')
                           ->on('f.id','=','g.idfono');
                      })
              ->leftjoin('arbolniv as a', 'a.id', '=','g.idgestion')
              ->where('g.rut',$rut)
              ->where('g.idcliente',$idcliente)
              ->where(DB::raw('g.fecha::date'),'>=',
                      DB::raw('now()::date - interval \'190 day\''))
              ->orderBy('g.id','desc')
              ->get();
} else {
            //Inicio Buscar Gestiones del Cliente Otros Cedentes
$gestiones = DB::table('gestion2 as g')
              ->select(DB::raw('distinct g.id,g.rut,
                                to_char(g.fecha::timestamp, \'DD-MM-YYYY hh24:mi:ss\')
                                        as fecha,
                                f.codarea ||\'-\'|| f.fono as fono,
                                u.nombre, a.descripcion,
                                g.observacion'
                                ))
               ->leftjoin('usuario as u', 'u.id', '=','g.idusuario')
               ->leftjoin('fono as f', function ($join) {
                      $join->on('f.idcliente','=','g.idcliente')
                           ->on('f.idcampania','=','g.idcampania')
                           ->on('f.id','=','g.idfono');
                      })
              ->leftjoin('arbolniv as a', 'a.id', '=','g.idgestion')
              ->where('g.rut',$rut)
              ->where('g.idcliente',$idcliente)
              ->where('g.idcampania',$idcampania)
              ->where(DB::raw('g.fecha::date'),'>=',
                      DB::raw('now()::date - interval \'190 day\''))
              ->orderBy('g.id','desc')
              ->get();
}
 return $this->showAll($gestiones);
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
