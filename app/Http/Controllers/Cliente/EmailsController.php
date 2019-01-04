<?php

namespace App\Http\Controllers\Cliente;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\EfiIndexModel;
use App\User;
use App\EmailsModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EmailsController extends ApiController
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
    
        $email = new EmailsModel;
        $email->estado_email= 'valido';
        $email->idusuario_create= $request->get('idusuario');
        $email->email =  $request->get('email');
        $email->rut = $request->get('rut');

        $mytime=Carbon::now('America/Santiago');
        $mytime=date("d-m-Y",strtotime($mytime));

        $email->fecha_create= $mytime;
        $email->save();

    $emails = DB::select("select a.id,a.email,u.nombre as nombre,a.fecha_create as fecha from efi_email_cliente_rut a left join usuario u on a.idusuario_create = u.id where a.rut = :id and a.estado_email='valido'", [ 'id' => $request->get('rut')]);

    return $emails;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($rut)
    {


$resultado = DB::select("select a.id,a.email,u.nombre as nombre,a.fecha_create as fecha from efi_email_cliente_rut a left join usuario u on a.idusuario_create = u.id where a.rut = :id and a.estado_email='valido'", [ 'id' => $rut]);

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
          $count = EmailsModel::where('rut',$request->get('rut'))
                              ->where('estado_email','valido')
                              ->count();
     
        if ($count < 2){ 
         return $this->errorResponse('Imposible dar de baja, al menos debe existir un email', 409);
       }else{


        $emails = EmailsModel::findOrFail($id);
        $emails->estado_email= 'invalido';
        $emails->idusuario_update= $request->get('idusuario');

        $mytime=Carbon::now('America/Santiago');
        $mytime=date("d-m-Y",strtotime($mytime));

        $emails->fecha_update= $mytime;
        $emails->save();

        $emails = DB::select("select a.id,a.email,u.nombre as nombre,a.fecha_create as fecha from efi_email_cliente_rut a left join usuario u on a.idusuario_create = u.id where a.rut = :id and a.estado_email='valido'", [ 'id' => $request->get('rut')]);

        return $emails;
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
