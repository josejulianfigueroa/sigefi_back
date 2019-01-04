<?php

namespace App\Http\Controllers\Cliente;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\EfiIndexModel;
use App\User;
use App\FonoBaseModel;
use App\FonosModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class FonosController extends ApiController
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

        $fono = new FonosModel;
        $fono->idregistro= $request->get('idregistro_rut');
        $fono->idcliente= $request->get('idcliente_rut');
        $fono->idcampania =  $request->get('idcampania_rut');
        $fono->idbase =  '1';
        $fono->codarea =  $request->get('codarea');
        $fono->fono =  $request->get('fono');
        $fono->tipo =  '1';
        $fono->estado =  'B';
        $fono->origen =  'E';
        $fono->save();

        // Regresando los fonos
        $fonos = DB::select("select case when estado = 'A' then 'CONFIRMADO'
                            else 'POR CONFIRMAR' end as estado,id,trim(codarea) as codarea,trim(fono) as fono,trim(codarea) || '-' || trim(fono) as fono_unido from fono where idcliente = :id and idcampania= :id2 and idregistro = :id3 and coalesce(estado,'B') in ('A','B')", [ 'id' => $request->get('idcliente_rut'), 'id2' => $request->get('idcampania_rut'), 'id3' => $request->get('idregistro_rut')] );

        return $fonos;
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
         $idcampania=$resp[0]->idcampania;
         $idregistro=$resp[0]->idregistro;

        } else {
        
        $valor = explode('-',request()->select_campa);
        $idcliente = trim($valor[0]);
        $idcampania = trim($valor[1]);

        $resp = EfiIndexModel::where('rut',$rut)
                             ->where('idcliente',$idcliente)
                             ->where('idcampania',$idcampania)
                             ->get();
         $idregistro=$resp[0]->idregistro;

        }


$resultado = DB::select("select case when estado = 'A' then 'CONFIRMADO'
                            else 'POR CONFIRMAR' end as estado,id,trim(codarea) as codarea,trim(fono) as fono,trim(codarea) || '-' || trim(fono) as fono_unido from fono where idcliente = :id and idcampania= :id2 and idregistro = :id3 and coalesce(estado,'B') in ('A','B')", [ 'id' => $idcliente, 'id2' => $idcampania, 'id3' => $idregistro] );

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
        $resp = EfiIndexModel::where('rut',$request->get('rut'))->get();

        $idcliente=$resp[0]->idcliente;
        $idcampania=$resp[0]->idcampania;
        $idregistro=$resp[0]->idregistro;

       /* $count = FonosModel::where('idcliente',$idcliente)
                           ->where('idcampania',$idcampania)
                           ->where('idregistro',$idregistro)
                           ->where('estado','A')
                           ->orwhere('estado','B')
                           ->count();*/
         $count = DB::select("SELECT count(*) as count FROM fono where
                    idcliente = :id1 and
                    idcampania = :id2 and
                    idregistro = :id3 and 
                    (estado = 'A' or estado = 'B')", 
                    [ 'id1' => $idcliente,
                      'id2' => $idcampania,
                      'id3' => $idregistro]);


        if ($count[0]->count < 2){ 
         return $this->errorResponse('Imposible dar de baja, al menos debe existir un fono', 409);
       }else{



       DB::update("update fono set estado = 'C' where idcliente= :id1 and idcampania in (select a.id from campania a, base b 
                         where a.idcliente = b.idcliente and a.id = b.idcampania 
                         and a.idcliente = :id1 and b.estado = true)
            and trim(codarea || fono) = :id2 ", [ 'id1' => $idcliente,'id2' => $id]);

        $fonos = DB::select("select case when estado = 'A' then 'CONFIRMADO'
                            else 'POR CONFIRMAR' end as estado,id,trim(codarea) as codarea,trim(fono) as fono,trim(codarea) || '-' || trim(fono) as fono_unido from fono where idcliente = :id and idcampania= :id2 and idregistro = :id3 and coalesce(estado,'B') in ('A','B')", [ 'id' => $idcliente, 'id2' => $idcampania, 'id3' => $idregistro] );

        return $fonos;
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
        //
    }
}
