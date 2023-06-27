<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoReservacion extends Model
{
    use HasFactory;
    protected $table = "tipos_reservaciones";
    protected $primaryKey = 'Cod_Tipo';
    protected $guarded = [];

   
}