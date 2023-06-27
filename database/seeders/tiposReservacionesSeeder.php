<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\TipoReservacion;
use File;
  
class TiposReservacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
  
        $json = File::get("database/data/tiposReservaciones.json");
        $tipos = json_decode($json);
  
        foreach ($tipos as $key => $value) {
            TipoReservacion::create([
                "Codigo" => $value->Codigo,
                "Nombre" => $value->Nombre
            ]);
        }
    }
}