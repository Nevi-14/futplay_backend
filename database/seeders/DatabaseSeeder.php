<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
         //  CategoriasSeeder::class,
           //EstadosSeeder::class,
           //PosicionesSeeder::class,
           //RolesSeeder::class,
           //TiposReservacionesSeeder::class,
           //MonedasSeeder::class
           //UsuariosgeoSeeder::class
          // EquiposgeoSeeder::class
         CanchasgeoSeeder::class
        ]);
    }
}
