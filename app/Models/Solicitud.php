<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    protected $table = "solicitudes_jugadores_equipos";
    protected $primaryKey = 'Cod_Solicitud';
    protected $guarded = [];

    
    public function equipos(){

        return $this->belongsTo('App\Models\Equipo' , 'Cod_Equipo');
    

    }

    public function usuarios(){

        return $this->belongsTo('App\Models\Usuario' , 'Cod_Usuario');
    

    }
}