<?php

namespace App\Http\Controllers\Cliente;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\EfiIndexModel;
use App\DireccionesModel;
use App\User;
use App\ComunasModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DireccionesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Entrega las Comunas, Provincias y Regiones

        $comunas= ComunasModel::all();

        return $this->showAll($comunas);
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

        $valor = explode('/',$request->get('comuna'));
        $comuna = trim($valor[0]);
        $provincia = trim($valor[1]);
        $region = trim($valor[2]);

        $direccion = new DireccionesModel;
        $direccion->estado_direccion= 'valido';
        $direccion->idusuario_create= $request->get('idusuario');
        $direccion->direccion =  $request->get('dire');
        $direccion->comuna =  $comuna;
        $direccion->region =  $region;
        $direccion->ciudad =  $provincia;
        $direccion->rut = $request->get('rut');

        $mytime=Carbon::now('America/Santiago');
        $mytime=date("d-m-Y",strtotime($mytime));

        $direccion->fecha_create= $mytime;
        $direccion->save();


    $direcciones = DB::select("Select a.id,(trim(coalesce(a.direccion,'')) ||', Comuna: '||trim(coalesce(a.comuna,''))||', Ciudad: '||trim(coalesce(a.ciudad,''))||', Region: '||trim(coalesce(a.region,''))) as dire,u.nombre as nombre,a.fecha_create as fecha from efi_direcciones_general a left join usuario u on a.idusuario_create = u.id where a.rut=:id  and a.estado_direccion='valido'", [ 'id' => $request->get('rut')]);


         return $direcciones;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($rut)
    {


    $resultado = DB::select("Select a.id,(trim(coalesce(a.direccion,'')) ||', Comuna: '||trim(coalesce(a.comuna,''))||', Ciudad: '||trim(coalesce(a.ciudad,''))||', Region: '||trim(coalesce(a.region,''))) as dire,u.nombre as nombre,a.fecha_create as fecha from efi_direcciones_general a left join usuario u on a.idusuario_create = u.id where a.rut=:id  and a.estado_direccion='valido'", [ 'id' => $rut]);

       return $resultado;
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
 
       $count = DireccionesModel::where('rut',$request->get('rut'))
                                ->where('estado_direccion','valido')
                                ->count();
        Log::info($count);
     
        if ($count < 2){ 
         return $this->errorResponse('Imposible dar de baja, al menos debe existir una dirección', 409);
       }else{

        $direccion = DireccionesModel::findOrFail($id);
        $direccion->estado_direccion= 'invalido';
        $direccion->idusuario_update= $request->get('idusuario');

        $mytime=Carbon::now('America/Santiago');
        $mytime=date("d-m-Y",strtotime($mytime));

        $direccion->fecha_update= $mytime;
        $direccion->save();

        $direcciones = DB::select("Select a.id,(trim(coalesce(a.direccion,'')) ||', Comuna: '||trim(coalesce(a.comuna,''))||', Ciudad: '||trim(coalesce(a.ciudad,''))||', Region: '||trim(coalesce(a.region,''))) as dire,u.nombre as nombre,a.fecha_create as fecha from efi_direcciones_general a left join usuario u on a.idusuario_create = u.id where a.rut=:id  and a.estado_direccion='valido'", [ 'id' => $request->get('rut')]);


         return $direcciones;
     }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
    }
}
