<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'Cod_Categoria';
    protected $guarded = [];

    
    public function canchas(){
        return $this->hasMany('App\Models\Cancha', 'Cod_Cancha');
    }

}
