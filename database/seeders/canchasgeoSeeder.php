<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\CanchaGeolocalizacion;
use File;
  
class CanchasgeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
  
        $json = File::get("database/data/canchasgeo.json");
        $canchas = json_decode($json);
  
        foreach ($canchas as $key => $value) {

          //  dd ($value);
          CanchaGeolocalizacion::create([
                "Cod_Cancha" => $value->Cod_Cancha,
                "Codigo_Pais" => $value->Codigo_Pais,
                "Pais" => $value->Pais,
                "Codigo_Estado" => $value->Codigo_Estado,
                "Estado" => $value->Estado,
                "Codigo_Ciudad" => $value->Codigo_Ciudad ,
                "Latitud" => $value->Latitud ,
                "Longitud" => $value->Longitud ,
                "Ciudad" => $value->Ciudad ,
                "Codigo_Postal" => null,
                "Direccion" => null
            ]);
        }
    }
}