<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodAreaModel extends Model
{
   
    protected $table ='codigos_de_area' ;

    public $fillable=['fld_cod_area'];

    public $timestamps = false;

    public $incrementing= false;
}
