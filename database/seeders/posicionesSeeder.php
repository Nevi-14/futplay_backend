<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Posicion;
use File;
  
class PosicionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
  
        $json = File::get("database/data/posiciones.json");
        $posiciones = json_decode($json);
  
        foreach ($posiciones as $key => $value) {
            Posicion::create([
                "Cod_Posicion" => $value->Cod_Posicion,
                "Posicion" => $value->Posicion
            ]);
        }
    }
}