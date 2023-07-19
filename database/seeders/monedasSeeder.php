<?php
 
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Moneda;
use File;
  
class MonedasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
  
        $json = File::get("database/data/monedas.json");
        $monedas = json_decode($json);
  
        foreach ($monedas as $key => $value) {
            Moneda::create([
                "Moneda" => $value->Moneda,
                "Descripcion" => $value->Descripcion
            ]);
        }
    }
}