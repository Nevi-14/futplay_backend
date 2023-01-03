<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Jugador extends Model
{
    use HasFactory;
    protected $table = "jugadores_equipos";
    protected $primaryKey = 'Cod_Jugador';
    protected $guarded = [];


    public function usuarios(){

        return $this->belongsTo(Usuario::class , 'Cod_Usuario');
    

    }
    public function equipos(){

        return $this->belongsTo(Equipo::class , 'Cod_Equipo');
    

    }
}
