<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Distrito;
use File;
  
class DistritosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
  
        $json = File::get("database/data/distritos.json");
        $distritos = json_decode($json);
  
        foreach ($distritos as $key => $value) {
            Distrito::create([
                "Cod_Distrito" => $value->Cod_Distrito,
                "Cod_Canton" => $value->Cod_Canton,
                "Distrito" => $value->Distrito
            ]);
        }
    }
}