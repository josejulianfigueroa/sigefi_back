<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ComunasModel extends Model
{
   
    protected $table ='direcciones_comunas' ;

    protected $primaryKey = 'id';

    public $fillable=['id',
    				  'comuna',
    				  'provincia',
    				  'region'
    				];

    public $timestamps = false;

    public $incrementing= false;

}

