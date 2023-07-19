<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Moneda extends Model
{
    use HasFactory;
    protected $table = "monedas";
    protected $primaryKey = 'ID';
    protected $guarded = [];

 
    public function detalleReservacion(){

        return $this->hasMany('App\Models\DetalleReservacion' , 'Cod_Moneda');
    

    }
}
