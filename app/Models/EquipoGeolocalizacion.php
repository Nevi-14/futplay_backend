<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class EquipoGeolocalizacion extends Model
{
    use HasFactory;

    protected $table = 'equipos_geolocalizacion';
    protected $primaryKey = 'ID';
    protected $guarded = [];


}
