<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ProcessesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('processes')->insert(
            
    [
        [
            'name' =>'Administración de medicamento via oral'
        ],
        [
            'name' =>'Administración de medicamento via oftalmica'
        ],
        [
            'name' =>'Administración de medicamento via parenteral IV-SC-IM'
        ],
        [
            'name' =>'Administración de medicamento via rectal'
        ],
        [
            'name' =>'Administración de medicamento via sublingual'
        ],
        [
            'name' =>'Aplicaión de membranas'
        ],
        [
            'name' =>'Aspiración de secreciones'
        ],
        [
            'name' =>'Cambio de vendaje'
        ],
        [
            'name' =>'Canalizacion de via periferica(Venoclisis)'
        ],
        [
            'name' =>'Cateterismo vesical'
        ],
        [
            'name' =>'Colocación de sonda nasogastrica'
        ],
        [
            'name' =>'Colocación de férula'
        ],
        [
            'name' =>'Colocación de sonda fija vesical'
        ],
        [
            'name' =>'Colocación de vendajes'
        ],
        [
            'name' =>'Colocación de venda elástica'
        ],
        [
            'name' =>'Compresas'
        ],
        [
            'name' =>'Curaciones'
        ],
        [
            'name' =>'Frotis y cultivos'
        ],
        [
            'name' =>'Glicemias'
        ],
        [
            'name' =>'Irrigacion vesical'
        ],
        [
            'name' =>'Lavado de ojos'
        ],
        [
            'name' =>'Medición de  constantes vistales (Signos vitales)'
        ],
        [
            'name' =>'Mediciones antropodemetricas'
        ],
        [
            'name' =>'Nebulizaciones'
        ], 
        [
            'name' =>'Oxigeno terapia'
        ],
        [
            'name' =>'Prueba tolerancia oral'
        ],
        [
            'name' =>'Prueba de sensibilidad a la penicilina'
        ],
        [
            'name' =>'Retiro de drenajes'
        ],
        [
            'name' =>'Retiro de grapas'
        ],
        [
            'name' =>'Retiro de sondas'
        ],
        [
            'name' =>'Retiro de suturas'
        ],
        [
            'name' =>'Toma de muestras'
        ],
        [
            'name' =>'Vacunas'
        ],
        [
            'name' =>'Preconsultas'
        ],
        [
            'name' =>'Post consulta'
        ],
        [
            'name' =>'Traslados a hospital'
        ],
        [
            'name' =>'Asistir a procedimientos'
        ],
        [
            'name' =>'Pacientes en observacion'
        ],
        [
            'name' =>'Entrega de material(Jeringas,Gasas,Pañales)'
        ],
        [
            'name' =>'Reuniones y educaciones'
        ],
        [
            'name' =>'Limpieza de refrigeradoras'
        ],
        [
            'name' =>'Tratamiento supervisado(TB-Hansen-etc)'
        ],
        [
            'name' =>'Trabajo escolar'
        ],
        [
            'name' =>'Visitas domiciliares primera vez en la vida'
        ],
        [
            'name' =>'Visitas domiciliares primera vez en el año'
        ],
        [
            'name' =>'Visitas domiciliares subsecuentes'
        ]
    ]
    
    );

    foreach(DB::table("processes")->get() as $cat) {
        DB::table("processes")
            ->where("id", $cat->id)
            ->update(array("created_at"=>Carbon::now(), "updated_at"=>Carbon::now()));
    }


    }
}
