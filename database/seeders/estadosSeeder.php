<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Estado;
use File;
  
class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
  
        $json = File::get("database/data/estados.json");
        $estados = json_decode($json);
  
        foreach ($estados as $key => $value) {
            Estado::create([
                "Cod_Estado" => $value->Cod_Estado,
                "Estado" => $value->Estado
            ]);
        }
    }
}