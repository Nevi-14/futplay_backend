<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Posicion extends Model
{
    use HasFactory;

    protected $table = 'posiciones';
    protected $primaryKey = 'Cod_Posicion';
    protected $guarded = [];


}
