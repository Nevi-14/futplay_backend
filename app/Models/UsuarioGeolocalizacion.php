<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UsuarioGeolocalizacion extends Model
{
    use HasFactory;

    protected $table = 'usuarios_geolocalizacion';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function usuarios(){
        return $this->belongsTo(Usuario::class , 'Cod_Usuario');
        }

}
