<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CanchaGeolocalizacion extends Model
{
    use HasFactory;

    protected $table = 'canchas_geolocalizacion';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function canchas(){
        return $this->belongsTo(Cancha::class , 'Cod_Cancha');
        }
}
