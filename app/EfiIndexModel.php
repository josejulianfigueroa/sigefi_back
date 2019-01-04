<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EfiIndexModel extends Model
{
   
    protected $table ='efi_index';

    protected $primaryKey = 'id';

    public $fillable=['rut','idcliente','idcampania'];

    public $timestamps = false;

    public $incrementing= false;
}