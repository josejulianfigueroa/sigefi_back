<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagosModel extends Model
{
   
    protected $table ='j_base_pagos_eficaz' ;

    protected $primaryKey = 'id';

    public $fillable=['rut','fecha_pago','monto','idcliente'];

    public $timestamps = false;

    public $incrementing= false;
}

