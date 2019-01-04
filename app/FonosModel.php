<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class FonosModel extends Model
{
   
    protected $table ='fono' ;

    protected $primaryKey = 'id';

    public $fillable=['id',
    				  'idregistro',
    				  'idcliente',
					  'idcampania',
					  'codarea',
					  'fono',
					  'tipo',
					  'estado',
					  'origen'];

    public $timestamps = false;

    public $incrementing= false;

}

