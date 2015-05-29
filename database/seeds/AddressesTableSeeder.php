<?php

use App\Models\Address;
use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressesTableSeeder extends Seeder
{

    public function run()
    {
        $randomSteatment = (DB::connection()->getName()=='mysql')?'RAND()':((DB::connection()->getName()=='sqlite')?'RANDOM()':'');

        $faker = Faker\Factory::create();
        $faker->addProvider(new \Faker\Provider\pt_BR\Address($faker));

        if (DB::connection()->getName() == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        Address::truncate();


        $partners = Partner::orderBy(DB::raw($randomSteatment))->get();
        foreach ($partners as $partner) {
            //$partnerId = \App\Partner::orderBy(DB::raw($randomSteatment))->first()->id;
            foreach (range(1, 2) as $index) {
                Address::create([
                    'mandante' => 'teste',
//                    'partner_id' => $partnerId,
                    'partner_id' => $partner->id,
                    //'cep' => str_replace('-','',$faker->postcode(8)),
                    'cep' => $faker->numberBetween(28890001,28899999),
                    'logradouro' => $faker->streetName,
                    'complemento' => $faker->secondaryAddress,
//                    'bairro' => $faker->,
                    'cidade' => $faker->city,
                    'estado' => $faker->stateAbbr,
                    'pais' => $faker->country,
                    'obs' => $faker->sentence(3),
                    //'principal ' => false,
                    //'cancelado ' => false,
                ]);
            }
        }

        if (DB::connection()->getName() == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
    }
}