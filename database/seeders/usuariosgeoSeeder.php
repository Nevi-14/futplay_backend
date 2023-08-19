<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\UsuarioGeolocalizacion;
use File;
  
class UsuariosgeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
  
        $json = File::get("database/data/usuariosgeo.json");
        $usuarios = json_decode($json);
  
        foreach ($usuarios as $key => $value) {

          //  dd ($value);
            UsuarioGeolocalizacion::create([
                "Cod_Usuario" => $value->Cod_Usuario,
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