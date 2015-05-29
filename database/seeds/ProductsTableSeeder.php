<?php

use App\Models\Product;
use App\Models\SharedUnitOfMeasure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{

    public function run()
    {
        $randomSteatment = (DB::connection()->getName()=='mysql')?'RAND()':((DB::connection()->getName()=='sqlite')?'RANDOM()':'');

        $faker = Faker\Factory::create();
//        $faker->seed(1234);

        $imageDir = config('filesystems.imageLocation') . DIRECTORY_SEPARATOR;

        if (DB::connection()->getName()=='mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        Product::truncate();
        Storage::deleteDirectory($imageDir);

        foreach (range(1, 10) as $index) {
            $uomId = SharedUnitOfMeasure::orderBy(DB::raw($randomSteatment))->first()->id;
            $fileUrl = $faker->imageUrl(150, 150, 'food');
//            $fileName = md5(\Carbon\Carbon::now()).'.jpg';
            $name = $faker->sentence(2);
            $fileName = 'imagem-de-'.str_slug($name).'.jpg';

            if (!Storage::exists($imageDir)) Storage::makeDirectory($imageDir);
            Storage::put($imageDir . $fileName, file_get_contents($fileUrl));

            Product::create([
                'mandante' => 'teste',
                'uom_id' => $uomId,
                'nome' => $name,
                'imagem' => $fileName,

                'promocao' => $faker->boolean(),
                'valorUnitVenda' => $faker->randomFloat(2, 5, 100),
                'valorUnitVendaPromocao' => $faker->randomFloat(2, 5, 100),
                'valorUnitCompra' => $faker->randomFloat(2, 5, 100),
            ]);

        }

        if (DB::connection()->getName()=='mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
    }
}