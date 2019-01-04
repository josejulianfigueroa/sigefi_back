<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class DireccionesModel extends Model
{
   
    protected $table ='efi_direcciones_general' ;

    protected $primaryKey = 'id';

    public $fillable=['id',
    				  'rut',
    				  'direccion',
    				  'comuna',
    				  'ciudad',
					  'region',
					  'estado_direccion',
					  'idusuario_create',
					  'fecha_create',
					  'idusuario_update', // Se da de baja
					  'fecha_update'];

    public $timestamps = false;

    public $incrementing= false;

     public function es_de_usuario(){

     	return $this->belongsTo(User::class,'idusuario_create');
     }

}

