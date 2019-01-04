<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class FonoBaseModel extends Model
{
   
    protected $table ='efi_fono_cliente_rut' ;

    protected $primaryKey = 'id';

    public $fillable=['id',
    				  'rut',
    				  'codarea',
    				  'fono',
					  'estado_fono',
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

