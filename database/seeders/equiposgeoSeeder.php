<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\EquipoGeolocalizacion;
use File;
  
class EquiposgeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
  
        $json = File::get("database/data/equiposgeo.json");
        $equipos = json_decode($json);
  
        foreach ($equipos as $key => $value) {

          //  dd ($value);
          EquipoGeolocalizacion::create([
                "Cod_Equipo" => $value->Cod_Equipo,
                "Codigo_Pais" => $value->Codigo_Pais,
                "Pais" => $value->Pais,
                "Codigo_Estado" => $value->Codigo_Estado,
                "Estado" => $value->Estado,
                "Codigo_Ciudad" => $value->Codigo_Ciudad ,
                "Ciudad" => $value->Ciudad ,
                "Codigo_Postal" => null,
                "Direccion" => null
            ]);
        }
    }
}