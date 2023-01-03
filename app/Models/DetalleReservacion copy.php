<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DetalleReservacion extends Model
{
    use HasFactory;

    protected $table = 'detalle_reservaciones';
    protected $primaryKey = 'Cod_Detalle';
    protected $guarded = [];
    public function reservaciones(){
        return $this->belongsTo('App\Models\Reservacion', 'Cod_Reservacion');
    }
    public function rival(){
        return $this->belongsTo('App\Models\Usuario', 'Cod_Usuario');
    }
  


}
