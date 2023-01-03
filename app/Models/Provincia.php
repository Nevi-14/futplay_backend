<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Provincia extends Model
{
    use HasFactory;

    protected $table = 'provincias';
    protected $primaryKey = 'Cod_Provincia';
    protected $guarded = [];

    public function cantones(){
        return $this->hasMany('App\Models\Cantones', 'Cod_Canton');
    }

    public function canchas(){
        return $this->hasMany('App\Models\Cancha', 'Cod_Cancha');
    }
}
