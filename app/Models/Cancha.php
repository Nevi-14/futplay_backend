<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Cancha extends Model
{
    use HasFactory;
    protected $table = "canchas";
    protected $primaryKey = 'Cod_Cancha';
    protected $guarded = [];


    public function usuarios(){

        return $this->belongsTo(Usuario::class , 'Cod_Usuario');
    

    }
    public function provincias(){

        return $this->belongsTo(Provincia::class , 'Cod_Provincia');
    

    }
    public function reservaciones(){

        return $this->hasMany(Reservacion::class , 'Cod_Reservacion');
    

    }
    public function horarios(){

        return $this->hasMany(Horario::class , 'Cod_Cancha');
    

    }
    public function cantones(){

        return $this->belongsTo(Canton::class , 'Cod_Canton');
    

    }
    public function distritos(){

        return $this->belongsTo(Distrito::class , 'Cod_Distrito');
    

    }
    public function categorias(){

        return $this->belongsTo(Categoria::class , 'Cod_Categoria');
    

    }
}
