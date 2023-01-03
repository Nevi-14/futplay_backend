<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use File;
  
class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
  
        $json = File::get("database/data/categorias.json");
        $categorias = json_decode($json);
  
        foreach ($categorias as $key => $value) {
            Categoria::create([
                "Cod_Categoria" => $value->Cod_Categoria,
                "Nombre" => $value->Nombre
            ]);
        }
    }
}