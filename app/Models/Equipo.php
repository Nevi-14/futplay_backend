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
    public function provincias(){

        return $this->belongsTo(Provincia::class , 'Cod_Provincia');
    

    }

    public function cantones(){

        return $this->belongsTo(Canton::class , 'Cod_Canton');
    

    }
    public function distritos(){

        return $this->belongsTo(Distrito::class , 'Cod_Distrito');
    

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
