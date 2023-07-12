<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Equipo extends Model
{
    use HasFactory;
    protected $table = "equipos";
    protected $primaryKey = 'Cod_Equipo';
    protected $guarded = [];


    public function usuarios(){

        return $this->belongsTo(Usuario::class , 'Cod_Usuario');
    

    }
    public function geolocalizacion(){
        return $this->belongsTo('App\Models\EquipoGeolocalizacion', 'ID');
    }
  
    public function rivales(){

        return $this->hasMany('App\Models\DetalleReservacion' , 'Cod_Equipo');
    

    }

    public function historial(){

        return $this->hasMany('App\Models\HistorialPartido' , 'Cod_Equipo');
    

    }

    
    public function retadores(){

        return $this->hasMany(DetalleReservacion::class , 'Cod_Retador');
    

    }

    public function solicitudes(){

        return $this->hasMany('App\Models\Solicitud' , 'Cod_Equipo');
    

    }
}
