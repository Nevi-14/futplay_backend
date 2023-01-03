<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Role;
use File;
  
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
  
        $json = File::get("database/data/roles.json");
        $roles = json_decode($json);
  
        foreach ($roles as $key => $value) {
            Role::create([
                "Cod_Role" => $value->Cod_Role,
                "Nombre" => $value->Nombre
            ]);
        }
    }
}