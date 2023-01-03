<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Canton;
use File;
  
class CantonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
  
        $json = File::get("database/data/cantones.json");
        $cantones = json_decode($json);
  
        foreach ($cantones as $key => $value) {
            Canton::create([
                "Cod_Canton" => $value->Cod_Canton,
                "Cod_Provincia" => $value->Cod_Provincia,
                "Canton" => $value->Canton
            ]);
        }
    }
}