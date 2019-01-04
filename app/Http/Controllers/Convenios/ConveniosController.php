<?php

namespace App\Http\Controllers\Convenios;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\EfiIndexModel;
use App\ConveniosModel;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ConveniosController extends ApiController
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

// Inicio Buscar Ultimo Convenio del Cliente
$convenio = ConveniosModel::where('rut',$rut)
            ->where('idcliente_origen',$idcliente)
            ->with(['es_de_usuario'])
           /* ->with(['es_de_usuario' => 
                    function ($query) use ($request) { 
                        if (request()->has('nombre')){
                            $query= strtolower(trim($request->get('nombre')));
                            $query->whereRaw( 'LOWER(nombre) like ?', '%'.$query.'%'); 
                        } 
                            
                    }]);*/
            ->orderBy('id','desc')
            ->limit('1')
            ->get();

return $this->showAll($convenio);

    }

    public function todos($rut)
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

// Inicio Buscar Todos los Convenios del Cliente
$convenios = ConveniosModel::where('rut',$rut)
            ->where('idcliente_origen',$idcliente)
            ->with(['es_de_usuario'])
            ->orderBy('id','desc')
            ->get();

return $this->showAll($convenios);

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
