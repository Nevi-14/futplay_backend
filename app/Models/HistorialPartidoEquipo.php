<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPartidoEquipo extends Model
{
    use HasFactory;
    protected $table = "historial_partidos_equipos";
    protected $primaryKey = 'Cod_Historial';
    protected $guarded = [];


}

