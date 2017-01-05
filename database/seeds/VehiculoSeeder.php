<?php

use Illuminate\Database\Seeder;
use App\Fabricante;
use App\Vehiculo;
use Faker\Factory as Faker;

class VehiculoSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{   
        $faker = Faker::create();
        $cantidad = Fabricante::all()->count(); 

	 	for($i=0; $i < $cantidad; $i++)
         {
             Vehiculo::create //Modelo fabricante
             ([
                 'color' => $faker->safeColorName(),
                 'cilindraje' => $faker->randomFloat(),
                 'potencia' => $faker->randomNumber(),
                 'peso' => $faker->randomFloat(),
                 'fabricante_id' => $faker->numberBetween(1,$cantidad)
             ]);
         }
	}

}
