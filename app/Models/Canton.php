<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Canton extends Model
{
    use HasFactory;

    protected $table = 'cantones';
    protected $primaryKey = 'Cod_Canton';
    protected $guarded = [];
    public function provincias(){

        return $this->belongsTo(Provincia::class , 'Cod_Provincia');
    

    }
    public function distritos(){
        return $this->hasMany('App\Models\Distrito', 'Cod_Distrito');
    }

    public function canchas(){
        return $this->hasMany('App\Models\Cancha', 'Cod_Cancha');
    }

}
