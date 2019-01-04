<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ConveniosModel extends Model
{
   
    protected $table ='efi_convenios_pago' ;

    protected $primaryKey = 'id';

    public $fillable=['rut','fecha_convenio','nro_convenio','monto_convenio','monto_deuda','monto_dcto','abono_inicial','total_cuotas','monto_cuotas','codigo_usuario','cuotas_pagadas','dias_mora','primer_vcto','idcliente_origen','idcampania_origen','tipo_ajuste','fecha_actual','fecha_abono','fecha_vigente','fecha_roto','fecha_cancelado','codigo_usuario_autoriza','estado_auditado','pagare','modo_pagare','id_usuario_auditado','fecha_autoriza','fecha_rechaza','fecha_pagare_envio','fecha_pagare_pendiente','fecha_pagare_generado','fecha_pagare_firmado','fecha_pagare_ingreso','fecha_entrega_pagare'];

    public $timestamps = false;

    public $incrementing= false;

     public function es_de_usuario(){

     	return $this->belongsTo(User::class,'codigo_usuario');
     }

}

