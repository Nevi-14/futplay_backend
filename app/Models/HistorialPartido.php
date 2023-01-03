<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class HistorialPartido extends Model
{
    use HasFactory;

    protected $table = 'historial_partidos';
    protected $primaryKey = 'Cod_Partido';
    protected $guarded = [];

    public function reservaciones(){
        return $this->belongsTo('App\Models\Reservacion', 'Cod_Reservacion');
    }


    public function Equipos(){
        return $this->belongsTo('App\Models\Equipo', 'Cod_Equipo');
    }
}
