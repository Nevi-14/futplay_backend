<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $table = "horario_canchas";
    protected $primaryKey = 'Cod_Horario';
    protected $guarded = [];




    public function canchas(){

        return $this->belongsTo(Cancha::class , 'Cod_Cancha');
    
    
    }



}

