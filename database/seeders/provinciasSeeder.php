<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Provincia;
use File;
  
class ProvinciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $json = File::get("database/data/provincias.json");
        $provincias = json_decode($json);
  
        foreach ($provincias as $key => $value) {
            Provincia::create([
                "Cod_Provincia" => $value->Cod_Provincia,
                "Provincia" => $value->Provincia
            ]);
        }
    }
}