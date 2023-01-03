<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
    use HasFactory;
    protected $table = "reservaciones";
    protected $primaryKey = 'Cod_Reservacion';
    protected $guarded = [];


    
    public function detalles(){

        return $this->hasMany(DetalleReservacion::class , 'Cod_Reservacion');
    

    }
    public function historial(){

        return $this->hasMany(DetalleReservacion::class , 'HistorialPartido');
    

    }

    
    public function canchas(){
        return $this->belongsTo('App\Models\Cancha', 'Cod_Cancha');
    }
  public function retador(){
        return $this->belongsTo('App\Models\Usuario', 'Cod_Usuario');
    }
}
