<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Distrito extends Model
{
    use HasFactory;

    protected $table = 'distritos';
    protected $primaryKey = 'Cod_Distrito';
    protected $guarded = [];


    public function Cantones(){

        return $this->belongsTo(Cantones::class , 'Cod_Canton');
    

    }

    public function canchas(){
        return $this->hasMany('App\Models\Cancha', 'Cod_Cancha');
    }


}
