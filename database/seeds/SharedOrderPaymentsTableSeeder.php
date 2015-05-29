<?php
use App\Models\SharedOrderPayment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SharedOrderPaymentsTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker\Factory::create();

        if (DB::connection()->getName() == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        SharedOrderPayment::truncate();

        foreach (range(1, 5) as $index) {
            SharedOrderPayment::create([
                'pagamento' => strtolower($faker->word),
                'descricao' => $faker->sentence(2),
            ]);
        }

        if (DB::connection()->getName() == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
    }
}