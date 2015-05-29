<?php
use App\Models\SharedUnitOfMeasure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SharedUnitOfMeasuresTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker\Factory::create();

        if (DB::connection()->getName() == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        SharedUnitOfMeasure::truncate();

        foreach (range(1, 5) as $index) {
            SharedUnitOfMeasure::create([
                'uom' => strtoupper($faker->word(2)),
                'descricao' => $faker->sentence(2),
            ]);
        }

        if (DB::connection()->getName() == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
    }
}