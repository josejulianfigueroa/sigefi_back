<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gestion2Model extends Model
{

    protected $table ='gestion2' ;

    protected $primaryKey = 'id';

    public $fillable=['rut','idcliente','idcampania','idbase','idgestion','idusuario','compromiso','fecha'];

    public $timestamps = false;

    public $incrementing= false;
}


