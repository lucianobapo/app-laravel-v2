<?php
use App\Models\CostAllocate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostAllocatesTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker\Factory::create();

        if (DB::connection()->getName() == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        CostAllocate::truncate();

        foreach (range(1, 5) as $index) {
            CostAllocate::create([
                'mandante' => 'teste',
                'numero' => $faker->randomNumber(2),
                'nome' => ucfirst($faker->word),
                'descricao' => $faker->sentence(2),
            ]);
        }

        if (DB::connection()->getName() == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
    }
}